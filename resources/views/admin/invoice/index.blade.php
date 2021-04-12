@extends('layouts.admin')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Unpaid Invoices</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="unpaid-invoice-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:20%">Client</th>
                            <th style="width:25%">Item</th>
                            <th style="width:10%">Amount</th>
                            <th style="width:20%">Invoice Date</th>
                            <th style="width:20%">Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            @unless ($invoice->paid)
                                <tr>
                                    <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                    <td><a href="{{ route('admin.client.show', ['id' => $invoice->client_id]) }}" target="_blank">{{ $client_model->find($invoice->client_id)->email }}</a></td>
                                    <td>{{ json_decode($invoice->products, true)[0] }}</td>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($subtotal * ($tax_model->find($invoice->tax_id)->percent / 100) * session('currency')->rate) }} {{ session('currency')->name }}</td>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                </tr>
                            @endunless
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:20%">Client</th>
                            <th style="width:25%">Item</th>
                            <th style="width:10%">Amount</th>
                            <th style="width:20%">Invoice Date</th>
                            <th style="width:20%">Due Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Paid Invoices</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="paid-invoice-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:20%">Client</th>
                            <th style="width:25%">Item</th>
                            <th style="width:10%">Amount</th>
                            <th style="width:20%">Invoice Date</th>
                            <th style="width:20%">Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            @if ($invoice->paid)
                                <tr>
                                    <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                    <td><a href="{{ route('admin.client.show', ['id' => $invoice->client_id]) }}" target="_blank">{{ $client_model->find($invoice->client_id)->email }}</a></td>
                                    <td>{{ json_decode($invoice->products, true)[0] }}</td>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($subtotal * ($tax_model->find($invoice->tax_id)->percent / 100) * session('currency')->rate) }} {{ session('currency')->name }}</td>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->updated_at }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:20%">Client</th>
                            <th style="width:25%">Item</th>
                            <th style="width:10%">Amount</th>
                            <th style="width:20%">Invoice Date</th>
                            <th style="width:20%">Paid Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            var css = document.createElement('link');
            css.href = '/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css';
            css.rel = 'stylesheet';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>

    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function () {
            $("#unpaid-invoice-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
            $("#paid-invoice-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
