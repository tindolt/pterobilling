<?php

namespace App\Jobs;

use App\Models\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PterodactylSDK\PterodactylAPI;

class DeletePanelUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = (new PterodactylAPI)->users()->delete($this->client_id);

        if ($api->status() != '204' || !empty($api->errors())) {
            Log::error("An error occurred while deleting a panel user!");

            foreach ($api->errors() as $error) {
                Log::error($error);
            }
            
            return $this->fail();
        }
    }
}
