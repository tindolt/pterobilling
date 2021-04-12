@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-6">
                        <label for="nameInput">Category Name</label>
                        <input type="text" name="name" form="saveForm" value="{{ $category->name }}" class="form-control" id="nameInput" placeholder="Category Name" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="orderInput">Order (The smaller, the higher display priority)</label>
                        <input type="number" name="order" form="saveForm" value="{{ $category->order }}" class="form-control" id="orderInput" placeholder="Order" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="globalLimitInput">Global Limit (max. servers using a plan in this category)</label>
                        <input type="number" name="global_limit" form="saveForm" value="{{ $category->global_limit }}" min="0" step="1" class="form-control" id="globalLimitInput" placeholder="Global Limit" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="perClientInput">Per Client Limit (max. servers per client using a plan in this category)</label>
                        <input type="number" name="per_client_limit" form="saveForm" value="{{ $category->per_client_limit }}" min="0" step="1" class="form-control" id="perClientInput" placeholder="Per Client Limit" required>
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.category.delete', ['id' => $category->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
    </div>
@endsection
