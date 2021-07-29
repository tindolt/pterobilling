<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PterodactylSDK\PterodactylAPI;

class UnsuspendServer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $server_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($server_id)
    {
        $this->server_id = $server_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = (new PterodactylAPI)->servers()->unsuspend($this->server_id);

        if ($api->status() != '204' || !empty($api->errors())) {
            Log::error("An error occurred while unsuspending a server!");

            foreach ($api->errors() as $error) {
                Log::error($error);
            }
            
            return $this->fail();
        }
    }
}
