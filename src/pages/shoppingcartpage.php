<?php
include_once('../components/footer.php');
include_once('../components/header.php');






make_header([], ["../styles/shoppingcartpage.css"]); ?>
<div class="container-md ">
  <div class="row justify-content-center">
    <div class="col-sm">
      <h1 class="text-center">Shopping Cart</h1>
    </div>
  </div>
  <!--  -->
  <div class="row justify-content-center border-bottom shopCartEntry">
    <div class="col-sm-1 align-middle">
      <img src="../assets/vaso.png" alt="" class="shopCartProduct-image">
    </div>
    <div class="col-sm-3 align-self-center shopCartProduct-name">
      <p class="mb-0">Vaso CRTF</p>
    </div>
    <div class="col-1 align-self-center shopCartProduct-per-price">
      <p class="mb-0 text-right">20€</p>
    </div>
    <div class="col-sm-3 text-center align-self-center shopCartProduct-stock">
      <a href="" class="stock-minus"><i class="fas fa-minus"></i></a>
      <span class="ml-2 mr-2">10</span>
      <a href="" class="stock-plus"><i class="fas fa-plus"></i></a>
    </div>
    <div class="col-1 align-self-center">
      <a href="" class="shopCartProduct-trash"><i class=" fas fa-trash"></i></a>
    </div>
    <div class="col-1 align-self-center shopCartProduct-total">
      <p class="mb-0 text-right">199.90€</p>
    </div>
  </div>
  <!--  -->
  <div class="row justify-content-center border-bottom shopCartEntry">
    <div class="col-sm-1 align-middle">
      <img src="../assets/vaso.png" alt="" class="shopCartProduct-image">
    </div>
    <div class="col-sm-3 align-self-center shopCartProduct-name">
      <p class="mb-0">Vaso CRTF</p>
    </div>
    <div class="col-sm-1 align-self-center shopCartProduct-per-price">
      <p class="mb-0 text-right">20€</p>
    </div>
    <div class="col-sm-3 text-center align-self-center shopCartProduct-stock">
      <a href="" class="stock-minus"><i class="fas fa-minus"></i></a>
      <span class="ml-2 mr-2">10</span>
      <a href="" class="stock-plus"><i class="fas fa-plus"></i></a>
    </div>
    <div class="col-sm-1 align-self-center">
      <a href="" class="shopCartProduct-trash"><i class=" fas fa-trash"></i></a>
    </div>
    <div class="col-sm-1 align-self-center shopCartProduct-total">
      <p class="mb-0 text-right">199.90€</p>
    </div>
  </div>
  <!--  -->
  <div class="row justify-content-center shopCart-total">
    <div class="col-9 align-self-center text-right">
      <h4 class="shopCart-totaltext" >Total Value:</h4>
    </div>
    <div class="col-1 align-self-center">
      <h5 class="text-center">400.00€</h5>
    </div>
  </div>
</div>

<?php
make_footer();
?>