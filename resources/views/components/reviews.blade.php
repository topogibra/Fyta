<article class="row comment">
    <div class="container w-100">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <img class="w-100 h-100 rounded-circle border border-light" src={{asset($review->img)}}>
            </div>
            <div class="col-md-6 col-sm-9">
                <p class="name">{{$review->name}}</p>
                <p class="date">{{$review->date}}</p>
                <div class="row review">
                    @for ($i = 0; $i < $review->review; $i++)
                        <i class=" fas fa-star"></i>
                    @endfor
                    @for ($i = 0; $i < (5 - $review->review); $i++)
                        <i class=" far fa-star"></i>
                    @endfor
                </div>
            </div>
        </div>
        <p class="row">
            {{ $review->description }}
        </p>
    </div>
</article>