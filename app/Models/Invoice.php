<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'products',
        'prices',
        'tax_id',
        'payment_method',
        'due_date',
        'paid',
    ];
}
