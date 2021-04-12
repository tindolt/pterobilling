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
                    <h3 class="card-title">Categories</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.category.create') }}" class="btn btn-success btn-sm float-right">Create Category <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="categories-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">Order</th>
                                <th style="width:5%">ID</th>
                                <th style="width:60%">Name</th>
                                <th style="width:15%">Global Limit</th>
                                <th style="width:15%">Per Client Limit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->order }}</td>
                                    <td><a href="{{ route('admin.category.show', ['id' => $category->id]) }}">{{ $category->id }}</a></td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->global_limit }}</td>
                                    <td>{{ $category->per_client_limit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">Order</th>
                                <th style="width:5%">ID</th>
                                <th style="width:60%">Name</th>
                                <th style="width:15%">Global Limit</th>
                                <th style="width:15%">Per Client Limit</th>
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
            $("#categories-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
