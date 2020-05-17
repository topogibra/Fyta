<article class="col-md-4 col-sm-10">
    <div class="card align-items-center">
        <a href="/product/{{ $item->id }}">
            <img class="border border-dark" src={{asset("img/$item->img")}} alt={{ "$item->description" }}>
        </a>
        <div class="card-body row">
            <a href="/product/{{ $item->id }}">
                <h4 class="card-title col">{{$item->name}}</h4>
            </a>
            @if($item->sale_price == -1)
            <p class="card-text">{{$item->price}}€</p>
            @else
            <div class="row card-text">
                <p class="px-1 text-danger"><s>{{ $item->price }}€</s></p>
                <p class="px-1">{{ $item->sale_price }}€</p>
            </div>
            @endif
        </div>
    </div>
</article>