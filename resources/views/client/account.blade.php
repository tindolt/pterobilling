@extends('layouts.client')

@inject('currency_model', 'App\Models\Currency')
@inject('tax_model', 'App\Models\Tax')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Basic Settings</h3>
                </div>
                <form action="{{ route('client.account.basic') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="currencyInput">Currency</label>
                            <select class="form-control" name="currency">
                                @foreach ($currency_model->all() as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="countryInput">Country</label>
                            <select class="form-control" name="country">
                                @foreach ($tax_model->all() as $tax)
                                    <option value="{{ $tax->id }}">
                                        @if ($tax->country === '0')
                                            Global
                                        @else
                                            {{ $tax->country }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @include('layouts.store.hcaptcha')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Change Email Address</h3>
                </div>
                <form action="{{ route('client.account.email') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <div class="alert alert-info">
                                Changing the account email will NOT change the panel email.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="emailInput">Email Address</label>
                            <input type="email" name="email" class="form-control" id="emailInput" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <label for="passwordInput">Current Password</label>
                            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Current Password" required>
                        </div>
                        @include('layouts.store.hcaptcha')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Enter Panel API Key</h3>
                </div>
                <form action="{{ route('client.account.api') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <div class="alert alert-info">
                                You may create an API key <a href="{{ config('app.panel_url') }}/account/api" target="_blank">here</a>. We use this API key only to monitor your server resource usage and upload/install softwares to your servers.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="apiKeyInput">Your Panel API Key</label>
                            <input type="password" name="api_key" class="form-control" id="apiKeyInput" placeholder="Panel API Key" required>
                        </div>
                        @include('layouts.store.hcaptcha')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>
                <form action="{{ route('client.account.password') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <div class="alert alert-info">
                                Changing the account password will NOT change the panel password.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="passwordInput">Current Password</label>
                            <input type="password" name="current" class="form-control" id="passwordInput" placeholder="Current Password" required>
                        </div>
                        <div class="form-group">
                            <label for="newPasswordInput">New Password</label>
                            <input type="password" name="password" class="form-control" id="newPasswordInput" placeholder="New Password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPasswordInput">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="confirmPasswordInput" placeholder="Confirm Password" required>
                        </div>
                        @include('layouts.store.hcaptcha')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
