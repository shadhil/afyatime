<?php

namespace App\Listeners;

use App\Events\FirstAppointment;
use App\Mail\Gmail;
use App\Mail\SubscriptionPaidMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailToPatient
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
        if ($patientInfo['email'] != 'none') {
            $email = $patientInfo['email'];
            $details = [
                'title' => 'Welcome to AfyaTime',
                'body' => 'Habari! Umeunganishwa kwenye mfumo wa AfyaTime, ambao utakusaidia kukumbusha siku zako za kuja hospitali zinapokaribia, bure bila malipo yoyote yale.'
            ];
            Mail::to($email)->send(new SubscriptionPaidMail($details));
            // Mail::to($email)->send(new Gmail($details));
        }
    }
}
