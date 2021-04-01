<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Page;
use App\Notifications\ContactForm;
use App\Traits\HCaptcha;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    use HCaptcha;

    public function show() {
        return view('store.contact', ['title' => 'Contact Us']);
    }

    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|min:3|max:40',
            'subject' => 'required|string|min:20|max:250',
            'message' => 'required|string|min:100|max:2000',
        ]);

        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            $request->flashExcept('h-captcha-response');
            return back()->with('captcha_error', true);
        }

        $receiver = Page::where('name', 'contact')->value('content');
        $sender = Contact::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        Notification::route('mail', $receiver)->notify(new ContactForm($sender));

        return back()->with('success', true);
    }
}
