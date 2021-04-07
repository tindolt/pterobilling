@extends('layouts.client')

@inject('plan_model', 'App\Models\Plan')

@php
    $plan = $plan_model->find($server->plan_id)->first();
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Server Information</h5>
                </div>
                <div class="card-body text-nowrap row">
                    <p class="card-text col-5">
                        <b>Plan Name</b><br>
                        <b>Server Name</b><br>
                        <b>Subdomain Name</b><br>
                        <b>Server IP</b><br>
                        <b>Server Status</b>
                    </p>
                    <p class="card-text col-7">
                        {{ $plan->name }}<br>
                        @if(session('server_' . $server->id))
                            {{ session('server_' . $server->id) }}
                        @else
                            Server #{{ $server->id }}
                        @endif
                        <br>
                        @if ($server->subdomain_name)
                            {{ $server->subdomain_name }}.{{ $server->subdomain }}
                        @else
                            None
                        @endif
                        <br>
                        <span id="allocation">Loading</span><br>
                        <span id="server_status"><span class="badge bg-warning">Loading</span></span>
                    </p>
                    <a href="{{ route('client.server.plan.show', ['id'=>1]) }}" class="btn btn-primary btn-sm col-12">Upgrade Server <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Billing Overview</h5>
                </div>
                <div class="card-body text-nowrap row">
                    <p class="card-text col-7">
                        <b>Recurring Amount</b><br>
                        <b>Billing Cycle</b><br>
                        <b>Server Creation Date</b><br>
                        <b>Next Due Date</b><br>
                        <b>Payment Method</b><br>
                        <b>Backup Payment Method</b>
                    </p>
                    <p class="card-text col-5">
                        {!! session('currency')->symbol !!}{{ number_format($plan->price * session('currency')->rate, 2) }} {{ session('currency')->name }}<br>
                        {{ ucfirst($server->billing_cycle) }}<br>
                        {{ $server->created_at }}<br>
                        {{ $server->next_due }}<br>
                        {{ $server->payment_method }}<br>
                        Account Credit
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Usage Statistics</h5>
                </div>
                <div class="card-body text-nowrap row">
                    <p class="card-text col-5">
                        <b>RAM</b><br>
                        <b>CPU</b><br>
                        <b>Disk</b><br>
                        <b>Databases</b><br>
                        <b>Backups</b><br>
                        <b>Extra Ports</b>
                    </p>
                    <p class="card-text col-7">
                        <span id="memory_usage">Loading</span> / {{ $plan->ram }} MB<br>
                        <span id="cpu_usage">Loading</span> / {{ $plan->cpu }}%<br>
                        <span id="disk_usage">Loading</span> / {{ $plan->disk }} MB<br>
                        <span id="database_usage">Loading</span> / {{ $plan->databases }}<br>
                        <span id="backup_usage">Loading</span> / {{ $plan->backups }}<br>
                        <span id="extra_port_usage">Loading</span> / {{ $plan->allocations - 1 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Quick Shortcuts</h5>
                </div>
                <div class="card-body text-nowrap row">
                    <p class="card-text col-lg-4 col-6">
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}"><i class="fas fa-terminal"></i> Console</a><br>
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/files"><i class="fas fa-folder-open"></i> Files</a><br>
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/databases"><i class="fas fa-database"></i> Databases</a><br>
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/schedules"><i class="fas fa-table"></i> Schedules</a>
                    </p>
                    <p class="card-text col-lg-4 col-6">
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/users"><i class="fas fa-users"></i> Users</a><br>
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/backups"><i class="fas fa-file-archive"></i> Backups</a><br>
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/network"><i class="fas fa-network-wired"></i> Network</a><br>
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/startup"><i class="fas fa-play"></i> Startup</a>
                    </p>
                    <p class="card-text col-lg-4 col-6">
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->id }}/settings"><i class="fas fa-cogs"></i> Settings</a><br>
                        <a href="{{ route('client.server.subdomain.show', ['id' => 1]) }}"><i class="fas fa-globe"></i> Subdomain Name</a><br>
                        <a href="{{ route('client.server.software.show', ['id' => 1]) }}"><i class="fas fa-download"></i> Software Installer</a><br>
                        <a href="{{ config('app.phpmyadmin_url') }}"><i class="fas fa-tools"></i> phpMyAdmin</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var allocation = document.getElementById('allocation');
        var server_status = document.getElementById('server_status');
        var memory_usage = document.getElementById('memory_usage');
        var cpu_usage = document.getElementById('cpu_usage');
        var disk_usage = document.getElementById('disk_usage');
        var database_usage = document.getElementById('database_usage');
        var backup_usage = document.getElementById('backup_usage');
        var extra_port_usage = document.getElementById('extra_port_usage');

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

        callApi('serversSLASH{{ $server->identifier }}', function(data) {
            data.attributes.relationships.allocations.data.forEach(allocation_data => {
                if (allocation_data.attributes.is_default) {
                    allocation.innerHTML = `${allocation_data.attributes.ip}:${allocation_data.attributes.port}`;
                }
            });
        });

        callApi('serversSLASH{{ $server->identifier }}SLASHresources', function(data) {
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

        callApi('serversSLASH{{ $server->identifier }}SLASHdatabases', function(data) {
            database_usage.innerHTML = data.data.length;
        });

        callApi('serversSLASH{{ $server->identifier }}SLASHbackups', function(data) {
            backup_usage.innerHTML = data.data.length;
        });

        callApi('serversSLASH{{ $server->identifier }}SLASHnetworkSLASHallocations', function(data) {
            extra_port_usage.innerHTML = data.data.length - 1;
        });
        
    </script>
@endsection
