<?php

namespace Database\Seeders;

use App\Models\KbArticle;
use App\Models\KbCategory;
use Illuminate\Database\Seeder;

class KbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x = 0;
        $y = 0;

        if (count(KbCategory::all()) == 0) {
            KbCategory::create([
                'name' => 'Example Category',
            ]);
            ++$x;
        }

        if (count(KbArticle::all()) == 0) {
            KbArticle::create([
                'category_id' => 1,
                'subject' => 'Example Article',
                'content' => 'You may edit or delete me in the admin area.'
            ]);
            ++$y;
        }

        if ($x > 0)
            $this->command->info('Seeded and updated the kb_categories table successfully!');
        else
            $this->command->line('Records already exist in the kb_categories table. Skipped seeding!');

        if ($y > 0)
            $this->command->info('Seeded and updated the kb_articles table successfully!');
        else
            $this->command->line('Records already exist in the kb_articles table. Skipped seeding!');
    }
}
