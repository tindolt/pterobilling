<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Plan;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show()
    {
        if (
            is_null(session('checkout_plan')) ||
            is_null(session('checkout_addons')) ||
            is_null(session('checkout_server_name')) ||
            is_null(session('checkout_location')) ||
            is_null(session('checkout_cycle'))
        ) return redirect()->route('plans');

        $due_today = session('checkout_plan')->price;

        foreach (session('checkout_addons') as $addon_id) {
            $addon = Addon::find($addon_id);
            if (!is_null($addon)) {
                $due_today += +$addon->price;
            }
        }

        

        return view('store.checkout', ['title' => 'Order Server', 'id' => '1']);
    }

    public function store(Request $request)
    {
        //
    }

    public function ordered()
    {
        return view('store.ordered', ['title' => 'Order Server']);
    }

    public function canceled()
    {
        return view('store.checkout', ['title' => 'Order Server', 'id' => '1']);
    }
}
