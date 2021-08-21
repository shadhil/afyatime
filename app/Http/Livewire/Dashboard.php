<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
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
        // dd($organizations);
        return view('livewire.dashboard', ['totalPatients' => $totalPatients, 'totalPrescribers' => $totalPrescribers, 'totalSupporters' => $totalSupporters, 'patients' => $patients, 'supporters' => $supporters, 'org' => $organizations]);
    }
}
