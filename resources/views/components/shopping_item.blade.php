<div class="row justify-content-center border-bottom shopCartEntry">
    <div class="col entry-img">
        <a href="/product/{{ $item->id }}">
        <img src={{asset("img/$item->img")}} alt={!!$item->alt!!} class="shopCartProduct-image">
    </a>
    </div>
    <div class="col-sm-10 row justify-space-around entry-info">
        <div class=" col-sm-4 col-6 align-self-center shopCartProduct-name">
            <a href="product/{{$item->id}}" class="name">{{$item->name}}</a>
        </div>
        <div class="col-sm-2 col-6 align-self-center shopCartProduct-per-price">
        <p class="mb-0 text-right">{{$item->price}}€</p>
        </div>
        <div class="col-sm-4 col-9 text-center align-self-center shopCartProduct-stock">
        <a href="cart/less/{{$item->id}}" class="stock-minus"><i class="fas fa-minus"></i></a>
        <span class="ml-2 mr-2">{{$item->quantity}}</span>
        <a href="cart/more/{{$item->id}}" class="stock-plus"><i class="fas fa-plus"></i></a>
        </div>
        <div class="col-sm-1 col-3 align-self-center shopCartProduct-delete">
        <a href="cart/{{$item->id}}" class="shopCartProduct-trash"><i class=" fas fa-trash"></i></a>
        </div>
        <div class="col-sm-1 col-6 align-self-center shopCartProduct-total">
        <p class="mb-0 text-right">{{($item->quantity * $item->price)}}€</p>
        </div>
    </div>
</div>