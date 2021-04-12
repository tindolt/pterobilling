@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="form-group col-lg-8">
                            <label for="countryInput">Country Name</label>
                            <input type="text" name="country" value="{{ old('country') }}" class="form-control" id="countryInput" placeholder="Country Name" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="percentInput">Tax Percentage</label>
                            <input type="number" name="percent" step="0.01" value="{{ old('percent') }}" class="form-control" id="percentInput" placeholder="Tax Percentage" required>
                        </div>
                    </div>
                    <div class="card-footer col-lg-12 row justify-content-center">
                        <a href="{{ route('admin.tax.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-1 col-md-3 offset-lg-1 offset-md-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
