<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\HCaptcha;

class RegisterController extends Controller
{
    use HCaptcha;

    public function show()
    {
        return view('client.register', ['title' => 'Register']);
    }

    public function store(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only('email'))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate([
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|confirmed|min:8|max:255',
            'terms' => 'required|accepted',
        ]);

        Auth::login($client = Client::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referer_id' => session('referer_id'),
            'currency' => session('currency')->name,
            'country' => session('tax')->country,
            'timezone' => 'UTC',
            'language' => 'EN',
        ]));

        if (session('referer_id')) {
            $referer = Client::find(session('referer_id'));
            $referer->sign_ups += 1;
            $referer->save();
        }

        event(new Registered($client));

        return redirect(RouteServiceProvider::HOME)->with('success_msg', 'We have sent you an email. Please click the link inside to verify your account. If you do not receive it within 3 minutes, please click <a href="{{' . route('verification.send') . '}}">here</a> to send the email again.');
    }
}
