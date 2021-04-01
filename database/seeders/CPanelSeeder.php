<?php

namespace Database\Seeders;

use App\Models\Extension;
use Illuminate\Database\Seeder;

class CPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Extension::create([
            'extension' => 'CPanel',
            'key' => 'enabled',
            'value' => 'false',
        ]);
        Extension::create([
            'extension' => 'CPanel',
            'key' => 'url',
            'value' => 'https://cpanel.example.com:2083',
        ]);
        Extension::create([
            'extension' => 'CPanel',
            'key' => 'username',
            'value' => null,
        ]);
        Extension::create([
            'extension' => 'CPanel',
            'key' => 'api_key',
            'value' => null,
        ]);
    }
}
