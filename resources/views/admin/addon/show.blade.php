@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-4">
                        <label for="nameInput">Add-on Name</label>
                        <input type="text" name="name" form="saveForm" value="{{ $addon->name }}" class="form-control" id="nameInput" placeholder="Add-on Name" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="orderInput">Order (The smaller, the higher display priority)</label>
                        <input type="number" name="order" form="saveForm" value="{{ $addon->order }}" class="form-control" id="orderInput" placeholder="Order" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Categories</label>
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category_{{ $category->id }}" value="true" form="saveForm" @if (in_array($category->id, json_decode($addon->categories, true))) checked @endif>
                                <p class="form-check-label">{{ $category->name }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Resource</label>
                        <select class="form-control" name="resource" form="saveForm">
                            <option value="ram" @if ($addon->resource === 'ram') selected @endif>RAM</option>
                            <option value="cpu" @if ($addon->resource === 'cpu') selected @endif>CPU</option>
                            <option value="disk" @if ($addon->resource === 'disk') selected @endif>Disk</option>
                            <option value="database" @if ($addon->resource === 'database') selected @endif>Database</option>
                            <option value="backup" @if ($addon->resource === 'backup') selected @endif>Backup</option>
                            <option value="extra_port" @if ($addon->resource === 'extra_port') selected @endif>Extra Port</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="amountInput">Amount of additional resource</label>
                        <input type="number" name="amount" form="saveForm" value="{{ $addon->amount }}" min="0" step="1" class="form-control" id="amountInput" placeholder="Amount" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="priceInput">Price (default currency)</label>
                        <input type="number" name="price" form="saveForm" value="{{ $addon->price }}" min="0" step="0.01" class="form-control" id="priceInput" placeholder="Price" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="setupFeeInput">Set-up Fee (default currency)</label>
                        <input type="number" name="setup_fee" form="saveForm" value="{{ $addon->setup_fee }}" min="0" step="0.01" class="form-control" id="setupFeeInput" placeholder="Set-up Fee" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="globalLimitInput">Global Limit (max. servers using this add-on)</label>
                        <input type="number" name="global_limit" form="saveForm" value="{{ $addon->global_limit }}" min="0" step="1" class="form-control" id="globalLimitInput" placeholder="Global Limit" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="perClientLimit">Per Client Limit (max. servers per client using this add-on)</label>
                        <input type="number" name="per_client_limit" form="saveForm" value="{{ $addon->per_client_limit }}" min="0" step="1" class="form-control" id="perClientLimit" placeholder="Per Client Limit" required>
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.addon.delete', ['id' => $addon->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
    </div>
@endsection
