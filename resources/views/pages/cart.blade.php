@extends('layouts.app', ['scripts' => [], 'styles' => ['css/shopping_cart_page.css']])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm">
        <h1 class="text-center">Shopping Cart</h1>
        </div>
    </div>
    @each('components.shopping_item', $items, 'item')
    <div class="row justify-content-end" id="checkout">
        <div class="col-sm-3">
            <a type="role" href="/checkout-details" class="btn rounded-0 btn-lg shadow-none" id="checkout_btn" type="submit">Checkout</a>
        </div>
    </div>

@endsection