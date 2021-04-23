<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Tax;
use Illuminate\Database\Seeder;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        
        if (count(Client::all()) == 0) {
            Client::create([
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'user_id' => 1,
                'password' => Hash::make('password'),
                'currency' => Currency::where('default', true)->value('name'),
                'country' => Tax::where('country', '0')->value('country'),
                'is_admin' => true,
            ]);
            ++$i;
        }

        if ($i > 0)
            $this->command->info('Seeded and updated the clients table successfully!');
        else
            $this->command->line('Records already exist in the clients table. Skipped seeding!');
    }
}
