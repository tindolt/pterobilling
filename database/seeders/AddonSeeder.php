<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Seeder;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Addon::create([
            'name' => 'Example Addon',
            'resource' => 'ram',
            'amount' => 1000,
            'price' => 5.00,
            'categories' => '[1]',
        ]);
    }
}
