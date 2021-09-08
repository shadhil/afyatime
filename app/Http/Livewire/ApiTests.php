<?php

namespace App\Http\Livewire;

use App\Mail\Gmail;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;

class ApiTests extends Component
{
    public function render()
    {
        // $response = Http::get('https://fakerestapi.azurewebsites.net/api/v1/Activities');
        // $body = json_decode($response->body());

        // $response = Http::get('https://fakerestapi.azurewebsites.net/api/v1/Activities/22');
        // $body = json_decode($response->body());

        // $response = Http::post('https://fakerestapi.azurewebsites.net/api/v1/Activities', [
        //     'title' => 'My Activity',
        //     'completed' => true,
        //     'dueDate' => Carbon::now(),
        // ]);
        // $body = json_decode($response->body());

        // $response = Http::put('https://fakerestapi.azurewebsites.net/api/v1/Activities/22', [
        //     'title' => 'My Updated Activity',
        //     'completed' => true,
        //     'dueDate' => Carbon::now(),
        // ]);
        // $body = json_decode($response->body());

        // $response = Http::get('https://fakerestapi.azurewebsites.net/api/v1/Activities');
        // $body = json_decode($response->body());

        // $response = Http::withHeaders([
        //     'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json'
        // ])->withBody('{"from": "NEXTSMS", "to": "255625592636", "text": "Hi! Shazy this is the message test."}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
        // $body = json_decode($response->body());

        $dt = CarbonImmutable::now('Africa/Dar_es_Salaam');
        $current_time = $dt->toTimeString('minutes');
        $current_date = $dt->toDateString();
        // $body = Carbon::parse('05:08');
        // $timeDiff = $body->isSameHour($dt);
        // // dd($timeDiff);
        // $future = $dt->addDays(7)->toDateString();
        // $now = $dt->toDateString();
        // // dd($past);

        // $activeOrgs = DB::table('organizations')
        //     ->join('organization_subscriptions', 'organizations.id', '=', 'organization_subscriptions.organization_id')
        //     ->select('organizations.*')
        //     ->where('organization_subscriptions.status', 'Subscribed')
        //     ->groupBy('organizations.id');

        // $patients = DB::table('patients')
        //     ->leftJoin('treatment_supporters', 'treatment_supporters.id', '=', 'patients.supporter_id')
        //     ->select('patients.*', 'treatment_supporters.phone_number as supporter_phone')
        //     ->groupBy('patients.id');

        // $appointments = DB::table('appointments')
        //     ->joinSub($activeOrgs, 'active_orgs', function ($join) {
        //         $join->on('appointments.organization_id', '=', 'active_orgs.id');
        //     })
        //     ->joinSub($patients, 'patients', function ($join) {
        //         $join->on('patients.id', '=', 'appointments.patient_id');
        //     })
        //     ->join('medical_conditions', 'medical_conditions.id', '=', 'appointments.condition_id')
        //     ->select('appointments.time_from', 'active_orgs.name', 'patients.first_name', 'patients.last_name', 'patients.email', 'patients.phone_number', 'patients.supporter_phone', 'medical_conditions.condition')
        //     ->whereBetween('appointments.date_of_visit', [$now, $future])
        //     ->groupBy('appointments.id')
        //     ->get();
        // dd($appointments);

        // // ->join('organizations', 'organizations.id', '=', 'organization_subscriptions.organization_id')
        // // ->select('organizations.id', 'organizations.name', 'organizations.email', 'organizations.phone_number', 'organization_subscriptions.end_date')
        // // Carbon::createFromFormat('m/d/Y', $current_timestamp)->format('Y-m-d');
        // $appointments = DB::table('appointments')
        //     ->where('date_of_visit', $current_date)->get();

        // foreach ($appointments as $appointment) {
        //     if ($appointment->time_from == $current_time . ':00') {
        //         dd('SAme');
        //     }
        // }


        $future = $dt->addDays(7)->toDateString();
        $now = $dt->toDateString();
        $activeOrgs = DB::table('organizations')
            ->join('organization_subscriptions', 'organizations.id', '=', 'organization_subscriptions.organization_id')
            ->select('organizations.*')
            ->where('organization_subscriptions.status', 'Subscribed')
            ->groupBy('organizations.id');

        $patients = DB::table('patients')
            ->leftJoin('treatment_supporters', 'treatment_supporters.id', '=', 'patients.supporter_id')
            ->select('patients.*', 'treatment_supporters.phone_number as supporter_phone')
            ->groupBy('patients.id');

        $appointments = DB::table('appointments')
            ->joinSub($activeOrgs, 'active_orgs', function ($join) {
                $join->on('appointments.organization_id', '=', 'active_orgs.id');
            })
            ->joinSub($patients, 'patients', function ($join) {
                $join->on('patients.id', '=', 'appointments.patient_id');
            })
            ->join('medical_conditions', 'medical_conditions.id', '=', 'appointments.condition_id')
            ->select('appointments.date_of_visit', 'appointments.time_from', 'active_orgs.name', 'patients.first_name', 'patients.last_name', 'patients.email', 'patients.phone_number', 'patients.supporter_phone', 'medical_conditions.condition')
            ->whereBetween('appointments.date_of_visit', [$now, $future])
            ->groupBy('appointments.id')
            ->get();

        foreach ($appointments as $appointment) {

            $dateDiff = Carbon::parse($appointment->date_of_visit)->diffInDays($current_date, false);
            $appointmentDate = "siku ya leo";
            if ($dateDiff == 7 || $dateDiff == 3 || $dateDiff == 0) {
                if (
                    $dateDiff == 7 || $dateDiff == 3
                ) {
                    $appointmentDate =
                        Carbon::createFromFormat('Y-m-d', $appointment->date_of_visit)->format('F j, Y');
                }
                $phone = Str::replace(' ', '', $appointment->phone_number);
                $phone = Str::start(Str::substr($phone, -9), '255');


                $response = Http::withHeaders([
                    'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->withBody('{"from": "NEXTSMS", "to": "' . $phone . '", "text": "Habari! ' . $appointment->first_name . ' ' . $appointment->last_name . ', Kupitia ' . $appointment->name . ' tunakumbushwa unatakiwa kuhudhuria kwenye kituo chako cha afya ' . $appointmentDate . '.    Taarifa hii inafikishwa kwako kupitia mfumo wa AfyaTime. "}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
                // dd(json_decode($response->body()));
                if ($appointment->email) {
                    $details = [
                        'title' => 'Appointment Reminder',
                        'body' => 'Habari! ' . $appointment->first_name . ' ' . $appointment->last_name . ', Kupitia ' . $appointment->name . ' tunakumbushwa unatakiwa kuhudhuria kwenye kituo chako cha afya ' . $appointmentDate . '.    Taarifa hii inafikishwa kwako kupitia mfumo wa AfyaTime.'
                    ];
                    Mail::to($appointment->email)->send(new Gmail($details));
                }
                if ($appointment->supporter_phone) {

                    $supporterPhone = Str::replace(' ', '', $appointment->supporter_phone);
                    $supporterPhone = Str::start(Str::substr($supporterPhone, -9), '255');

                    $response = Http::withHeaders([
                        'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->withBody('{"from": "NEXTSMS", "to": "' . $supporterPhone . '", "text": "Habari! Tafadhali unataarifiwa kupitia ' . $appointment->name . ' kumkumbusha' . $appointment->first_name . ' ' . $appointment->last_name . ', kuhudhuria kwenye kituo chake cha afya ' . $appointmentDate . '.    Taarifa hii inafikishwa kwako kupitia mfumo wa AfyaTime. "}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
                }
                dd($response);
            }
        }

        dd($appointments);
        return view('livewire.api-tests', ['item' => $appointment]);
    }
}
