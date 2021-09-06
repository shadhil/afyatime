<?php

namespace App\Http\Livewire\Admin;

use App\Models\OrganizationSubscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class OrganizationSubscriptions extends Component
{
    public $orgId;
    public $state = [];
    public $editState = [];

    public $showEditModal = false;

    public $subscriptionId = null;
    public $userId = null;


    public function mount($id)
    {
        $this->orgId = $id;
    }

    public function createSubscription()
    {
        // dd($this->state);
        Validator::make($this->state, [
            'package_id' => 'required',
            'paid_by' => 'required',
            'status' => 'required',
            'payment_ref' => 'required',
            'total_price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ])->validate();

        if (!empty($this->state['start_date'])) {
            $this->state['start_date'] = Carbon::createFromFormat('m/d/Y', $this->state['start_date'])->format('Y-m-d');
        }

        if (!empty($this->state['end_date'])) {
            $this->state['end_date'] = Carbon::createFromFormat('m/d/Y', $this->state['end_date'])->format('Y-m-d');
        }

        $this->state['organization_id'] = $this->orgId;

        $newSubscription = OrganizationSubscription::create($this->state);

        if ($newSubscription) {
            $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'Subscription added successfully!']);
        }
    }

    public function addSubscription()
    {
        $this->reset('state', 'subscriptionId');
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-subscription-modal');
    }

    public function editSubscription($subscriptionId)
    {
        $this->reset('state', 'subscriptionId');
        $this->showEditModal = true;
        $subscription = DB::table('organization_subscriptions')
            ->where('id', $subscriptionId)
            ->first();

        $collection = collect($subscription);
        $this->subscriptionId = $subscription->id;

        $this->state = $collection->toArray();

        if (!empty($this->state['start_date'])) {
            $this->state['start_date'] = Carbon::createFromFormat('Y-m-d', $this->state['start_date'])->format('m/d/Y');
        }

        if (!empty($this->state['end_date'])) {
            $this->state['end_date'] = Carbon::createFromFormat('Y-m-d', $this->state['end_date'])->format('m/d/Y');
        }

        $this->dispatchBrowserEvent('show-subscription-modal');
    }

    public function updateSubscription()
    {
        //dd($this->state);
        $validatedData =
            Validator::make($this->state, [
                'package_id' => 'required',
                'paid_by' => 'required',
                'status' => 'required',
                'payment_ref' => 'required',
                'total_price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ])->validate();

        if (!empty($this->state['start_date'])) {
            $this->editState['start_date'] = Carbon::createFromFormat('m/d/Y', $this->state['start_date'])->format('Y-m-d');
        }

        if (!empty($this->state['end_date'])) {
            $this->editState['end_date'] = Carbon::createFromFormat('m/d/Y', $this->state['end_date'])->format('Y-m-d');
        }

        $this->editState['status'] = $this->state['status'];
        $this->editState['payment_ref'] = $this->state['payment_ref'];
        $this->editState['total_price'] = $this->state['total_price'];

        OrganizationSubscription::find($this->subscriptionId)->update($this->editState);

        $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'subscription updated successfully!']);
    }

    public function render()
    {
        $users = DB::table('users')
            ->leftJoin('organizations', function ($join) {
                $join->on('organizations.id', '=', 'users.account_id')
                    ->where('users.account_type', 'organization');
            })
            ->leftJoin('prescribers', function ($join) {
                $join->on('prescribers.id', '=', 'users.account_id')
                    ->where('users.account_type', 'prescriber-admin');
            })
            ->select('users.*')
            ->where(function ($query) {
                $query->where('prescribers.organization_id', $this->orgId)
                    ->orWhere('organizations.id', $this->orgId);
            })->get();

        $subscriptions = DB::table('organization_subscriptions')
            ->join('subscription_packages', 'organization_subscriptions.package_id', '=', 'subscription_packages.id')
            ->join('users', 'organization_subscriptions.paid_by', '=', 'users.id')
            ->select('organization_subscriptions.*', 'subscription_packages.name AS package', 'subscription_packages.max_patients', 'subscription_packages.monthly_cost', 'users.name')
            ->where('organization_subscriptions.organization_id', $this->orgId)
            ->groupBy('organization_subscriptions.id')
            ->latest()
            ->paginate(5);

        $packages = DB::table('subscription_packages')->get();
        $org = DB::table('organizations')->select('name')->find($this->orgId);
        // dd($subscriptions);
        return view('livewire.admin.organization-subscriptions', ['subscriptions' => $subscriptions, 'users' => $users, 'packages' => $packages, 'org' => $org]);
    }
}
