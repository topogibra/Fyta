      <?php
      include_once('../components/footer.php');
      include_once('../components/header.php');

      make_header([], ["../styles/searchpage.css"]);
      ?>



      <div class="content">
        <div class="row justify-content-between">

          <div class="col-lg-2">

            <h5>Categories</h5>
            <ul class="list-group list-group-flush">

              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck2">
                  <label class="custom-control-label" for="customCheck2">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck3">
                  <label class="custom-control-label" for="customCheck3">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck4">
                  <label class="custom-control-label" for="customCheck4">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck5">
                  <label class="custom-control-label" for="customCheck5">custom checkbox</label>
                </div>
              </li>
            </ul>
            <h5>Size</h5>
            <ul class="list-group list-group-flush">

              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck2">
                  <label class="custom-control-label" for="customCheck2">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck3">
                  <label class="custom-control-label" for="customCheck3">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck4">
                  <label class="custom-control-label" for="customCheck4">custom checkbox</label>
                </div>
              </li>
              <li class="list-group-item">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck5">
                  <label class="custom-control-label" for="customCheck5">custom checkbox</label>
                </div>
              </li>
            </ul>
            <h5>Price Range</h5>
            <label for="customRange">4€ - 10€</label>
            <input type="range" class="custom-range" min="0" max="5" id="customRange2">

          </div>





          <div class="col-lg-8">
            <div class="row row-cols-1 row-cols-md-3">

              <?php
              $images = array("bomsai.jpg", "orquideas.jpg", "ramo.jpg", "vaso.jpg", "bomsai.jpg");
              foreach ($images as $image) : ?>
                <div class="col mb-4">
                  <div class="card">
                    <img class="card-img-top" src=<?= "../assets/" . $image ?> alt="Card image cap">
                    <div class="card-body">
                      <div class="row justify-content-between">
                        <h5 class="card-title">Alfyta Vase white</h5>
                        <i class="far fa-star"></i>
                      </div>
                      <p class="card-text">23.45€</p>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
          </div>
        </div>
      </div>







      <?php
      make_footer();
      ?>