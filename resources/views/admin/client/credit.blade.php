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
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.tickets', ['id' => $id]) }}">Support Tickets</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.affiliates', ['id' => $id]) }}">Affiliates</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.client.credit', ['id' => $id]) }}">Credit</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{!! session('currency')->symbol !!}{{ number_format($client->credit * session('currency')->rate, 2) }} {{ session('currency')->name }}</h3>
                    <p>Account Credit</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Credit Balance</h3>
                </div>
                <form action="" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="creditInput">Credit Amount</label>
                            <input type="number" name="credit" class="form-control" id="creditInput" placeholder="Credit Amount" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Edit Balance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Credit Transactions</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:30%">Details</th>
                                <th style="width:15%">Change</th>
                                <th style="width:15%">Balance</th>
                                <th style="width:30%">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credits as $credit)
                                <tr>
                                    <td>{{ $credit->id }}</td>
                                    <td>{{ $credit->details }}</td>
                                    <td>
                                        @if ($credit->change < 0)
                                            -{!! session('currency')->symbol !!}{{ number_format(abs($credit->change) * session('currency')->rate, 2) }} 
                                        @else
                                            +{!! session('currency')->symbol !!}{{ number_format($credit->change * session('currency')->rate, 2) }} 
                                        @endif
                                        {{ session('currency')->name }}
                                    </td>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($credit->balance * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                    <td>{{ $credit->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection