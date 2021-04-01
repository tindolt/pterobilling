<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\PterodactylApi;

class PterodactylApiController extends Controller
{
    use PterodactylApi;

    public function __invoke($api_key, $action, $method, $fields = null)
    {
        $action = str_replace('SLASH', '/', $action);
        $result = $this->clientApi($api_key, $action, $method, $fields);

        if ($result === false) {
            $result = ['errors' => true];
        }

        return json_encode($result);
    }
}
