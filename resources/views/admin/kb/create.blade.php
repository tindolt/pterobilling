@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="form-group col-lg-6">
                            <label for="nameInput">Category Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="nameInput" placeholder="Category Name" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="orderInput">Order (The smaller, the higher display priority)</label>
                            <input type="number" name="order" value="{{ old('order') }}" class="form-control" id="orderInput" placeholder="Order" required>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-center">
                        <a href="{{ route('admin.kb.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-1 col-md-3 offset-lg-1 offset-md-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
