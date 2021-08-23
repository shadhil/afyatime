<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'prescriber_id',
        'condition_id',
        'date_of_visit',
        'time_from',
        'time_to',
        'organization_id',
    ];
}
