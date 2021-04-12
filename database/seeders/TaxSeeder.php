<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;

        if (count(Tax::all()) == 0) {
            Tax::create(['country' => '0']);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the taxes table successfully!');
        else
            $this->command->line('Records already exist in the taxes table. Skipped seeding!');
    }
}
