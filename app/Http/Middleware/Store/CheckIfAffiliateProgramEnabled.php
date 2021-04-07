<?php

namespace App\Http\Middleware\Store;

use Closure;
use Illuminate\Http\Request;

class CheckIfAffiliateProgramEnabled
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
        if (!config('affiliate.enabled')) {
            return back()->with('warning_msg', 'Sorry, but the affiliate program hasn\'t been enabled.');
        }
        return $next($request);
    }
}
