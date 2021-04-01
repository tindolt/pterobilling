<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key' => 'company_name',
            'value' => 'Company Name',
        ]);
        Setting::create([
            'key' => 'store_url',
            'value' => 'https://example.com',
        ]);
        Setting::create([
            'key' => 'logo_path',
            'value' => '/img/icon.webp',
        ]);
        Setting::create([
            'key' => 'favicon_path',
            'value' => '/img/favicon.webp',
        ]);
        Setting::create([
            'key' => 'dark_mode',
            'value' => 'true',
        ]);
        Setting::create([
            'key' => 'panel_url',
            'value' => 'https://panel.example.com',
        ]);
        Setting::create([
            'key' => 'panel_api_key',
            'value' => null,
        ]);
        Setting::create([
            'key' => 'phpmyadmin_url',
            'value' => 'https://pma.example.com',
        ]);
        Setting::create([
            'key' => 'hcaptcha_public_key',
            'value' => '72c60a15-1b23-4aa1-a44e-940f4b3555ae',
        ]);
        Setting::create([
            'key' => 'hcaptcha_secret_key',
            'value' => '0xe7F8c19870D5e3955b397bcB51BCe424AB728240',
        ]);
    }
}
