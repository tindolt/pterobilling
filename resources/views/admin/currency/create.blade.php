@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="form-group col-lg-4">
                            <label for="nameInput">Currency Name (3 Letters)</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="nameInput" placeholder="(e.g. USD)" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="symbolInput">Symbol (HTML Entity Code)</label>
                            <input type="text" name="symbol" value="{{ old('symbol') }}" class="form-control" id="symbolInput" placeholder="(e.g. &#38;#36;)" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="rateInput">Conversion Rate</label>
                            <input type="number" name="rate" step="0.000000001" value="{{ old('rate') }}" class="form-control" id="rateInput" placeholder="Conversion Rate" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="alert alert-info">
                                If 1 'default currency' = 1.01 'this currency', enter 1.01 as the conversion rate.
                            </div>
                        </div>
                    </div>
                    <div class="card-footer col-lg-12 row justify-content-center">
                        <a href="{{ route('admin.currency.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-1 col-md-3 offset-lg-1 offset-md-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
