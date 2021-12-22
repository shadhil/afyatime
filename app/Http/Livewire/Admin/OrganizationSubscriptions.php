<?php

namespace App\Http\Livewire\Admin;

use App\Events\OrganizationBlocked;
use App\Events\OrganizationUnsubscribed;
use App\Jobs\EmailNotificationJob;
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
use Livewire\WithPagination;
use Illuminate\Support\Str;

class OrganizationSubscriptions extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $orgId;
    public $orgName;
    public $state = [];
    public $editState = [];


    public $vPatient;
    public $vPrescriber;
    public $vDate;
    public $vTime;
    public $vType;
    public $vReceiver;
    public $vCondition;

    public $showEditModal = false;

    public $subscriptionId = null;
    public $userId = null;

    public $isfirstSub = false;


    public function mount($id)
    {
        $this->orgId = $id;
        $org = DB::table('organizations')->select('name')->find($id);
        $this->orgName = $org->name;
    }

    public function newCode()
    {
        $testCode = '';
        $isFound = false;
        while (!$isFound) {
            $testCode = Str::before((string) Str::uuid(), '-');
            $code = DB::table('organization_subscriptions')
                ->select('payment_ref')
                ->where('payment_ref', $testCode)
                ->first();
            if (!$code) {
                $isFound = true;
            }
        }
        return Str::upper($testCode);
    }

    public function createSubscription()
    {
        // dd($this->state);
        Validator::make($this->state, [
            'package_id' => 'required',
            'paid_by' => 'required',
            'status' => 'string',
            'start_date' => 'required',
            'end_date' => 'required',
        ])->validate();

        $diffDays = CarbonImmutable::parse($this->state['start_date'])->diffInDays(CarbonImmutable::parse($this->state['end_date']));
        $package = SubscriptionPackage::find($this->state['package_id']);
        if ($diffDays > 33) {
            // dd((float)(($diffDays % 33) + 1));
            $this->state['total_price'] = ($package->monthly_cost * (float)(($diffDays % 33) + 1));
        } else {
            $this->state['total_price'] = $package->monthly_cost;
        }
        $this->state['confirmed_by'] = Auth::user()->id;
        $this->state['status'] = $this->state['status'];
        $this->state['payment_ref'] = $this->newCode();

        $prevSub = OrganizationSubscription::query()->latest()->first();
        if ($prevSub != null) {
            $res = CarbonImmutable::parse($prevSub->end_date)->greaterThan(CarbonImmutable::parse($this->state['end_date']));
        } else {
            $res = false;
        }

        if (!$res) {
            $this->state['organization_id'] = $this->orgId;

            if (!empty($this->state['start_date'])) {
                $this->state['start_date'] = db_date($this->state['start_date']);
            }

            if (!empty($this->state['end_date'])) {
                $this->state['end_date'] = db_date($this->state['end_date']);
            }

            $newSubscription = OrganizationSubscription::create($this->state);

            if ($newSubscription) {
                $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'Subscription added successfully!']);

                if (!$this->isfirstSub && $this->state['status'] == '2') {
                    $details = [
                        'name' => $newSubscription->organization->name,
                        'email' => $newSubscription->organization->email,
                        'subject' => 'Subscription Renewal',
                        'msg' => 'Hello! ' . $newSubscription->organization->name . '\'s subscriptions has been renewed successfully under the package ' . $newSubscription->package->name . '. Ths subscription will end on ' . $newSubscription->end_date . '.'
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
            $this->state['start_date'] = form_date($this->state['start_date']);
        }

        if (!empty($this->state['end_date'])) {
            $this->state['end_date'] = form_date($this->state['end_date']);
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

            if (Auth::user()->status == '2') {
                $this->editState['total_price'] = $this->state['total_price'];

                if (!empty($this->state['start_date'])) {
                    $this->state['start_date'] = db_date($this->state['start_date']);
                }

                if (!empty($this->state['end_date'])) {
                    $this->state['end_date'] = db_date($this->state['end_date']);
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
        $users = User::query()
            ->where('org_id', $this->orgId)
            ->where(function ($query) {
                $query->where('account_type', 'organization')
                    ->orWhere('account_type', 'prescriber');
            })->get();

        $subscriptions = OrganizationSubscription::query()->where('organization_id', $this->orgId)->latest()->paginate(12);
        $this->isfirstSub = $subscriptions->total() > 0 ? false : true;
        // dd($this->isfirstSub);

        $packages = SubscriptionPackage::all();
        // dd($packages);
        // dd($subscriptions);
        return view('livewire.admin.organization-subscriptions', ['subscriptions' => $subscriptions, 'users' => $users, 'packages' => $packages])->layout('layouts.admin-base');
    }
}
