@extends('layouts.app',['scripts' =>['js/shopping_cart.js'],'styles'=>['css/order_summary.css','css/payment_method.css','css/shopping_cart_page.css','css/checkoutprogress.css','css/confirm_cart.css']])


@section('content')
@include('components.checkout_progress',['number'=> 3])


<div class="container summary">
  <div class="row justify-content-center">
        <div class="col-sm">
          <h1 class="text-center">Confirm Order</h1>
        </div>
  </div>
  <div class="container order-details border-bottom">
    <div class="row payment-method">
      <p>Payment Method:  <span> {{ $paymentPretty }}</span></p>
    </div>
    <div class="row deliver-address text-wrap">
      <p>Delivery Address:  <span> {{ $delivery }}</span></p>
    </div>
    <div class="row billing-address ">
      <p class="text-wrap ">Billing Address:  <span> {{ $billing === null ? $delivery : $billing }}</span></p>
    </div>
  </div>
  @each('components.shopping_item', $items, 'item')
<div class="delivery-fee row justify-content-end">
  <p class="text-right">Delivery:</p>
  <p class="fee text-right">{{ $delivery_fee }} </p>
</div>
<div class="order-total row justify-content-end ">
  <span class="total text-right">Total Value: </span>
  <p class="total-value text-right" id="cart-total">{{ $sum }} €</p>
</div>
  
</div>
<form method="post">
    <div class="payment-method text-nowrap">
      <div class="row buttons lg-content-between sm-space-around">
        @csrf
        <input type="hidden" id="name"  name="name" value="johndoe">
        <input type="hidden" id="deliveryaddress"  name="delivery" value="{{ $delivery }}">
        <input type="hidden" id="billingaddress"  name="billing" value="{{ $billing == null ? $delivery : $billing }}">
        <input type="hidden" id="payment"  name="payment" value="{{ $payment }}">
        <input type="submit" formaction="/payment-details"  formmethod="post" id="back-btn" class="btn rounded-0 btn-lg shadow-none" value="Back">
        <input type="submit" formaction="/checkout-details" formmethod="post" id="next-btn" class="btn rounded-0 btn-lg shadow-none" value="Finish">
        </div>
      </div>
      
    </form>
    

@endsection