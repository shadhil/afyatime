<?php

namespace App\Http\Livewire;

use App\Events\FirstAppointment;
use App\Models\Appointment;
use Carbon\Carbon;
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
            'new_condition' => 'sometimes|string',
        ])->validate();

        $this->state['prescriber_id'] = Auth::user()->account_id;
        $this->state['patient_id'] = $this->patientId;
        $this->state['organization_id'] = Auth::user()->org_id;

        // if ($this->conditionId == '0') {
        //     $this->state['condition_id'] = DB::table('medical_conditions')
        //         ->insertGetId([
        //             'condition' => $this->state['new_condition'],
        //             'patient_id' => $this->patientId,
        //         ]);
        // }

        if (!empty($this->state['date_of_visit'])) {
            $this->state['date_of_visit'] = Carbon::createFromFormat('m/d/Y', $this->state['date_of_visit'])->format('Y-m-d');
        }

        if (!empty($this->state['time_from'])) {
            $this->state['time_from'] = Carbon::createFromFormat('h:i A', $this->state['time_from'])->format('H:i:s');
        }

        if (!empty($this->state['time_to'])) {
            $this->state['time_to'] = Carbon::createFromFormat('h:i A', $this->state['time_to'])->format('H:i:s');
        }

        $newAppointment = Appointment::create($this->state);

        if ($newAppointment) {
            if ($this->firstTime) {
                $details = [
                    'name' => $this->patientName,
                    'phone' => $this->patientPhone
                ];
                event(new FirstAppointment($details));
            }
            $this->dispatchBrowserEvent('hide-appointment-modal', ['message' => 'Appointment added successfully!']);
        }
    }


    public function addCondition()
    {
        $this->reset('state', 'conditionId');
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-condition-modal');
    }

    public function createCondition()
    {
        Validator::make($this->state, [
            'condition' => 'required',
        ])->validate();

        $this->state['patient_id'] = $this->patientId;
        $newAppointment = DB::table('medical_conditions')->insert($this->state);

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
        $appointment = DB::table('appointments')->find($appointmentId);

        $collection = collect($appointment);
        $this->appointmentId = $appointment->id;
        $this->conditionId = $appointment->condition_id;

        $this->state = $collection->toArray();
        if (!empty($appointment->date_of_visit)) {
            $this->state['date_of_visit'] = Carbon::createFromFormat('Y-m-d', $appointment->date_of_visit)->format('m/d/Y');
        }

        if (!empty($appointment->time_from)) {
            $this->state['time_from'] = Carbon::createFromFormat('H:i:s', $appointment->time_from)->format('h:i A');
        }

        if (!empty($appointment->time_to)) {
            $this->state['time_to'] = Carbon::createFromFormat('H:i:s', $appointment->time_to)->format('h:i A');
        }

        $this->dispatchBrowserEvent('show-appointment-modal');
        //dd($admin);
    }

    public function updateAppointment()
    {
        $this->state['condition_id'] = $this->conditionId;
        $validatedData = Validator::make($this->state, [
            'condition_id' => 'required',
            'date_of_visit' => 'required',
            'new_condition' => 'sometimes|string',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if ($this->conditionId == '0') {
                $this->state['condition_id'] = DB::table('medical_conditions')
                    ->insertGetId([
                        'condition' => $this->state['new_condition'],
                        'patient_id' => $this->patientId,
                    ]);
            }

            if (!empty($this->state['date_of_visit'])) {
                $this->state['date_of_visit'] = Carbon::createFromFormat('m/d/Y', $this->state['date_of_visit'])->format('Y-m-d');
            }

            if (!empty($this->state['time_from'])) {
                $this->state['time_from'] = Carbon::createFromFormat('h:i A', $this->state['time_from'])->format('H:i:s');
            }

            if (!empty($this->state['time_to'])) {
                $this->state['time_to'] = Carbon::createFromFormat('h:i A', $this->state['time_to'])->format('H:i:s');
            }

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

        $patient = DB::table('patients')
            ->leftJoin('treatment_supporters', 'treatment_supporters.id', '=', 'patients.supporter_id')
            ->join('full_regions', 'full_regions.district_id', '=', 'patients.district_id')
            ->select('patients.*', 'full_regions.district', 'full_regions.region', 'treatment_supporters.full_name')
            ->where('patients.id', $this->patientId)
            ->first();
        $this->patientName = $patient->first_name . ' ' . $patient->last_name;
        $this->patientPhone = $patient->phone_number;
        if ($patient->email) {
            $this->patientEmail = $patient->email;
        }

        $prescribers = DB::table('prescribers')
            ->join('appointments', 'appointments.prescriber_id', '=', 'prescribers.id')
            ->select('prescribers.id', 'prescribers.first_name', 'prescribers.last_name', 'prescribers.profile_photo')
            ->where('appointments.patient_id', $this->patientId)
            ->groupBy('prescribers.id')
            ->limit(5)
            ->get();

        $appointments = DB::table('appointments')
            ->join('prescribers', 'appointments.prescriber_id', '=', 'prescribers.id')
            ->join('medical_conditions', 'appointments.condition_id', '=', 'medical_conditions.id')
            ->select('appointments.*', 'prescribers.first_name', 'prescribers.last_name', 'medical_conditions.condition')
            ->where('appointments.patient_id', $this->patientId)
            ->groupBy('appointments.id')
            ->orderByDesc('appointments.date_of_visit')
            ->limit(5)
            ->get();
        if (sizeof($appointments) == 0) {
            $this->firstTime = true;
        }

        // dd(sizeof($appointments));
        return view('livewire.patient-profile', ['patient' => $patient, 'conditions' => $conditions, 'prescribers' => $prescribers, 'appointments' => $appointments]);
    }
}
