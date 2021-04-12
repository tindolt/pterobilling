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
        $i = 0;

        if (is_null(Announcement::where('key', 'enabled')->first())) {
            Announcement::create([
                'key' => 'enabled',
                'value' => 'true',
            ]);
            ++$i;
        }

        if (is_null(Announcement::where('key', 'subject')->first())) {
            Announcement::create([
                'key' => 'subject',
                'value' => 'Example Announcement',
            ]);
            ++$i;
        }

        if (is_null(Announcement::where('key', 'content')->first())) {
            Announcement::create([
                'key' => 'content',
                'value' => 'You may edit or remove me in the admin area.',
            ]);
            ++$i;
        }

        if (is_null(Announcement::where('key', 'theme')->first())) {
            Announcement::create([
                'key' => 'theme',
                'value' => '0',
            ]);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the announcements table successfully!');
        else
            $this->command->line('Records already exist in the announcements table. Skipped seeding!');
    }
}
