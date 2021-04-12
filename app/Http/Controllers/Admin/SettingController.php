<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show()
    {
        return view('admin.setting', ['title' => 'Store Settings', 'setting' => Setting::orderBy('id', 'asc')->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'store_url' => 'required|string|max:255',
            'logo_path' => 'required|string|max:255',
            'favicon_path' => 'required|string|max:255',
            'panel_url' => 'required|string|max:255',
            'panel_api_key' => 'required|string|max:255',
            'phpmyadmin_url' => 'required|string|max:255',
            'hcaptcha_public_key' => 'required|string|max:255',
            'hcaptcha_secret_key' => 'required|string|max:255',
            'google_analytics_id' => 'required|string|max:255',
            'arc_widget_id' => 'required|string|max:255',
        ]);

        $this->saveSetting($request, 'company_name');
        $this->saveSetting($request, 'store_url');
        $this->saveSetting($request, 'logo_path');
        $this->saveSetting($request, 'favicon_path');
        
        $dark_mode = Setting::where('key', 'dark_mode')->first();
        $dark_mode->value = $request->has('dark_mode');
        $dark_mode->save();
        
        $open_registration = Setting::where('key', 'open_registration')->first();
        $open_registration->value = $request->has('open_registration');
        $open_registration->save();

        $this->saveSetting($request, 'panel_url');
        $this->saveSetting($request, 'panel_api_key');
        $this->saveSetting($request, 'phpmyadmin_url');
        $this->saveSetting($request, 'hcaptcha_public_key');
        $this->saveSetting($request, 'hcaptcha_secret_key');
        $this->saveSetting($request, 'google_analytics_id');
        $this->saveSetting($request, 'arc_widget_id');

        return back()->with('success_msg', 'You have updated the store settings! Please click \'Reload Config\' above on the navigation bar to apply them.');
    }

    private function saveSetting(Request $request, $key)
    {
        $setting = Setting::where('key', $key)->first();
        $setting->value = $request->input($key);
        $setting->save();
    }
}
