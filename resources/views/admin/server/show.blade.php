@extends('layouts.admin')

@inject('plan_model', 'App\Models\Plan')
@inject('addon_model', 'App\Models\Addon')

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
                        <b>Panel ID</b><br>
                        <b>Server Identifier</b><br>
                        <b>Plan Name</b><br>
                        <b>Subdomain Name</b>
                    </p>
                    <p class="card-text col-7">
                        <a href="{{ config('app.panel_url') }}/admin/servers/view/{{ $server->server_id }}" target="_blank">{{ $server->server_id }}</a><br>
                        <a href="{{ config('app.panel_url') }}/server/{{ $server->identifier }}" target="_blank">{{ $server->identifier }}</a><br>
                        <a href="{{ route('admin.plan.show', ['id' => $plan->id]) }}" target="_blank">{{ $plan->name }}</a><br>
                        @if ($server->subdomain_name)
                            {{ $server->subdomain_name }}.{{ $server->subdomain }}
                        @else
                            None
                        @endif
                    </p>
                    <form action="{{ route('admin.server.suspend', ['id' => $server->id]) }}" method="POST">
                        @if ($server->status === 2)
                            <button type="submit" class="btn btn-warning btn-sm col-12">Unsuspend Server <i class="fas fa-arrow-circle-right"></i></button>
                        @else
                            <button type="submit" class="btn btn-danger btn-sm col-12">Suspend Server <i class="fas fa-arrow-circle-right"></i></button>
                        @endif
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Plan Information</h5>
                </div>
                <div class="card-body text-nowrap row">
                    <p class="card-text col-6">
                        <b>RAM</b><br>
                        <b>CPU</b><br>
                        <b>Disk</b><br>
                        <b>Databases</b><br>
                        <b>Backups</b><br>
                        <b>Extra Ports</b>
                    </p>
                    <p class="card-text col-6">
                        {{ $plan->ram }} MB<br>
                        {{ $plan->cpu }}%<br>
                        {{ $plan->disk }} MB<br>
                        {{ $plan->databases }}<br>
                        {{ $plan->backups }}<br>
                        {{ $plan->allocations - 1 }}
                    </p>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add-ons added to this server</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:55%">Name</th>
                                <th style="width:35%">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($server->addon, true) as $addon_id)
                                @php
                                    $addon = $addon_model->find($addon_id);
                                @endphp
                                <tr>
                                    <td><a href="{{ route('admin.addon.show', ['id' => $addon->id]) }}" target="_blank"></a>{{ $addon->id }}</td>
                                    <td>{{ $addon->name }}</td>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($addon->price * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
