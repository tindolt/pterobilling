<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class StoreController extends Controller
{
  public function contactPost(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email',
      'name' => 'required|string|max:250',
      'subject' => 'required|string|max:250',
      'message' => 'required|string|max:4000'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'invalid credentials',
        'errors' => $validator->errors(),
      ])->setStatusCode(400);
    }

    $data = $validator->validated();


    $message = (new \App\Mail\Contact($data['email'], $data['name'], $data['subject'], $data['message']));

    Mail::to(config('mail.from.address', 'mail.from.name'))->queue($message);

    return response()->json([
      'message' => 'success',
    ]);
  }
}
