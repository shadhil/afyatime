<?php

namespace App\Http\Livewire;

use App\Events\SubscriptionPaid;
use App\Models\Appointment;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\Patient;
use App\Models\Prescriber;
use App\Models\TreatmentSupporter;
use App\Models\UserLog;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

    public $receivedAppointments;
    public $previousAppointments;
    public $upcomingAppointments;
    public $countedApointments;
    public $packageApointments;

    public $subscriptionStatus;

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
        // dd(Auth::user());
        if (Session::get('logged_in')) {
            user_log('1', Auth::user()->account_id);
            Session::put('logged_in', false);
        }

        $this->totalPatients = Patient::query()
            ->where('organization_id', Auth::user()->org_id)
            ->count();

        $this->myPatients = UserLog::query()
            ->where('prescriber_id', Auth::user()->account->id)
            ->where('user_action_id', '3')
            ->count();

        $this->totalAppointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->count();

        $this->myAppointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('prescriber_id', Auth::user()->account->id)
            ->count();

        $this->receivedAppointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('prescriber_id', Auth::user()->account->id)
            ->whereNotNull('received_by')
            ->count();

        $this->previousAppointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('prescriber_id', Auth::user()->account->id)
            ->whereDate('date_of_visit', '<', Carbon::today()->toDateString())
            ->count();

        $this->upcomingAppointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('prescriber_id', Auth::user()->account->id)
            ->whereDate('date_of_visit', '>=', Carbon::today()->toDateString())
            ->count();

        $curSub = OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('status', '2')
            ->latest()
            ->first();

        // dd($curSub->package->monthly_appointments);

        if ($curSub->duration == 'monthly') {
            $this->packageApointments = $curSub->package->monthly_appointments;
        } else {
            $this->packageApointments = $curSub->package->yearly_appointments;
        }

        $this->countedApointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->whereDate('date_of_visit', '>=', $curSub->start_date)
            ->whereDate('date_of_visit', '<=', $curSub->end_date)
            ->count();


        $this->totalPrescribers = Prescriber::query()
            ->where('organization_id', Auth::user()->org_id)
            ->count();

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
            ->with(['prescriber' => function ($query) {
                $query->withTrashed();
            }])
            ->where('organization_id', Auth::user()->org_id)
            ->orderByDesc('date_of_visit')
            ->limit(12)
            ->get();

        $subscription = OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
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
            ->where('organization_id', Auth::user()->org_id)
            ->latest()
            ->limit(3)
            ->get();

        $packages = DB::table('subscription_packages')
            ->get();

        // dd($appointments);
        return view('livewire.dashboard', ['patients' => $patients, 'supporters' => $supporters, 'organization' => $organization, 'appointments' => $appointments, 'subscription' => $subscription, 'packages' => $packages, 'prescribers' => $prescribers])->layout('layouts.base');
    }
}
