<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AffiliateProgram;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AffiliateProgram::create([
            'key' => 'enabled',
            'value' => 'true',
        ]);
        AffiliateProgram::create([
            'key' => 'conversion',
            'value' => '50',
        ]);
        AffiliateProgram::create([
            'key' => 'payout_methods',
            'value' => '["credit"]',
        ]);
    }
}
