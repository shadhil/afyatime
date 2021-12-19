<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMIN = 1;
    const SYSTEM = 2;

    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'admin_type',
        'password',
        'profile_img',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'b_date' => 'date',
        // 'b_time' => 'time',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(OrganizationSubscription::class, 'confirmed_by');
    }

    // public function getBDateAttribute($value)
    // {
    //     return Carbon::parse($value)->toFormattedDate();
    // }

    // public function getBTimeAttribute($value)
    // {
    //     return Carbon::parse($value)->toFormattedTime();
    // }

    public function isAdmin(): bool
    {
        return false;
    }
}
