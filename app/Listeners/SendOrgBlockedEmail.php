<?php

namespace App\Listeners;

use App\Events\OrganizationBlocked;
use App\Mail\OrganizationBlockedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrgBlockedEmail
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
     * @param  OrganizationBlocked  $event
     * @return void
     */
    public function handle(OrganizationBlocked $event)
    {
        $details = $event->details;
        $email = $details['email'];
        Mail::to($email)->send(new OrganizationBlockedMail($details));
    }
}
