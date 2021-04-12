@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf
                    
                    <div class="card-body row">
                        <div class="form-group col-lg-6">
                            <label for="nameInput">Server Plan Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="nameInput" placeholder="Server Plan Name" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="orderInput">Order (The smaller, the higher display priority)</label>
                            <input type="text" name="order" value="{{ old('order') }}" class="form-control" id="orderInput" placeholder="Order" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Category</label>
                            <select class="form-control" name="category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id === old('category')) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Panel Egg</label>
                            <select class="form-control" name="egg">
                                @foreach ($eggs as $egg)
                                    <option value="{{ $egg['id'] }}" @if ($egg['id'] === old('egg')) selected @endif>{{ $egg['id'] }} - {{ $egg['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <hr>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="ramInput">RAM (MB)</label>
                            <input type="number" name="ram" value="{{ old('ram') }}" min="0" step="1" class="form-control" id="ramInput" placeholder="1000" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="cpuInput">CPU (%)</label>
                            <input type="number" name="cpu" value="{{ old('cpu') }}" min="0" step="1" class="form-control" id="cpuInput" placeholder="100" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="diskInput">Disk (MB)</label>
                            <input type="number" name="disk" value="{{ old('disk') }}" min="0" step="1" class="form-control" id="diskInput" placeholder="disk" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="swapInput">Swap (MB)</label>
                            <input type="number" name="swap" value="{{ old('swap') }}" min="-1" step="1" class="form-control" id="swapInput" placeholder="0" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="ioInput">Block IO</label>
                            <input type="number" name="io" value="{{ old('io') }}" min="10" max="1000" step="1" class="form-control" id="ioInput" placeholder="500" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <hr>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="databasesInput">Databases</label>
                            <input type="number" name="databases" value="{{ old('databases') }}" min="0" step="1" class="form-control" id="databasesInput" placeholder="0" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="backupsInput">Backups</label>
                            <input type="number" name="backups" value="{{ old('backups') }}" min="0" step="1" class="form-control" id="backupsInput" placeholder="0" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="extraPortsInput">Extra Ports</label>
                            <input type="number" name="extra_ports" value="{{ old('extra_ports') }}" min="0" step="1" class="form-control" id="extraPortsInput" placeholder="0" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <hr>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="priceInput">Monthly Price (default currency)</label>
                            <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" class="form-control" id="priceInput" placeholder="Monthly Price" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Billing Cycles</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="monthly" value="true" @if (old('monthly')) checked @endif>
                                <p class="form-check-label">Monthly</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="trimonthly" value="true" @if (old('trimonthly')) checked @endif>
                                <p class="form-check-label">Trimonthly</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="biannually" value="true" @if (old('biannually')) checked @endif>
                                <p class="form-check-label">Biannually</p>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="annually" value="true" @if (old('annually')) checked @endif>
                                <p class="form-check-label">Annually</p>
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="setupFeeInput">Set-up Fee (default currency)</label>
                            <input type="number" name="setup_fee" value="{{ old('setup_fee') }}" min="0" step="0.01" class="form-control" id="setupFeeInput" placeholder="Set-up Fee" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="trialInput">Free Trial (days)</label>
                            <input type="number" name="trial" value="{{ old('trial') }}" min="0" step="1" class="form-control" id="trialInput" placeholder="Free Trial" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Discount</label>
                            <select class="form-control" name="discount">
                                <option value="0" @if (old('discount') === 0) selected @endif>None</option>
                                @foreach ($discounts as $discount)
                                    <option value="{{ $discount->id }}" @if ($discount->id === old('discount')) selected @endif>{{ $discount->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Coupons</label>
                            @foreach ($coupons as $coupon)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="coupon_{{ $coupon->code }}" value="true" @if (old("coupon_$coupon->code")) checked @endif>
                                    <p class="form-check-label">{{ $coupon->code }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group col-lg-12">
                            <hr>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="globalLimitInput">Global Limit (max. servers using this plan)</label>
                            <input type="number" name="global_limit" value="{{ old('global_limit') }}" class="form-control" id="globalLimitInput" placeholder="Global Limit" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="perClientInput">Per Client Limit (max. servers per client using this plan)</label>
                            <input type="number" name="per_client_limit" value="{{ old('per_client_limit') }}" class="form-control" id="perClientInput" placeholder="Per Client Limit" required>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-center">
                        <a href="{{ route('admin.plan.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-1 col-md-3 offset-lg-1 offset-md-2">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
