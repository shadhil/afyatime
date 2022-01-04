<?php

namespace App\Jobs;

use App\Mail\PatientWelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class WelcomePatientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $patient;

    public function __construct($patient)
    {
        $this->patient = $patient;
    }

    public function handle()
    {
        $patient = $this->patient;

        $phone = sms_phone_number($patient['phone']);
        Http::withHeaders([
            'Authorization' => 'Basic bmppd2F0ZWNoOkZseWluZ2NvbG91cnNAIzAx',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBody('{"from": "AfyaTime", "to": "' . $phone . '", "text": "Ndugu ' . $patient["name"] . ' Karibu AFYATIME. Umeunganishwa kwenye mfumo wa kukumbushwa kuhudhuria miadi yako ya kliniki kwa njia ya SMS. Kituo chako cha kliniki ni ' . $patient["clinic"] . '. Karibu – AFYATIME. "}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');

        if ($patient['email'] != NULL) {
            $email = $patient['email'];
            Mail::to($email)->send(new PatientWelcomeMail($patient));
        }
    }
}
