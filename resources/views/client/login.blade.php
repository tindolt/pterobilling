@extends('layouts.store')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Welcome back!</h3>
                </div>
                <form action="" method="POST">
                    @csrf
                    
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    Please fix the following error(s):
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if (session('captcha_error'))
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    Please solve the hCaptcha challenge again.
                                </div>
                            </div>
                        @endif
                        @if (session('success_msg'))
                            <div class="form-group">
                                <div class="alert alert-success">
                                    {!! session('success_msg') !!}
                                </div>
                            </div>
                        @endif
                        @if (session('info_msg'))
                            <div class="form-group">
                                <div class="alert alert-info">
                                    {!! session('info_msg') !!}
                                </div>
                            </div>
                        @endif
                        @if (session('warning_msg'))
                            <div class="form-group">
                                <div class="alert alert-warning">
                                    {!! session('warning_msg') !!}
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="emailInput">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="emailInput" placeholder="Email Address" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="passwordInput">Password</label>
                            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" id="checkboxInput">
                                <label class="custom-control-label" for="checkboxInput">Remember Me</label>
                            </div>
                        </div>
                        @include('layouts.store.hcaptcha')
                        <div class="form-group mb-0">
                            <a href="{{ route('client.register') }}">Don't have an account?</a>
                        </div>
                        <div class="form-group mb-0">
                            <a href="{{ route('client.forgot') }}">Forgot password?</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection