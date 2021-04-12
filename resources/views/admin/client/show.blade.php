@extends('layouts.admin')

@inject('currency_model', 'App\Models\Currency')
@inject('tax_model', 'App\Models\Tax')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <ul class="nav ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.client.show', ['id' => $id]) }}">Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.servers', ['id' => $id]) }}">Servers</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.invoices', ['id' => $id]) }}">Invoices</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.tickets', ['id' => $id]) }}">Support Tickets</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.affiliates', ['id' => $id]) }}">Affiliates</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.client.credit', ['id' => $id]) }}">Credit</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Basic Settings</h3>
                </div>
                <form action="{{ route('admin.client.basic', ['id' => $id]) }}" method="POST">
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
                <form action="{{ route('admin.client.email', ['id' => $id]) }}" method="POST">
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
                    <h3 class="card-title">Change Password</h3>
                </div>
                <form action="{{ route('admin.client.password', ['id' => $id]) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <div class="alert alert-info">
                                Changing the account password will NOT change the panel password.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newPasswordInput">New Password</label>
                            <input type="password" name="password" class="form-control" id="newPasswordInput" placeholder="New Password" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Administrator</h3>
                </div>
                <form action="{{ route('admin.client.admin', ['id' => $id]) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <div class="alert alert-warning">
                                Only promote the user you trust to an admin, who can access everything inside the admin area!
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if ($client->is_admin)
                            <button type="submit" class="btn btn-danger">Demote Client</button>
                        @else
                            <button type="submit" class="btn btn-success">Promote Client</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
