<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\ApiController;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PterodactylSDK\PterodactylAPI;

class SoftwareController extends ApiController
{
    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'software' => 'required|string',
            'version' => 'required|string',
        ]);

        if ($validator->fails())
            return $this->respondJson(['errors' => $validator->errors()->all()]);

        $api = (new PterodactylAPI)->client()->getServerFileUploadUrl(Server::find($id)->identifier);

        if ($api->status() === '200' && empty($api->errors())) {
            $data = explode(':', $request->input('software'));
            $file = $data[0]::install($data[1], $request->input('version'));
            $curl_file = curl_file_create(base_path('extensions/Softwares/' . str_replace('Extensions\\Softwares\\', '', $data[0]) . '/software/' . $file), null, $file);
            $curl = curl_init($api->response()->attributes->url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, ['file' => $curl_file]);
            if (curl_exec($curl))
                return $this->respondJson(['success' => 'The server software has been uploaded to your server.']);
        }
        return $this->respondJson(['error' => 'Failed to upload the server software!']);
    }
}
