@extends('layouts.admin')

@inject('client_model', 'App\Models\Client')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{!! session('currency')->symbol !!}{{ number_format($total_income[0] * session('currency')->rate, 2) }} {{ session('currency')->name }}</h3>
                    <p>Income (Last 7 Days)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{!! session('currency')->symbol !!}{{ number_format($total_income[1] * session('currency')->rate, 2) }} {{ session('currency')->name }}</h3>
                    <p>Income (Last 30 Days)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{!! session('currency')->symbol !!}{{ number_format($total_income[2] * session('currency')->rate, 2) }} {{ session('currency')->name }}</h3>
                    <p>Income (Last 90 Days)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{!! session('currency')->symbol !!}{{ number_format($total_income[3] * session('currency')->rate, 2) }} {{ session('currency')->name }}</h3>
                    <p>Income (This Year)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Income in the last 90 days</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="income-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:25%">Client</th>
                            <th style="width:35%">Item</th>
                            <th style="width:15%">Price</th>
                            <th style="width:20%">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incomes[2] as $income)
                            <tr>
                                <td>{{ $income->id }}</a></td>
                                <td>{{ $client_model->find($income->client_id)->email }}</td>
                                <td>{{ $income->item }}</td>
                                <td>{!! session('currency')->symbol !!}{{ number_format($income->price * session('currency')->rate, 2) }} {{ session('currency')->name }}</td>
                                <td>{{ $income->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:25%">Client</th>
                            <th style="width:35%">Item</th>
                            <th style="width:10%">Price</th>
                            <th style="width:25%">Date</th>
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
            $("#income-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
