<?php

namespace App\Traits;

trait HCaptcha
{
    public function validateResponse($response)
    {
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query(array('secret' => config('hcaptcha_secret_key'), 'response' => $response)));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($verify));
        return $result->success;
    }
}
