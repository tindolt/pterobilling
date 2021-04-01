<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function show()
    {
        return view('client.account', ['title' => 'Account Settings']);
    }

    public function store(Request $request)
    {
        switch ($request->setting) {
            case "account":
                return $this->accountSetting($request);
                break;
            case "panel_api":
                return $this->panelApiSettings($request);
                break;
            case "email":
                return $this->emailSetting($request);
                break;
            case "password":
                return $this->passwordSetting($request);
                break;
            default:
                return back();
        }
    }

    private function accountSetting(Request $request)
    {
        $request->validate([
            'currency' => 'required|string',
            'country' => 'required|string',
        ]);

        $client = Client::find($request->user()->id);
        $client->currency = $request->input('currency');
        $client->country = $request->input('country');
        $client->save();

        return back()->with('success', true);
    }

    private function panelApiSettings(Request $request)
    {
        $request->validate(['api_key' => 'required|string']);

        $client = Client::find($request->user()->id);
        $client->api_key = $request->input('api_key');
        $client->save();

        return back()->with('success', true);
    }

    private function emailSetting(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255|unique:clients',
            'password' => 'required|string|min:8',
        ]);

        $client = Client::find($request->user()->id);

        if (Hash::check($request->input('password'), $client->password))
            return back()->with('password_incorrect', true);
        
        $client->email = $request->input('email');
        $client->save();

        return back()->with('success', true);
    }

    private function passwordSetting(Request $request)
    {
        $request->validate([
            'current' => 'required|string|min:8',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $client = Client::find($request->user()->id);

        if (Hash::check($request->input('password'), $client->password))
            return back()->with('password_incorrect', true);
        
        $client->password = Hash::make($request->input('password'));
        $client->save();

        return back()->with('success', true);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login')->with('success_msg', 'You have logged out successfully!');
    }
}
