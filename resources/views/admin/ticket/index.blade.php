@extends('layouts.admin')

@inject('client_model', 'App\Models\Client')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Open Tickets (Waiting for your reply)</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="open-tickets-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->status == 1)
                                    <tr>
                                        <td><a href="{{ route('admin.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td><a href="{{ route('admin.client.show', ['id' => $ticket->client_id]) }}" target="_blank">{{ $client_model->find($ticket->client_id)->email }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pending Tickets (Waiting for clients' reply)</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="pending-tickets-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->status == 2)
                                    <tr>
                                        <td><a href="{{ route('admin.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td><a href="{{ route('admin.client.show', ['id' => $ticket->client_id]) }}" target="_blank">{{ $client_model->find($ticket->client_id)->email }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resolved Tickets</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="resolved-tickets-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->status == 0)
                                    <tr>
                                        <td><a href="{{ route('admin.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td><a href="{{ route('admin.client.show', ['id' => $ticket->client_id]) }}" target="_blank">{{ $client_model->find($ticket->client_id)->email }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Closed Tickets</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="closed-tickets-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if ($ticket->status == 3)
                                    <tr>
                                        <td><a href="{{ route('admin.ticket.show', ['id' => $ticket->id]) }}">{{ $ticket->id }}</a></td>
                                        <td><a href="{{ route('admin.client.show', ['id' => $ticket->client_id]) }}" target="_blank">{{ $client_model->find($ticket->client_id)->email }}</a></td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->updated_at }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:35%">Subject</th>
                                <th style="width:20%">Updated Date</th>
                                <th style="width:20%">Created Date</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            var css = document.createElement('link');
            css.href = '/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css';
            css.rel = 'stylesheet';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>

    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function () {
            $("#open-tickets-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
            $("#pending-tickets-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
            $("#resolved-tickets-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
            $("#closed-tickets-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
