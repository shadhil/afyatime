<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentsLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "appointments_logs";

    protected $fillable = [
        'app_action',
        'appointment_id',
        'prescriber_id'
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(OrganizationSubscription::class, 'org_subscription_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function appAction(): BelongsTo
    {
        return $this->belongsTo(AppAction::class, 'app_action_id');
    }
}
