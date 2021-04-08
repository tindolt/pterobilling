<?php

namespace App\Http\Middleware\Admin;

use App\Models\KbArticle;
use Closure;
use Illuminate\Http\Request;

class CheckIfKbArticleExists
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
        $article_id = $request->route('article_id');
        $article = KbArticle::find($article_id);

        if (is_null($article)) {
            return abort(404);
        } else {
            view()->share(['article' => $article]);
            return $next($request);
        }
    }
}
