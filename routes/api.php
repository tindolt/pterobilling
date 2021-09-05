<?php

use App\Http\Controllers\GlobalsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => '/user'], function () {

  Route::middleware(['guest'])->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);

    Route::get('/reset-password', [ResetPasswordController::class, 'redirect'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
  });

  Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/', [UserController::class, 'logout']);
    Route::get('/', [UserController::class, 'fetchUser']);
  });
});

Route::get('/', [GlobalsController::class, 'fetch']);

Route::any('/{any?}', function () {
  return response()->setStatusCode(404);
})->where('any', '.*');;
