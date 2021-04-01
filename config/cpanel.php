<?php

use App\Models\Extension;

$extension_model = Extension::class;

return [
    'enabled' => $extension_model::where([['extension', 'CPanel'], ['key', 'enabled']])->value('value'),
    'url' => $extension_model::where([['extension', 'CPanel'], ['key', 'url']])->value('value'),
    'username' => $extension_model::where([['extension', 'CPanel'], ['key', 'username']])->value('value'),
    'api_key' => $extension_model::where([['extension', 'CPanel'], ['key', 'api_key']])->value('value'),
];
