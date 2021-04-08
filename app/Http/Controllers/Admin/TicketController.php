<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketContent;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return view('admin.ticket.index', ['title' => 'Support Tickets', 'tickets' => Ticket::all()]);
    }
    
    public function show($id)
    {
        return view('admin.ticket.show', ['title' => "Ticket ${id} - Support Tickets", 'header1' => 'Support Tickets', 'header1_route' => 'admin.ticket.index', 'header_title' => "Ticket ${id}", 'replies' => TicketContent::where('ticket_id', $id)->get()]);
    }
    
    public function store(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if ($request->input('close')) {
            $ticket->status = 3;
            $ticket->save();
            return redirect()->route('admin.ticket.index')->with('success_msg', 'The ticket has been closed!');
        }

        $request->validate(['message' => 'required|string|max:5000']);

        TicketContent::create([
            'ticket_id' => $id,
            'replier_id' => $request->user()->id,
            'message' => $request->input('message'),
        ]);

        $ticket->status = 2;
        $ticket->save();

        return back()->with('success_msg', 'You\'ve replied to the ticket!');
    }
}
