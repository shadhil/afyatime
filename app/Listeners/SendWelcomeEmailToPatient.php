<?php

namespace App\Listeners;

use App\Events\FirstAppointment;
use App\Mail\Gmail;
use App\Mail\PatientWelcomeMail;
use App\Mail\SubscriptionPaidMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToPatient implements ShouldQueue
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
     * @param  FirstAppointment  $event
     * @return void
     */
    public function handle(FirstAppointment $event)
    {
        $patientInfo = $event->patient;
        if ($patientInfo['email'] != NULL) {
            $email = $patientInfo['email'];
            Mail::to($email)->send(new PatientWelcomeMail($patientInfo));
        }
    }
}
