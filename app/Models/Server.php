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
        'plan_cycle',
        'due_date',
        'payment_method',
        'subdomain_name',
        'subdomain',
        'subdomain_port',
        'subdomain_provider',
        'status',
        'last_notif',
    ];

    public static function getTotalCost(Server $server)
    {
        $cost = 0.00;
        $plan_cycle = PlanCycle::find($server->plan_cycle);
        if ($first_cycle = Invoice::where('server_id', $server->id)->where('paid', true)->doesntExist()) {
            $cost += $plan_cycle->init_price;
            $cost += $plan_cycle->setup_fee;
        } else {
            $cost += $plan_cycle->renew_price;
        }
        foreach (ServerAddon::where('server_id', $server->id)->get() as $server_addon) {
            if (is_null($addon = AddonCycle::where('addon_id', $server_addon->addon_id)
                ->where('cycle_length', $plan_cycle->cycle_length)
                ->where('cycle_type', $plan_cycle->cycle_type)
                ->first())) continue;
            if ($first_cycle) {
                $cost += $addon->init_price * $server_addon->quantity;
                $cost += $addon->setup_fee * $server_addon->quantity;
            } else {
                $cost += $addon->renew_price * $server_addon->quantity;
            }
        }
        return $cost;
    }
}
