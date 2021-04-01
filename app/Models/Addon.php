<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = [
        'name',
        'resource',
        'amount',
        'price',
        'cycles',
        'plans',
        'categories',
        'setup_fee',
        'trial',
        'discounts',
        'coupons',
        'global_limit',
        'per_client_limit',
        'order',
    ];
}
