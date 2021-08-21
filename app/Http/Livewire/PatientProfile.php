<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PatientProfile extends Component
{
    public $patientId;

    public function mount($id)
    {
        $this->patientId = $id;
    }

    public function render()
    {
        $conditions = DB::table('medical_conditions')
            ->select('id', 'condition')
            ->where('patient_id', $this->patientId)
            ->get();

        $patient = DB::table('patients')
            ->leftJoin('treatment_supporters', 'treatment_supporters.id', '=', 'patients.supporter_id')
            ->join('full_regions', 'full_regions.district_id', '=', 'patients.district_id')
            ->select('patients.*', 'full_regions.district', 'full_regions.region', 'treatment_supporters.full_name')
            ->where('patients.id', $this->patientId)
            ->first();
        //dd($conditions);
        return view('livewire.patient-profile', ['patient' => $patient, 'conditions' => $conditions]);
    }
}
