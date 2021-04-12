@extends('layouts.admin')

@inject('client_model', 'App\Models\Client')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="affiliates-table" class="table table-hover text-nowrap">
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
                                    <td><a href="{{ route('admin.client.show', ['id' => $ticket->client_id]) }}" target="_blank">{{ $client_model->find($affiliate->client_id)->email }}</a></td>
                                    <td><a href="{{ route('admin.client.show', ['id' => $ticket->buyer_id]) }}" target="_blank">{{ $client_model->find($affiliate->buyer_id)->email }}</a></td>
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
                        <tfoot>
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
                        </tfoot>
                    </table>
                </div>
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
            $("#affiliates-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
