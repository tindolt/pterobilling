@extends('layouts.client')

@inject('server_model', 'App\Models\Server')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Subdomain Information</h5>
                </div>
                <div class="card-body text-nowrap row">
                    <p class="card-text col-5">
                        <b>Subdomain Name</b><br>
                        <b>Port Number</b>
                    </p>
                    <p class="card-text col-7">
                        @if ($server_model->subdomain_name)
                            {{ $server_model->subdomain_name }}
                        @else
                            Not Set
                        @endif<br>
                        @if ($server_model->subdomain_port)
                            {{ $server_model->subdomain_port }}
                        @else
                            Not Set
                        @endif
                    </p>
                    <button type="submit" name="updatePort" value="true" form="updatePort" class="btn btn-primary btn-sm col-12">Update Port Number <i class="fas fa-sync-alt"></i></button>
                    <br>
                    <p class="card-text"><i>Update it if you have changed the primary port.</i></p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 row">
            <div class="card col-12">
                <div class="card-header">
                    <h5 class="card-title m-0">Create/change your subdomain name</h5>
                </div>
                <div class="card-body text-nowrap">
                    <form action="" method="POST">
                        @csrf

                        <div class="input-group row">
                            <input type="text" name="name" class="form-control col-md-6" placeholder="Enter subdomain" required>
                            <select class="form-control col-md-6" name="subdomain">
                                @foreach ($subdomains as $extension => $subdomain_list)
                                    @foreach ($subdomain_list as $subdomain)
                                        <option value="{{ $subdomain }}">.{{ $subdomain }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary">
                                Update Subdomain <i class="fas fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="POST" id="updatePort"> @csrf </form>
@endsection