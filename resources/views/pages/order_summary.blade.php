@extends('layouts.app', ['scripts' => ['js/checkout.js'], 'styles' => ['css/orderdetails.css', 'css/checkoutprogress.css']])

@section('content')
    @include('components.checkout_progress', ['number' => 1])
    <div class="form">
            <h3>Order Details</h3>
        <form>
            <div class="form-group">
                <input type="text" class="form-control" id="checkoutemail" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="checkoutname" placeholder="Full Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="deliveryaddress" placeholder="Delivery Address">
            </div>
            <h6>Billing Address </h6>

            <div class="checkbox">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="addresses" id="checkout" value="same">
                    <label class="form-check-label" for="sameradio">Different Billing Address </label>
                </div>
            </div>


            <div class="form-group">
                <input type="text" class="form-control" id="billingaddress" placeholder="Billing Address">
            </div>
            <div class="d-flex flex-row-reverse">
                <a href="/payment-details" type="button" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Next</a>
            </div>
        </form>
    </div
@endsection