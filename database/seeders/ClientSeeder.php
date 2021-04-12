<?php

namespace Database\Seeders;

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
