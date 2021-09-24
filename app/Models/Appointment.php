<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'prescriber_id',
        'condition_id',
        'app_type',
        'date_of_visit',
        'visit_time',
        'organization_id',
        'receiver_id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function prescriber(): BelongsTo
    {
        return $this->belongsTo(Prescriber::class, 'prescriber_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(MedicalCondition::class, 'condition_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(AppointmentsLog::class, 'appointment_id');
    }
}
