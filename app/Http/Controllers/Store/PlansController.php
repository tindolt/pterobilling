<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use Carbon\Carbon;

class PlansController extends Controller
{
    public function __invoke($id = null)
    {
        $discounts = [];
        foreach (Discount::all() as $discount) {
            if (Carbon::parse($discount->end_date)->timestamp > Carbon::now()->timestamp) {
                array_push($discounts, $discount);
            }
        }

        if (is_null($id)) {
            return view('store.plans', ['title' => 'Server Plans', 'discounts' => $discounts]);
        } else {
            $category = Category::find($id);
            if (is_null($category)) {
                return abort(404);
            } else {
                return view('store.plans', ['title' => 'Server Plans', 'discounts' => $discounts, 'id' => $id, 'category' => $category->first()]);
            }
        }
    }
}
