@extends('layouts.product', ['content' => 'components.product-form', 'method' => 'POST', 'files' =>  ['scripts' => ['js/product_form.js'], 'styles' => ['css/product_page.css']]])

@section('img')
<div class="my-2" class="product-creation-left">
    <label for="img">
        <img id="template-img" src={{asset('/img/template_img.png')}}>
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
            <input id="name" class="mt-2 d-block" name="name" type="text">
        </div>
    </div>
    
    <div class="row number-input">
        <div class="my-2 col-4">
            <h5> Price </h5>
            <input class="col" class="mt-1 d-block" name="price" id="price" type="number" step=".01">
        </div>
        <div class="my-2 col-4">
            <h5> Stock </h5>
            <input class="col" class="mt-1 d-block" name="stock" id="stock" type="number">
        </div>
        <div class="my-2 col-4">
            <h5>Category</h5>
            <select class="custom-select">
                <option selected disabled></option>
                <option value="indoor">indoor</option>
                <option value="outdoor">outdoor</option>
                <option value="vases">vases</option>
                <option value="tools">tools</option>
            </select>
        </div>
    </div>
    <div class="row" id="tags-container">
        <div class="my-2">
            <h5>Tags</h5>
            <span class="badge badge-success" id="caption">Type a tag and press Enter to add it. Press a tag to remove it.</span>
            <div id="tags-row">
            </div>
            <input id="tags" class="mt-2 d-block" name="tags" type="text">
        </div>
    </div>
    <div class="row">
        <div class="my-2 product-creation-left" id="create-product-description">
            <h5> Description </h5>
            <textarea id="description" class="mt-1" name="description" type="text" rows="5", cols="50">
            </textarea>
        </div>
    </div>
    
    @if ($errors->any())
        <div class="alert row" id="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row" id="submit-button">
        <button type="submit" class="btn btn-primary mx-auto d-block mt-1" > Submit </button>
    </div>
</div>
@endsection