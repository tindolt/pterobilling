<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketContent;
use App\Traits\HCaptcha;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use HCaptcha;

    public function index()
    {
        return view('client.ticket.index', ['title' => 'Support Tickets']);
    }

    public function show($id)
    {
        $view_variables = array('title' => "Ticket ${id} - Support Tickets", 'header1' => 'Support Tickets', 'header1_route' => 'client.ticket.index', 'header_title' => "Ticket ${id}", 'id' => $id);
        return view('client.ticket.show', $view_variables);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if ($request->input('solved')) {
            $ticket->status = 0;
            $ticket->save();
            return redirect()->route('client.ticket.index')->with('success_msg', 'Your ticket has been marked resolved. If you\'d like to reopen it, please reply to the ticket.');
        }

        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only(['subject', 'message']))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate(['message' => 'required|string|min:100|max:5000']);

        TicketContent::create([
            'ticket_id' => $id,
            'replier_id' => $request->user()->id,
            'message' => $request->input('message'),
        ]);

        $ticket->status = 1;
        $ticket->save();

        return back()->with('success_msg', 'You\'ve successfully replied to the ticket. Our staff will reply to you as soon as possible.');
    }

    public function create()
    {
        $view_variables = array('title' => 'Create Ticket - Support Tickets', 'header1' => 'Support Tickets', 'header1_route' => 'client.ticket.index', 'header_title' => 'Create Ticket');
        return view('client.ticket.create', $view_variables);
    }

    public function store(Request $request)
    {
        if (!$this->validateResponse($request->input('h-captcha-response'))) {
            return back()->withInput($request->only(['subject', 'message']))->with('danger_msg', 'Please solve the captcha challenge again.');
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:100|max:5000',
        ]);

        $ticket = Ticket::create([
            'client_id' => $request->user()->id,
            'subject' => $request->input('subject'),
        ]);
        
        TicketContent::create([
            'ticket_id' => $ticket->id,
            'replier_id' => $request->user()->id,
            'message' => $request->input('message'),
        ]);

        return redirect()->route('client.ticket.show', ['id' => $ticket->id]);
    }
}
