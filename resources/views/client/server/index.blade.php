@extends('layouts.client')

@inject('server_model', 'App\Models\Server')
@inject('plan_model', 'App\Models\Plan')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Active Servers</h3>
                    <div class="card-tools">
                        <a href="{{ config('app.panel_url') }}" class="btn btn-default btn-sm float-right" target="_blank">View in Panel <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:15%">Plan</th>
                                <th style="width:24%">Server Name</th>
                                <th style="width:24%">Subdomain Name</th>
                                <th style="width:8%">RAM (MB)</th>
                                <th style="width:8%">CPU (%)</th>
                                <th style="width:8%">Disk (MB)</th>
                                <th style="width:8%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($server_model->where(['client_id' => auth()->user()->id, 'status' => 0])->get() as $server)
                                <tr>
                                    <td><a href="{{ route('client.server.show', ['id' => $server->id]) }}">{{ $server->id }}</a></td>
                                    <td>{{ $plan_model->find($server->plan_id)->name }}</td>
                                    <td>
                                        @if(session('server_' . $server->id))
                                            {{ session('server_' . $server->id) }}
                                        @else
                                            Server #{{ $server->id }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($server->subdomain_name)
                                            {{ $server->subdomain_name }}.{{ $server->subdomain }}
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td><span id="memory_usage_{{ $server->identifier }}">Loading</span></td>
                                    <td><span id="cpu_usage_{{ $server->identifier }}">Loading</span></td>
                                    <td><span id="disk_usage_{{ $server->identifier }}">Loading</span></td>
                                    <td><span id="server_status_{{ $server->identifier }}"><span class="badge bg-warning">Loading</span></span></td>
                                </tr>
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
                                <th style="width:20%">Plan</th>
                                <th style="width:35%">Server Name</th>
                                <th style="width:35%">Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($server_model->where(['client_id' => auth()->user()->id, 'status' => 1])->get() as $server)
                                <tr>
                                    <td>{{ $server->id }}</td>
                                    <td>{{ $plan_model->find($server->plan_id)->name }}</td>
                                    <td>
                                        @if(session('server_' . $server->id))
                                            {{ session('server_' . $server->id) }}
                                        @else
                                            Server #{{ $server->id }}
                                        @endif
                                    </td>
                                    <td>{{ $server->created_at }}</td>
                                </tr>
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
                                <th style="width:20%">Plan</th>
                                <th style="width:35%">Server Name</th>
                                <th style="width:35%">Cancellation Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($server_model->where(['client_id' => auth()->user()->id, 'status' => 3])->get() as $server)
                                <tr>
                                    <td>{{ $server->id }}</td>
                                    <td>{{ $plan_model->find($server->plan_id)->name }}</td>
                                    <td>
                                        @if(session('server_' . $server->id))
                                            {{ session('server_' . $server->id) }}
                                        @else
                                            Server #{{ $server->id }}
                                        @endif
                                    </td>
                                    <td>{{ $server->updated_at }}</td>
                                </tr>
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
                                <th style="width:20%">Plan</th>
                                <th style="width:35%">Server Name</th>
                                <th style="width:35%">Suspension Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($server_model->where(['client_id' => auth()->user()->id, 'status' => 2])->get() as $server)
                                <tr>
                                    <td>{{ $server->id }}</td>
                                    <td>{{ $plan_model->find($server->plan_id)->name }}</td>
                                    <td>
                                        @if(session('server_' . $server->id))
                                            {{ session('server_' . $server->id) }}
                                        @else
                                            Server #{{ $server->id }}
                                        @endif
                                    </td>
                                    <td>{{ $server->updated_at }}</td>
                                </tr>
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
            fetch(`/api/pterodactyl/{{ auth()->user()->api_key }}/${action}/GET`)
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
            var memory_usage = document.getElementById(`memory_usage_${identifier}`);
            var cpu_usage = document.getElementById(`cpu_usage_${identifier}`);
            var disk_usage = document.getElementById(`disk_usage_${identifier}`);

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

                memory_usage.innerHTML = (Math.round((data.attributes.resources.memory_bytes / 1024 / 1024) * 100) / 100).toFixed(2);
                cpu_usage.innerHTML = (Math.round(data.attributes.resources.cpu_absolute * 100) / 100).toFixed(2);
                disk_usage.innerHTML = (Math.round((data.attributes.resources.disk_bytes / 1024 / 1024) * 100) / 100).toFixed(2);
            });
        }

        @foreach ($server_model->where(['client_id' => auth()->user()->id, 'status' => 0])->get() as $server)
            updateStatus({{ $server->identifier }});
        @endforeach
    </script>
@endsection
