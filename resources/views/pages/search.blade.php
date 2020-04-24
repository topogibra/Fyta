@extends('layouts.app', ['scripts' => ['js/searchpage.js'], 'styles' => ['css/searchpage.css', 'css/pallette.css']])

@section('content')
    
      <div class="title">
        <div class="row">
          <div class="col">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Indoor Plants</a></li>
                <li class="breadcrumb-item active" aria-current="page">Flowering Plants</li>
              </ol>
            </nav>
          </div>
          <div class="col">

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Options
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">By Popularity</a>
                <a class="dropdown-item" href="#">By Price</a>
              </div>
            </div>

            <div class="searchbuttons">

              <div id="order">
                <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModalCenter">Order by
                  <i class="fas fa-chevron-down"></i>
                </button>

                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-body">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                          <label class="form-check-label" for="exampleRadios1">
                            By Price
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                          <label class="form-check-label" for="exampleRadios1">
                            By Popularity
                          </label>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div id="filter">
                <button type="button" class="btn btn-outline-dark">Filters
                  <i class="fas fa-chevron-down"></i>

                </button>
              </div>
            </div>

          </div>
        </div>
      </div>


      <div class="content">
        <div class="row justify-content-between">

          <div class="col-lg-3 ">

            <h5>Categories</h5>
            <ul class="list-group list-group-flush">
              @each('components.search_categories', $categories, 'category')
            </ul>
            <h5>Size</h5>
            <ul class="list-group list-group-flush">
                @each('components.search_sizes', $sizes, 'size')
            </ul>
            <div class="price">
              <h5>Price Range</h5>
              <div class="row price-values">
                <div class="col-5 min">
                  <p>1€ </p>
                </div>
                <div class="col-5 max">
                  <p>100€</p>
                </div>
              </div>
              <div class="row price-inputs">
                <div class="col-5 min-input">
                  <label for="min"></label>
                  <input type="number" class="form-control" id="min" placeholder="Min" min="1" max="99">
                </div>
                <div class="col-5 max-input">
                  <label for="max"> </label>
                  <input type="number" class="form-control" id="max" placeholder="Max" min="2" max="100">
                </div>
              </div>


            </div>
          </div>

          <div class="col-lg-8">
            <div class="row row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-2"> 
              @if (count($items) > 0)
                @each('components.search_items', $items, 'item')
              @else 
                <div class="alert row" id="errors">
                  <ul>                     
                    <li>No results found!</li>
                  </ul>
                </div>
              @endif
            </div>

          </div>



        </div>



      </div>
@endsection
