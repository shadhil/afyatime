<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class HourlyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email and SMS to everyone who has appointment visit hourly';

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

        // dd($tomorrow);


        $today_apps = Appointment::query()
            ->where('date_of_visit', $today)
            ->where('app_type', 'hourly')
            ->take(50)->get();

        // dd($today_apps);
        foreach ($today_apps as $appointment) {
            $visitDay = CarbonImmutable::parse($appointment->date_of_visit);
            $visitTime = CarbonImmutable::parse($appointment->visit_time);
            // $noon = Carbon::parse('12:00:00');
            $before_90 = CarbonImmutable::parse($appointment->visit_time)->subRealMinutes(90);
            $before_60 = CarbonImmutable::parse($appointment->visit_time)->subRealMinutes(60);
            $before_30 = CarbonImmutable::parse($appointment->visit_time)->subRealMinutes(30);

            // // dd($noon);
            // dd($visitTime->greaterThan($noon));
            $subscription = $appointment->organization->latestSubscription->package;
            $reminderCount = $subscription->reminder_msg;

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

            // dd($before_60->format('H:i') == now()->format('H:i'));
            if ($before_90->format('H:i') == now()->format('H:i') && $reminderCount == 3) {
                send_sms($details['phone'], $details['msg']);
                if ($details['email'] != null) {
                    Mail::to($details['email'])->send(new AppointmentReminder($details));
                }
                if ($supporter != null) {
                    send_sms($phone_supporter, $msg_supporter);
                }
                store_appointments_logs($appointment->id, $appointment->patient_id, $appointment->organization_id);
            } elseif (($before_30->format('H:i') == now()->format('H:i')) && ($reminderCount == 3 || $reminderCount == 2)) {
                // dd($details['phone'] . ' - ' . $details['msg']);
                send_sms($details['phone'], $details['msg']);
                if ($details['email'] != null) {
                    Mail::to($details['email'])->send(new AppointmentReminder($details));
                }
                if ($supporter != null) {
                    send_sms($phone_supporter, $msg_supporter);
                }
                store_appointments_logs($appointment->id, $appointment->patient_id, $appointment->organization_id);
            } elseif ($before_60->format('H:i') == now()->format('H:i')) {

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
