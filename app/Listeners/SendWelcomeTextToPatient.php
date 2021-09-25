<?php

namespace App\Listeners;

use App\Events\FirstAppointment;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendWelcomeTextToPatient implements ShouldQueue
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
        $patient = $event->patient;
        $phone = sms_phone_number($patient['phone']);

        Http::withHeaders([
            'Authorization' => 'Basic bmppd2F0ZWNoOkZseWluZ2NvbG91cnNAIzAx',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBody('{"from": "NEXTSMS", "to": "' . $phone . '", "text": "Ndugu ' . $patient["name"] . ' Karibu AFYATIME. Umeunganishwa kwenye mfumo wa kukumbushwa kuhudhuria miadi yako ya kliniki kwa njia ya SMS. Kituo chako cha kliniki ni ' . $patient["clinic"] . '. Karibu – AFYATIME. "}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
        // return json_decode($response->body());
    }
}
