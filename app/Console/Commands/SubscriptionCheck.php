<?php

namespace App\Console\Commands;

use App\Mail\EndSubscriptionMail;
use App\Mail\RenewSubscriptionMail;
use App\Models\OrganizationSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SubscriptionCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscription status daily and perform required action.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptions = DB::table('organization_subscriptions')
            ->join('organizations', 'organizations.id', '=', 'organization_subscriptions.organization_id')
            ->select('organizations.id', 'organizations.name', 'organizations.email', 'organizations.phone_number', 'organization_subscriptions.end_date')
            ->where('organization_subscriptions.status', 'Subscribed')->get();

        $currentDate = Carbon::now('Africa/Dar_es_Salaam');
        foreach ($subscriptions as $subscription) {
            $dateDiff = Carbon::parse($subscription->end_date)->diffInDays($currentDate, false);
            if ($dateDiff == 7 || $dateDiff == 3 || $dateDiff == 0) {
                $details = [
                    'title' => 'Please Renew Subscription',
                    'body' => 'Hi! ' . $subscription->name . ' your subscription is about, ' . $dateDiff . ' day(s) have remained. Please follow the required steps to renew the organization subscription account'
                ];
                Mail::to($subscription->email)->send(new RenewSubscriptionMail($details));
            } elseif ($dateDiff == -1) {
                $updatedUser = OrganizationSubscription::where('organization_id', $subscription->id)
                    ->where('status', 'Subscribed')
                    ->update(['status' => 'UnSubscribed']);
                $details = [
                    'title' => 'Please Renew Subscription',
                    'body' => 'Hi! ' . $subscription->name . ' your subscription is about, ' . $dateDiff . ' day(s) have remained. Please follow the required steps to renew the organization subscription account'
                ];
                Mail::to($subscription->email)->send(new EndSubscriptionMail($details));
            }
        }

        return 0;
    }
}
