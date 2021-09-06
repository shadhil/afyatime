<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Appointments extends Component
{
    public $orgId;

    public function mount($id)
    {
        $this->orgId = $id;
    }

    public function render()
    {
        $org = DB::table('organizations')->select('name')->find($this->orgId);
        $appointments = DB::table('appointments')
            ->join('prescribers', 'appointments.prescriber_id', '=', 'prescribers.id')
            ->join('medical_conditions', 'appointments.condition_id', '=', 'medical_conditions.id')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('prescriber_types', 'prescribers.prescriber_type', '=', 'prescriber_types.id')
            ->select('appointments.*', 'prescribers.first_name', 'prescribers.last_name', 'prescriber_types.initial', 'medical_conditions.condition', 'patients.first_name AS pf_name', 'patients.last_name AS pl_name', 'patients.photo', 'patients.phone_number')
            ->where('patients.organization_id', $this->orgId)
            ->groupBy('appointments.id')
            ->orderByDesc('appointments.date_of_visit')
            ->paginate(5);

        return view('livewire.admin.appointments', ['appointments' => $appointments, 'org' => $org]);
    }
}
