<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'cpu',
        'ram',
        'swap',
        'disk',
        'io',
        'databases',
        'backups',
        'allocations',
        'egg_id',
        'price',
        'cycles',
        'setup_fee',
        'trial',
        'discount',
        'coupons',
        'global_limit',
        'per_client_limit',
        'order',
    ];
}
