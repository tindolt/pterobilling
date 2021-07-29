<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Notifications\ContactForm;
use App\Rules\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class StoreController extends ApiController
{
    public function contact(Request $request)
    {
        if (!$receiver = config('page.contact')) return $this->respondJson(['error' => 'Contact form disabled'], 403);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'required|string|min:3|max:255',
            'subject' => 'required|string|min:20|max:255',
            'message' => 'required|string|min:50|max:5000',
            'h-captcha-response' => new Captcha,
        ]);

        if ($validator->fails())
            return $this->respondJson(['errors' => $validator->errors()->all()]);

        $sender = Contact::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        Notification::route('mail', $receiver)->notify(new ContactForm($sender->id));

        return $this->respondJson(['success' => 'Your message has been sent!']);
    }

    public function summary(Request $request, $id)
    {
        return $this->respondJson([]);
    }

    public function order(Request $request, $id)
    {
        return $this->respondJson([]);
    }

    public function checkout(Request $request, $id)
    {
        return $this->respondJson([]);
    }
}
