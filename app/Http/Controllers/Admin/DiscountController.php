<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Plan;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        return view('admin.discount.index', ['title' => 'Discounts', 'discounts' => Discount::all()]);
    }

    public function create()
    {
        return view('admin.discount.create', ['title' => "Create Discount - Discounts", 'header1' => 'Discounts', 'header1_route' => 'admin.discount.index', 'header_title' => 'Create Discount']);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:discounts',
            'percent_off' => 'required|integer|gte:1|lte:100',
            'end_date' => 'nullable|date',
        ]);

        $discount = Discount::create([
            'name' => $request->input('name'),
            'percent_off' => $request->input('percent_off'),
            'is_global' => $request->has('is_global'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('admin.discount.show', ['id' => $discount->id]);
    }
    
    public function show($id)
    {
        $discount = Discount::find($id);
        return view('admin.discount.show', ['title' => "$discount->name - Discount", 'header1' => 'Discount', 'header1_route' => 'admin.discount.index', 'header_title' => $discount->name, 'id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percent_off' => 'required|integer|gte:1|lte:100',
            'end_date' => 'nullable|date',
        ]);

        foreach (Discount::where('name', $request->input('name'))->get() as $discount) {
            if ($discount->id != $id) {
                return back()->with('danger_msg', 'The discount name has already been taken!');
            }
        }

        $discount = Discount::find($id);
        $discount->name = $request->input('name');
        $discount->percent_off = $request->input('percent_off');
        $discount->is_global = $request->has('is_global');
        $discount->end_date = $request->input('end_date');
        $discount->save();

        return back()->with('success_msg', 'You have updated the discount settings!');
    }
    
    public function delete($id)
    {
        if (Plan::where('discount', $id)->count() > 0) {
            return back()->with('danger_msg', 'You cannot delete this discount because there are server plans using it!');
        }

        $discount = Discount::find($id);
        $discount->delete();

        return redirect()->route('admin.discount.index')->with('success_msg', 'You have deleted a discount!');
    }
}
