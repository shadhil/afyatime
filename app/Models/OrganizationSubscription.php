<?php

namespace App\Models;

use App\Events\SubscriptionConfirmed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationSubscription extends Model
{
    use HasFactory, SoftDeletes;

    const UNSUBSCRIBED = 1;
    const SUBSCRIBED = 2;
    const PAID = 3;
    const CONFIRMED = 4;
    const BLOCKED = 5;

    protected $casts = [
        'status' => 'integer',
        'monthly_cost' => 'decimal',
    ];

    protected $guarded = [];

    protected $dispatchesEvents = [
        // 'created' => SubscriptionConfirmed::class,
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function status()
    {
        if ($this->status == $this::UNSUBSCRIBED) {
            return 'Subscription End';
        } elseif ($this->status == $this::SUBSCRIBED) {
            return 'Subscribed';
        } elseif ($this->status == $this::PAID) {
            return 'Waiting for Confirmation';
        } elseif ($this->status == $this::CONFIRMED) {
            return 'Subscription Confirmed';
        } else {
            return 'Blocked Organization';
        }
    }

    public function shortStatus()
    {
        if ($this->status == $this::UNSUBSCRIBED) {
            return 'UnSubscribed';
        } elseif ($this->status == $this::SUBSCRIBED) {
            return 'Subscribed';
        } elseif ($this->status == $this::PAID) {
            return 'Confirmation';
        } elseif ($this->status == $this::CONFIRMED) {
            return 'Confirmed';
        } elseif ($this->status == $this::BLOCKED) {
            return 'Blocked';
        } else {
            return 'Registerd';
        }
    }

    // public function logs(): HasMany
    // {
    //     return $this->hasMany(AppointmentsLog::class, 'org_subscription_id');
    // }
}
