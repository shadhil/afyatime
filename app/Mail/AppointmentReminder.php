<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subscription Reminder')
            ->from('no-reply@afyatime.com', 'AfyaTime')
            ->to($this->details['email'])
            ->replyTo('support@afyatime.com')
            ->markdown('emails.mail-template', $this->details);
    }
}
