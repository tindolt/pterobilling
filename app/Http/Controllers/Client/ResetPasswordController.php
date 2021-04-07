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
        return view('client.reset', ['title' => 'Reset Password']);
    }

    public function store(Request $request, $token)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only('email'))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation');
        array_push($credentials, $token);

        $status = Password::reset(
            $credentials,
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->setRememberToken(Str::random(60))->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('client.login')->with('success_msg', 'Your password has been reset! You may now log into your account.')
                    : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }
}
