@extends('layouts.client')

@inject('credit_model', 'App\Models\Credit')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{!! session('currency_symbol') !!}{{ auth()->user()->credit }} {{ session('currency') }}</h3>
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
                    <h3 class="card-title">Add Fund</h3>
                </div>
                <form action="" method="POST">
                    @csrf

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    Please fix the following error(s):
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="creditInput">Credit Amount</label>
                            <input type="number" name="credit" step="0.1" class="form-control" id="creditInput" placeholder="Credit Amount" required>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Payment Method</label>
                            <select name="gateway" class="form-control">
                                <option value="PayPal">PayPal</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Purchase Credit</button>
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
                            @foreach ($credit_model->where('client_id', auth()->user()->id) as $credit)
                                <tr>
                                    <td>{{ $credit->id }}</td>
                                    <td>{{ $credit->details }}</td>
                                    <td>
                                        @if ($credit->change < 0)
                                            -{!! session('currency_symbol') !!}{{ abs($credit->change) }} {{ session('currency') }}
                                        @else
                                            +{!! session('currency_symbol') !!}{{ $credit->change }} {{ session('currency') }}
                                        @endif
                                    </td>
                                    <td>{!! session('currency_symbol') !!}{{ $credit->balance }} {{ session('currency') }}</td>
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