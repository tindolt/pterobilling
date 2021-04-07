@extends('layouts.admin')

@inject('client_model', 'App\Models\Client')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav ml-auto p-2">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.show', ['id' => $id]) }}">Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.servers', ['id' => $id]) }}">Servers</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.invoices', ['id' => $id]) }}">Invoices</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.tickets', ['id' => $id]) }}">Support Tickets</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.client.affiliates', ['id' => $id]) }}">Affiliates</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.credit', ['id' => $id]) }}">Credit</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $client->clicks }}</h3>
                    <p>Clicks</p>
                </div>
                <div class="icon">
                    <i class="far fa-hand-point-up"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $client->sign_ups }}</h3>
                    <p>Sign-ups</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $client->purchases }}</h3>
                    <p>Purchases</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{!! session('currency')->symbol !!}{{ number_format($client->commissions * session('currency')->rate, 2) }} {{ session('currency')->name }}</h3>
                    <p>Commissions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="card col-12">
            <div class="card-body row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <h5 class="card-title">Client's Referral Link:</h5>
                    <a href="{{ config('app.url') }}/a/{{ $client->id }}" class="float-right" target="_blank">{{ config('app.url') }}/a/{{ $client->id }}</a>
                </div>
            </div>
        </div>
        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Affiliate Earnings</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:15%">Referer</th>
                            <th style="width:15%">Buyer</th>
                            <th style="width:15%">Product</th>
                            <th style="width:10%">Commission</th>
                            <th style="width:10%">Conversion</th>
                            <th style="width:10%">Status</th>
                            <th style="width:17%">Date</th>
                            <th style="width:3%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($affiliates as $affiliate)
                            <tr>
                                <td>{{ $affiliate->id }}</a></td>
                                <td>{{ $client_model->find($affiliate->client_id)->email }}</td>
                                <td>{{ $client_model->find($affiliate->buyer_id)->email }}</td>
                                <td>{{ $affiliate->product }}</td>
                                <td>{!! session('currency')->symbol !!}{{ number_format($affiliate->commission * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                <td>{{ $affiliate->conversion }}%</td>
                                <td>
                                    @switch($affiliate->status)
                                        @case(0)
                                            <span class="badge bg-success">Accepted</span>
                                            @break
                                        @case(1)
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-danger">Rejected</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $affiliate->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('admin.affiliate.accept', ['id' => $affiliate->id]) }}">Accept</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.affiliate.reject', ['id' => $affiliate->id]) }}">Reject</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection