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
        $i = 0;

        if (count(Addon::all()) == 0) {
            Addon::create([
                'name' => '+1 GB RAM Example Addon',
                'resource' => 'ram',
                'amount' => 1000,
                'price' => 5.00,
                'categories' => '[1]',
            ]);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the addons table successfully!');
        else
            $this->command->line('Records already exist in the addons table. Skipped seeding!');
    }
}
