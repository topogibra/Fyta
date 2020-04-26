<div class="card product border-0 col-lg-3 col-md-6 col-sm-6">
    <div class="img-wrapper">
        <a href="/product/{{ $item->id }}">
            <img class="card-img-top product-image img-fluid border" src={{asset($item->img)}} alt={!! $item->alt !!}>
        </a>
    </div>
    <div class="card-body text-center">
        <a href="/product/{{ $item->id }}">
            <h5 class="card-title product-name text-dark">{{ $item->name }}</h5>
        </a>
        <p class="card-text product-price text-secondary">{{ $item->price }}€</p>
    </div>
</div>