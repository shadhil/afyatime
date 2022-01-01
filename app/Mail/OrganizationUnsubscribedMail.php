<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizationUnsubscribedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject('Subscription has Ended')
            ->from('no-reply@afyatime.com', 'AfyaTime')
            ->to($this->details['email'])
            ->replyTo('support@afyatime.com')
            ->markdown('emails.organization-unsubscribed-mail', $this->details);
    }
}
