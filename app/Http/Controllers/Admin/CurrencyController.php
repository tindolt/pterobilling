<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('admin.currency.index', ['title' => 'Currencies', 'currencies' => Currency::all()]);
    }

    public function create()
    {
        return view('admin.currency.create', ['title' => "Create Currency - Currencies", 'header1' => 'Currencies', 'header1_route' => 'admin.currency.index', 'header_title' => 'Create Currency']);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|size:3|unique:currencies',
            'symbol' => 'required|string|max:255',
            'rate' => 'required|numeric|gt:0',
        ]);

        $currency = Currency::create([
            'name' => $request->input('name'),
            'symbol' => $request->input('symbol'),
            'rate' => $request->input('rate'),
        ]);

        return redirect()->route('admin.currency.show', ['id' => $currency->id]);
    }
    
    public function show($id)
    {
        $currency = Currency::find($id);
        return view('admin.currency.show', ['title' => "Edit $currency->name - Currencies", 'header1' => 'Currencies', 'header1_route' => 'admin.currency.index', 'header_title' => "Edit $currency->name", 'id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|size:3',
            'symbol' => 'required|string|max:255',
            'rate' => 'required|numeric|gt:0',
        ]);

        foreach (Currency::where('name', $request->input('name'))->get() as $currency) {
            if ($currency->id != $id) {
                return back()->with('danger_msg', 'The currency name has already been taken!');
            }
        }

        $currency = Currency::find($id);
        $currency->name = $request->input('name');
        $currency->symbol = $request->input('symbol');
        $currency->rate = $currency->default ? 1 : $request->input('rate');
        $currency->save();

        return back()->with('success_msg', 'You have updated the currency settings!');
    }

    public function default($id)
    {
        $defaults = Currency::where('default', true)->get();

        foreach ($defaults as $default) {
            $default->default = false;
            $default->save();
        }

        $currency = Currency::find($id);
        $currency->rate = 1;
        $currency->default = true;
        $currency->save();

        return back()->with('success_msg', 'You have set this currency to the default one!');
    }
    
    public function delete($id)
    {
        $currency = Currency::find($id);

        if ($currency->default)
            return back()->with('danger_msg', 'You cannot delete the default currency!');
        
        $currency->delete();

        return redirect()->route('admin.currency.index')->with('success_msg', 'You have deleted a currency!');
    }
}
