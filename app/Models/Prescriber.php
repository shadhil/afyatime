<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescriber extends Model
{
    use HasFactory, SoftDeletes;

    public const PATH = 'assets/images/profiles/';

    protected $fillable = [
        'first_name',
        'last_name',
        'prescriber_code',
        'profile_photo',
        'gender',
        'prescriber_type',
        'phone_number',
        'email',
        'organization_id',
    ];

    protected $dispatchesEvents = [
        // 'created' => SubscriptionConfirmed::class,
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PrescriberType::class, 'prescriber_type');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function accounts(): MorphMany
    {
        return $this->morphMany(User::class, 'account');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'prescriber_id');
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(UserLog::class, 'entity');
    }

    public function entities(): MorphMany
    {
        return $this->morphMany(UserLog::class, 'entity');
    }

    public function photoUrl(): String
    {
        if ($this->profile_photo != NULL) {
            return asset($this->profile_photo);
        }
        return asset('assets/images/avatar.jpg');
    }
}
