@extends('layouts.app', ['scripts' => [], 'styles' => ['css/order_summary.css']])

@section('content')
    @include('components.order_details',  ['order_number' => $order_number, 'date' => $date, 'name' => $name, 'address' => $address, 'location' => $location, 'sum' => $sum, 'delivery'=> $delivery ,'items' => $items, 'buttons' => False])
@endsection