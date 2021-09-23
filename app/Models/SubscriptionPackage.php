<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $casts = [
        'max_prescribers' => 'integer',
        'reminder_msg' => 'integer',
        'monthly_appointments' => 'integer',
        'monthly_cost' => 'string',
    ];

    protected $fillable = [
        'name',
        'max_prescribers',
        'reminder_msg',
        'monthly_appointments',
        'monthly_cost',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(OrganizationSubscription::class, 'package_id');
    }
}
