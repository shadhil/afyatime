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
use Intervention\Image\Facades\Image;

class Patients extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    // public $state = [];
    // public $editState = [];

    public $showEditModal = false;

    public $patientId = null;
    public $userId = null;

    public $searchTerm = null;

    public $photo;
    public $profilePhoto;

    public $districts = [];

    public $packageStatus = 4;

    public $first_name;
    public $last_name;
    public $date_of_birth;
    public $browsed_photo;
    public $gender;
    public $patient_code;
    public $phone_number;
    public $email;
    public $location;
    public $region_id;
    public $district_id;
    public $tensel_leader;
    public $tensel_leader_phone;
    public $supporter_id;
    public $organization_id;

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
        $validatedData = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'browsed_photo' => 'nullable|image|max:1024',
        ]);

        if ($validatedData['browsed_photo'] != null) {
            if ($this->browsed_photo->isValid()) {
                $photoName = Patient::PATH . '/pt_' . md5(microtime()) . '.' . $this->browsed_photo->extension();
                $ImageFile = Image::make($this->browsed_photo);
                $ImageFile->save($photoName);
                $this->photo = '/' . $photoName;
            } else {
                $this->photo = NULL;
            }
        } else {
            $this->photo = NULL;
        }

        $this->organization_id =  Auth::user()->org_id;

        DB::transaction(function () use ($validatedData) {

            $this->patient_code = $this->newCode();
            $validatedData['phone_number'] = trim_phone_number($validatedData['phone_number']);
            $validatedData['date_of_birth'] = db_date($validatedData['date_of_birth']);

            $newPatient = Patient::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'location' => $validatedData['location'],
                'district_id' => $validatedData['district_id'],
                'gender' => $validatedData['gender'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'patient_code' => $this->patient_code,
                'organization_id' => $this->organization_id,
                'photo' => $this->photo,
            ]);

            // if ($this->state['email'] != NULL) {
            //     $newPatient->accounts()->create([
            //         'name' => $this->state['first_name'] . ' ' . $this->state['last_name'],
            //         'email' => $this->state['email'],
            //         'profile_photo' => $this->state['photo'],
            //         'password' => Hash::make($this->state['phone_number']),
            //         'org_id' => Auth::user()->org_id,
            //     ]);
            // }

            if ($newPatient) {
                user_log('3', Auth::user()->account_id, 'patient', $newPatient->id);
                $this->dispatchBrowserEvent('hide-patient-modal', ['message' => 'Patient added successfully!', 'url' => route('patients.profile', $this->patient_code)]);
                // return redirect()->route('patients.profile', $this->state['patient_code']);
            }
        });
    }

    public function addPatient()
    {
        $this->reset([
            'photo',
            'profilePhoto',
            'patientId',
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'location',
            'district_id',
            'gender',
            'date_of_birth',
            'browsed_photo',
            'organization_id',
        ]);
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-patient-modal');
    }

    public function editPatient($patientId)
    {
        $this->reset([
            'photo',
            'profilePhoto',
            'patientId',
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'location',
            'district_id',
            'gender',
            'date_of_birth',
            'browsed_photo',
            'organization_id',
        ]);
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

        // $this->state = $patient->toArray();

        $this->first_name = $patient->first_name;
        $this->last_name = $patient->last_name;
        $this->date_of_birth = $patient->date_of_birth;
        $this->photo = $patient->photo;
        $this->gender = $patient->gender;
        $this->patient_code = $patient->patient_code;
        $this->phone_number = $patient->phone_number;
        $this->email = $patient->email;
        $this->location = $patient->location;
        $this->region_id = $patient->district->region_id;
        $this->district_id = $patient->district_id;
        $this->date_of_birth = form_date($patient->date_of_birth);

        $this->dispatchBrowserEvent('show-patient-modal');
        //dd($admin);
    }

    public function updatePatient()
    {
        // $this->state['user_id'] = $this->userId;
        //dd($this->state);
        $validatedData = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'browsed_photo' => 'nullable|image|max:1024',
        ]);

        DB::transaction(function () use ($validatedData) {

            $validatedData['phone_number'] = trim_phone_number($validatedData['phone_number']);
            $validatedData['date_of_birth'] = db_date($validatedData['date_of_birth']);


            if ($validatedData['browsed_photo'] != null) {
                if ($this->browsed_photo->isValid()) {
                    $photoName = Patient::PATH . '/pt_' . md5(microtime()) . '.' . $this->browsed_photo->extension();
                    $ImageFile = Image::make($this->browsed_photo);
                    $ImageFile->save($photoName);
                    $validatedData['photo'] = '/' . $photoName;
                }
            }

            $updatedPatient = Patient::find($this->patientId);
            $updatedPatient->update($validatedData);

            // $updatedPatient->accounts()->update($this->editState);

            if ($updatedPatient) {
                user_log('4', Auth::user()->account_id, 'patient', $this->patientId);
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
                ->latest()->paginate(12);
        } else {
            $patients = Patient::where('organization_id', Auth::user()->org_id)
                ->latest()->paginate(12);
        }


        if (!empty($this->region_id)) {
            $this->districts = DB::table('districts')
                ->select('id', 'name')
                ->where('region_id', $this->region_id)
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
