<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        
        if (count(Category::all()) == 0) {
            Category::create(['name' => 'Example Category']);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the categories table successfully!');
        else
            $this->command->line('Records already exist in the categories table. Skipped seeding!');
    }
}
