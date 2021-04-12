@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="col-lg-6">
                            @php
                                $i = 0;
                            @endphp
                            <div class="form-group">
                                <label for="companyNameInput">Company Name</label>
                                <input type="text" name="company_name" value="{{ $setting[$i]->value }}" class="form-control" id="companyNameInput" placeholder="Company Name" required>
                            </div>
                            <div class="form-group">
                                <label for="storeUrlInput">Store URL (Must include 'https://')</label>
                                <input type="text" name="store_url" value="{{ $setting[++$i]->value }}" class="form-control" id="storeUrlInput" placeholder="Store URL" required>
                            </div>
                            <div class="form-group">
                                <label for="logoPathInput">Logo File Path (Must be inside the 'public' folder)</label>
                                <input type="text" name="logo_path" value="{{ $setting[++$i]->value }}" class="form-control" id="logoPathInput" placeholder="Logo File Path" required>
                            </div>
                            <div class="form-group">
                                <label for="faviconPathInput">Favicon File Path (Must be inside the 'public' folder)</label>
                                <input type="text" name="favicon_path" value="{{ $setting[++$i]->value }}" class="form-control" id="faviconPathInput" placeholder="Favicon File Path" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="dark_mode" value="yes" class="custom-control-input" @if ($setting[++$i]->value) checked @endif id="darkModeInput">
                                    <label class="custom-control-label" for="darkModeInput">Enable Dark Mode</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="open_registration" value="yes" class="custom-control-input" @if ($setting[++$i]->value) checked @endif id="openRegistrationInput">
                                    <label class="custom-control-label" for="openRegistrationInput">Open Registration</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="panelUrlInput">Panel URL</label>
                                <input type="text" name="panel_url" value="{{ $setting[++$i]->value }}" class="form-control" id="panelUrlInput" placeholder="Panel URL" required>
                            </div>
                            <div class="form-group">
                                <label for="panelApiKeyInput">Panel API Key (Must be given enough permissions)</label>
                                <input type="password" name="panel_api_key" value="{{ $setting[++$i]->value }}" class="form-control" id="panelApiKeyInput" placeholder="Panel API Key" required>
                            </div>
                            <div class="form-group">
                                <label for="phpMyAdminUrlInput">phpMyAdmin URL (Put a '#' to disable this feature)</label>
                                <input type="text" name="phpmyadmin_url" value="{{ $setting[++$i]->value }}" class="form-control" id="phpMyAdminUrlInput" placeholder="phpMyAdmin URL" required>
                            </div>
                        </div>
                        <div class="col-lg-5 offset-lg-1">
                            <div class="form-group">
                                <label for="hCaptchaSiteKeyInput">hCaptcha Site Key</label>
                                <input type="text" name="hcaptcha_public_key" value="{{ $setting[++$i]->value }}" class="form-control" id="hCaptchaSiteKeyInput" placeholder="hCaptcha Site Key" required>
                            </div>
                            <div class="form-group">
                                <label for="hCaptchaSecretKeyInput">hCaptcha Secret Key</label>
                                <input type="password" name="hcaptcha_secret_key" value="{{ $setting[++$i]->value }}" class="form-control" id="hCaptchaSecretKeyInput" placeholder="hCaptcha Secret Key" required>
                            </div>
                            <div class="form-group">
                                <label for="analyticsIdInput">Google Analytics ID</label>
                                <input type="text" name="google_analytics_id" value="{{ $setting[++$i]->value }}" class="form-control" id="analyticsIdInput" placeholder="Google Analytics ID" required>
                            </div>
                            <div class="form-group">
                                <label for="arcInput">Arc Widget ID</label>
                                <input type="text" name="arc_widget_id" value="{{ $setting[++$i]->value }}" class="form-control" id="arcInput" placeholder="Arc Widget ID" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
