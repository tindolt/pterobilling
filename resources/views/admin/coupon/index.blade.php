@extends('layouts.admin')

@inject('coupon_expiry', 'App\View\Classes\CouponExpiry')
@inject('used_coupon_model', 'App\Models\UsedCoupon')

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
                    <h3 class="card-title">Coupons</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.coupon.create') }}" class="btn btn-success btn-sm float-right">Create Coupon <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="coupons-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:30%">Code</th>
                                <th style="width:10%">Percent Off</th>
                                <th style="width:10%">Is Global?</th>
                                <th style="width:10%">Expired?</th>
                                <th style="width:10%">Total Uses</th>
                                <th style="width:25%">Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td><a href="{{ route('admin.coupon.show', ['id' => $coupon->id]) }}">{{ $coupon->id }}</a></td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->percent_off }}%</td>
                                    <td>
                                        @if ($coupon->is_global)
                                            <i class="fas fa-check"></i> Yes
                                        @else
                                            <i class="fas fa-times"></i> No
                                        @endif
                                    </td>
                                    <td>
                                        @if (is_null($coupon->end_date))
                                            <i class="fas fa-times"></i> No
                                        @elseif ($coupon_expiry->checkCoupon($coupon->id))
                                            <i class="fas fa-times"></i> No
                                        @else
                                            <i class="fas fa-check"></i> Yes
                                        @endif
                                    </td>
                                    <td>{{ $used_coupon_model->where('coupon_id', $coupon->id)->count() }}</td>
                                    <td>{{ $coupon->end_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:30%">Code</th>
                                <th style="width:10%">Percent Off</th>
                                <th style="width:10%">Is Global?</th>
                                <th style="width:10%">Expired?</th>
                                <th style="width:10%">Total Uses</th>
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
            $("#coupons-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
