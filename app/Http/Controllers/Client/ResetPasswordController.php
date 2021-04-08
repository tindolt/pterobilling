<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Traits\HCaptcha;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use HCaptcha;
    
    public function show($token)
    {
        return view('client.reset', ['title' => 'Reset Password', 'token' => $token]);
    }

    public function store(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only('email'))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate([
            'token' => 'required',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('client.login')->with('success_msg', 'Your password has been reset! You may now log into your account.')
                    : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }
}
