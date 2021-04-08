<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KbArticle;
use App\Models\KbCategory;
use Illuminate\Http\Request;

class KbCategoryController extends Controller
{
    public function index()
    {
        return view('admin.kb.index', ['title' => 'Knowledge Base', 'categories' => KbCategory::orderBy('order', 'asc')->get()]);
    }

    public function create()
    {
        return view('admin.kb.create', ['title' => "Create Category - Knowledge Base", 'header1' => 'Knowledge Base', 'header1_route' => 'admin.kb.index', 'header_title' => 'Create Category']);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kb_categories',
            'order' => 'required|numeric|gte:0',
        ]);

        $category = KbCategory::create([
            'name' => $request->input('name'),
            'order' => $request->input('order'),
        ]);

        return redirect()->route('admin.kb.show', ['id' => $category->id]);
    }
    
    public function show($id)
    {
        $category = KbCategory::find($id);
        $articles = KbArticle::where('category_id', $category->id)->orderBy('order', 'asc')->get();
        return view('admin.kb.show', ['title' => "$category->name - Knowledge Base", 'header1' => 'Knowledge Base', 'header1_route' => 'admin.kb.index', 'header_title' => $category->name, 'id' => $id, 'articles' => $articles]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|numeric|gte:0',
        ]);

        foreach (KbCategory::where('name', $request->input('name'))->get() as $category) {
            if ($category->id != $id) {
                return back()->with('danger_msg', 'The support category name has already been taken!');
            }
        }

        $category = KbCategory::find($id);
        $category->name = $request->input('name');
        $category->order = $request->input('order');
        $category->save();

        return back()->with('success_msg', 'You have updated the knowledge base category settings!');
    }
    
    public function delete($id)
    {
        $category = KbCategory::find($id);
        $category->delete();

        foreach (KbArticle::where('category_id', $id)->get() as $article) {
            $article->delete();
        }

        return redirect()->route('admin.kb.index')->with('success_msg', 'You have deleted a category from the knowledge base!');
    }
}
