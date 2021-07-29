@extends('layouts.client')

@inject('invoice_model', 'App\Models\Invoice')

@section('title', 'Invoices')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Unpaid Invoices</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item</th>
                                <th>Amount</th>
                                <th>Invoice Date</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice_model->where(['client_id' => auth()->user()->id, 'paid' => false]) as $invoice)
                                <tr>
                                    <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                    <td>
                                        @if ($invoice->server_id)
                                            Server #{{ $invoice->server_id }}
                                        @elseif ($invoice->credit_amount)
                                            {!! session('currency')->symbol !!}{{ number_format($invoice->credit_amount * session('currency')->rate) }} {{ session('currency')->name }} Credit
                                        @endif
                                    </td>
                                    @php
                                        $tax = $tax_model->find($invoice->tax_id);
                                    @endphp
                                    <td>
                                        {!! session('currency')->symbol !!}
                                        @if ($invoice->server_id)
                                            {{ number_format((($server_model->getTotalCost() + $invoice->late_fee) * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                        @elseif ($invoice->credit_amount)
                                            {{ number_format(($invoice->credit_amount * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                        @endif
                                        {{ session('currency')->name }}
                                    </td>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Paid Invoices</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item</th>
                                <th>Amount</th>
                                <th>Invoice Date</th>
                                <th>Paid Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice_model->where(['client_id' => auth()->user()->id, 'paid' => true]) as $invoice)
                                <tr>
                                    <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                    <td>
                                        @if ($invoice->server_id)
                                            Server #{{ $invoice->server_id }}
                                        @elseif ($invoice->credit_amount)
                                            {!! session('currency')->symbol !!}{{ number_format($invoice->credit_amount * session('currency')->rate) }} {{ session('currency')->name }} Credit
                                        @endif
                                    </td>
                                    @php
                                        $tax = $tax_model->find($invoice->tax_id);
                                    @endphp
                                    <td>
                                        {!! session('currency')->symbol !!}
                                        @if ($invoice->server_id)
                                            {{ number_format((($server_model->getTotalCost() + $invoice->late_fee) * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                        @elseif ($invoice->credit_amount)
                                            {{ number_format(($invoice->credit_amount * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                        @endif
                                        {{ session('currency')->name }}
                                    </td>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
