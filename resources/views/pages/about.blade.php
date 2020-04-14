@extends('layouts.app', ['scripts' => [], 'styles' => ['css/aboutus.css']])

@section('content')
<div class="aboutus">
    <h1 class="text-center"> Fytá </h1>

    <div class="abouttext">
        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-10">
                <p class="text-center">Plants are an evergrowing market that is stuck in the past: shops are still mostly tied to a physical stand, something that users are beginning to disfavor. It is our goal to give a new and better option to plant lovers, to give them a platform where they can buy and obtain more information regarding the plants they love the most, as well as recommend new plants that might be to their liking.</p>
            </div>
        </div>
    </div>

    <div class="d-flex flex-row flex-wrap cards justify-content-center">
        <div class="card" style="width: 18rem;">
            <i class="fas fa-globe"></i>
            <div class="card-body">
                <h5 class="card-title">Worldwide Shipping</h5>
                <p class="card-text text-center"> Getting you desert roses from the Sahara to all the way to Los Angeles, there is no place we won't go to get you that plant that you really crave for</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <i class="fas fa-award"></i>
            <div class="card-body">
                <h5 class="card-title">Quality Certified</h5>
                <p class="card-text  text-center"> Not only our customers rate us as the top, we are recognized by the GreenPlants Magazine as the Best Gardening Seller of 2020</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <i class="fas fa-seedling"></i>
            <div class="card-body">
                <h5 class="card-title">Green Always</h5>
                <p class="card-text  text-center">We make that our plants get the care they deserve and every product we use is eco-friendly</p>
            </div>
        </div>
    </div>
</div>
@endsection