<?php

namespace App\Http\Livewire;

use App\Events\FirstAppointment;
use App\Jobs\PatientWelcomeJob;
use App\Jobs\WelcomePatientJob;
use App\Models\Appointment;
use App\Models\MedicalCondition;
use App\Models\Patient;
use App\Models\Prescriber;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class PatientProfile extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $editState = [];

    public $patientId;
    public $appointmentId;
    public $removeAppointmentId;

    public $firstTime = false;
    public $patientName = '';
    public $patientPhone = '';
    public $patientEmail = 'none';

    public $conditionId = '';

    public $showEditModal = false;

    public $searchTerm = null;

    public function mount($id)
    {
        $this->patientId = $id;
        $this->state['condition_id'] = '';
    }

    public function createAppointment()
    {
        // dd($this->state);
        $this->state['condition_id'] = $this->conditionId;
        Validator::make($this->state, [
            'condition_id' => 'required',
            'date_of_visit' => 'required',
        ])->validate();

        $this->state['prescriber_id'] = Auth::user()->account_id;
        $this->state['patient_id'] = $this->patientId;
        $this->state['organization_id'] = Auth::user()->org_id;

        if (!empty($this->state['date_of_visit'])) {
            $this->state['date_of_visit'] = db_date($this->state['date_of_visit']);
        }

        if (!empty($this->state['visit_time'])) {
            $this->state['visit_time'] = Carbon::createFromFormat('h:i A', $this->state['visit_time'])->format('H:i:s');
        }

        $newAppointment = Appointment::create($this->state);

        if ($newAppointment) {
            if (!$this->firstTime) {
                $details = [
                    'name' => $newAppointment->patient->first_name . ' ' . $newAppointment->patient->last_name,
                    'email' => $newAppointment->patient->email,
                    'phone' => $newAppointment->patient->phone_number,
                    'code' => $newAppointment->patient->patient_code,
                    'clinic' => $newAppointment->organization->known_as,
                ];
                WelcomePatientJob::dispatch($details);
            }
            $this->dispatchBrowserEvent('hide-appointment-modal', ['message' => 'Appointment added successfully!']);
        }
    }


    public function addCondition()
    {
        $this->reset('state', 'conditionId');
        $this->state['app_type'] = 'weekly';
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-condition-modal');
    }

    public function createCondition()
    {
        Validator::make($this->state, [
            'condition' => 'required',
        ])->validate();

        $this->state['patient_id'] = $this->patientId;
        $newAppointment = MedicalCondition::create($this->state);

        if ($newAppointment) {
            $this->dispatchBrowserEvent('hide-condition-modal', ['message' => 'Condition added successfully!']);
        }
    }

    public function addAppointment()
    {
        $this->reset('state', 'conditionId');
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-appointment-modal');
    }

    public function editAppointment($appointmentId)
    {
        $this->reset('state', 'conditionId');
        $this->showEditModal = true;
        $appointment = Appointment::find($appointmentId);

        // $collection = collect($appointment);
        $this->appointmentId = $appointment->id;
        $this->conditionId = $appointment->condition_id;

        $this->state = $appointment->toArray();
        if (!empty($appointment->date_of_visit)) {
            $this->state['date_of_visit'] = form_date($appointment->date_of_visit);
        }

        if (!empty($appointment->visit_time)) {
            $this->state['visit_time'] = Carbon::createFromFormat('H:i:s', $appointment->visit_time)->format('h:i A');
        }
        if (empty($appointment->received_by)) {
            $this->state['received_by'] = false;
        } else {
            $this->state['received_by'] = true;
        }

        $this->dispatchBrowserEvent('show-appointment-modal');
        //dd($admin);
    }

    public function updateAppointment()
    {
        // $this->state['condition_id'] = $this->conditionId;
        $validatedData = Validator::make($this->state, [
            'condition_id' => 'required',
            'date_of_visit' => 'required',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($this->state['date_of_visit'])) {
                $this->state['date_of_visit'] = db_date($this->state['date_of_visit']);
            }

            if (!empty($this->state['visit_time'])) {
                $this->state['visit_time'] = Carbon::createFromFormat('h:i A', $this->state['visit_time'])->format('H:i:s');
            }

            $this->state['received_by'] = $this->state['received_by'] == true ? Auth::user()->account_id : NULL;

            $updatedAppointment = Appointment::find($this->appointmentId)->update($this->state);

            if ($updatedAppointment) {
                $this->dispatchBrowserEvent('hide-appointment-modal', ['message' => 'Appointment updated successfully!']);
            }
        });
    }

    public function appointmentRemoval($appointmentId)
    {
        $this->removeAppointmentId = $appointmentId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteAppointment()
    {
        $appointment = Appointment::findOrFail($this->removeAppointmentId);

        $appointment->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Appointment deleted successfully!']);
    }


    public function render()
    {
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

        // dd($prescribers);
        // query()->where('organization_id', Auth::user()->org_id)->get();
        // $prescribers->appointments
        //     ->where('appointments.patient_id', $this->patientId)
        //     ->groupBy('prescribers.id')
        //     ->limit(5)
        //     ->get();

        $appointments = $patient->appontments()
            ->orderByDesc('date_of_visit')
            ->paginate(12);

        if (sizeof($appointments) == 0) {
            $this->firstTime = true;
        } else {
            $this->firstTime = false;
        }

        // dd($appointments->);
        return view('livewire.patient-profile', ['patient' => $patient, 'conditions' => $conditions, 'prescribers' => $prescribers, 'appointments' => $appointments]);
    }
}
