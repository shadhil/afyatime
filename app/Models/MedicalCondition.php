<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'condition'
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'condition_id');
    }
}
