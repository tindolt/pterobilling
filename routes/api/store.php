<?php

use Illuminate\Support\Facades\Route;

Route::get('/order/{id}', 'APi\StoreController@summary')->name('order.summary');
Route::post('/order/{id}', 'APi\StoreController@order')->name('order');
Route::post('/checkout/{id}', 'APi\StoreController@checkout')->name('checkout');
Route::post('/contact', 'APi\StoreController@contact')->name('contact');

Route::post('/login', 'Api\AuthController@login')->name('login');
Route::post('/register', 'Api\AuthController@register')->middleware('close.register')->name('register');
Route::post('/forgot', 'Api\AuthController@forgot')->name('forgot');
Route::post('/reset', 'Api\AuthController@reset')->name('reset');
