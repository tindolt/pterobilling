<?php

namespace App\Traits;

trait PterodactylApi {    
    public function appApi($action, $method, $fields = null)
    {
        $url = config('app.panel_url') . '/api/application/' . $action;
        $api_key = config('app.panel_api_key');
        return $this->curlApi($url, $method, $fields, $api_key);
    }
    
    public function clientApi($api_key, $action, $method, $fields = null)
    {
        $url = config('app.panel_url') . '/api/client/' . $action;
        return $this->curlApi($url, $method, $fields, $api_key);
    }

    private function curlApi($url, $method, $fields, $api_key)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
        } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }
        if (!is_null($fields)) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $api_key;
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        return empty($error) ? json_decode($result, true) : false;
    }
}
