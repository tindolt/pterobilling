<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'percent_off',
        'global_limit',
        'per_client_limit',
        'is_global',
        'end_date',
    ];
}
