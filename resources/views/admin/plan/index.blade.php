@extends('layouts.admin')

@inject('category_model', 'App\Models\Category')

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
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.plan.create') }}" class="btn btn-success btn-sm float-right">Create Server Plan <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="plans-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">Order</th>
                                <th style="width:5%">ID</th>
                                <th style="width:25%">Plan Name</th>
                                <th style="width:25%">Category</th>
                                <th style="width:8%">RAM</th>
                                <th style="width:8%">CPU</th>
                                <th style="width:8%">Disk</th>
                                <th style="width:16%">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $plan)
                                <tr>
                                    <td>{{ $plan->order }}</td>
                                    <td><a href="{{ route('admin.plan.show', ['id' => $plan->id]) }}">{{ $plan->id }}</a></td>
                                    <td>{{ $plan->name }}</td>
                                    <td>{{ $category_model->find($plan->category_id)->name }}</td>
                                    <td>{{ $plan->ram }} MB</td>
                                    <td>{{ $plan->cpu }}%</td>
                                    <td>{{ $plan->disk }} MB</td>
                                    <td>{!! session('currency')->symbol !!}{{ number_format($plan->price * session('currency')->rate , 2) }} {{ session('currency')->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">Order</th>
                                <th style="width:5%">ID</th>
                                <th style="width:25%">Plan Name</th>
                                <th style="width:25%">Category</th>
                                <th style="width:8%">RAM</th>
                                <th style="width:8%">CPU</th>
                                <th style="width:8%">Disk</th>
                                <th style="width:16%">Price</th>
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
            $("#plans-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
