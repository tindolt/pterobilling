<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PterodactylSDK\PterodactylAPI;

class EditPanelUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $email)
    {
        $this->user_id = $user_id;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pterodactyl_api = new PterodactylAPI;
        $user_api = $pterodactyl_api->users()->get($this->user_id);
        if ($user_api->status() != '200' || !empty($user_api->errors())) {
            Log::error("An error occurred while getting the panel user!");

            foreach ($user_api->errors() as $error) {
                Log::error($error);
            }
            
            return $this->fail();
        }

        $update_api = $pterodactyl_api->users()->edit($this->user_id, [
            'email' => $this->email,
            'username' => $user_api->response()->attributes->username,
            'first_name' => $user_api->response()->attributes->first_name, 
            'last_name' => $user_api->response()->attributes->last_name,
            'language' => $user_api->response()->attributes->language,
        ]);
        
        if ($update_api->status() != '200' || !empty($update_api->errors())) {
            Log::error("An error occurred while updating the panel email!");

            foreach ($update_api->errors() as $error) {
                Log::error($error);
            }

            return $this->fail();
        }
    }
}
