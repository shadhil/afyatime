<?php

namespace App\Http\Livewire\Admin;

use App\Models\OrganizationSubscription;
use App\Models\Patient;
use App\Models\Prescriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class PatientProfile extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $patientId;
    public $orgId;

    public $vPrescriber;
    public $vDate;
    public $vTime;
    public $vType;
    public $vReceiver;
    public $vCondition;

    public function mount($code, $org_id)
    {
        $patient = DB::table('patients')->where('patient_code', $code)->first();
        $this->patientId = $patient->id;
        $this->orgId = $org_id;
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
            $this->showEditModal = true;
        }
        // return 'false';

        dd($this->showEditModal);

        $this->dispatchBrowserEvent('show-view-modal');
    }

    public function render()
    {

        $orgSub = OrganizationSubscription::query()
            ->where('organization_id', $this->orgId)
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

        $prescribers = Prescriber::where('organization_id', $this->orgId)
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
            ->where('organization_id', $this->orgId)
            ->get();

        // dd($this->state['condition_id'] ?? '');
        return view('livewire.admin.patient-profile', ['patient' => $patient, 'conditions' => $conditions, 'prescribers' => $prescribers, 'appointments' => $appointments, 'supporters' => $supporters])->layout('layouts.admin-base');
    }
}
