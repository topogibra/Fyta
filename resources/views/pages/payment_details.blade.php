@extends('layouts.app', ['scripts' => ['js/payment.js'], 'styles' => ['css/payment_method.css', 'css/checkoutprogress.css']])

@section('content')
    @include('components.checkout_progress', ['number' => 2])
    <div class="payment-method text-nowrap">
        <h3>Payment Method</h3>
        <div class="row options">
        <div class="col-6 payment {{ $payment === 'bank_transfer' ? 'active' :  '' }}">
                <div class="img-wrapper">
                    <img src={{asset("img/mb.png")}} alt="Payment by Bank Transfer" id="bank_transfer" class="payment-img img-fluid border">
                </div>
                <div class="name w-100 text-center"><span>Bank Transfer</span></div>
            </div>
            <div class="col-6 payment {{ $payment === 'stripe' ? 'active' :  '' }} disabled">
                <div class="img-wrapper ">
                    <img src={{asset("img/stripe.png")}} alt="Payment by Stripe" id="stripe" class="payment-img img-fluid border">
                </div>
                <div class="name text-center"><span>Stripe Payment</span></div>
            </div>
        </div>
        <form action="/confirm-order" method="post" id="payment-form">    
            @csrf
            <input type="hidden" id="deliveryaddress"  name="delivery" value="{{ $delivery }}">
            <input type="hidden" id="billingaddress"  name="billing" value="{{ $billing == null ? $delivery : $billing }}">
            <input type="hidden" id="payment-input" name="payment" value="{{ $payment === null ? "" : $payment}}">
            <div class="row buttons lg-content-between sm-space-around">
                <a role="button" href="/checkout-details" id="back-btn" class="btn rounded-0 btn-lg shadow-none">Back</a>
                <input type="submit" id="next-btn" class="btn rounded-0 btn-lg shadow-none" value="Next">
            </div>
        </form>
    </div>
@endsection