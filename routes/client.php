<?php

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

    Route::prefix('{id}')->middleware('check.client.server')->group(function () {
        // Show server information
        Route::get('/', 'Client\ServerController@show')->name('show');

        // Manage server plan
        Route::prefix('plan')->name('plan.')->group(function () {
            Route::get('/', 'Client\PlanController@show')->name('show');
            Route::get('/cancel', 'Client\PlanController@cancel')->name('cancel');
            Route::post('/cancel', 'Client\PlanController@destroy');
            Route::get('/change/{plan_id}', 'Client\PlanController@change')->middleware('check.client.plan')->name('change');
            Route::post('/change/{plan_id}', 'Client\PlanController@store')->middleware('check.client.plan');
            Route::get('/checkout', 'Client\PlanController@confirm')->name('checkout');
            Route::post('/checkout', 'Client\PlanController@checkout');
            Route::get('/changed', 'Client\PlanController@changed')->name('changed');
        });

        // Manage server add-ons
        Route::prefix('addon')->name('addon.')->group(function () {
            Route::get('/', 'Client\AddonController@show')->name('show');
            Route::get('/remove/{addon_id}', 'Client\AddonController@remove')->middleware('check.client.addon:remove')->name('remove');
            Route::post('/remove/{addon_id}', 'Client\AddonController@destroy')->middleware('check.client.addon:remove');
            Route::get('/add/{addon_id}', 'Client\AddonController@add')->middleware('check.client.addon:add')->name('add');
            Route::post('/add/{addon_id}', 'Client\AddonController@store')->middleware('check.client.addon:add');
            Route::get('/checkout', 'Client\AddonController@confirm')->name('checkout');
            Route::post('/checkout', 'Client\AddonController@checkout');
            Route::get('/added', 'Client\AddonController@added')->name('added');
        });

        // Server subdomain manager
        Route::prefix('subdomain')->middleware('soon')->name('subdomain.')->group(function () {
            Route::get('/', 'Client\SubdomainController@show')->name('show');
            Route::post('/', 'Client\SubdomainController@store');
        });

        // Server software installer
        Route::prefix('software')->middleware('soon')->name('software.')->group(function () {
            Route::get('/', 'Client\SoftwareController@show')->name('show');
            Route::post('/', 'Client\SoftwareController@store');
        });
    });
});

// Invoices
Route::prefix('invoice')->name('invoice.')->group(function () {
    Route::get('/', 'Client\InvoiceController@index')->name('index');

    Route::prefix('{id}')->middleware('check.client.invoice')->group(function () {
        Route::get('/', 'Client\InvoiceController@show')->name('show');
        Route::post('/', 'Client\InvoiceController@store');
        Route::get('/print', 'Client\InvoiceController@print')->name('print');
        Route::get('/paid', 'Client\InvoiceController@paid')->name('paid');
    });
});

// Support Tickets
Route::prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'Client\TicketController@index')->name('index');
    Route::get('/create','Client\TicketController@create')->name('create');
    Route::post('/create', 'Client\TicketController@store');

    Route::prefix('view/{id}')->middleware('check.client.ticket')->group(function () {
        Route::get('/', 'Client\TicketController@show')->name('show');
        Route::post('/', 'Client\TicketController@update');
    });
});

// Affiliate Program
Route::prefix('affiliate')->middleware('check.store.affiliate')->name('affiliate.')->group(function () {
    Route::get('/', 'Client\AffiliateController@show')->name('show');
    Route::post('/', 'Client\AffiliateController@store');
});

// Account Settings
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/', 'Client\AccountController@show')->name('show');
    Route::post('/basic', 'Client\AccountController@basic')->name('basic');
    Route::post('/api', 'Client\AccountController@api')->name('api');
    Route::post('/email', 'Client\AccountController@email')->name('email');
    Route::post('/password', 'Client\AccountController@password')->name('password');
});

// Account Credit
Route::prefix('credit')->name('credit.')->group(function () {
    Route::get('/', 'Client\CreditController@show')->name('show');
    Route::post('/', 'Client\CreditController@store');
    Route::get('/added', 'Client\CreditController@added')->name('added');
});

// Logout
Route::get('/logout', 'Client\AccountController@destroy')->name('logout');
