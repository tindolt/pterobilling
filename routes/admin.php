<?php

use Illuminate\Support\Facades\Route;

/**
 * Admin Area
 */
// Dashboard
Route::get('/', 'Admin\DashController@show')->name('dash');

// Cache Config
Route::get('/cache', 'Admin\CacheController')->name('cache');

// Server Lists
Route::prefix('servers')->name('servers.')->group(function () {
    Route::get('/active', 'Admin\ServerController@active')->name('active');
    Route::get('/pending', 'Admin\ServerController@pending')->name('pending');
    Route::get('/suspended', 'Admin\ServerController@suspended')->name('suspended');
    Route::get('/canceled', 'Admin\ServerController@canceled')->name('canceled');
});

// Servers
Route::prefix('server/{id}')->name('server.')->middleware('check.admin.server')->group(function () {
    Route::get('/', 'Admin\ServerController@show')->name('show');
    Route::post('/', 'Admin\ServerController@suspend')->name('suspend');
});

// Clients
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/', 'Admin\ClientController@index')->name('index');
    Route::post('/', 'Admin\ClientController@import');

    Route::prefix('{id}')->middleware('check.admin.client')->group(function () {
        Route::get('/', 'Admin\ClientController@show')->name('show');
        Route::post('/basic', 'Admin\ClientController@basic')->name('basic');
        Route::post('/email', 'Admin\ClientController@email')->name('email');
        Route::post('/password', 'Admin\ClientController@password')->name('password');
        Route::post('/admin', 'Admin\ClientController@admin')->name('admin');
        Route::get('/servers', 'Admin\ClientController@servers')->name('servers');
        Route::get('/invoices', 'Admin\ClientController@invoices')->name('invoices');
        Route::get('/tickets', 'Admin\ClientController@tickets')->name('tickets');
        Route::get('/affiliates', 'Admin\ClientController@affiliates')->middleware('check.store.affiliate')->name('affiliates');
        Route::get('/credit', 'Admin\ClientController@credit')->name('credit');
        Route::post('/credit', 'Admin\ClientController@fund');
    });
});

// Affiliate Program
Route::prefix('affiliate')->middleware('check.store.affiliate')->name('affiliate.')->group(function () {
    Route::get('/', 'Admin\AffiliateController@index')->name('index');
    Route::get('/settings', 'Admin\AffiliateController@show')->withoutMiddleware('check.store.affiliate')->name('show');
    Route::post('/settings', 'Admin\AffiliateController@store')->withoutMiddleware('check.store.affiliate');
    Route::post('/accept/{id}', 'Admin\AffiliateController@accept')->middleware('check.admin.affiliate')->name('accept');
    Route::post('/reject/{id}', 'Admin\AffiliateController@reject')->middleware('check.admin.affiliate')->name('reject');
});

// Server Plans
Route::prefix('plan')->name('plan.')->group(function () {
    Route::get('/', 'Admin\PlanController@index')->name('index');
    Route::get('/create', 'Admin\PlanController@create')->name('create');
    Route::post('/create', 'Admin\PlanController@store');

    Route::prefix('view/{id}')->middleware('check.admin.plan')->group(function () {
        Route::get('/', 'Admin\PlanController@show')->name('show');
        Route::post('/', 'Admin\PlanController@update');
        Route::post('/delete', 'Admin\PlanController@delete')->name('delete');
    });
});

// Plan Categories
Route::prefix('category')->name('category.')->group(function () {
    Route::get('/', 'Admin\CategoryController@index')->name('index');
    Route::get('/create', 'Admin\CategoryController@create')->name('create');
    Route::post('/create', 'Admin\CategoryController@store');

    Route::prefix('view/{id}')->middleware('check.admin.category')->group(function () {
        Route::get('/', 'Admin\CategoryController@show')->name('show');
        Route::post('/', 'Admin\CategoryController@update');
        Route::post('/delete', 'Admin\CategoryController@delete')->name('delete');
    });
});

// Server Add-ons
Route::prefix('addon')->name('addon.')->group(function () {
    Route::get('/addon', 'Admin\AddonController@index')->name('index');
    Route::get('/create', 'Admin\AddonController@create')->name('create');
    Route::post('/create', 'Admin\AddonController@store');

    Route::prefix('view/{id}')->middleware('check.admin.addon')->group(function () {
        Route::get('/', 'Admin\AddonController@show')->name('show');
        Route::post('/', 'Admin\AddonController@update');
        Route::post('/delete', 'Admin\AddonController@delete')->name('delete');
    });
});

// Discounts
Route::prefix('discount')->name('discount.')->group(function () {
    Route::get('/', 'Admin\DiscountController@index')->name('index');
    Route::get('/create', 'Admin\DiscountController@create')->name('create');
    Route::post('/create', 'Admin\DiscountController@store');

    Route::prefix('view/{id}')->middleware('check.admin.discount')->group(function () {
        Route::get('/', 'Admin\DiscountController@show')->name('show');
        Route::post('/', 'Admin\DiscountController@update');
        Route::post('/delete', 'Admin\DiscountController@delete')->name('delete');
    });
});

// Coupon Codes
Route::prefix('coupon')->name('coupon.')->group(function () {
    Route::get('/', 'Admin\CouponController@index')->name('index');
    Route::get('/create', 'Admin\CouponController@create')->name('create');
    Route::post('/create', 'Admin\CouponController@store');

    Route::prefix('view/{id}')->middleware('check.admin.coupon')->group(function () {
        Route::get('/', 'Admin\CouponController@show')->name('show');
        Route::post('/', 'Admin\CouponController@update');
        Route::post('/delete', 'Admin\CouponController@delete')->name('delete');
    });
});

// Income
Route::get('/income', 'Admin\IncomeController@show')->name('income');

// Invoices
Route::prefix('invoice')->name('invoice.')->group(function () {
    Route::get('/', 'Admin\InvoiceController@index')->name('index');

    Route::prefix('{id}')->middleware('check.admin.invoice')->group(function () {
        Route::get('/', 'Admin\InvoiceController@show')->name('show');
    });
});

// Currencies
Route::prefix('currency')->name('currency.')->group(function () {
    Route::get('/', 'Admin\CurrencyController@index')->name('index');
    Route::get('/create', 'Admin\CurrencyController@create')->name('create');
    Route::post('/create', 'Admin\CurrencyController@store');

    Route::prefix('view/{id}')->middleware('check.admin.currency')->group(function () {
        Route::get('/', 'Admin\CurrencyController@show')->name('show');
        Route::post('/', 'Admin\CurrencyController@update');
        Route::post('/delete', 'Admin\CurrencyController@delete')->name('delete');
        Route::post('/default', 'Admin\CurrencyController@default')->name('default');
    });
});

// Taxes
Route::prefix('tax')->name('tax.')->group(function () {
    Route::get('/', 'Admin\TaxController@index')->name('index');
    Route::get('/create', 'Admin\TaxController@create')->name('create');
    Route::post('/create', 'Admin\TaxController@store');

    Route::prefix('view/{id}')->middleware('check.admin.tax')->group(function () {
        Route::get('/', 'Admin\TaxController@show')->name('show');
        Route::post('/', 'Admin\TaxController@update');
        Route::post('/delete', 'Admin\TaxController@delete')->name('delete');
    });
});

// Support Tickets
Route::prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'Admin\TicketController@index')->name('index');

    Route::prefix('{id}')->middleware('check.admin.ticket')->group(function () {
        Route::get('/', 'Admin\TicketController@show')->name('show');
        Route::post('/', 'Admin\TicketController@store');
    });
});

// Knowledge Base
Route::prefix('kb')->name('kb.')->group(function () {
    Route::get('/', 'Admin\KbCategoryController@index')->name('index');
    Route::get('/create', 'Admin\KbCategoryController@create')->name('create');
    Route::post('/create', 'Admin\KbCategoryController@store');

    Route::prefix('category/{id}')->middleware('check.admin.kb.category')->group(function () {
        Route::get('/', 'Admin\KbCategoryController@show')->name('show');
        Route::post('/', 'Admin\KbCategoryController@update');
        Route::post('/delete', 'Admin\KbCategoryController@delete')->name('delete');

        Route::name('article.')->group(function () {
            Route::get('/create', 'Admin\KbArticleController@create')->name('create');
            Route::post('/create', 'Admin\KbArticleController@store');

            Route::prefix('article/{article_id}')->middleware('check.admin.kb.article')->group(function () {
                Route::get('/', 'Admin\KbArticleController@show')->name('show');
                Route::post('/', 'Admin\KbArticleController@update');
                Route::post('/delete', 'Admin\KbArticleController@delete')->name('delete');
            });
        });
    });
});

// Announcements
Route::prefix('announce')->name('announce.')->group(function () {
    Route::get('/', 'Admin\AnnouncementController@show')->name('show');
    Route::post('/', 'Admin\AnnouncementController@store');
});

// Store Settings
Route::prefix('setting')->name('setting.')->group(function () {
    Route::get('/', 'Admin\SettingController@show')->name('show');
    Route::post('/', 'Admin\SettingController@store');
});

// Store Pages
Route::prefix('page/{id}')->name('page.')->group(function () {
    Route::get('/', 'Admin\PageController@show')->name('show');
    Route::post('/', 'Admin\PageController@store');
    Route::get('/{msg_id}', 'Admin\PageController@contact')->middleware('check.admin.message')->name('contact');
});

// Extensions
Route::prefix('extension/{id}')->name('extension.')->group(function () {
    Route::get('/', 'Admin\ExtensionController@show')->name('show');
    Route::post('/', 'Admin\ExtensionController@store');
});
