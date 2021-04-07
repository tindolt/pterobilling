@extends('layouts.admin')

@inject('plan_model', 'App\Models\Plan')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav ml-auto p-2">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.show', ['id' => $id]) }}">Settings</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.client.servers', ['id' => $id]) }}">Servers</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.invoices', ['id' => $id]) }}">Invoices</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.tickets', ['id' => $id]) }}">Support Tickets</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.affiliates', ['id' => $id]) }}">Affiliates</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.credit', ['id' => $id]) }}">Credit</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Active Servers</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:10%">Panel ID</th>
                                <th style="width:22%">Plan</th>
                                <th style="width:27%">Subdomain Name</th>
                                <th style="width:12%">Status</th>
                                <th style="width:24%">Creation Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servers as $server)
                                @if ($server->status === 0)
                                    <tr>
                                        <td><a href="{{ route('admin.server.show', ['id' => $server->id]) }}">{{ $server->id }}</a></td>
                                        <td><a href="{{ config('app.panel_url') }}/servers/view/{{ $server->server_id }}">{{ $server->server_id }}</a></td>
                                        <td><a href="{{ route('admin.plan.show', ['id' => $server->plan_id]) }}" target="_blank">{{ $plan_model->find($server->plan_id)->name }}</a></td>
                                        <td>
                                            @if ($server->subdomain_name)
                                                {{ $server->subdomain_name }}.{{ $server->subdomain }}
                                            @else
                                                None
                                            @endif
                                        </td>
                                        <td><span id="server_status_{{ $server->identifier }}"><span class="badge bg-warning">Loading</span></span></td>
                                        <td>{{ $server->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pending Servers</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:15%">Panel ID</th>
                                <th style="width:30%">Plan</th>
                                <th style="width:45%">Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servers as $server)
                                @if ($server->status === 1)
                                    <tr>
                                        <td><a href="{{ route('admin.server.show', ['id' => $server->id]) }}">{{ $server->id }}</a></td>
                                        <td><a href="{{ config('app.panel_url') }}/servers/view/{{ $server->server_id }}">{{ $server->server_id }}</a></td>
                                        <td>{{ $plan_model->find($server->plan_id)->name }}</td>
                                        <td>{{ $server->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Canceled Servers</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:15%">Panel ID</th>
                                <th style="width:30%">Plan</th>
                                <th style="width:45%">Cancellation Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servers as $server)
                                @if ($server->status === 3)
                                    <tr>
                                        <td><a href="{{ route('admin.server.show', ['id' => $server->id]) }}">{{ $server->id }}</a></td>
                                        <td><a href="{{ config('app.panel_url') }}/servers/view/{{ $server->server_id }}">{{ $server->server_id }}</a></td>
                                        <td>{{ $plan_model->find($server->plan_id)->name }}</td>
                                        <td>{{ $server->updated_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Suspended Servers</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:15%">Panel ID</th>
                                <th style="width:30%">Plan</th>
                                <th style="width:45%">Suspension Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servers as $server)
                                @if ($server->status === 2)
                                    <tr>
                                        <td><a href="{{ route('admin.server.show', ['id' => $server->id]) }}">{{ $server->id }}</a></td>
                                        <td><a href="{{ config('app.panel_url') }}/servers/view/{{ $server->server_id }}">{{ $server->server_id }}</a></td>
                                        <td>{{ $plan_model->find($server->plan_id)->name }}</td>
                                        <td>{{ $server->updated_at }}</td>
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

@section('scripts')
    <script>
        function callApi(action, callback) {
            fetch(`/api/pterodactyl/{{ $client->api_key }}/${action}/GET`)
            .then((resp) => resp.json())
            .then(function(data) {
                (callback)(data);
            })
            .catch(function(error) {
                console.error(error);
            });
        }

        function updateStatus(identifier) {
            var server_status = document.getElementById(`server_status_${identifier}`);

            callApi(`serversSLASH${identifier}SLASHresources`, function(data) {
                switch (data.attributes.current_state) {
                    case "starting":
                        server_status.innerHTML = `<span class="badge bg-info">Starting</span>`;
                        break;
                    case "running":
                        server_status.innerHTML = `<span class="badge bg-success">Online</span>`;
                        break;
                    case "stopping":
                        server_status.innerHTML = `<span class="badge bg-info">Stopping</span>`;
                        break;
                    case "offline":
                        server_status.innerHTML = `<span class="badge bg-danger">Offline</span>`;
                        break;
                }
            });
        }

        @foreach ($servers as $server)
            @if ($server->status === 0)
                updateStatus({{ $server->identifier }});
            @endif
        @endforeach
    </script>
@endsection
