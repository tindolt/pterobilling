<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;

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

    return redirect()->to("/mail/reset-password?token=" . $data['token'] . "&email=" . $data['email']);
  }

  function reset(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'token' => 'required|string',
      'email' => 'required|string|email',
      'password' => 'required|string|confirmed',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'message' => 'invalid credentials',
        'errors' => $validator->errors(),
      ])->setStatusCode(400);
    }

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function (User $user, $password) {
        $user->forceFill([
          'password' => Hash::make($password),
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
      }
    );

    if ($status === Password::PASSWORD_RESET) {
      return response()->json([
        'message' => 'password reset successfully',
        'status' => trans($status),
      ]);
    } else {
      return response()->json([
        'message' => 'password reset failed',
        'errors' => [trans($status)],
      ])->setStatusCode(400);
    }
  }
}
