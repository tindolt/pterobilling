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
                <div class="card-body row">
                    <div class="form-group col-lg-6">
                        <label for="codeInput">Coupon Code</label>
                        <input type="text" name="code" form="saveForm" value="{{ $coupon->code }}" class="form-control" id="codeInput" placeholder="Coupon Code" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="percentOffInput">Percent Off</label>
                        <input type="number" name="percent_off" form="saveForm" value="{{ $coupon->percent_off }}" min="1" max="100" step="1" class="form-control" id="percentOffInput" placeholder="Percent Off" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="globalLimitInput">Global Limit (max. uses of this coupon)</label>
                        <input type="number" name="global_limit" form="saveForm" value="{{ $coupon->global_limit }}" min="0" step="1" class="form-control" id="globalLimitInput" placeholder="Global Limit" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="perClientLimitInput">Per Client Limit (max. uses per client of this coupon)</label>
                        <input type="number" name="per_client_limit" form="saveForm" value="{{ $coupon->per_client_limit }}" min="0" step="1" class="form-control" id="perClientLimitInput" placeholder="Per Client Limit" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_global" form="saveForm" value="yes" class="custom-control-input" @if ($coupon->is_global) checked @endif id="isGlobalInput">
                            <label class="custom-control-label" for="isGlobalInput">Is Global? (apply to the whole store?)</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="endDateInput">End Date (optional)</label>
                        <input type="date" name="end_date" form="saveForm" value="{{ str_replace(' 00:00:00', '', $coupon->end_date) }}" class="form-control" id="endDateInput">
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.coupon.delete', ['id' => $coupon->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Used Coupons</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="used-coupons-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">Server ID</th>
                                <th style="width:60%">Client</th>
                                <th style="width:30%">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($used_coupons as $used_coupon)
                                <tr>
                                    <td><a href="{{ route('admin.server.show', ['id' => $coupon->server_id]) }}" target="_blank">{{ $coupon->id }}</a></td>
                                    <td><a href="{{ route('admin.client.show', ['id' => $coupon->client_id]) }}" target="_blank">{{ $client_model->find($coupon->client_id)->email }}</a></td>
                                    <td>{{ $coupon->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:10%">Server ID</th>
                                <th style="width:60%">Client</th>
                                <th style="width:30%">Date</th>
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
            $("#used-coupons-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
