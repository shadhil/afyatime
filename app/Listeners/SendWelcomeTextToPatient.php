<?php

namespace App\Listeners;

use App\Events\FirstAppointment;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendWelcomeTextToPatient
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
        $current_timestamp = Carbon::now('Africa/Dar_es_Salaam')->toDateTimeString();

        $patientInfo = $event->patient;

        $phone = Str::replace(' ', '', $patientInfo['phone']);
        $phone = Str::start(Str::substr($phone, -9), '255');

        $response = Http::withHeaders([
            'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBody('{"from": "NEXTSMS", "to": "' . $phone . '", "text": "Habari! Umeunganishwa kwenye mfumo wa AfyaTime, ambao utakusaidia kukumbusha siku zako za kuja hospitali zinapokaribia, bure bila malipo yoyote yale. "}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
        // return json_decode($response->body());
    }
}
