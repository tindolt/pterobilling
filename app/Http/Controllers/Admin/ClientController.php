<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateEarning;
use App\Models\Client;
use App\Models\Credit;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Server;
use App\Models\Tax;
use App\Models\Ticket;
use App\Traits\PterodactylApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    use PterodactylApi;

    public function index()
    {
        return view('admin.client.index', ['title' => 'Clients', 'clients' => Client::all()]);
    }

    public function import()
    {
        $users = $this->appApi('users?sort=id', 'GET');

        if ($users) {
            if (array_key_exists('errors', $users)) {
                return back()->with('danger_msg', 'Failed to import panel users!');
            } else {
                foreach ($users['data'] as $user) {
                    $email = $user['attributes']['email'];
                    $user_id = $user['attributes']['id'];

                    if (is_null(Client::where('email', $email)->orWhere('user_id', $user_id)->first())) {
                        Client::create([
                            'email' => $email,
                            'user_id' => $user_id,
                            'password' => Hash::make(Str::random()),
                        ]);
                    }
                }

                return back()->with('success_msg', 'Imported users from Pterodactyl panel successfully!');
            }
        } else {
            return back()->with('danger_msg', 'Failed to import panel users!');
        }
    }

    public function show($id)
    {
        $client = Client::find($id);
        return view('admin.client.show', ['title' => "$client->email - Clients", 'header1' => 'Clients', 'header1_route' => 'admin.client.index', 'header2' => $client->email, 'header2_route' => 'admin.client.show', 'header_title' => 'Client Settings', 'id' => $id]);
    }

    public function basic(Request $request, $id)
    {
        $request->validate([
            'currency' => 'required|string',
            'country' => 'required|string',
        ]);

        if (is_null($currency = Currency::find($request->input('currency')))) {
            return back()->withInput($request->only(['currency', 'country']))->with('danger_msg', 'Invalid currency ID! Please try again.');
        }

        if (is_null($tax = Tax::find($request->input('country')))) {
            return back()->withInput($request->only(['currency', 'country']))->with('danger_msg', 'Invalid country ID! Please try again.');
        }

        $client = Client::find($id);
        $client->currency = $currency->name;
        $client->country = $tax->country;
        $client->save();

        session([
            'currency' => $currency,
            'tax' => $tax,
        ]);

        return back()->with('success_msg', 'The account settings have been updated!');
    }

    public function email(Request $request, $id)
    {
        $request->validate(['email' => 'required|string|max:255|unique:clients']);
        $client = Client::find($id);
        $client->email = $request->input('email');
        $client->save();

        return back()->with('success_msg', 'The account settings have been updated!');
    }

    public function password(Request $request, $id)
    {
        $request->validate(['password' => 'required|string|min:8|max:255']);
        $client = Client::find($id);
        $client->password = Hash::make($request->input('password'));
        $client->save();

        return back()->with('success_msg', 'The account settings have been updated!');
    }

    public function admin($id)
    {
        $client = Client::find($id);
        $client->is_admin = $client->is_admin ? false : true;
        $client->save();

        return back()->with('success_msg', 'You have changed the role of the client!');
    }

    public function servers($id)
    {
        $client = Client::find($id);
        $servers = Server::where('client_id', $client->id)->get();
        return view('admin.client.servers', ['title' => "Servers | $client->email - Clients", 'header1' => 'Clients', 'header1_route' => 'admin.client.index', 'header2' => $client->email, 'header2_route' => 'admin.client.show', 'header_title' => 'Client Settings', 'id' => $id, 'servers' => $servers]);
    }

    public function invoices($id)
    {
        $client = Client::find($id);
        $invoices = Invoice::where('client_id', $client->id)->get();
        return view('admin.client.invoices', ['title' => "Invoices | $client->email - Clients", 'header1' => 'Clients', 'header1_route' => 'admin.client.index', 'header2' => $client->email, 'header2_route' => 'admin.client.show', 'header_title' => 'Client\'s Invoices', 'id' => $id, 'invoices' => $invoices]);
    }

    public function tickets($id)
    {
        $client = Client::find($id);
        $tickets = Ticket::where('client_id', $client->id)->get();
        return view('admin.client.tickets', ['title' => "Support Tickets | $client->email - Clients", 'header1' => 'Clients', 'header1_route' => 'admin.client.index', 'header2' => $client->email, 'header2_route' => 'admin.client.show', 'header_title' => 'Client\'s Support Tickets', 'id' => $id, 'tickets' => $tickets]);
    }

    public function affiliates($id)
    {
        $client = Client::find($id);
        $affiliates = AffiliateEarning::where('client_id', $client->id)->get();
        return view('admin.client.affiliates', ['title' => "Affiliates | $client->email - Clients", 'header1' => 'Clients', 'header1_route' => 'admin.client.index', 'header2' => $client->email, 'header2_route' => 'admin.client.show', 'header_title' => 'Client\'s Affiliates', 'id' => $id, 'affiliates' => $affiliates]);
    }

    public function credit($id)
    {
        $client = Client::find($id);
        $credits = Credit::where('client_id', $client->id)->get();
        return view('admin.client.credit', ['title' => "Account Credit | $client->email - Clients", 'header1' => 'Clients', 'header1_route' => 'admin.client.index', 'header2' => $client->email, 'header2_route' => 'admin.client.show', 'header_title' => 'Client\'s Account Credit', 'id' => $id, 'credits' => $credits]);
    }

    public function fund(Request $request, $id)
    {
        $request->validate(['credit' => 'required|numeric|gte:0']);
        $client = Client::find($id);
        $client->credit = $request->input('credit');
        $client->save();
        
        return back()->with('success_msg', 'You have successfully updated ' . $client->email . '\'s credit balance.');
    }
}
