<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Category;
use App\Models\Server;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index()
    {
        return view('admin.addon.index', ['title' => 'Add-ons', 'addons' => Addon::orderBy('order', 'asc')->get()]);
    }

    public function create()
    {
        return view('admin.addon.create', ['title' => "Create Add-on - Add-ons", 'header1' => 'Add-ons', 'header1_route' => 'admin.addon.index', 'header_title' => 'Create Add-ons', 'categories' => Category::orderBy('order', 'asc')->get()]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:addons',
            'order' => 'required|numeric',
            'resource' => 'required|string|in:ram,cpu,disk,database,backup,extra_port',
            'amount' => 'required|integer|gte:0',
            'price' => 'required|numeric|gte:0',
            'setup_fee' => 'required|numeric|gte:0',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
        ]);
        
        $categories = [];
        foreach (Category::orderBy('order', 'asc')->get() as $category) {
            if ($request->has("category_$category->id")) {
                array_push($categories, $category->id);
            }
        }

        $addon = Addon::create([
            'name' => $request->input('name'),
            'resource' => $request->input('resource'),
            'amount' => $request->input('amount'),
            'price' => $request->input('price'),
            'categories' => json_encode($categories),
            'setup_fee' => $request->input('setup_fee'),
            'global_limit' => $request->input('global_limit'),
            'per_client_limit' => $request->input('per_client_limit'),
            'order' => $request->input('order'),
        ]);

        return redirect()->route('admin.addon.show', ['id' => $addon->id]);
    }
    
    public function show($id)
    {
        $addon = Addon::find($id);
        return view('admin.addon.show', ['title' => "$addon->name - Add-ons", 'header1' => 'Add-ons', 'header1_route' => 'admin.addon.index', 'header_title' => $addon->name, 'id' => $id, 'categories' => Category::orderBy('order', 'asc')->get()]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|numeric',
            'resource' => 'required|string|in:ram,cpu,disk,database,backup,extra_port',
            'amount' => 'required|integer|gte:0',
            'price' => 'required|numeric|gte:0',
            'setup_fee' => 'required|numeric|gte:0',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
        ]);

        foreach (Addon::where('name', $request->input('name'))->get() as $addon) {
            if ($addon->id != $id) {
                return back()->with('danger_msg', 'The add-on name has already been taken!');
            }
        }

        $categories = [];
        foreach (Category::orderBy('order', 'asc')->get() as $category) {
            if ($request->has("category_$category->id")) {
                array_push($categories, $category->id);
            }
        }

        $addon = Addon::find($id);
        $addon->name = $request->input('name');
        $addon->resource = $request->input('resource');
        $addon->amount = $request->input('amount');
        $addon->price = $request->input('price');
        $addon->categories = json_encode($categories);
        $addon->setup_fee = $request->input('setup_fee');
        $addon->global_limit = $request->input('global_limit');
        $addon->per_client_limit = $request->input('per_client_limit');
        $addon->order = $request->input('order');
        $addon->save();

        return back()->with('success_msg', 'You have updated the add-on settings!');
    }
    
    public function delete($id)
    {
        foreach (Server::where('status', 0)->orWhere('status', 1)->orWhere('status', 2)->get() as $server) {
            if (in_array($id, json_decode($server->addon, true))) {
                return back()->with('danger_msg', 'You cannot delete this addon because there are servers using it!');
            }
        }

        $addon = Addon::find($id);
        $addon->delete();

        return redirect()->route('admin.addon.index')->with('success_msg', 'You have deleted an add-on!');
    }
}
