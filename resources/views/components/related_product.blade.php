<article class="col-md-4 col-sm-12">
    <div class="card align-items-center">
        <a href="/profile/{{ $item['id'] }}">
        <img class="border border-dark" src={{asset($item['img'])}} alt={{ str_replace(' ', '', $item['name'])}}>
        </a>
        <div class="card-body row">
            <h4 class="card-title col">{{$item['name']}}</h4>
            <p class="card-text">{{$item['price']}}</p>
        </div>
    </div>
</article>