<div class="col mb-4">
    <div class="card">
    <a href="/product" class="img-wrapper">
        <img class="card-img-top" src={{asset($item->img)}} alt={{$item->name}}>
    </a>
    <div class="card-body">
        <div class="row flex-nowrap justify-content-between">
        <h5 class="card-title">
            <a href="/product">
            {{$item->name}}
            </a>
        </h5>
        <i class="far fa-star" style="font-size: 1.5em;"></i>
        </div>
        <p class="card-text">{{$item->price}} €</p>
    </div>
    </div>
</div>