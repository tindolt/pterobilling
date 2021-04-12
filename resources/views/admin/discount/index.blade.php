@extends('layouts.admin')

@inject('discount_expiry', 'App\View\Classes\DiscountExpiry')

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
                    <h3 class="card-title">Discounts</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.discount.create') }}" class="btn btn-success btn-sm float-right">Create Discount <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="discounts-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:30%">Name</th>
                                <th style="width:10%">Percent Off</th>
                                <th style="width:15%">Is Global?</th>
                                <th style="width:15%">Expired?</th>
                                <th style="width:25%">Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discounts as $discount)
                                <tr>
                                    <td><a href="{{ route('admin.discount.show', ['id' => $discount->id]) }}">{{ $discount->id }}</a></td>
                                    <td>{{ $discount->name }}</td>
                                    <td>{{ $discount->percent_off }}%</td>
                                    <td>
                                        @if ($discount->is_global)
                                            <i class="fas fa-check"></i> Yes
                                        @else
                                            <i class="fas fa-times"></i> No
                                        @endif
                                    </td>
                                    <td>
                                        @if (is_null($discount->end_date))
                                            <i class="fas fa-times"></i> No
                                        @elseif ($discount_expiry->checkDiscount($discount->id))
                                            <i class="fas fa-times"></i> No
                                        @else
                                            <i class="fas fa-check"></i> Yes
                                        @endif
                                    </td>
                                    <td>{{ $discount->end_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:30%">Name</th>
                                <th style="width:10%">Percent Off</th>
                                <th style="width:15%">Is Global?</th>
                                <th style="width:15%">Expired?</th>
                                <th style="width:25%">Expiry Date</th>
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
            $("#discounts-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
