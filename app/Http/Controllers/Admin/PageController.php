<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public $pageTitle;
    
    public function show($id)
    {
        switch ($id) {
            case 'home':
                $this->pageTitle = 'Edit Home Page';
                break;
            case 'status':
                $this->pageTitle = 'Edit System Status Page';
                break;
            case 'terms':
                $this->pageTitle = 'Edit Terms of Service Page';
                break;
            case 'privacy':
                $this->pageTitle = 'Edit Privacy Policy Page';
                break;
            case 'contact':
                return view('admin.contact', ['title' => 'Contact Form', 'contact' => Page::where('name', $id)->value('content'), 'messages' => Contact::all()]);
                break;
            default:
                return abort(404);
        }
        
        return view('admin.page', ['title' => $this->pageTitle, 'content' => Page::where('name', $id)->value('content')]);
    }

    public function store(Request $request, $id)
    {
        $page = Page::where('name', $id)->first();

        if ($request->input('contact')) {
            $request->validate(['contact' => 'required|string|email|max:255']);
            $page->content = $request->input('contact');
        } else {
            $request->validate(['content' => 'required|string|max:5000']);
            $page->content = $request->input('content');
        }

        $page->save();

        return back()->with('success_msg', 'You have updated the page content! Please click \'Reload Config\' above on the navigation bar to publish the changes.');
    }

    public function contact()
    {
        return view('admin.message', ['title' => 'View Message']);
    }
}
