<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;

class CheckServerAddonPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $action)
    {
        $addon_id = $request->route('addon_id');
        return $next($request);
    }
}
