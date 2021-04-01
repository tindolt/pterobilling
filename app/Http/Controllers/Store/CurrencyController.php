<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $referer = $request->header('Referer');

        $currency = Currency::where('name', $id)->first();

        if (is_null($currency)) {
            $currency = Currency::where('default', true)->first();
        }

        session(['currency' => $currency->id, 'currency_symbol' => $currency->symbol, 'currency_rate' => $currency->rate]);
        
        return (is_null($referer)) ? redirect()->route('home') : redirect($referer);
    }
}
