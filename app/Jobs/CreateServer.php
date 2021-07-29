<?php

namespace App\Jobs;

use App\Models\Addon;
use App\Models\Client;
use App\Models\Plan;
use App\Models\Server;
use App\Models\ServerAddon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PterodactylSDK\PterodactylAPI;

class CreateServer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The server instance.
     *
     * @var \App\Models\Server
     */
    protected $server;
    
    protected $name;
    protected $nodes;
    protected $min_port;
    protected $nest_id;
    protected $egg_id;
    protected $allocation_id;
    protected $pages;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Server $server, string $name, int $user_id, int $nest_id, int $egg_id, array $nodes, int $min_port)
    {
        $this->server = $server;
        $this->name = $name;
        $this->nodes = $nodes;
        $this->min_port = $min_port;
        $this->nest_id = $nest_id;
        $this->egg_id = $egg_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pterodactyl_api = new PterodactylAPI;

        $this->pages = 1;

        foreach ($this->nodes as $node) {
            $this->getAllocationId($pterodactyl_api, $node);
            
            if ($this->allocation_id) {
                break;
            } else {
                for ($p=2; $p <= $this->pages; $p++) { 
                    $this->getAllocationId($pterodactyl_api, $node, $p);
                    if ($this->allocation_id) break;
                }
            }
        }

        if ($this->allocation_id == null) return $this->fail();
        
        $egg_api = $pterodactyl_api->nests()->eggsGet($this->nest_id, $this->egg_id);
        
        $egg = [];
        if ($egg_api->status() != '200' || !empty($egg_api->errors())) {
            Log::error("An error occurred while getting egg details!");

            foreach ($egg_api->errors() as $error) {
                Log::error($error);
            }

            return $this->fail();
        } else {
            $egg['docker_image'] = $egg_api->response()->attributes->docker_image;
            $egg['startup'] = $egg_api->response()->attributes->startup;
            $egg['environment'] = [];
            
            foreach ($egg_api->response()->attributes->relationships->variables->data as $key => $value) {
                $egg['environment'][$key] = $value;
            }
        }
        
        $plan = Plan::find($this->server->plan_id);
        $cpu = $plan->cpu;
        $ram = $plan->ram;
        $swap = $plan->swap;
        $disk = $plan->disk;
        $io = $plan->io;
        $databases = $plan->databases;
        $backups = $plan->backups;
        $extra_ports = $plan->extra_ports;

        foreach (ServerAddon::where('server_id', $this->server->id) as $server_addon) {
            switch (($addon = Addon::find($server_addon->addon_id))->resource) {
                case 'ram':
                    $ram += $addon->amount * $server_addon->quantity;
                    break;
                case 'cpu':
                    $cpu += $addon->amount * $server_addon->quantity;
                    break;
                case 'disk':
                    $disk += $addon->amount * $server_addon->quantity;
                    break;
                case 'database':
                    $databases += $addon->amount * $server_addon->quantity;
                    break;
                case 'backup':
                    $backups += $addon->amount * $server_addon->quantity;
                    break;
                case 'extra_port':
                    $extra_ports += $addon->amount * $server_addon->quantity;
                    break;
                case 'dedicated_ip':
                    $this->allocation_id = $addon->amount;
                    break;
            }
        }

        $server_api = $pterodactyl_api->servers()->add([
            'name' => $this->name,
            'user' => Client::find($this->server->client_id)->user_id,
            'egg' => $this->egg_id,
            'docker_image' => $egg['docker_image'],
            'startup' => $egg['startup'],
            'environment' => $egg['environment'],
            'limits' => [
                'cpu' => $cpu,
                'memory' => $ram,
                'swap' => $swap,
                'disk' => $disk,
                'io' => $io,
            ],
            'feature_limits' => [
                'databases' => $databases,
                'backups' => $backups,
                'allocations' => $extra_ports + 1,
            ],
            'allocation' => [
                'default' => $this->allocation_id,
            ],
        ]);

        if ($server_api->status() != '201' || !empty($server_api->errors())) {
            Log::error("An error occurred while creating a server!");

            foreach ($server_api->errors() as $error) {
                Log::error($error);
            }
            
            return $this->fail();
        }

        $this->server->status = 0;
        $this->server->save();
    }

    private function getAllocationId(PterodactylAPI $pterodactyl_api, int $node, int $p = null) {
        $allocation_api = $pterodactyl_api->nodes($p)->allocationsGetAll($node);

        if ($allocation_api->status() != '200' || !empty($allocation_api->errors())) {
            Log::error("An error occurred while getting a node and its allocations!");

            foreach ($allocation_api->errors() as $error) {
                Log::error($error);
            }
        } else {
            $this->pages = $allocation_api->response()->meta->pagination->total_pages;
            foreach ($allocation_api->response()->data as $allocation_obj) {
                if ($allocation_obj->attributes->port >= $this->min_port) {
                    $this->allocation_id = $allocation_obj->attributes->id;
                    break;
                }
            }
        }
    }
}
