@extends('layouts.app', ['scripts' => [], 'styles' => ['css/error.css']])

@section('content')
<article>
    <div class="mx-auto mt-5">
        <img class="d-block mx-auto" src={{ asset('img/404.jpg') }}>
        <p class="text-center h6">
            @switch($status)
                @case(404)
                    We can't seem to find the page you are looking for
                    @break
                @case(400)
                    Some information didn't get to us, please try again later...
                    @break
                @case(401)
                    Please log in to see this information
                    @break
                @case(403)
                    You are not authorized to see this page
                    @break
                @default
                    An error has ocurred, please try again later
            @endswitch
        </p>
    </div>
</article>
@endsection