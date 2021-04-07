@extends('layouts.client')

@inject('ticket_model', 'App\Models\Ticket')

@php
    $tickets = $ticket_model->where(['client_id' => auth()->user()->id])->get();
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Open Tickets</h3>
                    <div class="card-tools">
                        <a href="{{ route('client.ticket.create', ['id' => 0]) }}" class="btn btn-success btn-sm float-right">Create Ticket <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:10%">Status</th>
                                <th style="width:25%">Updated Date</th>
                                <th style="width:25%">Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->status == 1)
                                    <tr>
                                        <td><a href="{{ route('client.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td><span class="badge bg-info">Open</span></td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @elseif ($ticket->status == 2)
                                    <tr>
                                        <td><a href="{{ route('client.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Closed Tickets</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:10%">Status</th>
                                <th style="width:25%">Updated Date</th>
                                <th style="width:25%">Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->status == 0)
                                    <tr>
                                        <td><a href="{{ route('client.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td><span class="badge bg-success">Resolved</span></td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @elseif ($ticket->status == 3)
                                    <tr>
                                        <td><a href="{{ route('client.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td><span class="badge bg-danger">Closed</span></td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
