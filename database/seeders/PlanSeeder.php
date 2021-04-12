<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;

        if (count(Plan::all()) == 0) {
            Plan::create([
                'name' => 'Example Plan',
                'category_id' => 1,
                'cpu' => 100,
                'ram' => 2000,
                'swap' => 0,
                'disk' => 5000,
                'io' => 500,
                'databases' => 5,
                'backups' => 10,
                'allocations' => 5,
                'egg_id' => 3,
                'price' => 10.00,
                'cycles' => '["monthly","trimonthly","biannually","annually"]',
            ]);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the plans table successfully!');
        else
            $this->command->line('Records already exist in the plans table. Skipped seeding!');
    }
}
