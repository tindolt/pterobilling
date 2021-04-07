<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
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
            'email' => 'required|email|max:255',
            'name' => 'required|string|min:3|max:255',
            'subject' => 'required|string|min:20|max:255',
            'message' => 'required|string|min:100|max:5000',
        ]);

        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            $request->flashExcept('h-captcha-response');
            return back()->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $receiver = config('page.contact');
        $sender = Contact::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        Notification::route('mail', $receiver)->notify(new ContactForm($sender));

        return back()->with('success_msg', 'Your message has been sent!');
    }
}
