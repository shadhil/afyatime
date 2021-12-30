<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    public const PATH = 'assets/images/profiles/';

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'photo',
        'gender',
        'patient_code',
        'phone_number',
        'email',
        'location',
        'district_id',
        'tensel_leader',
        'tensel_leader_phone',
        'supporter_id',
        'organization_id',
    ];


    public function photoUrl(): String
    {
        if ($this->photo != NULL) {
            return asset($this->photo);
        }
        return asset('assets/images/default_patient.png');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function supporter(): BelongsTo
    {
        return $this->belongsTo(TreatmentSupporter::class, 'supporter_id');
    }

    public function accounts(): MorphMany
    {
        return $this->morphMany(User::class, 'account');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function latestAppointment()
    {
        return $this->hasOne(Appointment::class, 'patient_id')->latestOfMany();
    }

    public function lastAppointment()
    {
        return $this->hasOne(Appointment::class, 'patient_id')->ofMany([
            'date_of_visit' => 'max',
            'id' => 'max',
        ], function ($query) {
            $query->whereDate('date_of_visit', '>=', now());
        });
    }
}
