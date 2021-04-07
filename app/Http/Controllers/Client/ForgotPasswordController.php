<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Traits\HCaptcha;

class ForgotPasswordController extends Controller
{
    use HCaptcha;

    public function show()
    {
        return view('client.forgot', ['title' => 'Forgot Password']);
    }

    public function store(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only('email'))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate(['email' => 'required|string|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT ? back()->with('success_msg', 'We have sent you an email. Please click the link inside to reset your password.') : back()->withErrors(['email' => __($status)]);
    }
}
