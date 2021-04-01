<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\Plan;
use App\Traits\PterodactylApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    use PterodactylApi;

    public function show(Request $request, $id)
    {
        if (is_null($request->user())) {
            session(['redirect_to' => url()->current()]);
            return redirect()->route('client.login');
        }

        $plan = Plan::find($id);
        if (is_null($plan)) {
            return abort(404);
        }

        $discount = Discount::find($plan->discount);
        if (is_null($discount)) {
            $percent_off = 1;
        } else {
            if (Carbon::parse($discount->value('end_date'))->timestamp > Carbon::now()->timestamp) {
                $percent_off = 1 - ($discount->percent_off / 100);
            } else {
                $percent_off = 1;
            }
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
        if (is_null($request->user())) {
            session(['redirect_to' => url()->current()]);
            return redirect()->route('client.login');
        }

        $plan = Plan::find($id);
        if (is_null($plan)) {
            return abort(404);
        }

        if ($request->input('coupon')) {
            $request->validate(['coupon' => 'required|string']);

            $coupon = Coupon::where('code', $request->input('coupon'))->first();

            if (is_null($coupon)) {
                session(['plan_' . $id . '_coupon' => null]);
                return back()->with('error_msg', 'The coupon code is invalid or has expired!');
            } else {
                session(['plan_' . $id . '_coupon' => $coupon]);
                return back()->with('success_msg', 'You have successfully applied the coupon.');
            }
        }

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

    private function getLocations()
    {
        $locations = $this->appApi('locations', 'GET');
        Cache::put('pterodactyl_locations', $locations, now()->addMinutes(10));
        return $locations;
    }
}
