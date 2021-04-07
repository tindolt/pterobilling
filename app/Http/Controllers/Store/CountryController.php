<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Tax;

class CountryController extends Controller
{
    public function __invoke($id)
    {
        $tax = Tax::where('country', $id)->first();
        
        if (is_null($tax)) {
            $tax = Tax::where('country', '0')->first();
        }

        session(['tax' => $tax]);
        
        return back();
    }
}
