<article class="col-md-4 col-sm-12">
    <div class="card align-items-center">
        <img href="/profile/{{ $item['id'] }}"class="border border-dark" src={{asset($item['img'])}} alt={{$item['name']}}>
        <div class="card-body row">
            <h4 class="card-title col">{{$item['name']}}</h4>
            <p class="card-text">{{$item['price']}}</p>
        </div>
    </div>
</article>