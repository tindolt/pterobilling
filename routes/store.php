<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Store Pages
 */
// Home Page
Route::get('/', 'Store\PageController')->name('home');

// Plans Page
Route::get('/plans/{id?}', 'Store\PlansController')->name('plans');

// Order Server Pages
Route::prefix('order/{id}')->middleware('check.store.order')->group(function () {
    Route::get('/', 'Store\OrderController@show')->name('order');
    Route::post('/', 'Store\OrderController@store');
    Route::post('/coupon', 'Store\OrderController@coupon')->name('order.coupon');
});

// Checkout Page
Route::get('/checkout', 'Store\CheckoutController@show')->name('checkout');
Route::post('/checkout', 'Store\CheckoutController@store');
Route::get('/ordered', 'Store\CheckoutController@ordered')->name('ordered');
Route::get('/canceled', 'Store\CheckoutController@canceled')->name('canceled');

// Contact Page
Route::get('/contact', 'Store\ContactController@show')->name('contact');
Route::post('/contact', 'Store\ContactController@store');

// System Status Page
Route::get('/status', 'Store\PageController')->name('status');

// Terms of Service Page
Route::get('/terms', 'Store\PageController')->name('terms');

// Privacy Policy Page
Route::get('/privacy', 'Store\PageController')->name('privacy');

// Affiliate Link
Route::get('/a/{id}', 'Store\AffiliateController')->middleware('check.store.affiliate')->name('affiliate');

// Changing Currency
Route::get('/currency/{id}', 'Store\CurrencyController')->name('currency');

// Changing Country (Tax)
Route::get('/country/{id}', 'Store\CountryController')->name('country');

// Changing Language (coming soon...)
Route::get('/lang/{id}', 'Store\LanguageController')->name('lang');

// Knowledge Base
Route::get('/kb/{id?}', 'Store\KbController')->name('kb');

// Email Verification
Route::prefix('email')->name('verification.')->group(function () {
    Route::get('/notice', function () {
        return view('client.verify', ['title' => 'Account Verification']);
    })->middleware('auth')->withoutMiddleware('verified')->name('notice');

    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('client.dash')->with('success_msg', 'Your account has been verified!');
    })->middleware(['auth', 'signed', 'throttle:6,1'])->withoutMiddleware('verified')->name('verify');

    Route::get('/send', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success_msg', 'We have sent you an email. Please click the link inside to verify your account.');
    })->middleware(['auth', 'throttle:6,1'])->withoutMiddleware('verified')->name('send');
});

/**
 * Authentication Pages
 */
Route::prefix('auth')->name('client.')->middleware('guest')->group(function () {
    // Login Page
    Route::get('/login', 'Client\LoginController@show')->name('login');
    Route::post('/login', 'Client\LoginController@store');

    // Register Page
    Route::get('/register', 'Client\RegisterController@show')->middleware('close.register')->name('register');
    Route::post('/register', 'Client\RegisterController@store')->middleware('close.register');

    // Password Recovery Page
    Route::get('/forgot', 'Client\ForgotPasswordController@show')->name('forgot');
    Route::post('/forgot', 'Client\ForgotPasswordController@store');
    Route::get('/reset/{token}', 'Client\ResetPasswordController@show')->name('reset');
    Route::post('/reset/{token}', 'Client\ResetPasswordController@store');
});
