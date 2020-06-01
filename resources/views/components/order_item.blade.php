<div class="row order-list-item">
    <div class="col-md-3 col-sm-3">
        <div class="img-wrapper">
            <a href={{"/product/$item->id_product"}}>
                <img class="product-image img-fluid border border-dark" src={{ asset("img/$item->img") }} alt={!! $item->alt !!} >
            </a>
        </div>
    </div>
    <div class="col-md-5  col-sm-5 name">
        <a href="{{"/product/$item->id_product"}}">
            <p class="product-name ">{{ $item->name }}</p>
        </a>
    </div>
    <div class="col-md-2 col-sm-2">
        <p class="product-price">{{ $item->price }} €</p>
    </div>
    <div class="col-md-2  col-sm-2 units">
        <div class="quantity-box">{{ $item->quantity }} uni</div>
    </div>
</div>