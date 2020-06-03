@extends('layouts.product', ['content' => 'components.product-page', 'files' =>  ['scripts' => ['js/product_page.js','js/request.js','js/review.js'], 'styles' => ['css/product_page.css'], 'title' => $name]])

@section('img')
    <img class="border" src={{asset("img/$img")}} alt={!! $alt !!}>
@endsection

@section('header')
<h3 class="col-md-8 col-lg-8  ">
    {{$name}}
</h3>
<div class="col-md-4 col-lg-4 review">
    <div class="row ">
    <h6>{{$score}}</h6>
    <i class="far fa-star"></i>
    <a class="view-reviews" href="#reviews">View Reviews</a>
    </div>
</div>

@endsection

@section('price')
<div class="row price">
    @if($sale_price == -1)
         {{$price}}€
    @else
        <p class="text-danger px-1"><s>{{ $price }}€</s></p>
        <p class="px-1">{{ $sale_price }}€</p>
    @endif
</div>
@endsection

@section('description')
<p>
    {{$description}}
</p>
@endsection

@section('product-content')
    <div class="row ">
        @if (User::checkUser() != User::$MANAGER)
            <div class="col-md-1-12 pr-3">
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle " href="#"
                     id="numItems" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        1
                    </a>
                    <div class="dropdown-menu overflow-auto" aria-labelledby="numItems">
                        @for ($i = 1; $i <= $stock; $i++)  
                            <a class="dropdown-item" href="#">{{$i}}</a>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-md-1-12 pr-3" id="purchase-buttons">
                <a id="addbasket" class="btn btn-success pr-3 " href={{"/cart/$id"}} >
                    Add To Basket
                </a>
                <a id="buynow" class="btn btn-light pr-3 " href={{"buy/$id"}} >
                    Buy now
                </a>
            </div>
            <div class="col-lg-1-12 pr-3" id="favorites-add">
                @if (User::checkUser() == User::$CUSTOMER)
                    @if (User::isFavorited($id))
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @else
                    <i class="far fa-star"></i>
                @endif
                <span>Add to Favourites</span>
            </div>
            <div class="toast" id="myToast" role="alert" aria-live="assertive" aria-atomic="true"  >
                <div class="toast-body">
                    Product successfully added to shopping cart!
                </div>
            </div>
            <div class="toast" id="favoriteToast" role="alert" aria-live="assertive" aria-atomic="true"  >
                <div class="toast-body" >
                    Product added to Favorites!
                </div>
            </div>
        @else
        <div class="col-md-1-12 pr-3" id="purchase-buttons">
            <a name="" id="addbasket" class="btn btn-success pr-3 " href={{ "$id/edit" }} role="button">
                Edit Product
            </a>
        </div>
        @endif

</div>
@endsection

  


@section('product-page-content')
<div class="row related-section">
@if (count($related) > 0)
    <h3>
        Related Products
    </h3>
        <div class="row related-products justify-content-center">
            @each('components.related_product', $related, 'item')
        </div>
    </div>
@endif
<div id="reviews" class="row reviews">
    <div class="row reviews-title">
        <h3>{{count($reviews)}} Reviews</h3>
        <div class="stars">
            @for ($i = 0; $i < $score; $i++)
                <i class="fas fa-star"></i>
            @endfor
            @for ($i = 0; $i < (5 - $score); $i++)
                <i class="far fa-star"></i>
            @endfor
        </div>
    </div>
    @each('components.reviews', $reviews, 'review')
</div>
@endsection
