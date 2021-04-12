<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Tax;
use App\Traits\HCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    use HCaptcha;
    
    public function show()
    {
        return view('client.account', ['title' => 'Account Settings']);
    }

    public function basic(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only(['currency', 'country']))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate([
            'currency' => 'required|string',
            'country' => 'required|string',
        ]);

        if (is_null($currency = Currency::find($request->input('currency')))) {
            return back()->withInput($request->only(['currency', 'country']))->with('danger_msg', 'Invalid currency ID! Please try again.');
        }

        if (is_null($tax = Tax::find($request->input('country')))) {
            return back()->withInput($request->only(['currency', 'country']))->with('danger_msg', 'Invalid country ID! Please try again.');
        }

        $client = Client::find($request->user()->id);
        $client->currency = $currency->name;
        $client->country = $tax->country;
        $client->save();

        session([
            'currency' => $currency,
            'tax' => $tax,
        ]);

        return back()->with('success_msg', 'Your account settings have been updated!');
    }

    public function api(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only('api_key'))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate(['api_key' => 'required|string']);

        $client = Client::find($request->user()->id);
        $client->api_key = $request->input('api_key');
        $client->save();

        return back()->with('success_msg', 'Your account settings have been updated!');
    }

    public function email(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only('email'))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate([
            'email' => 'required|string|max:255|unique:clients',
            'password' => 'required|string|min:8',
        ]);

        $client = Client::find($request->user()->id);

        if (Hash::check($request->input('password'), $client->password))
            return back()->with('danger_msg', 'The current password is incorrect!');
        
        $client->email = $request->input('email');
        $client->save();

        return back()->with('success_msg', 'Your account settings have been updated!');
    }

    public function password(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate([
            'current' => 'required|string|min:8',
            'password' => 'required|string|confirmed|min:8|max:255',
        ]);

        $client = Client::find($request->user()->id);

        if (Hash::check($request->input('password'), $client->password))
            return back()->with('danger_msg', 'The current password is incorrect!');
        
        $client->password = Hash::make($request->input('password'));
        $client->save();

        return back()->with('success_msg', 'Your account settings have been updated!');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login')->with('success_msg', 'You have logged out successfully!');
    }
}
