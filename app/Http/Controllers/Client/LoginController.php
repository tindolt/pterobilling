<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\HCaptcha;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use HCaptcha;

    public function show(Request $request)
    {
        if (session('redirect_to')) {
            $request->session()->flash('info_msg', 'Please log into your account before ordering a server.');
        }

        return view('client.login', ['title' => 'Login']);
    }

    public function store(LoginRequest $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only('email'))->with('captcha_error', true);
        }

        $request->authenticate();
        $request->session()->regenerate();

        session([
            'currency' => auth()->user()->currency,
            'country' => auth()->user()->country,
            'timezone' => auth()->user()->timezone,
            'language' => auth()->user()->language,
        ]);

        if (session('redirect_to')) {
            $redirect_to = session('redirect_to');
            session(['redirect_to' => null]);
            return redirect($redirect_to);
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
