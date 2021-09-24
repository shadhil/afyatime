<?php

namespace App\Listeners;

use App\Events\PrescriberRegistered;
use App\Mail\Gmail;
use App\Mail\PrescriberWelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToPrescriber
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
     * @param  PrescriberRegistered  $event
     * @return void
     */
    public function handle(PrescriberRegistered $event)
    {
        $email = $event->details['email'];
        Mail::to($email)->send(new PrescriberWelcomeMail($event->details));
    }
}
