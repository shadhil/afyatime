<?php

namespace App\Http\Livewire;

use App\Jobs\EmailNotificationJob;
use App\Models\OrganizationSubscription;
use App\Models\SubscriptionPackage;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Subscriptions extends Component
{

    public $orgId;
    public $orgName;
    public $state = [];
    public $editState = [];

    public $showEditModal = false;
    public $showViewModal = false;

    public $subscriptionId = null;
    public $userId = null;

    public $isfirstSub = false;


    public function createSubscription()
    {
        // dd($this->state);
        Validator::make($this->state, [
            'package_id' => 'required',
            'payment_ref' => 'string',
            'start_date' => 'required',
            'end_date' => 'required',
        ])->validate();

        if (!empty($this->state['start_date'])) {
            $this->state['start_date'] = CarbonImmutable::createFromFormat('m/d/Y', $this->state['start_date'])->format('Y-m-d');
        }

        if (!empty($this->state['end_date'])) {
            $this->state['end_date'] = CarbonImmutable::createFromFormat('m/d/Y', $this->state['end_date'])->format('Y-m-d');
        }

        $diffDays = CarbonImmutable::parse($this->state['start_date'])->diffInDays(CarbonImmutable::parse($this->state['end_date']));
        $package = SubscriptionPackage::find($this->state['package_id']);
        if ($diffDays > 33) {
            // dd((float)(($diffDays % 33) + 1));
            $this->state['total_price'] = ($package->monthly_cost * (float)(($diffDays % 33) + 1));
        } else {
            $this->state['total_price'] = $package->monthly_cost;
        }
        $this->state['paid_by'] = Auth::user()->id;
        $this->state['status'] = '3';

        $prevSub = OrganizationSubscription::query()->latest()->first();
        if ($prevSub != null) {
            $res = CarbonImmutable::parse($prevSub->end_date)->greaterThan(CarbonImmutable::parse($this->state['end_date']));
        } else {
            $res = false;
        }

        if (!$res) {
            $this->state['organization_id'] = $this->orgId;

            $newSubscription = OrganizationSubscription::create($this->state);

            if ($newSubscription) {
                $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'Subscription added successfully!']);

                if (!$this->isfirstSub && $this->state['status'] == '2') {
                    $details = [
                        'name' => '$newSubscription->organization->name',
                        'email' => 'admin@afyatime.co.tz',
                        'subject' => 'Subscription Renewal',
                        'msg' => 'NEW! ' . $newSubscription->organization->name . '\'s new subscriptions has been paid successfully under the package ' . $newSubscription->package->name . '. Ths subscription will end on ' . $newSubscription->end_date . '. Please enter in the system to confirm payment'
                    ];
                    EmailNotificationJob::dispatch($details);
                }
            }
        } else {
            $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'please check the validity of the end date']);
        }
    }

    public function addSubscription()
    {
        $this->reset('state', 'subscriptionId');
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->dispatchBrowserEvent('show-subscription-modal');
    }

    public function editSubscription($subscriptionId, $action = "edit")
    {
        $this->reset('state', 'subscriptionId');
        $this->showEditModal = true;
        if ($action == 'view') {
            $this->showViewModal = true;
        } else {
            $this->showViewModal = false;
        }
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

            // if (Auth::user()->admin_type == Admin::SYSTEM) {
            //     $this->editState['total_price'] = $this->state['total_price'];
            //     if (!empty($this->state['start_date'])) {
            //         $this->editState['start_date'] = CarbonImmutable::createFromFormat('m/d/Y', $this->state['start_date'])->format('Y-m-d');
            //     }

            //     if (!empty($this->state['end_date'])) {
            //         $this->editState['end_date'] = CarbonImmutable::createFromFormat('m/d/Y', $this->state['end_date'])->format('Y-m-d');
            //     }
            // }

            $OrgSubscription = OrganizationSubscription::find($this->subscriptionId);
            $OrgSubscription->update($this->editState);

            info(Auth::user()->name . ' Updated Subscription for ' . $this->orgName . ' with ID ' . $this->orgId);

            $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'subscription updated successfully!']);

            if ($this->state['status'] == '1') {
                $details = [
                    'name' => $OrgSubscription->organization->name,
                    'email' => $OrgSubscription->organization->email,
                    'subject' => 'Subscription Ended',
                    'msg' => 'Hello! ' . $OrgSubscription->organization->name . ' your account subscription is ended on ' . now()->format('m-d-Y') . '. You can\'t use appointment features in our app.'
                ];
                EmailNotificationJob::dispatch($details);
            }

            if ($this->state['status'] == '5') {
                $details = [
                    'name' => $OrgSubscription->organization->name,
                    'email' => $OrgSubscription->organization->email,
                    'subject' => 'Subscription Blocked',
                    'msg' => 'Hello! ' . $OrgSubscription->organization->name . ' your account have been blocked to use in AfyaTime from ' . now()->format('m-d-Y') . '. You can\'t use any of the features in our app.'
                ];
                EmailNotificationJob::dispatch($details);
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
        $subscriptions = OrganizationSubscription::query()->where('organization_id', Auth::user()->org_id)->latest()->paginate(15);
        $this->isfirstSub = $subscriptions->total() > 0 ? false : true;
        // dd($this->isfirstSub);

        $packages = SubscriptionPackage::all();
        // dd($packages);
        // dd($subscriptions);
        return view('livewire.subscriptions', ['subscriptions' => $subscriptions, 'packages' => $packages]);
    }
}
