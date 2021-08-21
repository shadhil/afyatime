<?php

namespace App\Http\Livewire;

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
        return $testCode;
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
        //$this->state['password'] = bcrypt($this->state['password']);
        //$this->state['admin_type'] = 'admin';

        if ($this->photo) {
            $this->state['photo'] = $this->photo->store('/', 'profiles');
        } else {
            $this->state['photo'] = NULL;
        }

        if (!empty($this->state['date_of_birth'])) {
            $this->state['date_of_birth'] = Carbon::createFromFormat('m/d/Y', $this->state['date_of_birth'])->format('Y-m-d');
        }

        $this->state['organization_id'] =  Auth::user()->org_id;
        $this->state['patient_code'] = $this->newCode();

        DB::transaction(function () {

            $newPatient = Patient::create($this->state);

            $newUser = User::create([
                'name' => $this->state['first_name'] . ' ' . $this->state['last_name'],
                'email' => $this->state['email'] == null ? 'patient_' . $newPatient->id . '@afyatime.co.tz' : $this->state['email'],
                'profile_photo' => $this->state['photo'],
                'password' => Hash::make($this->state['phone_number']),
                'account_type' =>  'patient',
                'account_id' => $newPatient->id,
                'org_id' => Auth::user()->org_id,
            ]);

            if ($newUser) {
                $this->dispatchBrowserEvent('hide-patient-modal', ['message' => 'Patient added successfully!']);
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
        $patient = DB::table('patients')
            ->leftJoin('users', 'users.email', '=', 'patients.email')
            ->join('full_regions', 'full_regions.district_id', '=', 'patients.district_id')
            ->select('patients.*', 'users.account_type', 'users.id AS user_id', 'full_regions.region_id')
            ->where('patients.id', $patientId)
            ->first();

        $collection = collect($patient);
        $this->patientId = $patient->id;
        $this->userId = $patient->user_id;

        $this->state = $collection->toArray();
        $this->profilePhoto = $patient->photo;

        $this->dispatchBrowserEvent('show-patient-modal');
        //dd($admin);
    }

    public function updatePatient()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'sometimes|email|unique:users,email,' . $this->userId,
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'supporter_id' => 'sometimes',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['email'])) {
                $this->editState['email'] = $validatedData['email'];
            }
            $this->editState['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
            if ($this->photo) {
                $img = $this->photo->store('/', 'profiles');
                $this->editState['profile_photo'] = $img;
                $validatedData['photo'] = $img;
            }

            Patient::find($this->patientId)->update($validatedData);

            $updatedUser = User::where('account_id', $this->patientId)
                ->where('account_type', 'patient')
                ->update($this->editState);

            if ($updatedUser) {
                $this->dispatchBrowserEvent('hide-patient-modal', ['message' => 'Patient updated successfully!']);
            }
        });
    }



    public function searchPrescriber()
    {
        dd($this->searchTerm);
    }

    public function render()
    {
        $patients = Patient::where('organization_id', Auth::user()->org_id)
            ->latest()
            ->paginate(5);

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
            ->get();
        //dd($prescribers);
        return view('livewire.patients', ['patients' => $patients, 'regions' => $regions, 'supporters' => $supporters]);
    }
}
