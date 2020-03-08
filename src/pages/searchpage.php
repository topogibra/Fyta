      <?php
      include_once('../components/footer.php');
      include_once('../components/header.php');

      make_header(["../javascript/searchpage.js"], ["../styles/searchpage.css", "../styles/pallette.css"]);
      ?>

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
            <?php
              $categories = array("Anthuriums","Artificial", "Bulbs", "Gardenias","Orchids");
              
              foreach ($categories as $category ) : ?>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1"><?= $category ?></label>
                </div>
              </li>
              <?php endforeach ?>
            </ul>
            <h5>Size</h5>
            <ul class="list-group list-group-flush">
            <?php
              $sizes = array("0kg-0.2kg","0.2kg-0.5kg", "0.5-1.5kg", "1.5kg-3kg",">3kg");
              
              foreach ($sizes as $size ) : ?>
         
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1"><?= $size ?></label>
                </div>
              </li>
              <?php endforeach ?>
            </ul>

            <div class="price">
              <h5>Price Range</h5>
              <label for="customRange">50€</label>
              <input type="range" class="custom-range" min="0" max="200" id="pricerange">
            </div>
          </div>

          <div class="col-lg-8">
            <div class="row row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-2">

              <?php
              $images = array("indoor_flower8.jpg", "orquideas.jpg", "indoor_flower6.jpeg", "indoor_flower3.jpg", "indoor_floer7.jpg");
              $titles = array("Red Anthurium", "Junior Phalaenopsis Orchid", "Pink Gardenia", "Red and Yellow Artificial Flowers", "Hyacinth Bulbs");
              $prices = array("30.24€", "15.54€", "36.14€", "6.99€", "20.99€");
              
              foreach ($images as $index => $image) : ?>
                <div class="col mb-4">
                  <div class="card">
                    <div class="img-wrapper">
                      <img class="card-img-top" src=<?= "../assets/" . $image ?> alt="Card image cap">
                    </div>
                    <div class="card-body">
                      <div class="row flex-nowrap justify-content-between">
                        <h5 class="card-title"><?= $titles[$index] ?></h5>
                        <i class="far fa-star" style="font-size: 1.5em;"></i>
                      </div>
                      <p class="card-text"><?= $prices[$index] ?></p>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>

            <div class="pages">
              <div class="row">
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>


            </div>
          </div>



        </div>



      </div>







      <?php
      make_footer();
      ?>