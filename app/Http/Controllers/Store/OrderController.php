<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Traits\CouponExpiry;
use App\Traits\DiscountExpiry;
use App\Traits\PterodactylApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    use PterodactylApi, DiscountExpiry, CouponExpiry;

    public function show($id)
    {
        $plan = Plan::find($id);
        $discount = $this->checkDiscount($plan->discount);

        if ($discount) {
            $percent_off = 1 - ($discount->percent_off / 100);
        } else {
            $percent_off = 1;
        }

        $locations = Cache::get('pterodactyl_locations');

        if (is_null($locations)) {
            $locations = $this->getLocations();
        } elseif ($locations === false) {
            $locations = $this->getLocations();
        } elseif (array_key_exists('errors', $locations)) {
            $locations = $this->getLocations();
        }

        return view('store.order', ['title' => 'Order Server', 'percent_off' => $percent_off, 'id' => $id, 'plan' => $plan, 'locations' => $locations]);
    }

    public function store(Request $request, $id)
    {
        $plan = Plan::find($id);

        $request->validate([
            'order_details' => 'required|string|json',
            'server_name' => 'required|string|max:255',
            'location' => 'required|integer',
            'cycle' => 'required|string|in:monthly,trimonthly,biannually,annually',
        ]);

        session([
            'checkout_plan' => $plan,
            'checkout_addons' => json_decode($request->input('order_details'), true)->addons,
            'checkout_server_name' => $request->input('server_name'),
            'checkout_location' => $request->input('location'),
            'checkout_cycle' => $request->input('cycle'),
        ]);

        return redirect()->route('checkout');
    }

    public function coupon(Request $request, $id)
    {
        $request->validate(['coupon' => 'required|string']);
        $coupon = $this->checkCoupon($request->input('coupon'));

        if ($coupon) {
            session(['plan_' . $id . '_coupon' => $coupon]);
            return back()->with('success_msg', 'You\'ve applied the coupon code!');
        } else {
            session(['plan_' . $id . '_coupon' => null]);
            return back()->with('error_msg', 'The coupon code is invalid or has expired!');
        }
    }

    private function getLocations()
    {
        $locations = $this->appApi('locations', 'GET');
        Cache::put('pterodactyl_locations', $locations, now()->addMinutes(10));
        return $locations;
    }
}
