<?php

use Carbon\Carbon;
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
