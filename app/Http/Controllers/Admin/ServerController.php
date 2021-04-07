<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Server;
use App\Traits\PterodactylApi;

class ServerController extends Controller
{
    use PterodactylApi;

    public function active()
    {
        $servers = Server::where('status', 0)->get();
        return view('admin.server.active', ['title' => 'Active Servers', 'servers' => $servers]);
    }

    public function pending()
    {
        $servers = Server::where('status', 1)->get();
        return view('admin.server.pending', ['title' => 'Pending Servers', 'servers' => $servers]);
    }

    public function suspended()
    {
        $servers = Server::where('status', 2)->get();
        return view('admin.server.suspended', ['title' => 'Suspended Servers', 'servers' => $servers]);
    }

    public function canceled()
    {
        $servers = Server::where('status', 3)->get();
        return view('admin.server.canceled', ['title' => 'Canceled Servers', 'servers' => $servers]);
    }

    public function show($id)
    {
        return view('admin.server.show', ['title' => "Server Info | Server #${id} - Servers", 'header1' => 'Servers', 'header1_route' => 'admin.servers.active', 'header2' => "Server #${id}", 'header2_route' => 'admin.server.show', 'header_title' => 'Server Info', 'id' => $id]);
    }

    public function suspend($id)
    {
        $server = Server::find($id);

        if ($server->status === 2) {
            $response = $this->appApi("serversSLASH${id}SLASHunsuspend", 'POST');

            if ($response) {
                if (array_key_exists('errors', $response)) {
                    return back()->with('danger_msg', 'Failed to un-suspend the server!');
                } else {
                    $server->status = 0;
                    $server->save();

                    return back()->with('success_msg', 'You have successfully un-suspended the server.');
                }
            } else {
                return back()->with('danger_msg', 'Failed to un-suspend the server!');
            }
        } else {
            $response = $this->appApi("serversSLASH${id}SLASHsuspend", 'POST');

            if ($response) {
                if (array_key_exists('errors', $response)) {
                    return back()->with('danger_msg', 'Failed to suspend the server!');
                } else {
                    $server->status = 2;
                    $server->save();

                    return back()->with('success_msg', 'You have successfully suspended the server.');
                }
            } else {
                return back()->with('danger_msg', 'Failed to suspend the server!');
            }
        }
    }
}
