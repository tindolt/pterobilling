<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AffiliateSeeder::class,
            PlanSeeder::class,
            CategorySeeder::class,
            AddonSeeder::class,
            CurrencySeeder::class,
            TaxSeeder::class,
            ClientSeeder::class,
            KbSeeder::class,
            AnnouncementSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,

            /**
             * Extensions' seeder classes
             */
            PayPalSeeder::class,
            CloudflareSeeder::class,
            CPanelSeeder::class,
        ]);
    }
}
