<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\KbArticle;

class KbController extends Controller
{
    public function __invoke($id = null)
    {
        if (is_null($id)) {
            return view('store.kb', ['title' => 'Knowledge Base']);
        } else {
            $article = KbArticle::find($id);
            if (is_null($article)) {
                return abort(404);
            } else {
                return view('store.article', ['title' => 'Knowledge Base', 'id' => $id, 'article' => $article]);
            }
        }
    }
}
