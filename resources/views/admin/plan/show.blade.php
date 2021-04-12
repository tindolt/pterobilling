@extends('layouts.admin')

@inject('category_model', 'App\Models\Category')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-6">
                        <label for="nameInput">Server Plan Name</label>
                        <input type="text" name="name" form="saveForm" value="{{ $plan->name }}" class="form-control" id="nameInput" placeholder="Server Plan Name" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="orderInput">Order (The smaller, the higher display priority)</label>
                        <input type="text" name="order" form="saveForm" value="{{ $plan->order }}" class="form-control" id="orderInput" placeholder="Order" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Category</label>
                        <select class="form-control" name="category" form="saveForm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id === $plan->category_id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Panel Egg</label>
                        <select class="form-control" name="egg" form="saveForm">
                            @foreach ($eggs as $egg)
                                <option value="{{ $egg['id'] }}" @if ($egg['id'] === $plan->egg_id) selected @endif>{{ $egg['id'] }} - {{ $egg['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
                        <hr>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="ramInput">RAM (MB)</label>
                        <input type="number" name="ram" form="saveForm" value="{{ $plan->ram }}" min="0" step="1" class="form-control" id="ramInput" placeholder="1000" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="cpuInput">CPU (%)</label>
                        <input type="number" name="cpu" form="saveForm" value="{{ $plan->cpu }}" min="0" step="1" class="form-control" id="cpuInput" placeholder="100" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="diskInput">Disk (MB)</label>
                        <input type="number" name="disk" form="saveForm" value="{{ $plan->disk }}" min="0" step="1" class="form-control" id="diskInput" placeholder="disk" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="swapInput">Swap (MB)</label>
                        <input type="number" name="swap" form="saveForm" value="{{ $plan->swap }}" min="-1" step="1" class="form-control" id="swapInput" placeholder="0" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="ioInput">Block IO</label>
                        <input type="number" name="io" form="saveForm" value="{{ $plan->io }}" min="10" max="1000" step="1" class="form-control" id="ioInput" placeholder="500" required>
                    </div>
                    <div class="form-group col-lg-12">
                        <hr>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="databasesInput">Databases</label>
                        <input type="number" name="databases" form="saveForm" value="{{ $plan->databases }}" min="0" step="1" class="form-control" id="databasesInput" placeholder="0" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="backupsInput">Backups</label>
                        <input type="number" name="backups" form="saveForm" value="{{ $plan->backups }}" min="0" step="1" class="form-control" id="backupsInput" placeholder="0" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="extraPortsInput">Extra Ports</label>
                        <input type="number" name="extra_ports" form="saveForm" value="{{ $plan->allocations - 1 }}" min="0" step="1" class="form-control" id="extraPortsInput" placeholder="0" required>
                    </div>
                    <div class="form-group col-lg-12">
                        <hr>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="priceInput">Monthly Price (default currency)</label>
                        <input type="number" name="price" form="saveForm" value="{{ $plan->price }}" min="0" step="0.01" class="form-control" id="priceInput" placeholder="Monthly Price" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Billing Cycles</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="monthly" value="true" form="saveForm" @if (in_array('monthly', json_decode($plan->cycles, true))) checked @endif>
                            <p class="form-check-label">Monthly</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="trimonthly" value="true" form="saveForm" @if (in_array('trimonthly', json_decode($plan->cycles, true))) checked @endif>
                            <p class="form-check-label">Trimonthly</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="biannually" value="true" form="saveForm" @if (in_array('biannually', json_decode($plan->cycles, true))) checked @endif>
                            <p class="form-check-label">Biannually</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="annually" value="true" form="saveForm" @if (in_array('annually', json_decode($plan->cycles, true))) checked @endif>
                            <p class="form-check-label">Annually</p>
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="setupFeeInput">Set-up Fee (default currency)</label>
                        <input type="number" name="setup_fee" form="saveForm" value="{{ $plan->setup_fee }}" min="0" step="0.01" class="form-control" id="setupFeeInput" placeholder="Set-up Fee" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="trialInput">Free Trial (days)</label>
                        <input type="number" name="trial" form="saveForm" value="{{ $plan->trial }}" min="0" step="1" class="form-control" id="trialInput" placeholder="Free Trial" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Discount</label>
                        <select class="form-control" name="discount" form="saveForm">
                            <option value="0" @if (is_null($plan->discount)) selected @endif>None</option>
                            @foreach ($discounts as $discount)
                                <option value="{{ $discount->id }}" @if ($discount->id === $plan->discount) selected @endif>{{ $discount->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Coupons</label>
                        @foreach ($coupons as $coupon)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="coupon_{{ $coupon->code }}" value="true" form="saveForm" @if (in_array($coupon->id, json_decode($plan->coupons, true))) checked @endif>
                                <p class="form-check-label">{{ $coupon->code }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group col-lg-12">
                        <hr>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="globalLimitInput">Global Limit (max. servers using this plan)</label>
                        <input type="number" name="global_limit" form="saveForm" value="{{ $plan->global_limit }}" class="form-control" id="globalLimitInput" placeholder="Global Limit" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="perClientInput">Per Client Limit (max. servers per client using this plan)</label>
                        <input type="number" name="per_client_limit" form="saveForm" value="{{ $plan->per_client_limit }}" class="form-control" id="perClientInput" placeholder="Per Client Limit" required>
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.plan.delete', ['id' => $plan->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
    </div>
@endsection
