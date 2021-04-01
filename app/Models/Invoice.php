<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'total_due',
        'products_id',
        'prices',
        'subtotal',
        'tax_id',
        'credit',
        'payment_method',
        'due_date',
        'paid',
    ];
}
