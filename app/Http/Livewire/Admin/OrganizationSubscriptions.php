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

    public $package_details;
    public $package_id;
    public $package_duration;
    public $start_date;
    public $end_date;
    public $old_end_date;
    public $status;
    public $disabled = "";
    public $payment_ref;


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

    public function updatedPackageId($value)
    {
        if ($this->package_duration != null) {
            $package = DB::table('subscription_packages')->find($value);
            if ($this->package_duration == 'yearly') {
                $this->package_details = $package->yearly_appointments . ' Appointments - @ Tsh.' . $package->yearly_cost;
            } else {
                $this->package_details = $package->monthly_appointments . ' Appointments - @ Tsh.' . $package->monthly_cost;
            }
        }
    }

    public function updatedPackageDuration($value)
    {
        if ($this->package_id != null) {
            $package = DB::table('subscription_packages')->find($this->package_id);
            if ($value == 'yearly') {
                $this->package_details = $package->yearly_appointments . ' Appointments - @ Tsh.' . $package->yearly_cost;
            } else {
                $this->package_details = $package->monthly_appointments . ' Appointments - @ Tsh.' . $package->monthly_cost;
            }
        }
    }

    public function createSubscription()
    {

        // $endDate = CarbonImmutable::parse($this->start_date)->addMonth();
        // dd($endDate->format('Y-m-d'));
        $validatedData = $this->validate([
            'package_id' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'package_duration' => 'required'
        ]);

        // $diffDays = CarbonImmutable::parse($this->state['start_date'])->diffInDays(CarbonImmutable::parse($this->state['end_date']));
        // $package = SubscriptionPackage::find($this->state['package_id']);

        // if ($diffDays > 33) {
        //     // dd((float)(($diffDays % 33) + 1));
        //     $this->state['total_price'] = ($package->monthly_cost * (float)(($diffDays % 33) + 1));
        // } else {
        //     $this->state['total_price'] = $package->monthly_cost;
        // }
        // $this->state['confirmed_by'] = Auth::user()->id;
        // $this->state['status'] = $this->state['status'];
        // $this->state['payment_ref'] = $this->newCode();

        $prevSub = OrganizationSubscription::query()->where('organization_id', $this->orgId)->latest()->first();
        if ($prevSub != null) {
            $res = CarbonImmutable::parse($prevSub->end_date)->greaterThan(CarbonImmutable::parse($this->end_date));
        } else {
            $res = false;
        }

        if (!$res) {

            if ($this->package_duration == 'yearly') {
                $endDate = CarbonImmutable::parse($this->start_date)->addYear();
            } else {
                $endDate = CarbonImmutable::parse($this->start_date)->addMonth();
            }


            $newSubscription = OrganizationSubscription::create([
                'organization_id' => $this->orgId,
                'package_id' => $this->package_id,
                'start_date' => db_date($this->start_date),
                'end_date' => $endDate->format('Y-m-d'),
                'duration' => $this->package_duration,
                'payment_ref' => $this->newCode(),
                'status' => $this->status,
                'created_by' => Auth::user()->id,
            ]);

            if ($newSubscription) {
                admin_log('25', Auth::user()->id, 'orgSubscription', $newSubscription->id, $newSubscription->id, $newSubscription->id . ' - Package' . $newSubscription->package_id);

                $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'Subscription added successfully!']);

                if (!$this->isfirstSub && $this->status == '2') {
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
        $this->reset('subscriptionId', 'package_id', 'start_date', 'package_duration', 'status', 'payment_ref');
        $this->showEditModal = false;
        $this->disabled = "";
        $this->dispatchBrowserEvent('show-subscription-modal');
    }

    public function editSubscription($subscriptionId)
    {
        $this->reset('subscriptionId', 'package_id', 'start_date', 'package_duration', 'status', 'payment_ref');
        $this->showEditModal = true;
        if (Auth::user()->status != '2') {
            $this->disabled = "disabled";
        }

        $subscription = OrganizationSubscription::find($subscriptionId);

        $this->subscriptionId = $subscription->id;

        $this->start_date = form_date($subscription->start_date);
        $this->end_date = form_date($subscription->end_date);
        $this->old_end_date = form_date($subscription->end_date);
        $this->package_id = $subscription->package_id;
        $this->package_duration = $subscription->duration;
        $this->payment_ref = $subscription->payment_ref;
        $this->status = $subscription->status;

        $package = DB::table('subscription_packages')->find($this->package_id);
        if ($subscription->duration == 'yearly') {
            $this->package_details = $package->yearly_appointments . ' Appointments - @ Tsh.' . $package->yearly_cost;
        } else {
            $this->package_details = $package->monthly_appointments . ' Appointments - @ Tsh.' . $package->monthly_cost;
        }

        $this->dispatchBrowserEvent('show-subscription-modal');
    }

    public function updateSubscription()
    {
        //dd($this->state);
        $validatedData = $this->validate([
            'package_id' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'package_duration' => 'required'
        ]);

        $res = true;

        // dd($res);
        if ($res) {

            // $this->editState['status'] = $this->state['status'];
            // $this->editState['payment_ref'] = $this->state['payment_ref'];

            if (Auth::user()->status == '2') {
                // $this->editState['total_price'] = $this->state['total_price'];

                // if (!empty($this->state['start_date'])) {
                //     $this->state['start_date'] = db_date($this->state['start_date']);
                // }

                // if (!empty($this->state['end_date'])) {
                //     $this->state['end_date'] = db_date($this->state['end_date']);
                // }
            }

            $OrgSubscription = OrganizationSubscription::find($this->subscriptionId);
            $OrgSubscription->update([
                'package_id' => $this->package_id,
                'start_date' => db_date($this->start_date),
                'end_date' => db_date($this->end_date),
                'duration' => $this->package_duration,
                'status' => $this->status,
            ]);

            admin_log('26', Auth::user()->id, 'orgSubscription', $OrgSubscription->id, $OrgSubscription->id, $OrgSubscription->id . ' - Package' . $OrgSubscription->package_id);

            // info(Auth::user()->name . ' Updated Subscription for ' . $this->orgName . ' with ID ' . $this->orgId);

            $this->dispatchBrowserEvent('hide-subscription-modal', ['message' => 'subscription updated successfully!']);

            if ($this->status == '1') {
                $details = [
                    'name' => $OrgSubscription->organization->name,
                    'email' => $OrgSubscription->organization->email,
                    'subject' => 'Subscription Ended',
                    'msg' => 'Hello! ' . $OrgSubscription->organization->name . ' your account subscription is ended on ' . now()->format('m-d-Y') . '. You can\'t use appointment features in our app.'
                ];
                EmailNotificationJob::dispatch($details);
            }

            if ($this->status == '5') {
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

        admin_log('27', Auth::user()->id, 'orgSubscription', $subscription->id, $subscription->id . ' - ' . $subscription->organization->name);

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
