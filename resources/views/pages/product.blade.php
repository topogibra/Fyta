@extends('layouts.app', ['scripts' => ['js/product_page.js'], 'styles' => ['css/product_page.css']])

@section('content')
<section class="container">
    <div class="row product-section">
        <div class="col-md product-img ">
            <img class="border" src={{asset($img)}}>
        </div>
        <div class="col-md">
            <div class="container title">
                <div class="row justify-content-between ">
                    <h3 class="col-xs-1-12 col-5">
                        {{$name}}
                    </h3>
                    <span class="col-xs-1-12  review">
                        <h6>$score</h6>
                        <i class="far fa-star"></i>
                    </span>
                    <span class="col-5  view-reviews">
                        <a href="#reviews">View Reviews</a>
                    </span>

                </div>
                <div class="row price">
                    {{$price}}
                </div>
                <div id="description" class="row">
                    <p>
                        {{$description}}
                    </p>
                </div>
                <div class="row ">
                    <div class="col-md-1-12 pr-3">
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle " href="#" role="button" id="numItems" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                1
                            </a>
                            <div class="dropdown-menu" aria-labelledby="numItems">
                                <a class="dropdown-item" href="#">1</a>
                                <a class="dropdown-item" href="#">2</a>
                                <a class="dropdown-item" href="#">3</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1-12 pr-3" id="purchase-buttons">
                        <a name="" id="addbasket" class="btn btn-success pr-3 " href="/cart" role="button">
                            Add To Basket
                        </a>
                        <a name="" id="buynow" class="btn btn-light pr-3 " href="/checkout-details" role="button">
                            Buy now
                        </a>
                    </div>
                    <div class="col-lg-1-12 pr-3" id="favorites-add">
                        <i class="far fa-star"></i>
                        <span>Add to Favourites</span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3>
        Related Products
    </h3>
    <div class="row product-section">
        <div class="row related-products justify-content-center">
            @each('components.related_product', $related, 'item')
        </div>
    </div>
    <div id="reviews" class="row product-section">
        <span class="row reviews-title">
            <h3>{{count($reviews)}} Reviews</h3>
            <div class="stars">
                @for ($i = 0; $i < $score; $i++)
                    <i class=" fas fa-star"></i>
                @endfor
                @for ($i = 0; $i < (5 - $score); $i++)
                    <i class=" far fa-star"></i>
                @endfor
            </div>
        </span>
        @each('components.reviews', $reviews, 'review')
</section>
@endsection
