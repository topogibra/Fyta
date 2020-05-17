<div class="card product border-0 col-lg-3 col-md-6 col-sm-6">
    <div class="img-wrapper">
        <a href="/product/{{ $item->id }}">
            <img class="card-img-top product-image img-fluid border" src={{asset("img/$item->img")}} alt={!! $item->alt !!}>
        </a>
    </div>
    <div class="card-body text-center">
        <a href="/product/{{ $item->id }}">
            <h5 class="card-title product-name text-dark">{{ $item->name }}</h5>
        </a>
        @if( $item->sale_price == -1)
            <p class="card-text product-price text-secondary">{{ $item->price }}€</p>
        @else
            <div id="price-wrapper" class="product-price row justify-content-center">
                <p class="card-text text-danger px-1"><s>{{ $item->price }}€</s></p>
                <p class="card-text text-secondary px-1">{{ $item->sale_price }}€</p>
            </div>
        @endif
    </div>
</div>