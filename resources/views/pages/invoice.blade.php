@extends('layouts.app', ['scripts' => [], 'styles' => ['css/order_summary.css']])

@section('content')
    @include('components.order_details',  ['order_number' => $information->shipping_id, 'date' => $information->date, 'name' => $information->name, 'address' => $information->address,'billing' => $information->billing, 'sum' => $sum, 'delivery'=> $delivery ,'items' => $items, 'buttons' => False])
@endsection