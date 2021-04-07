<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function __invoke($id)
    {
        $currency = Currency::where('name', $id)->first();

        if (is_null($currency)) {
            $currency = Currency::where('default', true)->first();
        }

        session(['currency' => $currency]);
        
        return back();
    }
}
