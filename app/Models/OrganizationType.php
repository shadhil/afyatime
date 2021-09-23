<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationType extends Model
{
    use HasFactory;

    // protected $table = "organization_types";

    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'organization_type');
    }
}
