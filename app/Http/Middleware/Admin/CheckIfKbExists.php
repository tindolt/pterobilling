<?php

namespace App\Http\Middleware\Admin;

use App\Models\KbArticle;
use Closure;
use Illuminate\Http\Request;

class CheckIfKbExists
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
        $kb_article = KbArticle::find($id);

        if (is_null($kb_article)) {
            return abort(404);
        } else {
            view()->share(['kb_article' => $kb_article]);
            return $next($request);
        }
    }
}
