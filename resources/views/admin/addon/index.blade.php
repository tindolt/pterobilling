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
                    <h3 class="card-title">Add-ons</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.addon.create') }}" class="btn btn-success btn-sm float-right">Create Add-on <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="addons-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">Order</th>
                                <th style="width:5%">ID</th>
                                <th style="width:40%">Name</th>
                                <th style="width:10%">Resource</th>
                                <th style="width:10%">Amount</th>
                                <th style="width:15%">Price</th>
                                <th style="width:15%">Set-up Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addons as $addon)
                                <tr>
                                    <td>{{ $addon->order }}</td>
                                    <td><a href="{{ route('admin.addon.show', ['id' => $addon->id]) }}">{{ $addon->id }}</a></td>
                                    <td>{{ $addon->name }}</td>
                                    <td>
                                        @switch($addon->resource)
                                            @case('ram')
                                                RAM
                                                @break
                                            @case('cpu')
                                                CPU
                                                @break
                                            @case('disk')
                                                Disk
                                                @break
                                            @case('database')
                                                Database
                                                @break
                                            @case('backup')
                                                Backup
                                                @break
                                            @case('extra_port')
                                                Extra Port
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $addon->amount }}</td>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($addon->price * session('currency')->rate , 2) }} {{ session('currency')->name }}</td>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($addon->setup_fee * session('currency')->rate , 2) }} {{ session('currency')->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">Order</th>
                                <th style="width:5%">ID</th>
                                <th style="width:30%">Name</th>
                                <th style="width:15%">Resource</th>
                                <th style="width:15%">Amount</th>
                                <th style="width:15%">Price</th>
                                <th style="width:15%">Set-up Fee</th>
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
            $("#addons-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
