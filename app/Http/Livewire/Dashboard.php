<?php

namespace App\Http\Livewire;

use App\Events\SubscriptionPaid;
use App\Models\OrganizationSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Dashboard extends Component
{
    public $state = [];
    public $subscriberId;

    public $showEditModal = false;
    public $orgName = '';

    public function addSubscription()
    {
        $this->reset('state', 'subscriberId');
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-subscription-modal');
    }

    public function createSubscription()
    {
        Validator::make($this->state, [
            'package_id' => 'required',
            'payment_ref' => 'required',
            'total_price' => 'required',
        ])->validate();

        $this->state['paid_by'] = Auth::user()->id;
        $this->state['organization_id'] = Auth::user()->org_id;
        $this->state['status'] = 'Paid';
        $newSubscription = OrganizationSubscription::create($this->state);

        if ($newSubscription) {
            $details = [
                'organization' => $this->orgName,
            ];
            event(new SubscriptionPaid($details));
            $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'Subscriber added successfully!']);
        }
    }

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

        $organization = DB::table('organizations')
            ->leftJoin('organization_types', 'organizations.organization_type', '=', 'organization_types.id')
            ->join('full_regions', 'full_regions.district_id', '=', 'organizations.district_id')
            ->select('organizations.*', 'full_regions.district', 'full_regions.region', 'organization_types.type')
            ->where('organizations.id', Auth::user()->org_id)
            ->first();
        $this->orgName = $organization->name;

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

        $subscription = DB::table('organization_subscriptions')
            ->where('organization_id', Auth::user()->org_id)
            ->whereNotNull('end_date')
            ->latest()
            ->first();

        $packages = DB::table('subscription_packages')
            ->get();

        // dd(Auth::user()->org_id);
        return view('livewire.dashboard', ['totalAppointments' => $totalAppointments, 'totalPatients' => $totalPatients, 'totalPrescribers' => $totalPrescribers, 'totalSupporters' => $totalSupporters, 'patients' => $patients, 'supporters' => $supporters, 'org' => $organization, 'appointments' => $appointments, 'subscription' => $subscription, 'packages' => $packages]);
    }
}
