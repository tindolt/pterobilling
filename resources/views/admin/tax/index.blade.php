@extends('layouts.admin')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Taxes</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tax.create') }}" class="btn btn-success btn-sm float-right">Create Tax <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="taxes-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:65%">Country Name</th>
                                <th style="width:25%">Tax Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxes as $tax)
                                <tr>
                                    <td><a href="{{ route('admin.tax.show', ['id' => $tax->id]) }}">{{ $tax->id }}</a></td>
                                    <td>
                                        @if ($tax->country === '0')
                                            Global
                                        @else
                                            {{ $tax->country }}
                                        @endif
                                        </td>
                                    <td>{{ $tax->percent }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:10%">ID</th>
                                <th style="width:65%">Country Name</th>
                                <th style="width:25%">Tax (%)</th>
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
            $("#taxes-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
