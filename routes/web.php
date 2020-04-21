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

Route::get('/', 'HomeController@root');
Route::get('home', 'HomeController@render');
Route::get('about', 'AboutController@render');
Route::get('checkout-details', 'CheckoutController@details');
Route::post('checkout-details', 'CheckoutController@saveDetails');
Route::get('payment-details', 'CheckoutController@payment');
Route::get('order-summary/{order_id}', 'CheckoutController@summary');
Route::get('cart', 'CheckoutController@cart');
Route::get('profile', 'ProfileController@user');
Route::post('profile/update', 'ProfileController@updateCustomer');
Route::get('manager', 'ProfileController@manager');
Route::post('manager', 'ProfileController@updateManager');
Route::get('profile/order/{id}/invoice', 'OrderController@invoice');
Route::get('order/{id}', 'OrderController@invoice');
Route::get('search', 'SearchController@textSearch');
Route::get('product/add', 'ProductController@add');
Route::get('cart/buy', 'ProductController@buy');
Route::get('product/buy/{id}', 'ProductController@buyNow');
Route::post('product', 'ProductController@create');
Route::post('cart/{id}', 'ProductController@addShoppingCart');
Route::get('product/{id}', 'ProductController@render');
Route::get('profile/user','ProfileController@profile');
Route::get('profile/orders','ProfileController@orders');
Route::get('profile/wishlist','ProfileController@wishlist');
Route::get('manager/user','ProfileController@profile');
Route::get('manager/stocks','ProfileController@stocks');
Route::get('manager/pending-orders','ProfileController@pending');
Route::get('manager/managers','ProfileController@managers');
Route::delete('product/{id}','ProductController@delete');
Route::post('order/update','OrderController@update');

//Whishlists
Route::get('profile/wishlist','ProfileController@wishlist');
Route::put('profile/wishlist', 'ProfileController@addProductToWishlist');
Route::delete('profile/wishlist/{id}', 'ProfileController@removeProductFromWishlist');



// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
