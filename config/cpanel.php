<?php

use App\Models\Extension;

$extension_model = Extension::class;

try {
    $enabled = $extension_model::where([['extension', 'CPanel'], ['key', 'enabled']])->value('value');
    $url = $extension_model::where([['extension', 'CPanel'], ['key', 'url']])->value('value');
    $username = $extension_model::where([['extension', 'CPanel'], ['key', 'username']])->value('value');
    $api_key = $extension_model::where([['extension', 'CPanel'], ['key', 'api_key']])->value('value');
} catch (Throwable $err) {
    $enabled = 'false';
    $url = 'https://cpanel.example.com:2083';
    $username = null;
    $api_key = null;
}

return [
    'enabled' => $enabled,
    'url' => $url,
    'username' => $username,
    'api_key' => $api_key,
];
