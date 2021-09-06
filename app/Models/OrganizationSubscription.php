<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationSubscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'paid_by',
        'start_date',
        'end_date',
        'organization_id',
        'package_id',
        'payment_ref',
        'total_price',
        'status'
    ];
}
