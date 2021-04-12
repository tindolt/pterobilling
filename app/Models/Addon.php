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
        'categories',
        'setup_fee',
        'global_limit',
        'per_client_limit',
        'order',
    ];
}
