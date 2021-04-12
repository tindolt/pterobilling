@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="form-group col-lg-4">
                            <label for="nameInput">Add-on Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="nameInput" placeholder="Add-on Name" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="orderInput">Order (The smaller, the higher display priority)</label>
                            <input type="number" name="order" value="{{ old('order') }}" class="form-control" id="orderInput" placeholder="Order" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Categories</label>
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category_{{ $category->id }}" value="true" @if (old("category_{{ $category->id }}")) checked @endif>
                                    <p class="form-check-label">{{ $category->name }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Resource</label>
                            <select class="form-control" name="resource">
                                <option value="ram" @if (old('resource') === 'ram') selected @endif>RAM</option>
                                <option value="cpu" @if (old('resource') === 'cpu') selected @endif>CPU</option>
                                <option value="disk" @if (old('resource') === 'disk') selected @endif>Disk</option>
                                <option value="database" @if (old('resource') === 'database') selected @endif>Database</option>
                                <option value="backup" @if (old('resource') === 'backup') selected @endif>Backup</option>
                                <option value="extra_port" @if (old('resource') === 'extra_port') selected @endif>Extra Port</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="amountInput">Amount of additional resource</label>
                            <input type="number" name="amount" value="{{ old('amount') }}" min="0" step="1" class="form-control" id="amountInput" placeholder="Amount" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="priceInput">Price (default currency)</label>
                            <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" class="form-control" id="priceInput" placeholder="Price" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="setupFeeInput">Set-up Fee (default currency)</label>
                            <input type="number" name="setup_fee" value="{{ old('setup_fee') }}" min="0" step="0.01" class="form-control" id="setupFeeInput" placeholder="Set-up Fee" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="globalLimitInput">Global Limit (max. servers using this add-on)</label>
                            <input type="number" name="global_limit" value="{{ old('global_limit') }}" min="0" step="1" class="form-control" id="globalLimitInput" placeholder="Global Limit" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="perClientLimit">Per Client Limit (max. servers per client using this add-on)</label>
                            <input type="number" name="per_client_limit" value="{{ old('per_client_limit') }}" min="0" step="1" class="form-control" id="perClientLimit" placeholder="Per Client Limit" required>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-center">
                        <a href="{{ route('admin.addon.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-1 col-md-3 offset-lg-1 offset-md-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
