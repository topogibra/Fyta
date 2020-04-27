@extends('layouts.product', ['content' => 'components.product-form', 'method' => $method, 'files' =>  ['scripts' => ['js/product_form.js'], 'styles' => ['css/product_page.css']]])

@section('img')
<div class="my-2" class="product-creation-left">
    <label for="img">
        <img id="template-img" src={{isset($img) ? asset("/img/$img") : asset('/img/template_img.png')}} alt="defaultImg">
    </label>
        <input type="file"  name="img" id="img">
</div>
@endsection

@section('header')

@endsection

@section('price')

@endsection

@section('description')
@endsection

@section('product-page-content')
<div class="container mx-auto" id="form-content">
    <div class="row">
        <div class="my-2">
            <h5> Name </h5>
            <label for="name">  </label>
            <input id="name" class="mt-2 d-block" name="name" type="text" value={!! $name ?? "" !!}>
            <input id="id" name="id" type="hidden" value={{ $id ?? -1}}> 
        </div>
    </div>
    
    <div class="row number-input">
        <div class="my-2 col-4">
            <h5> Price </h5>
            <label for="price"> </label>
            <input class="col" class="mt-1 d-block" name="price" id="price" type="number" step=".01" value={{ $price ?? 0}}>
        </div>
        <div class="my-2 col-4">
            <h5> Stock </h5>
            <label for="stock"> </label>
            <input class="col" class="mt-1 d-block" name="stock" id="stock" type="number" value={{ $stock ?? 0}}>
        </div>
        <div class="my-2 col-4">
            <h5>Category</h5>
            <select class="custom-select">
                @if (isset($category))
                    <option value={{ $category }}> {{ $category }} </option>
                @else
                    <option selected disabled></option>
                @endif
                @foreach ($categories as $item)
                    <option value={{ $item }}> {{ $item }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" id="tags-container">
        <div class="my-2">
            <h5>Tags</h5>
            <span class="badge badge-success" id="caption">Type a tag and press Enter to add it. Press a tag to remove it.</span>
            <div id="tags-row">
                @if (isset($tags))
                    @foreach ($tags as $tag)
                        <div class="badge badge-pill badge-light">
                            {{ $tag->name }}
                        </div>
                    @endforeach
                @endif
            </div>
            <label for="tags">  </label>
            <input id="tags" class="mt-2 d-block" name="tags" type="text">
        </div>
    </div>
    <div class="row">
        <div class="my-2 product-creation-left" id="create-product-description">
            <h5> Description </h5>
            <textarea id="description" class="mt-1" name="description" type="text" rows="5", cols="50">{{$description ?? ""}}</textarea>
        </div>
    </div>
    @include('components.errors')
    <div class="row" id="submit-button">
        <button type="submit" class="btn btn-primary mx-auto d-block mt-1" > Submit </button>
    </div>
</div>
@endsection