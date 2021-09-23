<?php

namespace App\Http\Livewire\Admin;

use App\Events\OrganizationBlocked;
use App\Events\OrganizationUnsubscribed;
use App\Models\Admin;
use App\Models\OrganizationSubscription;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class OrganizationSubscriptions extends Component
{
    public $orgId;
    public $orgName;
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
            'payment_ref' => 'string',
            'start_date' => 'required',
            'end_date' => 'required',
        ])->validate();

        if (!empty($this->state['start_date'])) {
            $this->state['start_date'] = Carbon::createFromFormat('m/d/Y', $this->state['start_date'])->format('Y-m-d');
        }

        if (!empty($this->state['end_date'])) {
            $this->state['end_date'] = Carbon::createFromFormat('m/d/Y', $this->state['end_date'])->format('Y-m-d');
        }

        $diffDays = CarbonImmutable::parse($this->state['start_date'])->diffInDays(CarbonImmutable::parse($this->state['end_date']));
        $package = SubscriptionPackage::find($this->state['package_id']);
        if ($diffDays > 33) {
            // dd((float)(($diffDays % 33) + 1));
            $this->state['total_price'] = ($package->monthly_cost * (float)(($diffDays % 33) + 1));
        } else {
            $this->state['total_price'] = $package->monthly_cost;
        }
        $this->state['confirmed_by'] = Auth::user()->id;
        $this->state['status'] = '2';

        $prevSub = OrganizationSubscription::query()->latest()->first();
        $res = CarbonImmutable::parse($prevSub->end_date)->greaterThan(CarbonImmutable::parse($this->state['end_date']));

        if (!$res) {
            $this->state['organization_id'] = $this->orgId;

            $newSubscription = OrganizationSubscription::create($this->state);

            if ($newSubscription) {
                $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'Subscription added successfully!']);
            }
        } else {
            $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'please check the validity of the end date']);
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
            $this->state['old_end_date'] = $this->state['end_date'];
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
                'payment_ref' => 'string',
                'total_price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ])->validate();

        $res = CarbonImmutable::parse($this->state['end_date'])->greaterThan(CarbonImmutable::parse($this->state['old_end_date']));

        // dd($res);
        if ($res) {
            $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'you can not chnage date']);
        } else {

            $this->editState['status'] = $this->state['status'];
            $this->editState['payment_ref'] = $this->state['payment_ref'];

            if (Auth::user()->admin_type == Admin::SYSTEM) {
                $this->editState['total_price'] = $this->state['total_price'];
                if (!empty($this->state['start_date'])) {
                    $this->editState['start_date'] = CarbonImmutable::createFromFormat('m/d/Y', $this->state['start_date'])->format('Y-m-d');
                }

                if (!empty($this->state['end_date'])) {
                    $this->editState['end_date'] = CarbonImmutable::createFromFormat('m/d/Y', $this->state['end_date'])->format('Y-m-d');
                }
            }

            $OrgSubscription = OrganizationSubscription::find($this->subscriptionId);
            $OrgSubscription->update($this->editState);

            info(Auth::user()->name . ' Updated Subscription for ' . $this->orgName . ' with ID ' . $this->orgId);

            $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'subscription updated successfully!']);

            if ($this->state['status'] == '1') {
                $details = [
                    'name' => $OrgSubscription->organization->name,
                    'email' => $OrgSubscription->organization->email,
                    'date' => now()->format('m-d-Y'),
                ];
                OrganizationUnsubscribed::dispatch($details);
            }

            if ($this->state['status'] == '4') {
                $details = [
                    'name' => $OrgSubscription->organization->name,
                    'email' => $OrgSubscription->organization->email,
                    'date' => now()->format('m-d-Y'),
                ];
                OrganizationBlocked::dispatch($details);
            }
        }
    }

    public function deleteSubModal($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteSubscription()
    {
        $subscription = OrganizationSubscription::findOrFail($this->subscriptionId);

        $subscription->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Subscription deleted successfully!']);
    }

    public function render()
    {
        // $users = DB::table('users')
        //     ->leftJoin('organizations', function ($join) {
        //         $join->on('organizations.id', '=', 'users.account_id')
        //             ->where('users.account_type', 'organization');
        //     })
        //     ->leftJoin('prescribers', function ($join) {
        //         $join->on('prescribers.id', '=', 'users.account_id')
        //             ->where('users.account_type', 'prescriber-admin');
        //     })
        //     ->select('users.*')
        //     ->where(function ($query) {
        //         $query->where('prescribers.organization_id', $this->orgId)
        //             ->orWhere('organizations.id', $this->orgId);
        //     })->get();

        $users = User::query()
            ->where('org_id', $this->orgId)
            ->where(function ($query) {
                $query->where('account_type', 'organization')
                    ->orWhere('account_type', 'prescriber');
            })->get();

        // dd($users[0]->account);

        // $subscriptions = DB::table('organization_subscriptions')
        //     ->join('subscription_packages', 'organization_subscriptions.package_id', '=', 'subscription_packages.id')
        //     ->join('users', 'organization_subscriptions.paid_by', '=', 'users.id')
        //     ->select('organization_subscriptions.*', 'subscription_packages.name AS package', 'subscription_packages.max_patients', 'subscription_packages.monthly_cost', 'users.name')
        //     ->where('organization_subscriptions.organization_id', $this->orgId)
        //     ->groupBy('organization_subscriptions.id')
        //     ->latest()
        //     ->paginate(5);

        $subscriptions = OrganizationSubscription::query()->where('organization_id', $this->orgId)->latest()->paginate(6);

        $packages = SubscriptionPackage::all();
        // dd($packages);
        $org = DB::table('organizations')->select('name')->find($this->orgId);
        $this->orgName = $org->name;
        // dd($subscriptions);
        return view('livewire.admin.organization-subscriptions', ['subscriptions' => $subscriptions, 'users' => $users, 'packages' => $packages, 'org' => $org]);
    }
}
