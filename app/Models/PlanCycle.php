<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanCycle extends Model
{
    protected $fillable = [
        'plan_id',
        'cycle_length',
        'cycle_type',
        'init_price',
        'renew_price',
        'setup_fee',
        'late_fee',
        'trial_length',
        'trial_type',
    ];
}
