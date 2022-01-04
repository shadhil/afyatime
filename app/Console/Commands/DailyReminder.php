<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Mail\Gmail;
use App\Mail\SubscriptionPaidMail;
use App\Models\Appointment;
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
    protected $description = 'Send an email and SMS to everyone who has appointment visit daily';

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
        $tomorrow = CarbonImmutable::parse(\Carbon\Carbon::now()->addRealDay(1)->format('Y-m-d'));
        $today = CarbonImmutable::parse(\Carbon\Carbon::now()->format('Y-m-d'));
        $now = CarbonImmutable::parse(\Carbon\Carbon::now()->format('H:i:s'));

        $tomorrow_apps = Appointment::query()
            ->where('date_of_visit', $tomorrow)
            ->where('app_type', 'daily')
            ->take(50)->get();

        $today_apps = Appointment::query()
            ->where('date_of_visit', $today)
            ->where('app_type', 'daily')
            ->take(50)->get();

        // dd($tomorrow_apps);

        foreach ($tomorrow_apps as $appointment) {
            $visitDay = CarbonImmutable::parse($appointment->date_of_visit);
            $visitTime = CarbonImmutable::parse($appointment->visit_time);
            $noon = Carbon::parse('12:00:00');
            $before_12 = CarbonImmutable::parse($appointment->visit_time)->subRealHours(12);

            $subscription = $appointment->organization->latestSubscription;;
            $reminderCount = $subscription->package->reminder_msg;
            $appId = $appointment->id;
            $subId = $subscription->id;

            $details = [
                'msg' => "Ndugu " . $appointment->patient->first_name . " " . $appointment->patient->last_name . " Unakumbushwa miadi yako ya kuhudhuria kliniki tarehe " . $visitDay->format('d/m/Y') . " kuanzai saa " . $visitTime->format('h:m A') . " bila kukosa kwenye kituo chako cha " . $appointment->organization->known_as . ". ",
                'email' => $appointment->patient->email,
                'phone' => $appointment->patient->phone_number
            ];

            $supporter = $appointment->patient->supporter;
            if ($supporter != null) {
                $phone_supporter = $supporter->phone_number;
                $msg_supporter = "Ndugu " . $appointment->patient->first_name . " " . $appointment->patient->last_name . " anakumbushwa miadi yake ya kuhudhuria kliniki tarehe " . $visitDay->format('d/m/Y') . " kuanzai saa " . $visitTime->format('h:m A') . " bila kukosa kwenye kituo chako cha " . $appointment->organization->known_as . ". Kama msaidizi wa mgonjwa unaombwa kumkumbusha atimize miadi.";
            } else {
                $phone_supporter = null;
                $msg_supporter = null;
            }

            if (!$visitTime->greaterThan($noon) && $reminderCount == 3) {
                if ($now->isSameHour($before_12)) {
                    send_sms($details['phone'], $details['msg']);
                    if ($details['email'] != null) {
                        Mail::to($details['email'])->send(new AppointmentReminder($details));
                    }
                    if ($supporter != null) {
                        send_sms($phone_supporter, $msg_supporter);
                    }
                    store_appointments_logs($appointment->id, $appointment->patient_id, $appointment->organization_id);
                }
            }
        }

        foreach ($today_apps as $appointment) {
            $visitDay = CarbonImmutable::parse($appointment->date_of_visit);
            $visitTime = CarbonImmutable::parse($appointment->visit_time);
            $noon = Carbon::parse('12:00:00');
            $before_12 = CarbonImmutable::parse($appointment->visit_time)->subRealHours(12);
            $before_6 = CarbonImmutable::parse($appointment->visit_time)->subRealHours(6);
            $before_1 = CarbonImmutable::parse($appointment->visit_time)->subRealHours(1);

            // // dd($noon);
            // dd($visitTime->greaterThan($noon));
            $subscription = $appointment->organization->latestSubscription->package;
            $reminderCount = $subscription->reminder_msg;

            // dd($now->isSameHour($before_12));

            $details = [
                'msg' => "Ndugu " . $appointment->patient->first_name . " " . $appointment->patient->last_name . " Unakumbushwa miadi yako ya kuhudhuria kliniki tarehe " . $visitDay->format('d/m/Y') . " kuanzai saa " . $visitTime->format('h:m A') . " bila kukosa kwenye kituo chako cha " . $appointment->organization->known_as . ". ",
                'email' => $appointment->patient->email,
                'phone' => $appointment->patient->phone_number
            ];

            $supporter = $appointment->patient->supporter;
            if ($supporter != null) {
                $phone_supporter = $supporter->phone_number;
                $msg_supporter = "Ndugu " . $appointment->patient->first_name . " " . $appointment->patient->last_name . " anakumbushwa miadi yake ya kuhudhuria kliniki tarehe " . $visitDay->format('d/m/Y') . " kuanzai saa " . $visitTime->format('h:m A') . " bila kukosa kwenye kituo chako cha " . $appointment->organization->known_as . ". Kama msaidizi wa mgonjwa unaombwa kumkumbusha atimize miadi.";
            } else {
                $phone_supporter = null;
                $msg_supporter = null;
            }

            if ($visitTime->greaterThan($noon) && $reminderCount == 3) {
                if ($now->isSameHour($before_12)) {
                    send_sms($details['phone'], $details['msg']);
                    if ($details['email'] != null) {
                        Mail::to($details['email'])->send(new AppointmentReminder($details));
                    }
                    if ($supporter != null) {
                        send_sms($phone_supporter, $msg_supporter);
                    }
                    store_appointments_logs($appointment->id, $appointment->patient_id, $appointment->organization_id);
                }
            } elseif ($now->isSameHour($before_6) && ($reminderCount == 3 || $reminderCount == 2)) {
                // dd($details['phone'] . ' - ' . $details['msg']);
                send_sms($details['phone'], $details['msg']);
                if ($details['email'] != null) {
                    Mail::to($details['email'])->send(new AppointmentReminder($details));
                }
                if ($supporter != null) {
                    send_sms($phone_supporter, $msg_supporter);
                }
                store_appointments_logs($appointment->id, $appointment->patient_id, $appointment->organization_id);
            } elseif ($now->isSameHour($before_12)) {
                send_sms($details['phone'], $details['msg']);
                if ($details['email'] != null) {
                    Mail::to($details['email'])->send(new AppointmentReminder($details));
                }
                if ($supporter != null) {
                    send_sms($phone_supporter, $msg_supporter);
                }
                store_appointments_logs($appointment->id, $appointment->patient_id, $appointment->organization_id);
            }
        }
    }
}
