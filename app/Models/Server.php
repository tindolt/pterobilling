<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'server_id',
        'identifier',
        'client_id',
        'plan_id',
        'billing_cycle',
        'next_due',
        'payment_method',
        'addon',
        'subdomain_name',
        'subdomain',
        'subdomain_port',
        'subdomain_provider',
        'status',
    ];
}
