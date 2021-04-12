<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index', ['title' => 'Categories', 'categories' => Category::orderBy('order', 'asc')->get()]);
    }

    public function create()
    {
        return view('admin.category.create', ['title' => "Create Category - Categories", 'header1' => 'Categories', 'header1_route' => 'admin.category.index', 'header_title' => 'Create Category']);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'order' => 'required|numeric',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'order' => $request->input('order'),
            'global_limit' => $request->input('global_limit'),
            'per_client_limit' => $request->input('per_client_limit'),
        ]);

        return redirect()->route('admin.category.show', ['id' => $category->id]);
    }
    
    public function show($id)
    {
        $category = Category::find($id);
        return view('admin.category.show', ['title' => "$category->name - Categories", 'header1' => 'Categories', 'header1_route' => 'admin.category.index', 'header_title' => $category->name, 'id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|numeric',
            'global_limit' => 'required|integer|gte:0',
            'per_client_limit' => 'required|integer|gte:0',
        ]);

        foreach (Category::where('name', $request->input('name'))->get() as $category) {
            if ($category->id != $id) {
                return back()->with('danger_msg', 'The category name has already been taken!');
            }
        }

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->global_limit = $request->input('global_limit');
        $category->per_client_limit = $request->input('per_client_limit');
        $category->order = $request->input('order');
        $category->save();

        return back()->with('success_msg', 'You have updated the category settings!');
    }
    
    public function delete($id)
    {
        if (Plan::where('category_id', $id)->count() > 0) {
            return back()->with('danger_msg', 'You cannot delete this category because there are server plans inside it.');
        }

        $category = Category::find($id);
        $category->delete();

        return redirect()->route('admin.category.index')->with('success_msg', 'You have deleted a category!');
    }
}
