<?php

use App\Models\Extension;

$extension_model = Extension::class;

return [
    'enabled' => $extension_model::where([['extension', 'PayPal'], ['key', 'enabled']])->value('value'),
    'mode' => $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox']])->value('value'),
    'sandbox' => [
        'username' => $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_username']])->value('value'),
        'password' => $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_password']])->value('value'),
        'secret' => $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_secret']])->value('value'),
        'certificate' => $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_certificate']])->value('value'),
        'app_id' => $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_app_id']])->value('value'),
    ],
    'live' => [
        'username' => $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_username']])->value('value'),
        'password' => $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_password']])->value('value'),
        'secret' => $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_secret']])->value('value'),
        'certificate' => $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_certificate']])->value('value'),
        'app_id' => $extension_model::where([['extension', 'PayPal'], ['key', 'live_app_id']])->value('value'),
    ],

    'payment_action' => 'Sale',
    'currency'       => 'USD',
    'billing_type'   => 'MerchantInitiatedBilling',
    'notify_url'     => '/paypal/ipn',
    'locale'         => '',
    'validate_ssl'   => true,
];
