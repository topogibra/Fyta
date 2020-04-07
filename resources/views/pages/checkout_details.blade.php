@extends('layouts.app', ['scripts' => [], 'styles' => ['css/order_summary.css', 'css/payment_method.css','css/checkoutprogress.css']])

@section('content')
    @include('components.checkout_progress', ['number' => 3])
    @include('components.order_details',  ['order_number' => $order_number, 'date' => $date, 'name' => $name, 'address' => $address, 'location' => $location, 'sum' => $sum, 'delivery'=> $delivery ,'items' => $items, 'buttons' => True])
@endsection