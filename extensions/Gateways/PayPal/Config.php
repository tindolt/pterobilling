<?php

namespace Extensions\Gateways\PayPal;

use App\Models\Extension;

class Config
{
    public static function get()
    {
        $extension_model = Extension::class;

        try {
            $enabled = $extension_model::where([['extension', 'PayPal'], ['key', 'enabled']])->value('value');
            $mode = $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox']])->value('value');
            $sandbox_username = $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_username']])->value('value');
            $sandbox_password = $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_password']])->value('value');
            $sandbox_secret = $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_secret']])->value('value');
            $sandbox_certificate = $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_api_certificate']])->value('value');
            $sandbox_app_id = $extension_model::where([['extension', 'PayPal'], ['key', 'sandbox_app_id']])->value('value');
            $live_username = $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_username']])->value('value');
            $live_password = $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_password']])->value('value');
            $live_secret = $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_secret']])->value('value');
            $live_certificate = $extension_model::where([['extension', 'PayPal'], ['key', 'live_api_certificate']])->value('value');
            $live_app_id = $extension_model::where([['extension', 'PayPal'], ['key', 'live_app_id']])->value('value');
        } catch (\Throwable $err) {
            $enabled = 'false';
            $mode = 'sandbox';
            $sandbox_username = null;
            $sandbox_password = null;
            $sandbox_secret = null;
            $sandbox_certificate = null;
            $sandbox_app_id = null;
            $live_username = null;
            $live_password = null;
            $live_secret = null;
            $live_certificate = null;
            $live_app_id = null;
        }

        return [
            'enabled' => $enabled,
            'mode' => $mode,
            'sandbox' => [
                'username' => $sandbox_username,
                'password' => $sandbox_password,
                'secret' => $sandbox_secret,
                'certificate' => $sandbox_certificate,
                'app_id' => $sandbox_app_id,
            ],
            'live' => [
                'username' => $live_username,
                'password' => $live_password,
                'secret' => $live_secret,
                'certificate' => $live_certificate,
                'app_id' => $live_app_id,
            ],

            'payment_action' => 'Sale',
            'currency'       => 'USD',
            'billing_type'   => 'MerchantInitiatedBilling',
            'notify_url'     => '/extension/paypal/ipn',
            'locale'         => '',
            'validate_ssl'   => true,
        ];
    }
}
