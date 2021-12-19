<?php

namespace App\Http\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\Patient;
use App\Models\Prescriber;
use App\Models\TreatmentSupporter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrgProfile extends Component
{
    public $orgId;

    public $viewState = [];

    public function mount($id)
    {
        $this->orgId = $id;
    }

    public function viewSupporter($supporterId)
    {

        $this->reset('viewState');
        $supporter = TreatmentSupporter::find($supporterId);
        $this->viewState['id'] = $supporter->id;
        $this->viewState['full_name'] = $supporter->full_name;
        $this->viewState['phone_number'] = $supporter->phone_number;
        $this->viewState['email'] = $supporter->email ?? ' - - - ';
        $this->viewState['location'] = $supporter->location;
        $this->viewState['district'] = $supporter->district->name;
        $this->viewState['region'] = $supporter->district->region->name;
        $this->viewState['total_patients'] = $supporter->patients()->count();
        $this->viewState['patients'] = $supporter->patients;
        $this->dispatchBrowserEvent('show-view-modal');
    }

    public function render()
    {
        $org = Organization::find($this->orgId);

        $totalPatients = DB::table('patients')->where('organization_id', $this->orgId)->count();

        $totalAppointments = DB::table('appointments')
            ->where('organization_id', $this->orgId)
            ->whereNull('deleted_at')
            ->count();

        $receivedAppointments = DB::table('appointments')
            ->where('organization_id', $this->orgId)
            ->whereNotNull('received_by')
            ->whereNull('deleted_at')
            ->count();

        $totalPrescribers = DB::table('prescribers')->where('organization_id', $this->orgId)->count();

        $totalSupporters = DB::table('treatment_supporters')->where('organization_id', $this->orgId)->count();

        $patients = Patient::query()
            ->where('organization_id', $this->orgId)
            ->orderByDesc('created_at')
            ->latest()
            ->limit(6)
            ->get();

        $supporters = TreatmentSupporter::query()
            ->where('organization_id', $this->orgId)
            ->limit(6)
            ->get();


        $appointments = Appointment::query()
            ->with(['prescriber' => function ($query) {
                $query->withTrashed();
            }])
            ->where('organization_id', $this->orgId)
            ->orderByDesc('date_of_visit')
            ->limit(10)
            ->get();

        $subscription = OrganizationSubscription::query()
            ->where('organization_id', $this->orgId)
            ->where('status', '2')
            ->latest('end_date')
            ->first();

        if ($subscription) {
            if ((today('Africa/Dar_es_Salaam')->greaterThan(Carbon::parse($subscription->end_date)))) {
                $this->subscriptionStatus = 'UNSUBSCRIBED';
            } else {
                $this->subscriptionStatus = "SUBSCRIBED";
            }
        } else {
            $this->subscriptionStatus = "NOT_SUBSCRIBED";
        }

        $prescribers = Prescriber::query()
            ->where('organization_id', $this->orgId)
            ->latest()
            ->limit(3)
            ->get();

        $packages = DB::table('subscription_packages')
            ->get();




        // $totalAppointments = DB::table('appointments')
        //     ->join('prescribers', 'appointments.prescriber_id', '=', 'prescribers.id')
        //     ->where('prescribers.organization_id', $this->orgId)
        //     ->count();
        // $totalPatients = DB::table('patients')
        //     ->where('organization_id', $this->orgId)
        //     ->count();
        // $totalPrescribers = DB::table('prescribers')
        //     ->where('organization_id', $this->orgId)
        //     ->count();
        // $totalSupporters = DB::table('treatment_supporters')
        //     ->where('organization_id', $this->orgId)
        //     ->count();

        // $patients = DB::table('patients')
        //     ->select('id', 'first_name', 'last_name', 'photo', 'created_at')
        //     ->where('organization_id', $this->orgId)
        //     ->orderByDesc('created_at')
        //     ->limit(5)
        //     ->get();

        // $supporters = DB::table('treatment_supporters')
        //     ->leftJoin('patients', 'patients.supporter_id', '=', 'treatment_supporters.id')
        //     ->select('treatment_supporters.id', 'treatment_supporters.full_name', DB::raw('count(patients.id) as patients'))
        //     ->where('treatment_supporters.organization_id', $this->orgId)
        //     ->groupBy('treatment_supporters.id')
        //     ->orderByDesc('patients')
        //     ->limit(5)
        //     ->get();

        // $organization = DB::table('organizations')
        //     ->leftJoin('organization_types', 'organizations.organization_type', '=', 'organization_types.id')
        //     ->join('full_regions', 'full_regions.district_id', '=', 'organizations.district_id')
        //     ->select('organizations.*', 'full_regions.district', 'full_regions.region', 'organization_types.type')
        //     ->where('organizations.id', $this->orgId)
        //     ->first();

        // $subscription = $org->subscriptions()
        //     ->latest()
        //     ->first();

        // $appointments = DB::table('appointments')
        //     ->join('prescribers', 'appointments.prescriber_id', '=', 'prescribers.id')
        //     ->join('medical_conditions', 'appointments.condition_id', '=', 'medical_conditions.id')
        //     ->join('patients', 'appointments.patient_id', '=', 'patients.id')
        //     ->leftJoin('prescriber_types', 'prescribers.prescriber_type', '=', 'prescriber_types.id')
        //     ->select('appointments.*', 'prescribers.first_name', 'prescribers.last_name', 'prescriber_types.initial', 'medical_conditions.condition', 'patients.first_name AS pf_name', 'patients.last_name AS pl_name', 'patients.photo', 'patients.phone_number')
        //     ->where('patients.organization_id', $this->orgId)
        //     ->groupBy('appointments.id')
        //     ->orderByDesc('appointments.date_of_visit')
        //     ->paginate(5);

        // $prescribers = DB::table('prescribers')
        //     ->leftJoin('prescriber_types', 'prescriber_types.id', '=', 'prescribers.prescriber_type')
        //     ->select('prescribers.*', 'prescriber_types.initial', 'prescriber_types.title')
        //     ->where('prescribers.organization_id', $this->orgId)
        //     ->latest()->paginate(5);

        // dd($totalPatients);
        return view('livewire.admin.org-profile', ['organization' => $org, 'totalAppointments' => $totalAppointments, 'totalPatients' => $totalPatients, 'totalPrescribers' => $totalPrescribers, 'totalSupporters' => $totalSupporters, 'patients' => $patients, 'supporters' => $supporters, 'appointments' => $appointments, 'prescribers' => $prescribers, 'subscription' => $subscription])->layout('layouts.admin-base');
    }
}
