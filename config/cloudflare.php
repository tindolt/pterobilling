<?php

use App\Models\Extension;

$extension_model = Extension::class;

try {
    $enabled = $extension_model::where([['extension', 'Cloudflare'], ['key', 'enabled']])->value('value');
    $email = $extension_model::where([['extension', 'Cloudflare'], ['key', 'email']])->value('value');
    $api_key = $extension_model::where([['extension', 'Cloudflare'], ['key', 'api_key']])->value('value');
} catch (Throwable $err) {
    $enabled = 'false';
    $email = null;
    $api_key = null;
}

return [
    'enabled' => $enabled,
    'email' => $email,
    'api_key' => $api_key,
];
