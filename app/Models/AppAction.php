<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppAction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'action'
    ];
}
