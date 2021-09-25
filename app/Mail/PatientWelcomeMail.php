<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;

    public function __construct($patient)
    {
        $this->patient = $patient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to AfyaTrack')
            ->from('no-reply@afyatime.co.tz', 'AfyaTime')
            ->to($this->patient['email'])
            ->replyTo('support@afyatime.co.tz')
            ->markdown('emails.patient-welcome-mail', $this->patient);
    }
}
