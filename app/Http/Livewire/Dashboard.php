<?php

namespace App\Http\Livewire;

use App\Events\SubscriptionPaid;
use App\Models\Appointment;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\Patient;
use App\Models\TreatmentSupporter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

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

        $organization = Organization::find(Auth::user()->org_id);
        $patients = Patient::query()
            ->where('organization_id', Auth::user()->org_id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $supporters = TreatmentSupporter::query()
            ->where('treatment_supporters.organization_id', Auth::user()->org_id)
            ->limit(5)
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
            ->limit(15)->get();

        $subscription = OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('status', '2')
            ->latest()
            ->first();

        $packages = DB::table('subscription_packages')
            ->get();

        // dd(Auth::user()->org_id);
        return view('livewire.dashboard', ['patients' => $patients, 'supporters' => $supporters, 'org' => $organization, 'appointments' => $appointments, 'subscription' => $subscription, 'packages' => $packages])->layout('layouts.base');
    }
}
