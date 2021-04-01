<?php

use App\Models\Setting;

$setting_model = Setting::class;

return [
    'site_key' => $setting_model::where('key', 'hcaptcha_public_key')->value('value'),
    'secret_key' => $setting_model::where('key', 'hcaptcha_secret_key')->value('value'),
];
