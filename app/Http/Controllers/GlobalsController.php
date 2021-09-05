<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalsController extends Controller
{
  public function fetch(Request $request)
  {
    return response()->json([
      'appName' => config('app.name'),
      'appIcon' => config('app.icon'),
      'appVersion' => config('app.version'),
      'plans' => [],
    ]);
  }
}
