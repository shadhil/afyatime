<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Patient extends Model
{
    use HasFactory;

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

    public function appontments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}
