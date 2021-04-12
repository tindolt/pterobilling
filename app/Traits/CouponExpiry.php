<?php

namespace App\Traits;

use App\Models\Coupon;
use Carbon\Carbon;

trait CouponExpiry {
    public function checkCoupon($id)
    {
        $coupon = Coupon::find($id)->first();

        if ($coupon) {
            if (Carbon::parse($coupon->end_date)->timestamp > Carbon::now()->timestamp || is_null($coupon->end_date)) {
                return $coupon;
            }
        }

        return false;
    }

    public function availableCoupons()
    {
        $coupons = [];

        foreach (Coupon::all() as $coupon) {
            if (Carbon::parse($coupon->end_date)->timestamp > Carbon::now()->timestamp || is_null($coupon->end_date)) {
                array_push($coupons, $coupon);
            }
        }

        return $coupons;
    }
}
