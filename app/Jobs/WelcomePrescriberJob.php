<?php

namespace App\Jobs;

use App\Mail\PrescriberWelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WelcomePrescriberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $prescriber;

    public function __construct($prescriber)
    {
        $this->prescriber = $prescriber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->prescriber['email'];
        Mail::to($email)->send(new PrescriberWelcomeMail($this->prescriber));
    }
}
