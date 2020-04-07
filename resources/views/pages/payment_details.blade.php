@extends('layouts.app', ['scripts' => [], 'styles' => ['css/payment_method.css', 'css/checkoutprogress.css']])

@section('content')
    @include('components.checkout_progress', ['number' => 2])
    <div class="payment-method text-nowrap">
        <h3>Payment Method</h3>
        <div class="row options">
            <a href="#mb" class="col-6">
                <div class="img-wrapper">
                    <img src={{asset("img/mb.png")}} alt="mb" class="payment-img img-fluid border">
                </div>
                <div class="name w-100 text-center">Bank Transfer</div>
            </a>
            <a href="#stripe" class="col-6">
                <div class="img-wrapper ">
                    <img src={{asset("img/stripe.png")}} alt="stripe" class="payment-img img-fluid border">
                </div>
                <div class="name text-center">Stripe Payment</div>
            </a>
        </div>
        <div class="row buttons lg-content-between sm-space-around">
            <a type="button" href="/checkout-details" id="back-btn" class="btn rounded-0 btn-lg shadow-none">Back</a>
            <a type="button" id="next-btn" href="/order-summary" class="btn rounded-0 btn-lg shadow-none">Next</a>
        </div>
    </div>
@endsection