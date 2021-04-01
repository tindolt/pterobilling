<?php

namespace App\Http\Middleware;

use App\Models\Server;
use Closure;
use Illuminate\Http\Request;

class CheckServerPermission
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
        $id = $request->route('id');
        $server = Server::find($id);

        if (is_null($server)) {
            return abort(403);
        } elseif ($server->first()->client_id !== $request->user()->id) {
            return abort(403);
        } else {
            view()->share(['server' => $server->first()]);
            return $next($request);
        }
    }
}
