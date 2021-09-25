<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


if (!function_exists('trim_phone_number')) {
    function trim_phone_number($phone)
    {
        $phone = Str::replace(' ', '', $phone);
        return Str::start(Str::substr($phone, -9), '0');
    }
}

if (!function_exists('sms_phone_number')) {
    function sms_phone_number($phone)
    {
        $phone = Str::replace(' ', '', $phone);
        return Str::start(Str::substr($phone, -9), '255');
    }
}

if (!function_exists('db_date')) {
    function db_date($date)
    {
        return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    }
}

if (!function_exists('form_date')) {
    function form_date($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m/d/Y');
    }
}

if (!function_exists('send_sms')) {
    function send_sms($phone, $msg)
    {
        Http::withHeaders([
            'Authorization' => 'Basic bmppd2F0ZWNoOkZseWluZ2NvbG91cnNAIzAx',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBody('{"from": "NEXTSMS", "to": "' . $phone . '", "text": "' . $msg . ' Shukrani – AFYATIME."}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
    }
}

if (!function_exists('store_appointments_logs')) {
    function store_appointments_logs($appId, $subId)
    {
        \App\Models\AppointmentsLog::create([
            'appointment_id' => $appId,
            'org_subscription_id' => $subId,
        ]);
    }
}

if (!function_exists('is_subscription_paid')) {
    function is_subscription_paid($orgId)
    {
        $result = \App\Models\OrganizationSubscription::query()
            ->where('organization_id', $orgId)
            ->where(function ($query) {
                $query->where('status', '1')
                    ->orWhere('status', '4');
            })->first();

        return $result == null ? false : true;
    }
}

if (!function_exists('organization_admins')) {
    function organization_admins($orgId)
    {
        $result = \App\Models\User::query()
            ->where('org_id', $orgId)
            ->where('is_admin', 1)
            ->get();

        return $result;
    }
}
