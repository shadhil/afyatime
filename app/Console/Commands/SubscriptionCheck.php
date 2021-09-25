<?php

namespace App\Console\Commands;

use App\Mail\EndSubscriptionMail;
use App\Mail\RenewSubscriptionMail;
use App\Models\OrganizationSubscription;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
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
        $today = CarbonImmutable::parse(\Carbon\Carbon::now()->format('Y-m-d'));

        $endSubs = OrganizationSubscription::query()
            ->where('end_date', '<', $today)
            ->where('status', 2)
            ->get();

        foreach ($endSubs as $subscription) {
            $endDate = CarbonImmutable::parse($subscription->end_date);
            $diffDay = $today->diffInDays($endDate, false);
            if ($diffDay == -2) {
                $subscription->status = 1;
                $subscription->save();
            }
        }

        $unSubs = OrganizationSubscription::query()
            ->where('end_date', '>', $today)
            ->where('status', 1)
            ->get();


        foreach ($unSubs as $subscription) {
            $endDate = CarbonImmutable::parse($subscription->end_date);
            $diffDay = $today->diffInDays($endDate, false);
            if ($diffDay <= -2) {
                if (is_subscription_paid($subscription->organization_id)) {
                    $subscription->status = 2;
                    $subscription->save();
                }
            }
        }
    }
}
