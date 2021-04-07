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
        ]);

        $this->saveSetting($request, 1, 'company_name');
        $this->saveSetting($request, 2, 'store_url');
        $this->saveSetting($request, 3, 'logo_path');
        $this->saveSetting($request, 4, 'favicon_path');
        
        $dark_mode = Setting::find(5);
        $dark_mode->value = $request->input('dark_mode') ? true : false;
        $dark_mode->save();

        $this->saveSetting($request, 6, 'panel_url');
        $this->saveSetting($request, 7, 'panel_api_key');
        $this->saveSetting($request, 8, 'phpmyadmin_url');
        $this->saveSetting($request, 9, 'hcaptcha_public_key');
        $this->saveSetting($request, 10, 'hcaptcha_secret_key');

        return back()->with('success_msg', 'You have updated the store settings! Please click \'Reload Config\' above on the navigation bar to apply them.');
    }

    private function saveSetting(Request $request, $id, $key)
    {
        $setting = Setting::find($id);
        $setting->value = $request->input($key);
        $setting->save();
    }
}
