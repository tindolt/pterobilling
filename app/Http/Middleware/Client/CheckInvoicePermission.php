<?php

namespace App\Http\Middleware\Client;

use App\Models\Invoice;
use Closure;
use Illuminate\Http\Request;

class CheckInvoicePermission
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
        $invoice = Invoice::find($id);

        if (is_null($invoice)) {
            return abort(403);
        } elseif ($invoice->client_id !== $request->user()->id) {
            return abort(403);
        } else {
            view()->share(['invoice' => $invoice]);
            return $next($request);
        }
    }
}
