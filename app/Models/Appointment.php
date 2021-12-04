<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    const VISITED = 1;
    const COMING = 0;
    const NOT_VISITED = 2;

    protected $fillable = [
        'patient_id',
        'prescriber_id',
        'condition_id',
        'app_type',
        'date_of_visit',
        'visit_time',
        'organization_id',
        'received_by',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function prescriber(): BelongsTo
    {
        return $this->belongsTo(Prescriber::class, 'prescriber_id');
    }


    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Prescriber::class, 'received_by');
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

    public function dateOfVisit(): String
    {
        $today = CarbonImmutable::parse(now('Africa/Dar_es_Salaam'));
        $theDay = CarbonImmutable::parse($this->date_of_visit);

        if ($today->isSameDay($theDay)) {
            return "Today at";
        } elseif ($theDay->isTomorrow()) {
            return "Tomorrow at";
        } else {
            return  CarbonImmutable::parse($this->date_of_visit)->format('D, M jS, Y');
        }

        return false;
    }

    public function updatable(): bool
    {
        if (!Auth::user()->isAdmin() || $this->prescriber_id == Auth::user()->account->id) {
            return true;
        }
        return false;
    }

    public function visited(): int
    {
        $today = CarbonImmutable::parse(now('Africa/Dar_es_Salaam'));
        $theDay = CarbonImmutable::parse($this->date_of_visit);
        if ($this->received_by == NULL) {
            if ($today->diffInDays($theDay, false) < -2) {
                return Appointment::NOT_VISITED;
            } else {
                return Appointment::COMING;
            }
        } else {
            return Appointment::VISITED;
        }
    }
}
