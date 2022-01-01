<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizationWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject('Welcome to AfyaTime')
            ->from('no-reply@afyatime.com', 'AfyaTime')
            ->to($this->details['email'])
            ->replyTo('support@afyatime.com')
            ->markdown('emails.organization-welcome-mail', $this->details);
    }
}
