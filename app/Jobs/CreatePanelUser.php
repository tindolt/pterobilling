<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PterodactylSDK\PterodactylAPI;

class CreatePanelUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The client instance.
     *
     * @var \App\Models\Client
     */
    protected $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pterodactyl_api = new PterodactylAPI;
        $get_user_api = $pterodactyl_api->users()->getByEmail($this->client->email);

        if ($get_user_api->status() != '200' || !empty($get_user_api->errors())) {
            Log::error("An error occurred while getting a panel user!");

            foreach ($get_user_api->errors() as $error) {
                Log::error($error);
            }
            
            return $this->fail();
        }

        if (!empty($get_user_api->response()->data)) {
            if ($get_user_api->response()->data[0]->attributes->email == $this->client->email
                && Client::where('user_id', $user_id = $get_user_api->response()->data[0]->attributes->id)->count() == 0) {
                $this->client->user_id = $user_id;
                $this->client->save();
                return;
            }
        }
        
        $username = preg_replace("/[^A-Za-z0-9 ]/", '', strstr($this->client->email, '@', true) . Str::random(4));
        $create_user_api = (new PterodactylAPI)->users()->add([
            'username' => $username,
            'email' => $this->client->email,
            'first_name' => 'First',
            'last_name' => 'Last',
        ]);

        if ($create_user_api->status() != '201' || !empty($create_user_api->errors())) {
            Log::error("An error occurred while creating a panel user!");

            foreach ($create_user_api->errors() as $error) {
                Log::error($error);
            }
            
            return $this->fail();
        }

        $this->client->user_id = $create_user_api->response()->attributes->id;
        $this->client->save();
    }
}
