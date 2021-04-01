<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Announcement::create([
            'key' => 'enabled',
            'value' => 'true',
        ]);
        Announcement::create([
            'key' => 'subject',
            'value' => 'Example Announcement',
        ]);
        Announcement::create([
            'key' => 'content',
            'value' => 'You may edit or remove me in the admin area.',
        ]);
        Announcement::create([
            'key' => 'theme',
            'value' => '0',
        ]);
    }
}
