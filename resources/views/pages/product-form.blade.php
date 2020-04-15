@extends('layouts.product', ['content' => 'components.product-form', 'method' => 'POST', 'files' =>  ['scripts' => ['js/product_form.js'], 'styles' => ['css/product_page.css']]])

@section('img')
<div class="my-4">
    <label for="img">
        <img id="template-img" src={{asset('/img/user.png')}}>
    </label>
    <input type="file"  name="img" id="img">
</div>
@endsection

@section('header')
<div class="my-4">
    <h5> Name </h5>
    <input id="name" class="mt-4 d-block" name="name" type="text">
</div>
@endsection

@section('price')
<div class="row number-input">
    <div class="my-4">
        <h5> Price </h5>
        <input class="col" class="mt-2 d-block" name="price" id="price" type="number">
    </div>
</div>
<div class="row number-input">
    <div class="my-4">
        <h5> Stock </h5>
        <input class="col" class="mt-2 d-block" name="stock" id="stock" type="number">
    </div>
</div>
@endsection

@section('description')
<div class="my-4">
    <h5> Description </h5>
    <textarea id="description" class="mt-3" name="description" type="text" rows="5", cols="50">
    </textarea>
</div>
@endsection

@section('product-page-content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div>
    <button type="submit" class="btn btn-primary mx-auto d-block mt-5" > Submit </button>
</div>
@endsection