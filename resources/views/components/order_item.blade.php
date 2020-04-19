<div class="row order-list-item">
    <div class="col-md-3">
        <div class="img-wrapper">
            <a href="product_page.php">
                <img class="product-image img-fluid border border-dark" src={{ asset($item->img) }} alt={{ $item->name }} >
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <a href="product_page.php">
            <p class="product-name ">{{ $item->name }}</p>
        </a>
    </div>
    <div class="col-md-3">
        <p class="product-price">{{ $item->price }} €</p>
    </div>
    <div class="col-md-3">
        <div class="quantity-box">{{ $item->quantity }}</div>
    </div>
</div>