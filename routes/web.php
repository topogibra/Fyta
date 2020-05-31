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
Route::post('payment-details', 'CheckoutController@payment');
Route::get('order-summary/{order_id}', 'CheckoutController@summary');
Route::get('cart', 'CheckoutController@cart');
Route::get('profile', 'CustomerController@render');
Route::post('profile/update', 'CustomerController@update');
Route::get('manager', 'ManagerController@render');
Route::post('manager', 'ManagerController@update');
Route::post('manager/create', 'ManagerController@create');
Route::get('profile/order/{id}/invoice', 'OrderController@invoice');
Route::get('order/{id}', 'OrderController@invoice');
Route::get('search', 'SearchController@render');
Route::get('product/add', 'ProductController@add');
Route::get('cart/buy', 'ShoppingCartController@buy');
Route::get('product/buy/{id}', 'OrderController@buyNow');
Route::delete('cart/{id}','ShoppingCartController@deleteCartProduct');
Route::post('product', 'ProductController@create');
Route::put('product', 'ProductController@updateProduct');
Route::post('cart/{id}', 'ShoppingCartController@addShoppingCart');
Route::post('cart/less/{id}', 'ShoppingCartController@addShoppingCart');
Route::post('cart/more/{id}', 'ShoppingCartController@addShoppingCart');
Route::get('product/{id}', 'ProductController@render');
Route::get('product/{id}/edit', 'ProductController@edit');
Route::get('profile/user', 'ProfileController@profile');
Route::get('profile/orders', 'OrderController@orders');
Route::get('manager/user', 'ProfileController@profile');
Route::delete('manager/{id}', 'ManagerController@delete');
Route::get('manager/stocks', 'ManagerController@stocks');
Route::put('manager/stocks', 'ProductController@updateProducts');
Route::get('manager/pending-orders', 'OrderController@pending');
Route::get('manager/managers', 'ManagerController@managers');
Route::delete('product/{id}', 'ProductController@delete');
Route::post('order/update', 'OrderController@update');
Route::post('search', 'SearchController@fullSearch');
Route::delete('customer/{username}','CustomerController@delete');

//Sales
Route::get('manager/sales','SalesController@sales');
Route::delete('manager/sales/{id}','SalesController@delete');
Route::get('manager/sale','SalesController@add');
Route::post('manager/sale','SalesController@create');
Route::get('manager/sales/{id}','SalesController@edit');
Route::put('manager/sale','SalesController@update');
Route::get('manager/sale/products','SalesController@availableProducts');

// Wishlists
Route::get('profile/wishlist', 'CustomerController@wishlist');
Route::put('profile/wishlist/{id}', 'CustomerController@addProductToWishlist');
Route::delete('profile/wishlist/{id}', 'CustomerController@removeProductFromWishlist');

//Reviews
Route::post('review', 'ReviewController@addReview');


// Statistics
Route::post('statistics', 'StatisticsController@statistics');

//Checkout
Route::post('confirm-order', 'CheckoutController@confirmCart');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('password-recovery', 'Auth\LoginController@passwordRecovery');
Route::post('password-recovery', 'Auth\LoginController@recoverPassword');
Route::get('change-password', 'Auth\LoginController@passwordChange');
Route::post('change-password', 'Auth\LoginController@changePassword');

