<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\UsedCoupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupon.index', ['title' => 'Coupons', 'coupons' => Coupon::all()]);
    }

    public function create()
    {
        return view('admin.coupon.create', ['title' => "Create Coupon - Coupons", 'header1' => 'Coupons', 'header1_route' => 'admin.coupon.index', 'header_title' => 'Create Coupon']);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons',
            'percent_off' => 'required|integer|gte:1|lte:100',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
            'end_date' => 'nullable|date',
        ]);

        $coupon = Coupon::create([
            'code' => $request->input('code'),
            'percent_off' => $request->input('percent_off'),
            'global_limit' => $request->input('global_limit'),
            'per_client_limit' => $request->input('per_client_limit'),
            'is_global' => $request->has('is_global'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('admin.coupon.show', ['id' => $coupon->id]);
    }
    
    public function show($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon.show', ['title' => "$coupon->code - Coupons", 'header1' => 'Coupons', 'header1_route' => 'admin.coupon.index', 'header_title' => $coupon->code, 'id' => $id, 'used_coupons' => UsedCoupon::where('coupon_id', $coupon->id)->oldest()->get()]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'percent_off' => 'required|integer|gte:1|lte:100',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
            'end_date' => 'nullable|date',
        ]);

        foreach (Coupon::where('code', $request->input('code'))->get() as $coupon) {
            if ($coupon->id != $id) {
                return back()->with('danger_msg', 'The coupon code has already been taken!');
            }
        }

        $coupon = Coupon::find($id);
        $coupon->code = $request->input('code');
        $coupon->percent_off = $request->input('percent_off');
        $coupon->global_limit = $request->input('global_limit');
        $coupon->per_client_limit = $request->input('per_client_limit');
        $coupon->is_global = $request->has('is_global');
        $coupon->end_date = $request->input('end_date');
        $coupon->save();

        return back()->with('success_msg', 'You have updated the coupon settings!');
    }
    
    public function delete($id)
    {
        foreach (Plan::where('coupons', '!=', '[]')->orWhereNotNull('coupons')->get() as $plan) {
            if (in_array($id, json_decode($plan->coupons, true))) {
                return back()->with('danger_msg', 'You cannot delete this coupon because there are server plans using it!');
            }
        }

        $coupon = Coupon::find($id);
        $coupon->delete();

        return redirect()->route('admin.coupon.index')->with('success_msg', 'You have deleted a coupon!');
    }
}
