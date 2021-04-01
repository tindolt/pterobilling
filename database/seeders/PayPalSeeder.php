<?php

namespace Database\Seeders;

use App\Models\Extension;
use Illuminate\Database\Seeder;

class PayPalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'enabled',
            'value' => 'false',
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'mode',
            'value' => 'sandbox',
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'sandbox_api_username',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'sandbox_api_password',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'sandbox_api_secret',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'sandbox_api_certificate',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'sandbox_app_id',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'live_api_username',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'live_api_password',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'live_api_secret',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'live_api_certificate',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'PayPal',
            'key' => 'live_app_id',
            'value' => null,
        ]);
    }
}
