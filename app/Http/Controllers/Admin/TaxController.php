<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        return view('admin.tax.index', ['title' => 'Taxes', 'taxes' => Tax::all()]);
    }
    
    public function create()
    {
        return view('admin.tax.create', ['title' => "Create Tax - Taxes", 'header1' => 'Taxes', 'header1_route' => 'admin.tax.index', 'header_title' => 'Create Tax']);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255|unique:taxes',
            'percent' => 'required|numeric|gte:0',
        ]);

        if ($request->input('country') === '0' || $request->input('country') === 'Global')
            return back()->with('danger_msg', 'This country name is not allowed!');

        $tax = Tax::create([
            'country' => $request->input('country'),
            'percent' => $request->input('percent'),
        ]);

        return redirect()->route('admin.tax.show', ['id' => $tax->id]);
    }
    
    public function show($id)
    {
        $tax = Tax::find($id);

        if ($tax->country === '0')
            $tax->country = 'Global';

        return view('admin.tax.show', ['title' => "Edit $tax->country - Taxes", 'header1' => 'Taxes', 'header1_route' => 'admin.tax.index', 'header_title' => "Edit $tax->country", 'id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required|string|max:255|unique:taxes',
            'percent' => 'required|numeric|gte:0',
        ]);

        foreach (Tax::where('country', $request->input('country'))->get() as $tax) {
            if ($tax->id != $id) {
                return back()->with('danger_msg', 'The country name has already been taken!');
            }
        }

        $tax = Tax::find($id);
        $tax->country = ($tax->country === '0') ? '0' : $request->input('country');
        $tax->percent = $request->input('percent');
        $tax->save();

        return back()->with('success_msg', 'You have updated the tax settings!');
    }
    
    public function delete($id)
    {
        $tax = Tax::find($id);

        if ($tax->country === '0')
            return back()->with('danger_msg', 'Global cannot be deleted!');
        
        $tax->delete();

        return redirect()->route('admin.tax.index')->with('success_msg', 'You have deleted a tax!');
    }
}
