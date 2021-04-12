@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-6">
                        <label for="nameInput">Discount Name</label>
                        <input type="text" name="name" form="saveForm" value="{{ $discount->name }}" class="form-control" id="nameInput" placeholder="Discount Name" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="percentOffInput">Percent Off</label>
                        <input type="number" name="percent_off" form="saveForm" value="{{ $discount->percent_off }}" min="1" max="100" step="1" class="form-control" id="percentOffInput" placeholder="Percent Off" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_global" form="saveForm" value="yes" class="custom-control-input" @if ($discount->is_global) checked @endif id="isGlobalInput">
                            <label class="custom-control-label" for="isGlobalInput">Is Global? (apply to the whole store?)</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="endDateInput">End Date (optional)</label>
                        <input type="date" name="end_date" form="saveForm" value="{{ str_replace(' 00:00:00', '', $discount->end_date) }}" class="form-control" id="endDateInput">
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.discount.delete', ['id' => $discount->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
    </div>
@endsection
