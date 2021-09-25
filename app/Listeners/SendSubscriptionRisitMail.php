<?php

namespace App\Listeners;

use App\Events\SubscriptionConfirmed;
use App\Mail\SubscriptionRisitMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionRisitMail
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
     * @param  SubscriptionConfirmed  $event
     * @return void
     */
    public function handle(SubscriptionConfirmed $event)
    {
        $orgSub = $event->orgSub;
        if ($orgSub->status = '2') {
            // $org = DB::table('organizations')->select('name')->find($details['org_id']);
            $email = $orgSub->organization->email;
            $details = [
                'name' => $orgSub->organization->name,
                'end_date' => $orgSub->end_date,
                'package' => $orgSub->package->name,
            ];
            Mail::to($email)->send(new SubscriptionRisitMail($details));
        } else {
            info('Subscription with STATUS ' . $orgSub->status . ' for organization ' . $orgSub->organization->name);
        }
    }
}
