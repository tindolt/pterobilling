<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Client Area
 */
// Dashboard
Route::get('/', 'Client\DashController@show')->name('dash');

// Servers
Route::prefix('server')->name('server.')->group(function () {
    // List all servers
    Route::get('/', 'Client\ServerController@index')->name('index');

    Route::prefix('{id}')->middleware('check.server')->group(function () {
        // Show server information
        Route::get('/', 'Client\ServerController@show')->name('show');

        // Manage server plan
        Route::prefix('plan')->name('plan.')->group(function () {
            Route::get('/', 'Client\PlanController@show')->name('show');
            Route::get('/cancel', 'Client\PlanController@cancel')->name('cancel');
            Route::post('/cancel', 'Client\PlanController@destroy');
            Route::get('/change/{plan_id}', 'Client\PlanController@change')->middleware('check.plan')->name('change');
            Route::post('/change/{plan_id}', 'Client\PlanController@store')->middleware('check.plan');
            Route::get('/checkout', 'Client\PlanController@confirm')->name('checkout');
            Route::post('/checkout', 'Client\PlanController@checkout');
            Route::get('/changed', 'Client\PlanController@changed')->name('changed');
        });

        // Manage server add-ons
        Route::prefix('addon')->name('addon.')->group(function () {
            Route::get('/', 'Client\AddonController@show')->name('show');
            Route::get('/remove/{addon_id}', 'Client\AddonController@remove')->middleware('check.addon')->name('remove');
            Route::post('/remove/{addon_id}', 'Client\AddonController@destroy')->middleware('check.addon');
            Route::get('/add/{addon_id}', 'Client\AddonController@add')->middleware('check.addon')->name('add');
            Route::post('/add/{addon_id}', 'Client\AddonController@store')->middleware('check.addon');
            Route::get('/checkout', 'Client\AddonController@confirm')->name('checkout');
            Route::post('/checkout', 'Client\AddonController@checkout');
            Route::get('/added', 'Client\AddonController@added')->name('added');
        });

        // Server subdomain manager
        Route::prefix('subdomain')->name('subdomain.')->group(function () {
            Route::get('/', 'Client\SubdomainController@show')->name('show');
            Route::post('/', 'Client\SubdomainController@store');
        });

        // Server software installer
        Route::prefix('software')->name('software.')->group(function () {
            Route::get('/', 'Client\SoftwareController@show')->name('show');
            Route::post('/', 'Client\SoftwareController@store');
        });
    });
});

// Invoices
Route::prefix('invoice')->name('invoice.')->group(function () {
    Route::get('/', 'Client\InvoiceController@index')->name('index');

    Route::prefix('{id}')->middleware('check.invoice')->group(function () {
        Route::get('/', 'Client\InvoiceController@show')->name('show');
        Route::post('/', 'Client\InvoiceController@store');
        Route::get('/print', 'Client\InvoiceController@print')->name('print');
        Route::get('/paid', 'Client\InvoiceController@paid')->name('paid');
    });
});

// Support Tickets
Route::prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'Client\TicketController@index')->name('index');

    Route::prefix('{id}')->middleware('check.ticket')->group(function () {
        Route::get('/', 'Client\TicketController@show')->name('show');
        Route::post('/', 'Client\TicketController@update');
        Route::get('/create','Client\TicketController@create')->withoutMiddleware('check.ticket')->name('create');
        Route::post('/create', 'Client\TicketController@store')->withoutMiddleware('check.ticket');
    });
});

// Affiliate Program
Route::prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/', 'Client\AffiliateController@show')->name('show');
    Route::post('/', 'Client\AffiliateController@store');
});

// Account Settings
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/', 'Client\AccountController@show')->name('show');
    Route::post('/', 'Client\AccountController@store');
});

// Account Credit
Route::prefix('credit')->name('credit.')->group(function () {
    Route::get('/', 'Client\CreditController@show')->name('show');
    Route::post('/', 'Client\CreditController@store');
    Route::get('/added', 'Client\CreditController@added')->name('added');
});

// Email Verification
Route::get('/email/notice', function () {
    return view('client.verify');
})->withoutMiddleware('verified')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('client.dash')->with('success_msg', 'Your account has been verified!');
})->middleware(['signed', 'throttle:6,1'])->withoutMiddleware('verified')->name('verification.verify');

Route::get('/email/send', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success_msg', 'We have sent you an email. Please click the link inside to verify your account.');
})->middleware('throttle:6,1')->withoutMiddleware('verified')->name('verification.send');

// Logout
Route::get('/logout', 'Client\AccountController@destroy')->name('logout');
