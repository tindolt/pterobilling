<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Extensions\ExtensionManager;
use Illuminate\Http\Request;

class SubdomainController extends Controller
{
    public function show($id)
    {
        $subdomains = [];

        foreach (ExtensionManager::subdomain_extensions() as $extension) {
            $subdomains[$extension] = $extension::getSubdomains();
        }

        $view_variables = array('title' => "Subdomain Name | Server #${id} - My Servers", 'header1' => 'My Servers', 'header1_route' => 'client.server.index', 'header2' => "Server #${id}", 'header2_route' => 'client.server.show', 'header_title' => 'Subdomain Name', 'id' => $id, 'subdomains' => $subdomains);
        return view('client.server.subdomain', $view_variables);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            '' => '',
        ]);
    }
}
