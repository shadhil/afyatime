<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrescriberType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function prescribers(): HasMany
    {
        return $this->hasMany(Prescriber::class, 'prescriber_type');
    }
}
