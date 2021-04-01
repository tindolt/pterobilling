<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create([
            'name' => 'home',
            'content' => "<h1>Welcome to your new PteroBilling store.</h1>\n<p>This is the home page. You may edit this page in the admin area.</p>",
        ]);
        Page::create([
            'name' => 'contact',
            'content' => config('mail.from.address', 'hello@example.com'),
        ]);
        Page::create([
            'name' => 'status',
            'content' => "<h1>Welcome to your System Status page.</h1>\n<p>You may edit this page in the admin area.</p>",
        ]);
        Page::create([
            'name' => 'terms',
            'content' => "<h1>Welcome to your Terms of Service page.</h1>\n<p>You may edit this page in the admin area.</p>",
        ]);
        Page::create([
            'name' => 'privacy',
            'content' => "<h1>Welcome to your Privacy Policy page.</h1>\n<p>You may edit this page in the admin area.</p>",
        ]);
    }
}
