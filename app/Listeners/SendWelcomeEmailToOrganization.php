<?php

namespace App\Listeners;

use App\Events\OrganizationRegistered;
use App\Mail\PrescriberWelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToOrganization
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
     * @param  OrganizationRegistered  $event
     * @return void
     */
    public function handle(OrganizationRegistered $event)
    {
        $details = $event->details;
        $org = DB::table('organizations')->select('name')->find($details->org_id);
        $email = $details->email;
        $details = [
            'title' => 'Welcome to AfyaTime',
            'body' => 'Hi! ' . $details->name . ' you have been registerd in AfyaTime Patient Reminder System as subcriber at ' . $org->name . '. The following credentials below can be used after clicking <a href="https://afyatime.test/login">this link</a> <br/>
            <b>Email: </b> <i>' . $email . '</i> <br />
            <b>PAssword: </b> <i>' . $details->password . '</i> <br />'
        ];
        Mail::to($email)->send(new PrescriberWelcomeMail($details));
    }
}
