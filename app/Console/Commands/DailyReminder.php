<?php

namespace App\Console\Commands;

use App\Mail\Gmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DailyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive email and SMS to everyone whose appointment day is approaching.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dt = Carbon::now('Africa/Dar_es_Salaam');
        $current_time = $dt->toTimeString();
        $current_date = $dt->toDateString();

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

        foreach ($appointments as $appointment) {
            if ($appointment->time_from == $current_time . ':00') {
                $phone = Str::replace(' ', '', $appointment->phone_number);
                $phone = Str::start(Str::substr($phone, -9), '255');

                $response = Http::withHeaders([
                    'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->withBody('{"from": "NEXTSMS", "to": "' . $phone . '", "text": "Habari! Umeunganishwa kwenye mfumo wa AfyaTime, ambao utakusaidia kukumbusha siku zako za kuja hospitali zinapokaribia, bure bila malipo yoyote yale. "}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
                return json_decode($response->body());
            }
        }




        $currentDate = Carbon::now('Africa/Dar_es_Salaam');
    }
}
