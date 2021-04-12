@extends('layouts.admin')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Currencies</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.currency.create') }}" class="btn btn-success btn-sm float-right">Create Currency <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="currencies-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:25%">Name</th>
                                <th style="width:25%">Symbol</th>
                                <th style="width:50%">Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $currency)
                                <tr>
                                    <td><a href="{{ route('admin.currency.show', ['id' => $currency->id]) }}">{{ $currency->id }}</a></td>
                                    <td>{{ $currency->name }}</td>
                                    <td>{!! $currency->symbol !!}</td>
                                    <td>{{ $currency->rate }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:25%">Name</th>
                                <th style="width:25%">Symbol</th>
                                <th style="width:50%">Conversion Rate</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="callout callout-info">
                <h5>Default currency</h5>
                <hr>
                <h3>
                    @foreach ($currencies as $currency)
                        @if ($currency->default)
                            {{ $currency->name }} ( {!! $currency->symbol !!} )
                        @endif
                    @endforeach
                </h3>
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
            $("#currencies-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
