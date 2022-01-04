<?php

namespace App\Listeners;

use App\Events\SubscriptionPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendPaymentTextToAdmin
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
     * @param  SubscriptionPaid  $event
     * @return void
     */
    public function handle(SubscriptionPaid $event)
    {
        $subscriberInfo = $event->details;
        $admins = DB::table('admins')->select('phone_numbers')->get();
        foreach ($admins as $admin) {
            $phone = Str::replace(' ', '', $admin->phone_number);
            $phone = Str::start(Str::substr($phone, -9), '255');

            $response = Http::withHeaders([
                'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->withBody('{"from": "AfyaTime", "to": "' . $phone . '", "text": "Hi! There is new subscription payment from ' . $subscriberInfo->organization . ', please check and confirm the details."}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
            return json_decode($response->body());
        }
    }
}
