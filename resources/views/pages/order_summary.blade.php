@extends('layouts.app', ['scripts' => ['js/checkout.js'], 'styles' => ['css/orderdetails.css', 'css/checkoutprogress.css']])

@section('content')
    @include('components.checkout_progress', ['number' => 1])
    <div class="form">
            <h3>Order Details</h3>
        <form action="/checkout-details" method="POST">
            @csrf
            <fieldset>
            <div class="form-group">
                <label for="deliveryaddress"> Delivery Address </label>
                <input type="text" class="form-control" id="deliveryaddress"  name="delivery" value={!! $address !!} placeholder="Delivery Address">
            </div>
            <h6>Billing Address </h6>

            <div class="checkbox">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="addresses" id="checkout" value="same">
                    <label class="form-check-label"  for="checkout">Same Billing Address </label>
                </div>
            </div>
            

            <div class="form-group">
                <label for="billingaddress"> </label>
                <input type="text" class="form-control" id="billingaddress" name="billing" placeholder="Billing Address">
            </div>
            <fieldset>
            @include('components.errors')

            <div class="d-flex flex-row-reverse">
                <button type="submit" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Next</button>
            </div>
        </form>
    </div
@endsection