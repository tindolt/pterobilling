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
        $i = 0;

        if (is_null(Extension::where(['extension' => 'CPanel', 'key' => 'enabled'])->first())) {
            Extension::create([
                'extension' => 'CPanel',
                'key' => 'enabled',
                'value' => 'false',
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'CPanel', 'key' => 'url'])->first())) {
            Extension::create([
                'extension' => 'CPanel',
                'key' => 'url',
                'value' => 'https://cpanel.example.com:2083',
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'CPanel', 'key' => 'username'])->first())) {
            Extension::create([
                'extension' => 'CPanel',
                'key' => 'username',
                'value' => null,
            ]);
            ++$i;
        }

        if (is_null(Extension::where(['extension' => 'CPanel', 'key' => 'api_key'])->first())) {
            Extension::create([
                'extension' => 'CPanel',
                'key' => 'api_key',
                'value' => null,
            ]);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the extensions table for CPanel extension successfully!');
        else
            $this->command->line('Records of CPanel extension already exist in the extensions table. Skipped seeding!');
    }
}
