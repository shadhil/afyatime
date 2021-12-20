<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PrescriberType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function prescribers(): HasMany
    {
        return $this->hasMany(Prescriber::class, 'prescriber_type');
    }


    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function entities(): MorphMany
    {
        return $this->morphMany(UserLog::class, 'entity');
    }
}
