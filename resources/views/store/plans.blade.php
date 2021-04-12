@extends('layouts.store')

@section('content')
    <div class="row">
        @isset($id)
            <div class="col-lg-12">
                <div class="callout callout-info">
                    <h5>You are viewing the plans of {{ $category->name }}.</h5>
                </div>
            </div>
        @endisset
        @foreach ($plans as $plan)
            @php
                $plan_percent_off = 1;
            @endphp
            @foreach ($discounts as $discount)
                @if ($plan->discount === $discount->id || $discount->is_global)
                    @php
                        $plan_percent_off = 1 - ($discount->percent_off / 100);
                        break;
                    @endphp
                @endif
            @endforeach
            @switch(json_decode($plan->cycles, true)[0])
                @case('trimonthly')
                    @php
                        $cycle_multiply = 3;
                    @endphp
                    @break
                @case('biannually')
                    @php
                        $cycle_multiply = 6;
                    @endphp
                    @break
                @case('annually')
                    @php
                        $cycle_multiply = 12;
                    @endphp
                    @break
                @default
                    @php
                        $cycle_multiply = 1;
                    @endphp
            @endswitch
            <div class="col-lg-3 col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">{{ $plan->name }}</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{!! session('currency')->symbol !!}{{ number_format($plan->price * session('currency')->rate * $plan_percent_off * $cycle_multiply, 2) }} {{ session('currency')->name }} {{ ucfirst(json_decode($plan->cycles, true)[0]) }}</h6>
                        @if ($plan->trial > 0)
                            <br><h6 class="card-title">{{ $plan->trial }} Days Free Trial</h6>
                        @endif
                        <p class="card-text">
                            <ul class="list-unstyled">
                                <li>RAM <span class="float-right">{{ $plan->ram }} MB</span></li>
                                <li>CPU <span class="float-right">{{ $plan->cpu }}%</span></li>
                                <li>Disk <span class="float-right">{{ $plan->disk }} MB</span></li>
                                <li>Databases <span class="float-right">{{ $plan->databases }}</span></li>
                                <li>Backups <span class="float-right">{{ $plan->backups }}</span></li>
                                <li>Extra Ports <span class="float-right">{{ $plan->allocations - 1 }}</span></li>
                            </ul>
                        </p>
                        <a href="{{ route('order', ['id' => $plan->id]) }}" class="btn btn-primary col-12">Order <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection