<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $referer = $request->header('Referer');

        if (is_null($id)) return back();

        session(['language' => $id]);
        
        return back();
    }
}
