<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use App\Traits\DiscountExpiry;

class PlansController extends Controller
{
    use DiscountExpiry;

    public function __invoke($id = null)
    {
        $discounts = $this->availableDiscounts();

        if (is_null($id)) {
            return view('store.plans', ['title' => 'Server Plans', 'plans' => Plan::all(), 'discounts' => $discounts]);
        } else {
            $category = Category::find($id);
            if (is_null($category)) {
                return abort(404);
            } else {
                return view('store.plans', ['title' => 'Server Plans', 'discounts' => $discounts, 'id' => $id, 'category' => $category, 'plans' => Plan::where('category_id', $category->id)->orderBy('order', 'asc')->get()]);
            }
        }
    }
}
