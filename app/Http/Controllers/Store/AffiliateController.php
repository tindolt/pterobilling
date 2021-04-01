<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Client;

class AffiliateController extends Controller
{
    public function __invoke($id)
    {
        if ($client = Client::find($id)) {
            if (is_null(session('referer_id'))) {
                session(['referer_id' => $id]);
                $client->clicks += 1;
                $client->save();
            }
        }
        
        return redirect()->route('home');
    }
}
