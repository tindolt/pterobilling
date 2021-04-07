<?php

namespace App\Http\Middleware\Client;

use App\Models\Ticket;
use Closure;
use Illuminate\Http\Request;

class CheckTicketPermission
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
        $ticket = Ticket::find($id);

        if (is_null($ticket)) {
            return abort(403);
        } elseif ($ticket->client_id !== $request->user()->id) {
            return abort(403);
        } else {
            view()->share(['ticket' => $ticket]);
            return $next($request);
        }
    }
}
