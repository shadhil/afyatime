<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WeeklyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an exclusive email and SMS to everyone who has appointment visit weekly';

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
        $today = CarbonImmutable::parse(\Carbon\Carbon::now()->format('Y-m-d'));
        $now = CarbonImmutable::parse(\Carbon\Carbon::now()->format('H:i:s'));

        $appointments = Appointment::query()
            ->where('date_of_visit', '>=', $today)
            ->where('app_type', 'weekly')
            ->take(50)->get();

        // dd($appointments);

        foreach ($appointments as $appointment) {
            $visitDay = CarbonImmutable::parse($appointment->date_of_visit);
            $visitTime = CarbonImmutable::parse($appointment->visit_time);
            // dd($visitTime->format('h:m A'));

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
            // dd($subscription->reminder_msg);
            $diffDay = $today->diffInDays($visitDay, false);
            if ($diffDay == 3 && $reminderCount == 2) {
                if ($now->isSameHour($visitTime)) {
                    send_sms($details['phone'], $details['msg']);
                    if ($details['email'] != null) {
                        Mail::to($details['email'])->send(new AppointmentReminder($details));
                    }
                    if ($supporter != null) {
                        send_sms($phone_supporter, $msg_supporter);
                    }
                }
            } elseif ($diffDay == 0 && ($reminderCount == 2 || $reminderCount == 2)) {
                if ($now->diffInRealHours($visitTime) == 0) {
                    send_sms($details['phone'], $details['msg']);
                    if ($details['email'] != null) {
                        Mail::to($details['email'])->send(new AppointmentReminder($details));
                    }
                    if ($supporter != null) {
                        send_sms($phone_supporter, $msg_supporter);
                    }
                }
                dd('Zero Days Before');
            } elseif ($diffDay == 1) {
                if ($now->isSameHour($visitTime)) {
                    send_sms($details['phone'], $details['msg']);
                    if ($details['email'] != null) {
                        Mail::to($details['email'])->send(new AppointmentReminder($details));
                    }
                    if ($supporter != null) {
                        send_sms($phone_supporter, $msg_supporter);
                    }
                }
            }
        }
    }
}
