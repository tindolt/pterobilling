<?php

namespace Database\Seeders;

use App\Models\Extension;
use Illuminate\Database\Seeder;

class CloudflareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Extension::create([
            'extension' => 'Cloudflare',
            'key' => 'enabled',
            'value' => 'false',
        ]);
        Extension::create([
            'extension' => 'Cloudflare',
            'key' => 'email',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'Cloudflare',
            'key' => 'api_key',
            'value' => null,
        ]);
    }
}
