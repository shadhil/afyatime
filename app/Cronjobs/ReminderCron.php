<?php

namespace App\Cronjobs;

use App\Mail\SubscriptionPaidMail;
use Illuminate\Support\Facades\Mail;
use Log;

class ReminderCron
{

    public function __invoke()
    {


        //log that its run
        //Log::info("Cronjob has started", ['process' => '[foo-cron]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

        //and more
        $email = 'kijiwe1337@gmail.com';
        $details = [
            'title' => 'Reminder Testing in AfyaTime',
            'body' => 'Habari! Umeunganishwa kwenye mfumo wa AfyaTime, ambao utakusaidia kukumbusha siku zako za kuja hospitali zinapokaribia, bure bila malipo yoyote yale.'
        ];
        Mail::to($email)->send(new SubscriptionPaidMail($details));
        // Mail::to($email)->send(new Gmail($details));
    }
}
