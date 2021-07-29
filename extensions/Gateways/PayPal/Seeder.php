<?php

namespace Extensions\Gateways\PayPal;

use App\Models\Extension;
use Illuminate\Database\Seeder as DatabaseSeeder;

class Seeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'enabled'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'enabled',
                'value' => 'false',
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'mode'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'mode',
                'value' => 'sandbox',
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'sandbox_api_username'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'sandbox_api_username',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'sandbox_api_password'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'sandbox_api_password',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'sandbox_api_secret'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'sandbox_api_secret',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'sandbox_api_certificate'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'sandbox_api_certificate',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'sandbox_app_id'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'sandbox_app_id',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'live_api_username'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'live_api_username',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'live_api_password'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'live_api_password',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'live_api_secret'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'live_api_secret',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'live_api_certificate'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'live_api_certificate',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'PayPal', 'key' => 'live_app_id'])->first())) {
            Extension::create([
                'extension' => 'PayPal',
                'key' => 'live_app_id',
                'value' => null,
            ]);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the extensions table for PayPal extension successfully!');
        else
            $this->command->line('Records of PayPal extension already exist in the extensions table. Skipped seeding!');
    }
}
