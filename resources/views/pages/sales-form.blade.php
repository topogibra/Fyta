@extends('layouts.product', ['content' => 'components.sales-form', 'method' => $method, 'files' =>  ['scripts' => ['js/sales_form.js'], 'styles' => ['css/product_page.css','css/styles.css','css/searchpage.css','css/sale_page.css']]])

@section('sales-page-content')
<div class="container justify-content-center" id="form-content">
    <h3>Sale</h3>

    <input type="hidden" name="sale-id" id="sale-id" value={{ $id ?? -1 }}>
    <div class="row">
        <div class="col">
            <div class="col">
                <label for="begin">Begins at</label>
            </div>
            <div class="col">
                <input class="col" class="mt-1 d-block" name="begin" id="begin" type="date" value="{{ $begin ?? null}}" required>
            </div>
        </div>
        <div class="col">
            <div class="col">
                <label for="end">Ends at</label>
            </div>
            <div class="col">
                <input class="col" class="mt-1 d-block" name="end" id="end" type="date" value="{{ $end ?? null}}" required>
            </div>
        </div>
        <div class="col">
            <div class="col">
                <label for="percentage">Percentage (%)</label>
            </div>
            <div class="col">
                <input class="col" class="mt-1 d-block" name="percentage" id="percentage" type="number" step="1" value={{ $percentage ?? 1}} min="1" max="99" required>
            </div>
        </div>
    </div>
    <div class="row">
        <fieldset id="products-sales" name="apply-products" class="col">
            <h5 class="text-center" id="legend">Select a date range to view eligible products</h5>
        </fieldset>

    </div>
    <div class="row searchbuttons">
        @include('components.filterButton')
    </div>
    <div class="row" id="selProducts">
        <div id="after-dates" class="col ">  
            <div class="row">
                <div class="col-lg-4 categories-col">
                    @include('components.categories')
                </div>
                <div class="col">
                    <div class="row" id="miniSearch">
                        <div class="col">
                            <input type="text" id="search-available" placeholder="Search for a product...">
                        </div>
                        <div id="selectedCheckbox" class="col-offset-1 col-3 text-nowrap text-right ">
                            <label for="showSelected" id="showSelected-label">Show selected </label>
                            <input type="checkbox" name="showSelected" id="showSelected" checked="checked">
                        </div>
                    </div>         
                    <div class="row">
                        <div class="col">

                            <ul id="products-list" class="list-group list-group-flush"> 
                            </ul>
                        </div>
                    </div>           
                </div>
            </div>

            <input id="products" name="products" type="hidden">
        </div>
    </div>
    @include('components.errors')
    <div class="row" id="submit-button">
        <button type="button" class="btn btn-primary mx-auto d-block mt-1" >Submit</button>
    </div>
</div>
@endsection