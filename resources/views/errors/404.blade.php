@extends('layouts.app', ['scripts' => [], 'styles' => ['css/error.css']])

@section('content')
<article>
    <div class="mx-auto mt-5">
        <img class="d-block mx-auto" src={{ asset('img/404.jpg') }}>
        <p class="text-center h6">We can't seem to find the page you are looking for</p>
    </div>
</article>
@endsection