<?php

namespace App\Http\Middleware\Admin;

use App\Models\AffiliateEarning;
use Closure;
use Illuminate\Http\Request;

class CheckIfAffiliateExists
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
        $affiliate = AffiliateEarning::find($id);

        if (is_null($affiliate)) {
            return abort(404);
        } elseif ($affiliate !== 1) {
            return back()->with('danger_msg', 'The commission withdrawal request has already been either accepted or rejected!');
        } else {
            view()->share(['affiliate' => $affiliate]);
            return $next($request);
        }
    }
}
