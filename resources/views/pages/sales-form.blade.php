@extends('layouts.product', ['content' => 'components.sales-form', 'method' => $method, 'files' =>  ['scripts' => ['js/sales_form.js'], 'styles' => ['css/product_page.css','css/sale_page.css','css/styles.css']]])

@section('sales-page-content')
<div class="container mx-auto" id="form-content">
    <h3>Sale</h3>
    <input type="hidden" name="sale-id" id="sale-id" value={{ $id ?? -1 }}>
    <div class="row number-input">
        <div class="col">
            <div class="col">
                <label for="begin">Begins at</label>
            </div>
            <div class="col">
                <input class="col" class="mt-1 d-block" name="begin" id="begin" type="date" value="{{ $begin ?? null}}" required>
            </div>
        </div>
        <div class="col ">
            <div class="col">
                <label for="end">Ends at</label>
            </div>
            <div class="col">
                <input class="col" class="mt-1 d-block" name="end" id="end" type="date" value="{{ $end ?? null}}" required>
            </div>
        </div>
    </div>

    <div class="row number-input">
        <div class=" col">
            <div class="col">
                    <label for="percentage">Percentage (%)</label>
            </div>
            <div class="col">
                <input class="col" class="mt-1 d-block" name="percentage" id="percentage" type="number" step="1" value={{ $percentage ?? 1}} min="1" max="99" required>
            </div>
        </div>
    </div>
    <div class="row" id="selProducts">
        <div class="my-2 col ">
            <fieldset id="products-sales" name="apply-products" class="col">
                <legend>Select a date range to view eligible products</legend>
            </fieldset>
                    <div id="after-dates">
                        <input type="text" id="search-available" placeholder="Search for a product...">
                        <ul id="products-list" class="list-group list-group-flush"> 
                        </ul>
                    </div>
            <input id="products" name="products" type="hidden">
        </div>
    </div>
    @include('components.errors')
    <div class="row" id="submit-button">
        <button type="submit" class="btn btn-primary mx-auto d-block mt-1" >Submit</button>
    </div>
</div>
@endsection