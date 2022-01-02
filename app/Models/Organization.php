<?php

namespace App\Models;

use App\Events\OrganizationRegistered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    public const PATH = 'assets/images/profiles/';

    protected $fillable = [
        'name',
        'email',
        'logo',
        'phone_number',
        'location',
        'district_id',
        'organization_type',
        'known_as'
    ];

    protected $dispatchesEvents = [
        // 'created' => OrganizationRegistered::class,
    ];

    public function logoUrl(): String
    {
        if ($this->logo != NULL) {
            return asset($this->logo);
        }
        return asset('assets/images/default_org.png');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(OrganizationSubscription::class, 'organization_id');
    }

    public function prescribers(): HasMany
    {
        return $this->hasMany(Prescriber::class, 'organization_id');
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'organization_id');
    }

    public function supporters(): HasMany
    {
        return $this->hasMany(TreatmentSupporter::class, 'organization_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'organization_id');
    }

    public function accounts(): MorphMany
    {
        return $this->morphMany(User::class, 'account');
    }

    public function latestSubscription()
    {
        return $this->hasOne(OrganizationSubscription::class)->latestOfMany();
    }

    public function photoUrl(): String
    {
        if ($this->logo != NULL) {
            return asset($this->logo);
        }
        return asset('assets/images/avatar.jpg');
    }
}
