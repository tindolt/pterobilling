<?php

namespace App\Http\Middleware;

use App\Models\Server;
use App\Traits\PterodactylApi;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CacheServerDetails
{
    use PterodactylApi;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (is_null(session('server_details_updated_at'))) {
            $this->refreshServerDetails($request);
        } elseif ((session('server_details_updated_at') - Carbon::now()->timestamp) > 180) {
            $this->refreshServerDetails($request);
        }

        return $next($request);
    }

    private function refreshServerDetails(Request $request)
    {
        session(['server_details_updated_at' => Carbon::now()->timestamp]);

        $servers = Server::where('client_id', $request->user()->id)->get();

        foreach ($servers as $server) {
            $result = $this->appApi('servers/' . $server->server_id, 'GET');

            if ($result) {
                if (array_key_exists('errors', $result)) {
                    $server_name = 'ERROR';
                } else {
                    $server_name = $result['attributes']['name'];
                }
            } else {
                $server_name = 'ERROR';
            }

            session(['server_' . $server->id => $server_name]);
        }
    }
}
