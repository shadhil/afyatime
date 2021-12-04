<?php

namespace App\Http\Livewire;

use App\Events\FirstAppointment;
use App\Models\OrganizationSubscription;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Patients extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $editState = [];

    public $showEditModal = false;

    public $patientId = null;
    public $userId = null;

    public $searchTerm = null;

    public $photo;
    public $profilePhoto;

    public $districts = [];

    public $packageStatus = 4;

    public function newCode()
    {
        $testCode = '';
        $isFound = false;
        while (!$isFound) {
            $testCode = Str::before((string) Str::uuid(), '-');
            $code = DB::table('patients')
                ->select('patient_code')
                ->where('patient_code', $testCode)
                ->first();
            if (!$code) {
                $isFound = true;
            }
        }
        return Str::upper($testCode);
    }

    public function createPatient()
    {
        // dd($this->newCode());
        Validator::make($this->state, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'sometimes|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
        ])->validate();

        if ($this->photo) {
            $this->state['photo'] = $this->photo->store('/', 'profiles');
        } else {
            $this->state['photo'] = NULL;
        }

        if (empty($this->state['email'])) {
            $this->state['email'] = NULL;
        }

        $this->state['organization_id'] =  Auth::user()->org_id;
        $this->state['patient_code'] = $this->newCode();
        $this->state['phone_number'] = trim_phone_number($this->state['phone_number']);
        $this->state['date_of_birth'] = db_date($this->state['date_of_birth']);

        DB::transaction(function () {

            $newPatient = Patient::create($this->state);

            if ($this->state['email'] != NULL) {
                $newPatient->accounts()->create([
                    'name' => $this->state['first_name'] . ' ' . $this->state['last_name'],
                    'email' => $this->state['email'],
                    'profile_photo' => $this->state['photo'],
                    'password' => Hash::make($this->state['phone_number']),
                    'org_id' => Auth::user()->org_id,
                ]);
            }

            if ($newPatient) {
                $this->dispatchBrowserEvent('hide-patient-modal', ['message' => 'Patient added successfully!', 'url' => route('patients.profile', $this->state['patient_code'])]);
                // return redirect()->route('patients.profile', $this->state['patient_code']);
            }
        });
    }

    public function addPatient()
    {
        $this->reset('state', 'photo', 'profilePhoto', 'patientId');
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-patient-modal');
    }

    public function editPatient($patientId)
    {
        $this->reset('state', 'photo', 'profilePhoto', 'patientId');
        $this->showEditModal = true;

        $patient = Patient::find($patientId);

        $this->patientId = $patient->id;
        $this->profilePhoto = $patient->photo;

        $user = $patient->accounts()->where('account_id', $patientId)->first();
        // dd($user);
        if ($user != null) {
            $this->userId = $user->id;
        } else {
            $this->userId = null;
        }

        $this->state = $patient->toArray();
        $this->state['region_id'] = $patient->district->region_id;
        $this->state['district_id'] = $patient->district_id;
        $this->state['date_of_birth'] = form_date($patient->date_of_birth);

        $this->dispatchBrowserEvent('show-patient-modal');
        //dd($admin);
    }

    public function updatePatient()
    {
        $this->state['user_id'] = $this->userId;
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'exclude_if:user_id,null|sometimes|email|unique:users,email,' . $this->userId,
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'supporter_id' => 'sometimes',
            // 'password' => 'sometimes|confirmed',
        ])->validate();

        DB::transaction(function () use ($validatedData) {
            // if (!empty($validatedData['password'])) {
            //     $this->editState['password'] = bcrypt($validatedData['password']);
            // }
            if (!empty($validatedData['email'])) {
                $this->editState['email'] = $validatedData['email'];
            }
            $this->editState['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];

            $validatedData['phone_number'] = trim_phone_number($validatedData['phone_number']);
            $validatedData['date_of_birth'] = db_date($validatedData['date_of_birth']);


            if ($this->photo) {
                $img = $this->photo->store('/', 'profiles');
                $this->editState['profile_photo'] = $img;
                $validatedData['photo'] = $img;
            }

            $updatedPatient = Patient::find($this->patientId);
            $updatedPatient->update($validatedData);

            $updatedPatient->accounts()->update($this->editState);

            if ($updatedPatient) {
                $this->dispatchBrowserEvent('hide-patient-modal', ['message' => 'Patient updated successfully!']);
            }
        });
    }


    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function searchPatient()
    {
        $this->resetPage();
        // dd($this->searchTerm);
    }

    public function render()
    {
        $orgSub = OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('status', 2)
            ->latest()->first();
        if ($orgSub == null) {
            $this->packageStatus = 4;
        } else {
            $this->packageStatus = $orgSub->status;
        }

        if ($this->searchTerm != null) {
            $patients = Patient::where('organization_id', Auth::user()->org_id)
                ->where(function ($query) {
                    $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('patient_code', 'like', '%' . $this->searchTerm . '%');
                })
                ->latest()->paginate(4);
        } else {
            $patients = Patient::where('organization_id', Auth::user()->org_id)
                ->latest()->paginate(4);
        }


        if (!empty($this->state['region_id'])) {
            $this->districts = DB::table('districts')
                ->select('id', 'name')
                ->where('region_id', $this->state['region_id'])
                ->get();
        } else {
            $this->districts = [];
        }

        $regions = DB::table('regions')
            ->select('id', 'name')
            ->get();
        $supporters = DB::table('treatment_supporters')
            ->select('id', 'full_name', 'phone_number')
            ->where('organization_id', Auth::user()->org_id)
            ->get();

        // dd($patients[0]->lastAppointment->date_of_visit);
        return view('livewire.patients', ['patients' => $patients, 'regions' => $regions, 'supporters' => $supporters])->layout('layouts.base');
    }
}
