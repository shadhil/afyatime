<?php

namespace App\Listeners;

use App\Events\OrganizationUnsubscribed;
use App\Mail\OrganizationUnsubscribedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrgUnsubscribedEmail
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
     * @param  OrganizationUnsubscribed  $event
     * @return void
     */
    public function handle(OrganizationUnsubscribed $event)
    {
        $details = $event->details;
        $email = $details['email'];
        Mail::to($email)->send(new OrganizationUnsubscribedMail($details));
    }
}
