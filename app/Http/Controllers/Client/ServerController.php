<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Server;

class ServerController extends Controller
{
    public function index()
    {
        return view('client.server.index', ['title' => 'My Servers']);
    }

    public function show($id)
    {
        $server = Server::find($id);
        $view_variables = array('title' => "Server Info | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Server Info', 'id' => $id);
        return view('client.server.show', $view_variables);
    }
}
