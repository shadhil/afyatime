<?php

namespace App\Console\Commands;

use App\Mail\Gmail;
use App\Mail\SubscriptionPaidMail;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
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
        $dt = CarbonImmutable::now('Africa/Dar_es_Salaam');
        $current_time = $dt->toTimeString();
        $current_date = $dt->toDateString();
        $earlyMorning = Carbon::parse('05:00');
        $lateMorning = Carbon::parse('18:00');

        $future = $dt->addDays(7)->toDateString();
        $now = $dt->toDateString();

        if ($lateMorning->isSameHour($dt)) {
            $activeOrgs = DB::table('organizations')
                ->join('organization_subscriptions', 'organizations.id', '=', 'organization_subscriptions.organization_id')
                ->select('organizations.*')
                ->where('organization_subscriptions.status', 'Subscribed')
                ->groupBy('organizations.id');

            $patients = DB::table('patients')
                ->leftJoin('treatment_supporters', 'treatment_supporters.id', '=', 'patients.supporter_id')
                ->select('patients.*', 'treatment_supporters.phone_number as supporter_phone', 'treatment_supporters.email as supporter_email')
                ->groupBy('patients.id');

            $appointments = DB::table('appointments')
                ->joinSub($activeOrgs, 'active_orgs', function ($join) {
                    $join->on('appointments.organization_id', '=', 'active_orgs.id');
                })
                ->joinSub($patients, 'patients', function ($join) {
                    $join->on('patients.id', '=', 'appointments.patient_id');
                })
                ->join('medical_conditions', 'medical_conditions.id', '=', 'appointments.condition_id')
                ->select('appointments.date_of_visit', 'appointments.time_from', 'active_orgs.name', 'patients.first_name', 'patients.last_name', 'patients.email', 'patients.phone_number', 'patients.supporter_phone', 'patients.supporter_email', 'medical_conditions.condition')
                ->whereBetween('appointments.date_of_visit', [$now, $future])
                ->groupBy('appointments.id')
                ->get();

            foreach ($appointments as $appointment) {

                $dateDiff = Carbon::parse($appointment->date_of_visit)->diffInDays($current_date, false);
                $appointmentDate = "siku ya leo";
                if ($dateDiff == 7 || $dateDiff == 3 || $dateDiff == 0) {
                    if ($dateDiff == 7 || $dateDiff == 3) {
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

                    if ($appointment->email) {
                        $details = [
                            'title' => 'Appointment Reminder',
                            'body' => 'Habari! ' . $appointment->first_name . ' ' . $appointment->last_name . ', Kupitia ' . $appointment->name . ' tunakumbushwa unatakiwa kuhudhuria kwenye kituo chako cha afya ' . $appointmentDate . '.    Taarifa hii inafikishwa kwako kupitia mfumo wa AfyaTime.'
                        ];
                        Mail::to($appointment->email)->send(new SubscriptionPaidMail($details));
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

                    if ($appointment->supporter_email) {
                        $details = [
                            'title' => 'Appointment Reminder',
                            'body' => 'Habari! Tafadhali unataarifiwa kupitia ' . $appointment->name . ' kumkumbusha' . $appointment->first_name . ' ' . $appointment->last_name . ', kuhudhuria kwenye kituo chake cha afya ' . $appointmentDate . '.    Taarifa hii inafikishwa kwako kupitia mfumo wa AfyaTime.'
                        ];
                        Mail::to($appointment->supporter_email)->send(new SubscriptionPaidMail($details));
                    }
                }
            }
        } elseif ($earlyMorning->isSameHour($dt)) {
            $activeOrgs = DB::table('organizations')
                ->join('organization_subscriptions', 'organizations.id', '=', 'organization_subscriptions.organization_id')
                ->select('organizations.*')
                ->where('organization_subscriptions.status', 'Subscribed')
                ->groupBy('organizations.id');

            $patients = DB::table('patients')
                ->leftJoin('treatment_supporters', 'treatment_supporters.id', '=', 'patients.supporter_id')
                ->select('patients.*', 'treatment_supporters.phone_number as supporter_phone', 'treatment_supporters.email as supporter_email')
                ->groupBy('patients.id');

            $appointments = DB::table('appointments')
                ->joinSub($activeOrgs, 'active_orgs', function ($join) {
                    $join->on('appointments.organization_id', '=', 'active_orgs.id');
                })
                ->joinSub($patients, 'patients', function ($join) {
                    $join->on('patients.id', '=', 'appointments.patient_id');
                })
                ->join('medical_conditions', 'medical_conditions.id', '=', 'appointments.condition_id')
                ->select('appointments.date_of_visit', 'appointments.time_from', 'active_orgs.name', 'patients.first_name', 'patients.last_name', 'patients.email', 'patients.phone_number', 'patients.supporter_phone', 'patients.supporter_email', 'medical_conditions.condition')
                ->whereBetween('appointments.date_of_visit', [$now, $future])
                ->groupBy('appointments.id')
                ->get();

            foreach ($appointments as $appointment) {

                $dateDiff = Carbon::parse($appointment->date_of_visit)->diffInDays($current_date, false);
                if ($dateDiff == 0) {
                    $phone = Str::replace(' ', '', $appointment->phone_number);
                    $phone = Str::start(Str::substr($phone, -9), '255');
                    $appointmentDate =
                        Carbon::createFromFormat('Y-m-d', $appointment->date_of_visit)->format('F j, Y');

                    $response = Http::withHeaders([
                        'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])->withBody('{"from": "NEXTSMS", "to": "' . $phone . '", "text": "Habari! ' . $appointment->first_name . ' ' . $appointment->last_name . ', Kupitia ' . $appointment->name . ' tunakumbushwa unatakiwa kuhudhuria kwenye kituo chako cha afya siku ya leo, ' . $appointmentDate . '.    Taarifa hii inafikishwa kwako kupitia mfumo wa AfyaTime. "}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
                    //STore Msg Status
                    if ($appointment->email) {
                        $details = [
                            'title' => 'Appointment Reminder',
                            'body' => 'Habari! ' . $appointment->first_name . ' ' . $appointment->last_name . ', Kupitia ' . $appointment->name . ' tunakumbushwa unatakiwa kuhudhuria kwenye kituo chako cha afya ' . $appointmentDate . '.    Taarifa hii inafikishwa kwako kupitia mfumo wa AfyaTime.'
                        ];
                        Mail::to($appointment->email)->send(new SubscriptionPaidMail($details));
                    }
                }
            }
        }
        return 0;
    }
}
