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
        $view_variables = array('title' => "Server Info | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Server Info', 'id' => $id);

        switch (Server::find($id)->first()->status) {
            case 0:
                return view('client.server.show', $view_variables);
                break;
            case 1:
                return view('client.server.pending', $view_variables);
                break;
            case 2:
                return view('client.server.suspended', $view_variables);
                break;
            case 3:
                return view('client.server.canceled', $view_variables);
                break;
        }
    }
}
