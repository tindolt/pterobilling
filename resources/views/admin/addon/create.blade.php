@php $header_route = "admin.addon.index"; @endphp

@extends('layouts.admin')

@inject('category_model', 'App\Models\Category')

@section('title', 'Create Plan Add-on')
@section('header', 'Plan Add-ons')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('api.admin.addon.create') }}" method="POST" data-callback="createForm">
                    @csrf

                    <div class="card-body row">
                        <div class="form-group col-lg-4">
                            <label for="nameInput">Add-on Name</label>
                            <input type="text" name="name" class="form-control" id="nameInput" placeholder="Add-on Name" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="descriptionInput">Short Description (Optional)</label>
                            <textarea name="description" class="form-control" id="descriptionInput" placeholder="Around 10 words recommended"></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="orderInput">Order (The smaller, the higher display priority)</label>
                            <input type="text" name="order" value="1000" class="form-control" id="orderInput" placeholder="Order" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Categories</label>
                            @foreach ($category_model->all() as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}">
                                    <p class="form-check-label">{{ $category->name }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Resource</label>
                            <select class="form-control" name="resource">
                                <option value="ram">RAM</option>
                                <option value="cpu">CPU</option>
                                <option value="disk">Disk</option>
                                <option value="database">Database</option>
                                <option value="backup">Backup</option>
                                <option value="extra_port">Extra Port</option>
                                <option value="dedicated_ip">Dedicated IP</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="amountInput">Amount of additional resource</label>
                            <input type="number" name="amount" min="0" class="form-control" id="amountInput" placeholder="Dedicated IP: enter allocation ID">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="globalLimitInput">Global Limit (max. servers using this add-on) (Optional)</label>
                            <input type="number" name="global_limit" min="0" class="form-control" id="globalLimitInput" placeholder="0 = No servers can use this add-on">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="perClientInput">Per Client Limit (max. servers per client using this add-on) (Optional)</label>
                            <input type="number" name="per_client_limit" min="0" class="form-control" id="perClientInput" placeholder="0 = No servers can use this add-on">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="perServerInput">Per Server Limit (max. quantity per server) (Optional)</label>
                            <input type="number" name="per_server_limit" min="0" class="form-control" id="perServerInput" placeholder="Dedicated IP: limit = 1">
                        </div>
                        <div class="form-group col-lg-12">
                            <hr>
                            <h5>Default Billing Cycle</h5>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Cycle Length</label>
                            <input type="number" name="cycle[0][cycle_length]" class="form-control" placeholder="e.g. Quarterly: enter '3', choose 'Monthly'" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Cycle Type</label>
                            <select class="form-control" name="cycle[0][cycle_type]">
                                <option value="0">One-time</option>
                                <option value="1">Hourly</option>
                                <option value="2">Daily</option>
                                <option value="3">Monthly</option>
                                <option value="4">Yearly</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Initial Price</label>
                            <input type="text" name="cycle[0][init_price]" class="form-control" placeholder="Use default currency" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Renew Price</label>
                            <input type="text" name="cycle[0][renew_price]" class="form-control" placeholder="Use default currency" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Setup fee</label>
                            <input type="text" name="cycle[0][setup_fee]" class="form-control" placeholder="Use default currency" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <hr>
                            <h5>Additional Billing Cycles (Optional)</h5>
                        </div>
                        @for ($i = 1; $i <= 8; $i++)
                            <div class="form-group col-lg-3">
                                <label>Cycle Length</label>
                                <input type="number" name="cycle[{{$i}}][cycle_length]" class="form-control" placeholder="e.g. Quarterly: enter '3', choose 'Monthly'">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Cycle Type</label>
                                <select class="form-control" name="cycle[{{$i}}][cycle_type]">
                                    <option value="0">One-time</option>
                                    <option value="1">Hourly</option>
                                    <option value="2">Daily</option>
                                    <option value="3">Monthly</option>
                                    <option value="4">Yearly</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Initial Price</label>
                                <input type="text" name="cycle[{{$i}}][init_price]" class="form-control" placeholder="Use default currency">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Renew Price</label>
                                <input type="text" name="cycle[{{$i}}][renew_price]" class="form-control" placeholder="Use default currency">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Setup fee</label>
                                <input type="text" name="cycle[{{$i}}][setup_fee]" class="form-control" placeholder="Use default currency">
                            </div>
                            <div class="form-group col-lg-12">
                                <hr>
                            </div>
                        @endfor
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

@section('admin_scripts')
    <script>
        function createForm(data) {
            if (data.success) {
                toastr.success(data.success)
                resetForms()
            } else if (data.error) {
                toastr.error(data.error)
            } else if (data.errors) {
                data.errors.forEach(error => { toastr.error(error) });
            } else {
                wentWrong()
            }
        }
    </script>
@endsection
