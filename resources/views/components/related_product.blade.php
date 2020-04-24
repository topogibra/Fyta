<article class="col-md-4 col-sm-12">
    <div class="card align-items-center">
        <a href="/product/{{ $item->id }}">
            <img class="border border-dark" src={{asset("img/$item->img")}} alt={{ "$item->description" }}>
        </a>
        <div class="card-body row">
            <a href="/product/{{ $item->id }}">
                <h4 class="card-title col">{{$item->name}}</h4>
            </a>
            <p class="card-text">{{$item->price}}€</p>
        </div>
    </div>
</article>