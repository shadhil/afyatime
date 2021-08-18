<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'patient_code',
        'photo',
        'gender',
        'email',
        'phone_number',
        'location',
        'district_id',
        'tensel_leader',
        'tensel_leader_phone',
        'organization_id'
    ];
}
