@extends('layouts.client')

@inject('plan_model', 'App\Models\Plan')

@php
    $server_plan = $plan_model->find($server->plan_id)->first();
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0">Your Current Plan</h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">
                        {{ $server_plan->name }}<br>
                        {!! session('currency_symbol') !!}{{ $server_plan->price }} {{ session('currency') }} {{ $server->billing_cycle }}
                    </h6>
                    <p class="card-text">
                        <ul class="list-unstyled">
                            <li>RAM <span class="float-right">{{ $server_plan->ram }} MB</span></li>
                            <li>CPU <span class="float-right">{{ $server_plan->cpu }} %</span></li>
                            <li>Disk <span class="float-right">{{ $server_plan->disk }} MB</span></li>
                            <li>Databases <span class="float-right">{{ $server_plan->databases }}</span></li>
                            <li>Backups <span class="float-right">{{ $server_plan->backups }}</span></li>
                            <li>Extra Ports <span class="float-right">{{ $server_plan->allocations - 1 }}</span></li>
                        </ul>
                    </p>
                    <a href="{{ route('client.server.plan.cancel', ['id' => 1]) }}" class="btn btn-danger col-12">Cancel Plan</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-6 row">
            @foreach ($plan_model->where('category_id', $plan_model->find($server->plan_id)->value('category_id'))->orderBy('order', 'desc')->get() as $plan)
                @if ($plan->id !== $server->plan_id)
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title m-0">{{ $plan->name }}</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">{!! session('currency_symbol') !!}{{ $plan->price }} {{ session('currency') }} {{ json_decode($plan->cycles)[0] }}</h6>
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
                                <a href="{{ route('client.server.plan.change', ['id' => $server->id, 'plan_id' => $plan->id]) }}" class="btn btn-primary    col-12">Change Plan <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection