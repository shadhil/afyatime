<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'region_id',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'district_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'district_id');
    }

    public function supporters(): HasMany
    {
        return $this->hasMany(TreatmentSupporter::class, 'district_id');
    }
}
