<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header([], ["../styles/shopping_cart_page.css"]); ?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-sm">
      <h1 class="text-center">Shopping Cart</h1>
    </div>
  </div>
  <!--  -->
  <div class="row justify-content-center border-bottom shopCartEntry">
    <div class="col-sm-2 entry-img">
      <img src="../assets/tulipas.jpg" alt="" class="shopCartProduct-image">
    </div>
    <div class="col-sm-9 row justify-content-center entry-info">
      <div class=" col-sm-3 col-6 align-self-center shopCartProduct-name">
        <p class="mb-0">Rose Orchid</p>
      </div>
      <div class="col-sm-2 col-6 align-self-center shopCartProduct-per-price">
        <p class="mb-0 text-right">20€</p>
      </div>
      <div class="col-sm-4 col-9 text-center align-self-center shopCartProduct-stock">
        <a href="" class="stock-minus"><i class="fas fa-minus"></i></a>
        <span class="ml-2 mr-2">10</span>
        <a href="" class="stock-plus"><i class="fas fa-plus"></i></a>
      </div>
      <div class="col-sm-1 col-3 align-self-center shopCartProduct-delete">
        <a href="" class="shopCartProduct-trash"><i class=" fas fa-trash"></i></a>
      </div>
      <div class="col-sm-2 col-6 align-self-center shopCartProduct-total">
        <p class="mb-0 text-right">200€</p>
      </div>
    </div>
  </div>
  <div class="row justify-content-center border-bottom shopCartEntry">
    <div class="col-sm-2 entry-img">
      <img src="../assets/sativa_indoor.jpg" alt="" class="shopCartProduct-image">
    </div>
    <div class="col-sm-9 row justify-content-center entry-info">
      <div class=" col-sm-3 col-6 align-self-center shopCartProduct-name">
        <p class="mb-0">Sativa Prime</p>
      </div>
      <div class="col-sm-2 col-6 align-self-center shopCartProduct-per-price">
        <p class="mb-0 text-right">4.20€</p>
      </div>
      <div class="col-sm-4 col-9 text-center align-self-center shopCartProduct-stock">
        <a href="" class="stock-minus"><i class="fas fa-minus"></i></a>
        <span class="ml-2 mr-2">10</span>
        <a href="" class="stock-plus"><i class="fas fa-plus"></i></a>
      </div>
      <div class="col-sm-1 col-3 align-self-center shopCartProduct-delete">
        <a href="" class="shopCartProduct-trash"><i class=" fas fa-trash"></i></a>
      </div>
      <div class="col-sm-2 col-6 align-self-center shopCartProduct-total">
        <p class="mb-0 text-right">42€</p>
      </div>
    </div>
  </div>
  <!--  -->
  <div class="row justify-content-center shopCart-total">
    <div class="col-sm-9 align-self-center text-right">
      <h4 class="shopCart-totaltext">Total Value:</h4>
    </div>
    <div class="col-sm-2 align-self-center">
      <h5 class="text-right">242€</h5>
    </div>
  </div>
  <div class="row" id="checkout">
    <a type="role" href="checkout_order_details.php" class="btn btn-primary ml-auto" type="submit">Checkout</a>
  </div>
</div>

<?php
make_footer();