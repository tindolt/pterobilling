<?php

namespace App\Http\Middleware\Client;

use Closure;
use Illuminate\Http\Request;

class CloseRegistration
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
        if (!config('app.open_registration')) {
            return back()->with('warning_msg', 'You cannot register for an account now because the registration has been closed!');
        }
        
        return $next($request);
    }
}
