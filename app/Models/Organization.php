<?php

namespace App\Models;

use App\Events\OrganizationRegistered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'location',
        'district_id',
        'organization_type',
        'known_as'
    ];

    protected $dispatchesEvents = [
        // 'created' => OrganizationRegistered::class,
    ];

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
}
