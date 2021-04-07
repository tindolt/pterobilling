<?php

namespace App\Http\Middleware\Store;

use App\Models\Plan;
use Closure;
use Illuminate\Http\Request;

class CheckPlanOrder
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
        if (is_null($request->user())) {
            session(['redirect_to' => url()->current()]);
            return redirect()->route('client.login');
        }
        
        if (is_null(Plan::find($request->route('id')))) {
            return abort(404);
        }

        return $next($request);
    }
}
