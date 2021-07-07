@extends('layouts.store')

@inject('category_model', 'App\Models\Category')
@inject('addon_model', 'App\Models\Addon')

@php
    $plan->price = number_format($plan->price * session('currency')->rate * $percent_off, 2);
    $plan->setup_fee = number_format($plan->setup_fee * session('currency')->rate * $percent_off, 2);
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $plan->name }} - <i>{{ $category_model->find($plan->category_id)->value('name') }}</i></h5>
                    <p class="card-text">
                        <ul>
                            <li>{{ $plan->ram }} GB RAM</li>
                            <li>{{ $plan->cpu }}% CPU</li>
                            <li>{{ $plan->disk }} GB Disk</li>
                        </ul>
                    </p>
                    <a href="{{ route('plans') }}" class="card-link"><i class="fas fa-arrow-left text-sm"></i> Choose another plan</a>
                </div>
            </div>
            <form method="POST" action="" id="orderForm">
                @csrf

                <input type="hidden" name="order_details" value='{"addons": []}' id="order-details">
                <div class="form-group row">
                    <label for="serverNameInput" class="col-lg-3 col-form-label">Server Name</label>
                    <div class="col-lg-4">
                        <input type="text" name="server_name" value="{{ old('server_name') }}" class="form-control" id="serverNameInput" placeholder="Server Name" required>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="serverIpInput" class="col-lg-3 col-form-label">Server Location</label>
                    <div class="col-lg-5">
                        <select class="form-control" name="location">
                            @if ($locations)
                                @unless (array_key_exists('errors', $locations))
                                    @foreach ($locations['data'] as $location_data)
                                        <option value="{{ $location_data['attributes']['id'] }}">{{ $location_data['attributes']['short'] }}</option>
                                    @endforeach
                                @endunless
                            @endif
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Add-ons</label>
                    <div class="col-lg-7">
                        @foreach ($addon_model->all() as $addon)
                            @if (in_array($plan->category_id, json_decode($addon->categories, true)))
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="addon_{{ $addon->id }}" value="true" onchange="updateAddonSummary({{ $addon }});">
                                    <p class="form-check-label">{{ $addon->name }} <span class="float-right">{!! session('currency')->symbol !!}{{ number_format($addon->price * session('currency')->rate * $percent_off, 2) }} {{ json_decode($plan->cycles)[0] }} (${{ number_format($addon->setup_fee * session('currency')->rate * $percent_off, 2) }} setup fee)</span></p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Billing Cycle</label>
                    <div class="col-lg-3">
                        <select class="form-control" name="cycle" id="billing-cycle" onchange="updateValues();">
                            @foreach (json_decode($plan->cycles) as $cycle)
                                <option value="{{ $cycle }}">{{ ucfirst($cycle) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <hr>
            <form method="POST" action="{{ route('order.coupon', ['id' => $id]) }}">
                @csrf
                <div class="form-group row">
                    <label for="couponCodeInput" class="col-lg-3 col-form-label">Coupon Code</label>
                    <div class="col-lg-4">
                        <input type="text" name="coupon" value="{{ old('coupon') }}" class="form-control" id="couponCodeInput" placeholder="Coupon Code" required>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary btn-sm float-left">Apply</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <h6>Server <span class="float-right">{{ $plan->name }}</span></h6>
                    <small>
                        Monthly <span class="float-right">{!! session('currency')->symbol !!}{{ $plan->price }}</span><br>
                        Setup Fee <span class="float-right">{!! session('currency')->symbol !!}{{ $plan->setup_fee }}</span>
                    </small>
                    <hr>
                    <div id="addons-summary"></div>
                    <h6>Subtotal <span class="float-right">{!! session('currency')->symbol !!}<span id="subtotal"></span> {{ session('currency')->name }}</span></h6>
                    <small>
                        Billed <span id="subtotal-cycle"></span> <span class="float-right">{!! session('currency')->symbol !!}<span id="subtotal-cycle-price"></span> {{ session('currency')->name }}</span><br>
                        Tax (%) <span class="float-right"></span>
                    </small><br>
                    <small>
                        @if (session('coupon'))
                            Coupon: {{ session('coupon')->code }} <span class="float-right">- {!! session('currency')->symbol !!}<span id="coupon-discount"></span></span><br>
                        @endif
                        @if (auth()->user()->credit > 0)
                            Account Credit <span class="float-right">- {!! session('currency')->symbol !!}<span id="credit-discount"></span></span>
                        @endif
                    </small>
                    <hr>
                    <h6>Due Today <span class="float-right">{!! session('currency')->symbol !!}<span id="due-today"></span> {{ session('currency')->name }}</span></h6>
                    @if ($plan->trial > 0)
                        <small class="card-title">Billed after the {{ $plan->trial }}-day free trial</small><br>
                    @endif
                    <small>Next <span id="next-cycle"></span> <span class="float-right">{!! session('currency')->symbol !!}<span id="next-due"></span> {{ session('currency')->name }}</span></small><br>
                    <button type="submit" form="orderForm" class="btn btn-primary float-right">Continue <i class="fas fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var orderDetailsInput = document.getElementById("order-details");
        var billingCycle = document.getElementById("billing-cycle");
        var addonsDiv = document.getElementById("addons-summary");
        var subtotalSpan = document.getElementById("subtotal");
        var subtotalCycleSpan = document.getElementById("subtotal-cycle");
        var subtotalCyclePriceSpan = document.getElementById("subtotal-cycle-price");
        var couponDiscountSpan = document.getElementById("coupon-discount");
        var creditDiscountSpan = document.getElementById("credit-discount");
        var dueTodaySpan = document.getElementById("due-today");
        var nextCycle = document.getElementById("next-cycle");
        var nextDueSpan = document.getElementById("next-due");

        var checkedAddons = [];
        var months = 1;
        var subtotal = {{ $plan->price + $plan->setup_fee }};
        var currencyRate = {{ session('currency')->rate }};
        @if (session('coupon'))
            var couponPercentOff = {{ session('coupon')->percent_off }} / 100;
        @endif
        @if (auth()->user()->credit > 0)
            var accountCredit = {{ auth()->user()->credit }};
        @endif

        function updateAddonSummary(addon) {
            if (checkedAddons.includes(addon.id)) {
                document.getElementById(`addon_${addon.id}`).remove();
                checkedAddons.splice(checkedAddons.indexOf(addon.id), 1);
                subtotal -= addon.price;
                dueToday -= addon.price;
                nextDue -= addon.price;
            } else {
                var div = document.createElement("div");
                div.setAttribute("id", `addon_${addon.id}`);
                div.innerHTML = `
                    <h6>Add-on <span class="float-right">${addon.name}</span></h6>
                    <small>
                        Monthly <span class="float-right">$${addon.price}</span><br>
                        Setup Fee <span class="float-right">$${addon.setup_fee}</span>
                    </small>
                    <hr>
                `;
                addonsDiv.appendChild(div);
                checkedAddons.push(addon.id);
                subtotal += +addon.price;
            }
            
            updateValues();
        }

        function updateValues() {
            switch (billingCycle.value) {
                case 'monthly':
                    subtotalCycleSpan.innerHTML = `Monthly`;
                    nextCycle.innerHTML = `Month`;
                    months = 1;
                    break;
                case 'trimonthly':
                    subtotalCycleSpan.innerHTML = `Trimonthly`;
                    nextCycle.innerHTML = `3 Months`;
                    months = 3;
                    break;
                case 'biannually':
                    subtotalCycleSpan.innerHTML = `Biannually`;
                    nextCycle.innerHTML = `6 Months`;
                    months = 6;
                    break;
                case 'annually':
                    subtotalCycleSpan.innerHTML = `Yearly`;
                    nextCycle.innerHTML = `Year`;
                    months = 12;
                    break;
            }

            subtotalCyclePrice = dueToday = nextDue = subtotal * months;

            if (couponDiscountSpan && couponPercentOff) {
                couponDiscountSpan.innerHTML = (dueToday * couponPercentOff).toFixed(2);
                dueToday = dueToday * (1 - couponPercentOff);
            }

            if (creditDiscountSpan && accountCredit) {
                if (dueToday > accountCredit) {
                    creditDiscountSpan.innerHTML = accountCredit.toFixed(2);
                    dueToday -= accountCredit;
                } else {
                    creditDiscountSpan.innerHTML = dueToday.toFixed(2);
                    dueToday = 0.00;
                }
            }

            subtotalSpan.innerHTML = subtotal.toFixed(2);
            subtotalCyclePriceSpan.innerHTML = subtotalCyclePrice.toFixed(2);
            dueTodaySpan.innerHTML = dueToday.toFixed(2);
            nextDueSpan.innerHTML = nextDue.toFixed(2);
            orderDetailsInput.value = JSON.stringify({"addons": checkedAddons});
        }
        
        updateValues();
    </script>
@endsection
