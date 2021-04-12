@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-8">
                        <label for="countryInput">Country Name</label>
                        <input type="text" name="country" value="@if ($tax->country === '0') Global @else{{ $tax->country }}@endif" form="saveForm" class="form-control" id="countryInput" placeholder="Country Name" required @if ($tax->country === '0') disabled @else {{ $tax->country }} @endif>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="percentInput">Tax Percentage</label>
                        <input type="number" name="percent" step="0.01" value="{{ $tax->percent }}" form="saveForm" class="form-control" id="percentInput" placeholder="Tax Percentage" required>
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.tax.delete', ['id' => $tax->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
    </div>
@endsection
