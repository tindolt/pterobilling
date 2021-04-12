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
                        <div class="form-group col-lg-6">
                            <label for="globalLimitInput">Global Limit (max. servers using a plan in this category)</label>
                            <input type="number" name="global_limit" value="{{ old('global_limit') }}" min="0" step="1" class="form-control" id="globalLimitInput" placeholder="Global Limit" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="perClientInput">Per Client Limit (max. servers per client using a plan in this category)</label>
                            <input type="number" name="per_client_limit" value="{{ old('per_client_limit') }}" min="0" step="1" class="form-control" id="perClientInput" placeholder="Per Client Limit" required>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-center">
                        <a href="{{ route('admin.category.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-1 col-md-3 offset-lg-1 offset-md-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
