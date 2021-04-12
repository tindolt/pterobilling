<?php

namespace App\Traits;

use App\Models\Discount;
use Carbon\Carbon;

trait DiscountExpiry {
    public function checkDiscount($id)
    {
        $discount = Discount::find($id);

        if ($discount) {
            if (Carbon::parse($discount->end_date)->timestamp > Carbon::now()->timestamp || is_null($discount->end_date)) {
                return $discount;
            }
        }

        return false;
    }

    public function availableDiscounts()
    {
        $discounts = [];

        foreach (Discount::all() as $discount) {
            if (Carbon::parse($discount->end_date)->timestamp > Carbon::now()->timestamp || is_null($discount->end_date)) {
                array_push($discounts, $discount);
            }
        }

        return $discounts;
    }
}
