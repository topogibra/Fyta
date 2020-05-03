@extends('layouts.app', ['scripts' => ['js/shopping_cart.js'], 'styles' => ['css/shopping_cart_page.css']])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm">
        <h1 class="text-center">Shopping Cart</h1>
        </div>
    </div>
    @each('components.shopping_item', $items, 'item')
    @if(count($items) != 0)
    <div class="row justify-content-end" id="checkout">
        <div class="col-sm-3">
            <a href="/cart/buy" class="btn rounded-0 btn-lg shadow-none" id="checkout_btn" >Checkout</a>
        </div>
    </div>
    @endif
    <div class="row justify-content-center" id="noproducts">
            <h5 class="text-center" >No products in cart!</h5>
    </div>

@endsection