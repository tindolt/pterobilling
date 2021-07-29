<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PterodactylSDK\PterodactylAPI;

class ImportPanelUsers implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pages;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pterodactyl_api = new PterodactylAPI;
        $this->pages = 1;
        $this->importUsers($pterodactyl_api);

        for ($p=2; $p <= $this->pages; $p++) {
            $this->importUsers($pterodactyl_api, $p);
        }
    }

    private function importUsers(PterodactylAPI $pterodactyl_api, int $p = null) {
        $api = $pterodactyl_api->users($p)->getAll();

        if ($api->status() != '200' || !empty($api->errors())) {
            Log::error("An error occurred while getting a node and its allocations!");

            foreach ($api->errors() as $error) {
                Log::error($error);
            }
        } else {
            $this->pages = $api->response()->meta->pagination->total_pages;
            foreach ($api->response()->data as $user_obj) {
                $email = $user_obj->attributes->email;
                $user_id = $user_obj->attributes->id;

                if (!Client::where('email', $email)->orWhere('user_id', $user_id)->first()) {
                    Client::create([
                        'email' => $email,
                        'user_id' => $user_id,
                        'password' => Hash::make(Str::random()),
                    ]);
                }
            }
        }
    }
}
