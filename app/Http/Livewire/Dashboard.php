<?php

namespace App\Http\Livewire;

use App\Events\SubscriptionPaid;
use App\Models\Appointment;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\Patient;
use App\Models\Prescriber;
use App\Models\TreatmentSupporter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $viewState = [];

    public $totalPatients;
    public $myPatients;
    public $totalAppointments;
    public $myAppointments;
    public $totalPrescribers;

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
        $this->totalPatients = DB::table('patients')->count();
        $this->myPatients = DB::table('user_logs')->where('prescriber_id', Auth::user()->account->id)->where('user_action_id', '3')->count();

        $this->totalAppointments = DB::table('appointments')->count();
        $this->myAppointments = DB::table('appointments')->where('prescriber_id', Auth::user()->account->id)->count();

        $this->totalPrescribers = DB::table('prescribers')->count();

        $organization = Organization::find(Auth::user()->org_id);
        $patients = Patient::query()
            ->where('organization_id', Auth::user()->org_id)
            ->orderByDesc('created_at')
            ->latest()
            ->limit(6)
            ->get();

        $supporters = TreatmentSupporter::query()
            ->where('treatment_supporters.organization_id', Auth::user()->org_id)
            ->limit(6)
            ->get();

        // $organization = DB::table('organizations')
        //     ->leftJoin('organization_types', 'organizations.organization_type', '=', 'organization_types.id')
        //     ->join('full_regions', 'full_regions.district_id', '=', 'organizations.district_id')
        //     ->select('organizations.*', 'full_regions.district', 'full_regions.region', 'organization_types.type')
        //     ->where('organizations.id', Auth::user()->org_id)
        //     ->first();
        $this->orgName = $organization->name;

        $appointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->orderByDesc('date_of_visit')
            ->limit(10)
            ->get();

        $subscription = OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('status', '2')
            ->latest()
            ->first();

        $prescribers = Prescriber::query()
            ->where('organization_id', Auth::user()->org_id)
            ->latest()
            ->limit(3)
            ->get();

        $packages = DB::table('subscription_packages')
            ->get();

        // dd(Auth::user()->org_id);
        return view('livewire.dashboard', ['patients' => $patients, 'supporters' => $supporters, 'organization' => $organization, 'appointments' => $appointments, 'subscription' => $subscription, 'packages' => $packages, 'prescribers' => $prescribers])->layout('layouts.base');
    }
}
