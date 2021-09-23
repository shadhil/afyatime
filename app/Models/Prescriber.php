<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Prescriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'profile_photo',
        'gender',
        'prescriber_type',
        'phone_number',
        'email',
        'organization_id',
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
}
