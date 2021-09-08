<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

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

        $dt = Carbon::now('Africa/Dar_es_Salaam');
        $current_time = $dt->toTimeString('minutes');
        $current_date = $dt->toDateString();
        $body = Carbon::parse('05:08');
        $timeDiff = $body->isSameHour($dt);
        dd($timeDiff);
        $future = $dt->addDays(7)->toDateString();
        $past = $dt->subDays(7)->toDateString();
        dd($body->toTimeString('minutes'));

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
            ->select('appointments.time_from', 'active_orgs.name', 'patients.first_name', 'patients.last_name', 'patients.email', 'patients.phone_number', 'patients.supporter_phone', 'medical_conditions.condition')
            ->where('appointments.date_of_visit', $current_date)
            ->groupBy('appointments.id')
            ->get();
        dd($appointments);

        // ->join('organizations', 'organizations.id', '=', 'organization_subscriptions.organization_id')
        // ->select('organizations.id', 'organizations.name', 'organizations.email', 'organizations.phone_number', 'organization_subscriptions.end_date')
        // Carbon::createFromFormat('m/d/Y', $current_timestamp)->format('Y-m-d');
        $appointments = DB::table('appointments')
            ->where('date_of_visit', $current_date)->get();

        foreach ($appointments as $appointment) {
            if ($appointment->time_from == $current_time . ':00') {
                dd('SAme');
            }
        }

        dd($appointments);
        return view('livewire.api-tests', ['item' => $appointment]);
    }
}
