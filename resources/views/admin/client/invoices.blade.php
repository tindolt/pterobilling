@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav ml-auto p-2">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.show', ['id' => $id]) }}">Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.servers', ['id' => $id]) }}">Servers</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.client.invoices', ['id' => $id]) }}">Invoices</a></li>
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
                    <h3 class="card-title">Unpaid Invoices</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:32%">Item</th>
                                <th style="width:13%">Amount</th>
                                <th style="width:25%">Invoice Date</th>
                                <th style="width:25%">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                @unless ($invoice->paid)
                                    <tr>
                                        <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                        <td>{{ json_decode($invoice->products, true)[0] }}</td>
                                        <td>{!! session('currency')->symbol !!}{{ number_format($invoice->total_due * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                        <td>{{ $invoice->created_at }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                    </tr>
                                @endunless
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Paid Invoices</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:32%">Item</th>
                                <th style="width:13%">Amount</th>
                                <th style="width:25%">Invoice Date</th>
                                <th style="width:25%">Paid Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                @if ($invoice->paid)
                                    <tr>
                                        <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                        <td>{{ json_decode($invoice->products, true)[0] }}</td>
                                        <td>{!! session('currency')->symbol !!}{{ number_format($invoice->total_due * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                        <td>{{ $invoice->created_at }}</td>
                                        <td>{{ $invoice->updated_at }}</td>
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
