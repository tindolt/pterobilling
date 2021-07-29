@extends('layouts.admin')

@inject('client_model', 'App\Models\Client')
@inject('tax_model', 'App\Models\Tax')

@section('content')
    <div class="row" id="invoice_content">
        <div class="col-12">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <img src="{{ config('app.logo_file_path') }}" height="50px" alt="{{ config('app.company_name') }} Logo"> {{ config('app.company_name') }}
                            <span class="float-right">
                                Status:
                                @if ($invoice->paid)
                                    Paid
                                @else
                                    Unpaid
                                @endif
                            </span>
                        </h4>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>{{ config('app.company_name') }}</strong>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong><a href="{{ route('admin.client.show', ['id' => $invoice->client_id]) }}" target="_blank">{{ $client_model->find($invoice->client_id)->email }}</a></strong>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{ $invoice->id }}</b><br>
                        <b>Invoice Date:</b> {{ $invoice->created_at }}<br>
                        <b>Due Date:</b> {{ number_format($invoice->due_date * session('currency')->rate, 2) }}<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($invoice->products as $product)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $product }}</td>
                                        <td>{!! session('currency')->symbol !!}{{ number_format($invoice->prices[$i] * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5">
                        <p class="lead">Payment Methods</p>
    
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Primary</th>
                                    <td>{{ $invoice->payment_method }}</td>
                                </tr>
                                <tr>
                                    <th>Backup</th>
                                    <td>Account Credit</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-5 offset-1">
                        <p class="lead">Amount Due</p>
    
                        <div class="table-responsive">
                            <table class="table">
                                @php
                                    $subtotal = 0.00;
                                    foreach ($invoice->prices as $price) {
                                        $subtotal += $price;
                                    }
                                @endphp
                                <tr>
                                    <th>Subtotal</th>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($subtotal * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tax ({{ $tax_model->find($invoice->tax_id)->percent }}%)</th>
                                    <td>+{!! session('currency')->symbol !!}{{ number_format($subtotal * session('currency')->rate * $tax_model->find($invoice->tax_id)->percent, 2) }} {{ session('currency')->name }}</td>
                                </tr>
                                <tr>
                                    <th>Total Due</th>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($subtotal * ($tax_model->find($invoice->tax_id)->percent / 100) * session('currency')->rate) }} {{ session('currency')->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
