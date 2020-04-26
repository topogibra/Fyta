@extends('layouts.app', ['scripts' => [], 'styles' => ['css/homepage.css']])

@section('content')
    <div class="card bg-light border border-secondary rounded-0 text-white" id="main-banner">
        <div class="card-img-overlay d-flex justify-content-center">
            <p class="card-text text-center align-self-center ">Fytá</h5>
        </div>
    </div>
    <div class="top-sold">
        <h2 id="top-title-top"><a href="/search">Top Deals</a></h2>
        <div class="container-fluid">
            <div class="row">
                @each('components.homecard', $items['top-deals'], 'item')
            </div>
        </div>
    </div>
    <div class="top-sold">
        <h2 id="top-title-indoor"><a href="/search">Indoor Plants</a></h2>
        <div class="container-fluid">
            <div class="row">
                @each('components.homecard', $items['indoor-plants'], 'item')
            </div>
        </div>
    </div>
    <div class="top-sold">
        <h2 id="top-title-outdoor"><a href="/search">Outdoor Plants</a></h2>
        <div class="container-fluid">
            <div class="row">
                @each('components.homecard', $items['outdoor-plants'], 'item')
            </div>
        </div>
    </div>
    <div class="top-sold">
        <h2 id="top-title-vases"><a href="/search">Top Vases</a></h2>
        <div class="container-fluid">
            <div class="row">
                @each('components.homecard', $items['top-vases'], 'item')
            </div>
        </div>
    </div>
    <div class="top-sold">
        <h2 id="top-title-tools"><a href="/search">Top Tools</a></h2>
        <div class="container-fluid">
            <div class="row">
                @each('components.homecard', $items['top-tools'], 'item')
            </div>
        </div>
    </div>
@endsection