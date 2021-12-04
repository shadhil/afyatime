<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }

    public function userAction(): BelongsTo
    {
        return $this->belongsTo(UserAction::class, 'user_action_id');
    }

}
