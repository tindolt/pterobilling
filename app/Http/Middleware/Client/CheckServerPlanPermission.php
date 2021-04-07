<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;

class CheckServerPlanPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $plan_id = $request->route('plan_id');
        return $next($request);
    }
}
