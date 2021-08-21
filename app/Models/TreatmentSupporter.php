<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentSupporter extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'photo',
        'email',
        'phone_number',
        'location',
        'district_id',
        'organization_id'
    ];
}
