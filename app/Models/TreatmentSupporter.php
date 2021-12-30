<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentSupporter extends Model
{
    use HasFactory, SoftDeletes;

    public const PATH = 'assets/images/profiles/';

    protected $fillable = [
        'full_name',
        'photo',
        'phone_number',
        'email',
        'location',
        'district_id',
        'organization_id',
    ];

    public function photoUrl(): String
    {
        if ($this->photo != NULL) {
            return asset($this->photo);
        }
        return asset('assets/images/default_patient.png');
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'supporter_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function accounts(): MorphMany
    {
        return $this->morphMany(User::class, 'account');
    }

    public function entities(): MorphMany
    {
        return $this->morphMany(UserLog::class, 'entity');
    }
}
