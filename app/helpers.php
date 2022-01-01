<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }
}

if (!function_exists('form_date')) {
    function form_date($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }
}

if (!function_exists('send_sms')) {
    function send_sms($phone, $msg)
    {
        Http::withHeaders([
            'Authorization' => 'Basic bmppd2F0ZWNoOkZseWluZ2NvbG91cnNAIzAx',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBody('{"from": "NEXTSMS", "to": "' . sms_phone_number($phone) . '", "text": "' . $msg . ' Shukrani – AFYATIME."}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/text/single');
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


if (!function_exists('subscription_payment_confirmed')) {
    function subscription_payment_confirmed($orgId)
    {
        $result = \App\Models\OrganizationSubscription::query()
            ->where('organization_id', $orgId)
            ->where('status', '4')
            ->first();

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

if (!function_exists('is_valid_date')) {
    function is_valid_date($date): bool
    {
        $today = \Carbon\CarbonImmutable::parse(now('Africa/Dar_es_Salaam'));
        $theDate = \Carbon\CarbonImmutable::parse($date);
        if ($theDate->greaterThan($today)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('user_log')) {
    function user_log($actionId, $prescriberId, $entityType = NULL, $entityId = NULL, $note = NULL)
    {
        $newLog = \App\Models\UserLog::create([
            'user_action_id' => $actionId,
            'prescriber_id' => $prescriberId,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'note' => $note
        ]);

        return $newLog == null ? false : true;
    }
}

if (!function_exists('admin_log')) {
    function admin_log($actionId, $adminId, $entityType = NULL, $entityId = NULL, $note = NULL)
    {
        $newLog = \App\Models\AdminLog::create([
            'user_action_id' => $actionId,
            'user_id' => $adminId,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'note' => $note
        ]);

        return $newLog == null ? false : true;
    }
}

if (!function_exists('is_subscribed')) {
    function is_subscribed()
    {
        $subscription = \App\Models\OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('status', '2')
            ->latest('end_date')
            ->first();

        if ($subscription) {
            if ((today('Africa/Dar_es_Salaam')->greaterThan(Carbon::parse($subscription->end_date)))) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }
}
