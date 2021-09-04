<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
  function redirect(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'token' => 'required|string',
      'email' => 'required|string|email',
    ]);

    if ($validator->fails()) {
      return response()->home();
    }

    $data = $validator->validated();

    return redirect()->to("/mail/user?token=" . $data['token'] . "&email=" . $data['email']);
  }
}
