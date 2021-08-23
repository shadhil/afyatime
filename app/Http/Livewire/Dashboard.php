<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalAppointments = DB::table('appointments')
            ->join('prescribers', 'appointments.prescriber_id', '=', 'prescribers.id')
            ->where('prescribers.organization_id', Auth::user()->org_id)
            ->count();
        $totalPatients = DB::table('patients')
            ->where('organization_id', Auth::user()->org_id)
            ->count();
        $totalPrescribers = DB::table('prescribers')
            ->where('organization_id', Auth::user()->org_id)
            ->count();
        $totalSupporters = DB::table('treatment_supporters')
            ->where('organization_id', Auth::user()->org_id)
            ->count();

        $patients = DB::table('patients')
            ->select('id', 'first_name', 'last_name', 'photo', 'created_at')
            ->where('organization_id', Auth::user()->org_id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $supporters = DB::table('treatment_supporters')
            ->leftJoin('patients', 'patients.supporter_id', '=', 'treatment_supporters.id')
            ->select('treatment_supporters.id', 'treatment_supporters.full_name', DB::raw('count(patients.id) as patients'))
            ->where('treatment_supporters.organization_id', Auth::user()->org_id)
            ->groupBy('treatment_supporters.id')
            ->orderByDesc('patients')
            ->limit(5)
            ->get();

        $organizations = DB::table('organizations')
            ->leftJoin('organization_types', 'organizations.organization_type', '=', 'organization_types.id')
            ->join('full_regions', 'full_regions.district_id', '=', 'organizations.district_id')
            ->select('organizations.*', 'full_regions.district', 'full_regions.region', 'organization_types.type')
            ->where('organizations.id', Auth::user()->org_id)
            ->first();

        $appointments = DB::table('appointments')
            ->join('prescribers', 'appointments.prescriber_id', '=', 'prescribers.id')
            ->join('medical_conditions', 'appointments.condition_id', '=', 'medical_conditions.id')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('prescriber_types', 'prescribers.prescriber_type', '=', 'prescriber_types.id')
            ->select('appointments.*', 'prescribers.first_name', 'prescribers.last_name', 'prescriber_types.initial', 'medical_conditions.condition', 'patients.first_name AS pf_name', 'patients.last_name AS pl_name', 'patients.photo', 'patients.phone_number')
            ->where('patients.organization_id', Auth::user()->org_id)
            ->groupBy('appointments.id')
            ->orderByDesc('appointments.date_of_visit')
            ->paginate(5);

        // dd($organizations);
        return view('livewire.dashboard', ['totalAppointments' => $totalAppointments, 'totalPatients' => $totalPatients, 'totalPrescribers' => $totalPrescribers, 'totalSupporters' => $totalSupporters, 'patients' => $patients, 'supporters' => $supporters, 'org' => $organizations, 'appointments' => $appointments]);
    }
}
