<?php

namespace App\Http\Livewire;

use App\Events\FirstAppointment;
use App\Jobs\PatientWelcomeJob;
use App\Jobs\WelcomePatientJob;
use App\Models\Appointment;
use App\Models\MedicalCondition;
use App\Models\OrganizationSubscription;
use App\Models\Patient;
use App\Models\Prescriber;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PatientProfile extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $editState = [];

    public $patientId;
    public $userId;
    public $appointmentId;
    public $appointmentDate;
    public $prescriberId;
    public $removeAppointmentId;

    public $firstTime = false;
    public $patientName = '';
    public $patientPhone = '';
    public $patientEmail = 'none';

    public $photo;
    public $profilePhoto;

    public $districts = [];

    // public $conditionId = '';

    public $showEditModal = false;

    public $searchTerm = null;

    public $packageAppointments = 150;
    public $currentAppointments = 0;
    public $packageStatus = 4;

    public $vPrescriber;
    public $vDate;
    public $vTime;
    public $vType;
    public $vReceiver;
    public $vCondition;

    public $changeSupporter = false;

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

    public function mount($code)
    {
        $patient = DB::table('patients')->where('patient_code', $code)->first();
        $this->patientId = $patient->id;
        // dd($this->patientId);
        // $this->state['condition_id'] = '';
    }

    public function addAppointment()
    {
        $this->reset('state');
        $this->state['condition_id'] = '';
        $this->state['app_type'] = 'weekly';
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-appointment-modal');
    }

    public function createAppointment()
    {
        // dd($this->state);
        Validator::make($this->state, [
            'condition_id' => 'required',
            'new_condition' => 'exclude_unless:condition_id,"NEW"|required',
            'date_of_visit' => 'required',
            'visit_time' => 'required',
        ])->validate();

        // dd($this->state['date_of_visit']);
        $dateOfVisit = db_date($this->state['date_of_visit']);

        if (is_valid_date($dateOfVisit)) {

            if ($this->state['condition_id'] == "NEW") {
                $this->state['patient_id'] = $this->patientId;
                $newCondition = MedicalCondition::create([
                    'patient_id' => $this->patientId,
                    'condition' => $this->state['new_condition'] ?? 'Common Medical Condition'
                ]);
                $this->state['condition_id'] = $newCondition->id;
            }

            $this->state['prescriber_id'] = Auth::user()->account_id;
            $this->state['patient_id'] = $this->patientId;
            $this->state['organization_id'] = Auth::user()->org_id;

            if (!empty($this->state['date_of_visit'])) {
                $this->state['date_of_visit'] = db_date($this->state['date_of_visit']);
            }

            if (!empty($this->state['visit_time'])) {
                $this->state['visit_time'] = Carbon::createFromFormat('H:i', $this->state['visit_time'])->format('H:i:s');
            }

            $newAppointment = Appointment::create($this->state);

            if ($newAppointment) {
                if ($this->firstTime) {
                    $details = [
                        'name' => $newAppointment->patient->first_name . ' ' . $newAppointment->patient->last_name,
                        'email' => $newAppointment->patient->email,
                        'phone' => $newAppointment->patient->phone_number,
                        'code' => $newAppointment->patient->patient_code,
                        'clinic' => $newAppointment->organization->known_as,
                    ];
                    WelcomePatientJob::dispatch($details);
                }

                user_log('12', Auth::user()->account_id, 'appointment', $newAppointment->id);
                $this->dispatchBrowserEvent('hide-appointment-modal', ['message' => 'Appointment added successfully!']);
            }
        } else {
            $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'Please enter the valid future date!']);
        }
    }

    public function editAppointment($appointmentId)
    {
        $this->reset('state');
        $this->showEditModal = true;
        $appointment = Appointment::find($appointmentId);

        // $collection = collect($appointment);
        $this->appointmentId = $appointment->id;
        // $this->prescriberId = $prescriberId;
        // $this->conditionId = $appointment->condition_id;

        $this->state = $appointment->toArray();
        if (!empty($appointment->date_of_visit)) {
            $this->state['date_of_visit'] = form_date($appointment->date_of_visit);
        }

        if (!empty($appointment->visit_time)) {
            $this->state['visit_time'] = Carbon::createFromFormat('H:i:s', $appointment->visit_time)->format('H:i');
        }
        if (empty($appointment->received_by)) {
            $this->state['received_by'] = false;
        } else {
            $this->state['received_by'] = true;
        }

        $this->dispatchBrowserEvent('show-appointment-modal');
        $this->dispatchBrowserEvent('hide-view-modal');
        //dd($admin);
    }

    public function updateAppointment()
    {
        // $this->state['condition_id'] = $this->conditionId;
        $validatedData = Validator::make($this->state, [
            'date_of_visit' => 'required',
            'visit_time' => 'required',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            // if (!empty($this->state['date_of_visit'])) {
            //     $this->state['date_of_visit'] = db_date($this->state['date_of_visit']);
            // }


            // if (!empty($this->state['visit_time'])) {
            //     $this->state['visit_time'] = Carbon::createFromFormat('H:i', $this->state['visit_time'])->format('H:i:s');
            // }

            // $this->state['received_by'] = $this->state['received_by'] == true ? Auth::user()->account_id : NULL;

            $updatedAppointment = Appointment::find($this->appointmentId)->update([
                'date_of_visit' => db_date($this->state['date_of_visit']),
                'visit_time' => Carbon::createFromFormat('H:i', $this->state['visit_time'])->format('H:i:s'),
                'app_type' => $this->state['app_type']
            ]);

            if ($updatedAppointment) {
                user_log('13', Auth::user()->account_id, 'appointment', $this->appointmentId);
                $this->dispatchBrowserEvent('hide-appointment-modal', ['message' => 'Appointment updated successfully!']);
            }
        });
    }

    public function deleteModal()
    {
        // $this->prescriberId = $prescriberId;
        $this->dispatchBrowserEvent('hide-appointment-modal', ['message' => 'none']);
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteAppointment()
    {
        $appointment = Appointment::findOrFail($this->appointmentId);

        $appointment->delete();

        user_log('14', Auth::user()->account_id, 'appointment', $this->appointmentId);
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Appointment deleted successfully!']);
    }

    public function completeModal($appointmentId, $date)
    {
        $this->appointmentId = $appointmentId;
        $this->appointmentDate = $date;
        $this->dispatchBrowserEvent('show-complete-modal');
    }

    public function confirmCompletion()
    {
        // if (Auth::user()->isAdmin() || $prescriber_id == Auth::user()->account->id) {
        //     $this->showEditModal = true;
        // } else {
        //     $this->showEditModal = false;
        // }
        if (is_subscribed()) {

            $res = CarbonImmutable::parse($this->appointmentDate)->lessThanOrEqualTo(CarbonImmutable::now());

            // dd($res);

            if ($res) {

                $appointment = Appointment::findOrFail($this->appointmentId);

                $appointment->received_by = Auth::user()->account->id;

                $appointment->save();

                user_log('14', Auth::user()->account_id, 'appointment', $this->appointmentId);
                $this->dispatchBrowserEvent('hide-complete-modal', ['message' => 'The Patient is Confirmed to attend his/her Appointment successfully!']);
            } else {
                $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'You can not confirm before the visiting date']);
            }


            // $appointment = Appointment::findOrFail($this->appointmentId);

            // $appointment->received_by = Auth::user()->account->id;

            // $appointment->save();

            // user_log('14', Auth::user()->account_id, 'appointment', $this->appointmentId);
            // $this->dispatchBrowserEvent('hide-complete-modal', ['message' => 'The Patient is Confirmed to attend his/her Appointment successfully!']);
        } else {
            $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'Your subscription is up so you can not aupdate this appointment']);
        }
    }

    public function viewAppointmentModal($id, $prescriber, $date, $time, $type, $condition, $receiver = null, $prescriber_id)
    {
        $this->appointmentId = $id;
        $this->vPrescriber = $prescriber;
        $this->vDate = $date;
        $this->vTime = $time;
        $this->vType = Str::ucfirst($type);
        $this->vReceiver = Str::of($receiver)->trim();
        $this->vCondition = $condition;

        if (Auth::user()->isAdmin() || $prescriber_id == Auth::user()->account->id) {
            $this->showEditModal = true;
        } else {
            $this->showEditModal = false;
        }
        // dd($this->showEditModal);

        $this->dispatchBrowserEvent('show-view-modal');
    }

    public function editPatient()
    {
        // dd($this->patientId);
        $this->reset([
            'photo',
            'profilePhoto',
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

        $patient = Patient::find($this->patientId);
        // dd($this->patientId);

        // $this->this->patientId = $patient->id;
        $this->profilePhoto = $patient->photo;

        $user = $patient->accounts()->where('account_id', $this->patientId)->first();
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
        $this->profilePhoto = $patient->photo;
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
            'tensel_leader' => 'sometimes',
            'tensel_leader_phone' => 'sometimes',
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

    public function addSupporter()
    {
        $this->reset('state', 'photo', 'profilePhoto', 'changeSupporter');
        $this->dispatchBrowserEvent('show-supporter-modal');
    }

    public function updateSupporter()
    {
        $validatedData = Validator::make($this->state, [
            'supporter_id' => 'required',
        ])->validate();

        $updatedPatient = Patient::find($this->patientId);
        $updatedPatient->update($validatedData);

        if ($updatedPatient) {
            user_log('18', Auth::user()->account_id, 'supporter', $this->state['supporter_id'], 'to ' . $updatedPatient->first_name . ' ' . $updatedPatient->last_name);
            $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'Supporter updated successfully!', 'url' => 'none']);
        }
    }

    public function UnAssignSupporter()
    {
        $updatedPatient = Patient::find($this->patientId);
        $supporter = $updatedPatient->supporter->full_name;
        $updatedPatient->update([
            'supporter_id' => NULL,
        ]);

        if ($updatedPatient) {
            user_log('18', Auth::user()->account_id, 'supporter', NULL, 'remove ' . $supporter . ' from ' . $updatedPatient->first_name . ' ' . $updatedPatient->last_name);
            $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'Supporter unassigned successfully!', 'url' => 'none']);
        }
    }

    public function newSupporter()
    {
        $this->reset('changeSupporter');
        $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'none', 'url' => route('patients.supporters', ['new' => 'new'])]);
    }

    public function editSupporter()
    {
        $this->reset('state', 'changeSupporter');

        $patient = Patient::find($this->patientId);

        $this->state['supporter_id'] = $patient->supporter_id;
        $this->changeSupporter = true;

        $this->dispatchBrowserEvent('show-supporter-modal');
        // dd($patient);
    }


    public function render()
    {
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

        $orgSub = OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('status', 2)
            ->latest()->first();
        if ($orgSub == null) {
            $this->packageAppointments = 0;
            $this->currentAppointments = 0;
            $this->packageStatus = 4;
        } else {
            $this->packageAppointments = $orgSub->package->monthly_appointments;
            $this->currentAppointments = 0; //$orgSub->logs()->count();
            $this->packageStatus = $orgSub->status;
        }
        // dd($this->packageAppointments);


        $conditions = DB::table('medical_conditions')
            ->select('id', 'condition', 'created_at')
            ->where('patient_id', $this->patientId)
            ->get();

        $patient = Patient::query()->find($this->patientId);

        $this->patientName = $patient->first_name . ' ' . $patient->last_name;
        $this->patientPhone = $patient->phone_number;
        if ($patient->email) {
            $this->patientEmail = $patient->email;
        }

        $prescribers = Prescriber::where('organization_id', Auth::user()->org_id)
            ->whereHas('appointments', function (Builder $query) {
                $query->where('patient_id', $this->patientId);
            })->limit(7)->get();

        $appointments = $patient->appointments()
            ->with(['prescriber' => function ($query) {
                $query->withTrashed();
            }])
            ->orderByDesc('date_of_visit')
            ->paginate(15);

        if (sizeof($appointments) == 0) {
            $this->firstTime = true;
        } else {
            $this->firstTime = false;
        }

        $supporters = DB::table('treatment_supporters')
            ->where('organization_id', Auth::user()->org_id)
            ->get();

        // dd($this->state['condition_id'] ?? '');
        return view('livewire.patient-profile', ['patient' => $patient, 'conditions' => $conditions, 'prescribers' => $prescribers, 'appointments' => $appointments, 'regions' => $regions, 'supporters' => $supporters])->layout('layouts.base');
    }
}
