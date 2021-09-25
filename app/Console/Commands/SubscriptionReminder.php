<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionReminderMail;
use App\Models\OrganizationSubscription;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SubscriptionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send reminder to organizations whom subscription is about to end.';

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

        $orgSubs = OrganizationSubscription::query()
            ->where('end_date', '>=', $today)
            ->where('status', 2)
            ->get();

        // dd($appointments);

        foreach ($orgSubs as $subscription) {
            $endDate = CarbonImmutable::parse($subscription->end_date);
            dd($endDate->format('F j, Y'));

            $details = [
                'msg' => "Hello “Organisation Name”, this is to alert you that a subscription to AFYATIME is about to expire.  Please review the following details.
                Your account subscription will expire on “organisation subscription expiry date”. Be aware that if you fail to renew your subscription after the above date, your clients will not receive their SMS reminders.",
                'email' => $subscription->organization->email,
                'phone' => $subscription->organization->phone_number
            ];
            // dd($subscription->reminder_msg);
            $diffDay = $today->diffInDays($endDate, false);
            if ($diffDay == 7) {
                if (!is_subscription_paid($subscription->organization_id)) {
                    $admins = organization_admins($subscription->organization_id);
                    foreach ($admins as $admin) {
                        if ($admin->email != null) {
                            Mail::to($admin->email)->send(new SubscriptionReminderMail($details));
                        }
                        if ($admin->account->phone_number != null) {
                            send_sms($details['phone'], $details['msg']);
                        }
                    }
                    Mail::to($details['email'])->send(new SubscriptionReminderMail($details));
                    if ($details['phone'] != null) {
                        send_sms($details['phone'], $details['msg']);
                    }
                }
            } elseif ($diffDay == 3) {
                if (!is_subscription_paid($subscription->organization_id)) {
                    $admins = organization_admins($subscription->organization_id);
                    foreach ($admins as $admin) {
                        if ($admin->email != null) {
                            Mail::to($admin->email)->send(new SubscriptionReminderMail($details));
                        }
                        if ($admin->account->phone_number != null) {
                            send_sms($details['phone'], $details['msg']);
                        }
                    }
                    Mail::to($details['email'])->send(new SubscriptionReminderMail($details));
                    if ($details['phone'] != null) {
                        send_sms($details['phone'], $details['msg']);
                    }
                }
            } elseif ($diffDay == 1) {
                if (!is_subscription_paid($subscription->organization_id)) {
                    $admins = organization_admins($subscription->organization_id);
                    foreach ($admins as $admin) {
                        if ($admin->email != null) {
                            Mail::to($admin->email)->send(new SubscriptionReminderMail($details));
                        }
                        if ($admin->account->phone_number != null) {
                            send_sms($details['phone'], $details['msg']);
                        }
                    }
                    Mail::to($details['email'])->send(new SubscriptionReminderMail($details));
                    if ($details['phone'] != null) {
                        send_sms($details['phone'], $details['msg']);
                    }
                }
            } elseif ($diffDay == -1) {
                if (!is_subscription_paid($subscription->organization_id)) {
                    $admins = organization_admins($subscription->organization_id);
                    foreach ($admins as $admin) {
                        if ($admin->email != null) {
                            Mail::to($admin->email)->send(new SubscriptionReminderMail($details));
                        }
                        if ($admin->account->phone_number != null) {
                            send_sms($details['phone'], $details['msg']);
                        }
                    }
                    Mail::to($details['email'])->send(new SubscriptionReminderMail($details));
                    if ($details['phone'] != null) {
                        send_sms($details['phone'], $details['msg']);
                    }
                }
            }
        }
    }
}
