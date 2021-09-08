<?php

namespace App\Listeners;

use App\Events\SubscriptionPaid;
use App\Mail\SubscriptionPaidMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendPaymentEmailToAdmin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SubscriptionPaid  $event
     * @return void
     */
    public function handle(SubscriptionPaid $event)
    {
        $subscriberInfo = $event->details;
        $admins = DB::table('admins')->select('email')->get();
        foreach ($admins as $admin) {

            $email = $admin->email;
            $details = [
                'title' => 'Subscription Payment Confirmation',
                'body' => 'Hi there is subscription payment need confirmation from ' . $subscriberInfo->organization . '. Please follow up and confirm subscription or contact the the payer for more details'
            ];
            Mail::to($email)->send(new SubscriptionPaidMail($details));
        }
    }
}
