<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DashController extends Controller
{
    public function show()
    {
        return view('client.dash', ['title' => 'Dashboard']);
    }
}
