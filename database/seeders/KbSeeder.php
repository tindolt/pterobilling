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
        KbCategory::create([
            'name' => 'Example Category',
        ]);

        KbArticle::create([
            'category_id' => 1,
            'subject' => 'Example Article',
            'content' => 'You may edit or delete me in the admin area.'
        ]);
    }
}
