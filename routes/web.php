<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function(){
    return redirect('home');
});

Route::get('home', 'HomeController@render');
Route::get('about', 'AboutController@render');
Route::get('checkout-details', 'CheckoutController@details');
Route::post('checkout-details', 'CheckoutController@saveDetails');
Route::get('payment-details', 'CheckoutController@payment');
Route::get('order-summary/{order_id}', 'CheckoutController@summary');
Route::get('cart', 'CheckoutController@cart');
Route::get('profile', 'ProfileController@user');
Route::get('manager', 'ProfileController@manager');
Route::get('profile/order/{id}/invoice', 'InvoiceController@invoice');
Route::get('order/{id}', 'InvoiceController@order');
Route::get('search', 'SearchController@render');
Route::get('product/add', 'ProductController@add');
Route::get('product/id', 'ProductController@delete');
Route::get('product/buy/{id}', 'ProductController@buyNow');
Route::post('product', 'ProductController@create');
Route::get('product/{id}', 'ProductController@render');
Route::get('profile/get','ProfileController@profile');
Route::get('profile/orders','ProfileController@orders');
Route::get('profile/wishlist','ProfileController@wishlist');
Route::get('manager/get','ProfileController@profile');
Route::get('manager/stocks','ProfileController@stocks');
Route::get('manager/pending-orders','ProfileController@pending');
Route::get('manager/managers','ProfileController@managers');

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
