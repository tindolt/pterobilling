@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-4">
                        <label for="nameInput">Currency Name (3 Letters)</label>
                        <input type="text" name="name" form="saveForm" value="{{ $currency->name }}" class="form-control" id="nameInput" placeholder="(e.g. USD)" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="symbolInput">Symbol (HTML Entity Code)</label>
                        <input type="text" name="symbol" form="saveForm" value="{{ $currency->symbol }}" class="form-control" id="symbolInput" placeholder="(e.g. &#38;#36;)" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="rateInput">Conversion Rate</label>
                        <input type="number" name="rate" form="saveForm" step="0.000000001" value="{{ $currency->rate }}" class="form-control" id="rateInput" placeholder="Conversion Rate" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="alert alert-info">
                            If 1 'default currency' = 1.01 'this currency', enter 1.01 as the conversion rate.
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="alert alert-danger">
                            <b>WARNING!</b> You should NEVER change the default currency when your store has existing plans, add-ons, or invoices. This issue will be fixed in a newer version.
                        </div>
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <button type="submit" form="defaultForm" class="btn btn-info btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Set Default</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.currency.delete', ['id' => $currency->id]) }}" method="POST" id="deleteForm">@csrf</form>
                    <form action="{{ route('admin.currency.default', ['id' => $currency->id]) }}" method="POST" id="defaultForm">@csrf</form>
                </div>
            </div>
        </div>
    </div>
@endsection
