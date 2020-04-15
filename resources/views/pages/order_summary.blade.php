@extends('layouts.app', ['scripts' => ['js/checkout.js'], 'styles' => ['css/orderdetails.css', 'css/checkoutprogress.css']])

@section('content')
    @include('components.checkout_progress', ['number' => 1])
    <div class="form">
            <h3>Order Details</h3>
        <form action="/checkout-details" method="POST">
            @csrf

            <div class="form-group">
                <input type="text" class="form-control" id="deliveryaddress" name="delivery" placeholder="Delivery Address">
            </div>
            <h6>Billing Address </h6>

            <div class="checkbox">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="addresses" id="checkout" value="same">
                    <label class="form-check-label"  for="sameradio">Different Billing Address </label>
                </div>
            </div>


            <div class="form-group">
                <input type="text" class="form-control" id="billingaddress" name="billing" placeholder="Billing Address">
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="d-flex flex-row-reverse">
                <button type="submit" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Next</button>
            </div>
        </form>
    </div
@endsection