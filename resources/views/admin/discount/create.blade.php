@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="form-group col-lg-6">
                            <label for="nameInput">Discount Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="nameInput" placeholder="Discount Name" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="percentOffInput">Percent Off</label>
                            <input type="number" name="percent_off" value="{{ old('percent_off') }}" min="1" max="100" step="1" class="form-control" id="percentOffInput" placeholder="Percent Off" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_global" value="yes" class="custom-control-input" @if (old('is_global')) checked @endif id="isGlobalInput">
                                <label class="custom-control-label" for="isGlobalInput">Is Global? (apply to the whole store?)</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="endDateInput">End Date (optional)</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control" id="endDateInput">
                        </div>
                    </div>
                    <div class="card-footer row justify-content-center">
                        <a href="{{ route('admin.discount.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-1 col-md-3 offset-lg-1 offset-md-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
