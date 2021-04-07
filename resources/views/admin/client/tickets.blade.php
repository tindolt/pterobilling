@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav ml-auto p-2">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.show', ['id' => $id]) }}">Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.servers', ['id' => $id]) }}">Servers</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.invoices', ['id' => $id]) }}">Invoices</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.client.tickets', ['id' => $id]) }}">Support Tickets</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.affiliates', ['id' => $id]) }}">Affiliates</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.credit', ['id' => $id]) }}">Credit</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Open Tickets</h3>
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
