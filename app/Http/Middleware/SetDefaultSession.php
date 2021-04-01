<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetDefaultSession
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
        $this->checkIfExist('referer_id', null);
        $this->checkIfExist('currency', 'USD');
        $this->checkIfExist('currency_symbol', '&#36;');
        $this->checkIfExist('country', '0');
        $this->checkIfExist('timezone', 'UTC');
        $this->checkIfExist('language', 'EN');

        return $next($request);
    }

    private function checkIfExist($key, $value)
    {
        if (is_null(session($key))) {
            session([$key => $value]);
        }
    }
}
