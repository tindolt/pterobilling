<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KbArticle;
use Illuminate\Http\Request;

class KbArticleController extends Controller
{
    public function create()
    {
        return view('admin.kb.article.create', ['title' => "Create Support Article - Knowledge Base", 'header1' => 'Knowledge Base', 'header1_route' => 'admin.kb.index', 'header_title' => 'Create Support Article']);
    }
    
    public function store(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255|unique:kb_articles',
            'order' => 'required|numeric|gte:0',
            'content' => 'required|string|max:5000'
        ]);

        $article = KbArticle::create([
            'category_id' => $id,
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'order' => $request->input('order'),
        ]);

        return redirect()->route('admin.kb.show', ['id' => $id]);
    }
    
    public function show($id, $article_id)
    {
        $article = KbArticle::find($article_id);
        return view('admin.kb.article.show', ['title' => "$article->subject - Knowledge Base", 'header1' => 'Knowledge Base', 'header1_route' => 'admin.kb.index', 'header_title' => $article->subject, 'id' => $id]);
    }
    
    public function update(Request $request, $id, $article_id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'order' => 'required|numeric|gte:0',
            'content' => 'required|string|max:5000'
        ]);

        foreach (KbArticle::where('subject', $request->input('subject'))->get() as $article) {
            if ($article->id != $article_id) {
                return back()->with('danger_msg', 'The support article subject has already been taken!');
            }
        }

        $article = KbArticle::find($article_id);
        $article->category_id = $id;
        $article->subject = $request->input('subject');
        $article->content = $request->input('content');
        $article->order = $request->input('order');
        $article->save();

        return back()->with('success_msg', 'You have updated the knowledge base support article!');
    }
    
    public function delete($id, $article_id)
    {
        $article = KbArticle::find($article_id);
        $article->delete();

        return redirect()->route('admin.kb.show', ['id' => $id])->with('success_msg', 'You have deleted a support article from the knowledge base!');
    }
}
