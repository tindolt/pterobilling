@extends('layouts.admin')

@inject('plan_model', 'App\Models\Plan')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="servers-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:10%">Panel ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:20%">Plan</th>
                                <th style="width:25%">Subdomain Name</th>
                                <th style="width:20%">Creation Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servers as $server)
                                <tr>
                                    <td><a href="{{ route('admin.server.show', ['id' => $server->id]) }}">{{ $server->id }}</a></td>
                                    <td><a href="{{ config('app.panel_url') }}/admin/servers/view/{{ $server->server_id }}" target="_blank">{{ $server->server_id }}</a></td>
                                    <td><a href="{{ route('admin.client.show', ['id' => $server->client_id]) }}" target="_blank">{{ $server->client_id }}</a></td>
                                    <td><a href="{{ route('admin.plan.show', ['id' => $server->plan_id]) }}" target="_blank">{{ $plan_model->find($server->plan_id)->name }}</a></td>
                                    <td>
                                        @if ($server->subdomain_name)
                                            {{ $server->subdomain_name }}.{{ $server->subdomain }}
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td>{{ $server->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:10%">Panel ID</th>
                                <th style="width:20%">Client</th>
                                <th style="width:20%">Plan</th>
                                <th style="width:25%">Subdomain Name</th>
                                <th style="width:20%">Creation Date</th>
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
            $("#servers-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
