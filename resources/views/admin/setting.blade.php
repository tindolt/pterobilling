@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="companyNameInput">Company Name</label>
                                <input type="text" name="company_name" value="{{ $setting[0]->value }}" class="form-control" id="companyNameInput" placeholder="Company Name" required>
                            </div>
                            <div class="form-group">
                                <label for="storeUrlInput">Store URL (Must include 'https://')</label>
                                <input type="text" name="store_url" value="{{ $setting[1]->value }}" class="form-control" id="storeUrlInput" placeholder="Store URL" required>
                            </div>
                            <div class="form-group">
                                <label for="logoPathInput">Logo File Path (Must be inside the 'public' folder)</label>
                                <input type="text" name="logo_path" value="{{ $setting[2]->value }}" class="form-control" id="logoPathInput" placeholder="Logo File Path" required>
                            </div>
                            <div class="form-group">
                                <label for="faviconPathInput">Favicon File Path (Must be inside the 'public' folder)</label>
                                <input type="text" name="favicon_path" value="{{ $setting[3]->value }}" class="form-control" id="faviconPathInput" placeholder="Favicon File Path" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="dark_mode" value="yes" class="custom-control-input" @if ($setting[4]->value) checked @endif id="darkModeInput">
                                    <label class="custom-control-label" for="darkModeInput">Enable Dark Mode</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="panelUrlInput">Panel URL</label>
                                <input type="text" name="panel_url" value="{{ $setting[5]->value }}" class="form-control" id="panelUrlInput" placeholder="Panel URL" required>
                            </div>
                            <div class="form-group">
                                <label for="panelApiKeyInput">Panel API Key (Must be given enough permissions)</label>
                                <input type="password" name="panel_api_key" value="{{ $setting[6]->value }}" class="form-control" id="panelApiKeyInput" placeholder="Panel API Key" required>
                            </div>
                            <div class="form-group">
                                <label for="phpMyAdminUrlInput">phpMyAdmin URL (Put a '#' to disable this feature)</label>
                                <input type="text" name="phpmyadmin_url" value="{{ $setting[7]->value }}" class="form-control" id="phpMyAdminUrlInput" placeholder="phpMyAdmin URL" required>
                            </div>
                            <div class="form-group">
                                <label for="hCaptchaSiteKeyInput">hCaptcha Site Key</label>
                                <input type="text" name="hcaptcha_public_key" value="{{ $setting[8]->value }}" class="form-control" id="hCaptchaSiteKeyInput" placeholder="hCaptcha Site Key" required>
                            </div>
                            <div class="form-group">
                                <label for="hCaptchaSecretKeyInput">hCaptcha Secret Key</label>
                                <input type="password" name="hcaptcha_secret_key" value="{{ $setting[9]->value }}" class="form-control" id="hCaptchaSecretKeyInput" placeholder="hCaptcha Secret Key" required>
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
