<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header(['../js/product_page.js'], ['../styles/product_page.css']);
?>

<section class="container-fluid">
    <div class="row product-section">
        <div class="col-md">
            <img class="border w-100 h-100" src="../assets/bonsai.jpg">
        </div>
        <div class="col-md">
            <div class="container-fluid title">
                <div class="row align-items ">
                    <h3 class="col-xs-1-12">
                        Bonsai CRT
                    </h3>
                    <span class="col-xs-1-12 review">
                        <h6>4.8</h6>
                        <i class="far fa-star"></i>
                    </span>
                    <span class="col-md-3 view-reviews">
                        <a href="#reviews">View Reviews</a>
                    </span>

                </div>
                <div class="row price">
                    35€
                </div>
                <div id="description" class="row">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non sodales quam. Etiam venenatis est ex, id gravida nulla hendrerit sit amet. Quisque vel nibh.
                    </p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-1-12 pr-3">
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="numItems" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                1
                            </a>
                            <div class="dropdown-menu" aria-labelledby="numItems">
                                <a class="dropdown-item" href="#">1</a>
                                <a class="dropdown-item" href="#">2</a>
                                <a class="dropdown-item" href="#">3</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1-12 pr-3" id="purchase-buttons">
                        <a name="" id="" class="btn btn-success pr-3" href="#" role="button">
                            Add To Basket
                        </a>
                        <a name="" id="" class="btn btn-outline-success pr-3" href="#" role="button">
                            Buy now
                        </a>
                    </div>
                    <div class="col-lg-1-12 pr-3" id="favorites-add">
                        <i class="far fa-star"></i>
                        <span>Add to Favourites</span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row product-section">
        <h3>
            Related Products
        </h3>
        <div class="row related-products">
            <article class="col-md-4 col-sm-4">
                <div class="card">
                    <img class="card-img-top border border-dark" src="../assets/bonsai.jpg" alt="">
                    <div class="card-body row">
                        <h4 class="card-title col">Bonsai CRT</h4>
                        <p class="card-text">35€</p>
                    </div>
                </div>
            </article>
            <article class="col-md-4 col-sm-4">
                <div class="card">
                    <img class="card-img-top border border-dark" src="../assets/bonsai.jpg" alt="">
                    <div class="card-body row">
                        <h4 class="card-title col">Bonsai CRT</h4>
                        <p class="card-text">35€</p>
                    </div>
                </div>
            </article>
            <article class="col-md-4 col-sm-4">
                <div class="card">
                    <img class="card-img-top border border-dark" src="../assets/bonsai.jpg" alt="">
                    <div class="card-body row">
                        <h4 class="card-title col">Bonsai CRT</h4>
                        <p class="card-text">35€</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <div id="reviews" class="row product-section">
        <span class="row reviews-title justify-content-start">
            <h3 class="col-md-4">345 Reviews</h3>
            <div class="col-md-1 row">
                <i class=" fas fa-star"></i>
                <i class=" fas fa-star"></i>
                <i class=" fas fa-star"></i>
                <i class=" far fa-star"></i>
                <i class=" far fa-star"></i>
            </div>
        </span>
        <article class="row comment">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <img class="w-100 h-100 rounded-circle border border-light" src="../assets/person.jpg">
                    </div>
                    <div class="col-md-6 col-sm-9">
                        <p class="name">Mohammad Faruque</p>
                        <p class="date">2 days ago</p>
                        <div class="row review">
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col far fa-star"></i>
                            <i class="col far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="row">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non sodales quam. Etiam venenatis est ex, id gravida nulla hendrerit sit amet. Quisque vel nibh.
                </p>
            </div>
        </article>
        <article class="row comment">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <img class="w-100 h-100 rounded-circle border border-light" src="../assets/person.jpg">
                    </div>
                    <div class="col-md-6 col-sm-9">
                        <p class="name">Mohammad Faruque</p>
                        <p class="date">2 days ago</p>
                        <div class="row review">
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col far fa-star"></i>
                            <i class="col far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="row">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non sodales quam. Etiam venenatis est ex, id gravida nulla hendrerit sit amet. Quisque vel nibh.
                </p>
            </div>
        </article>
        <article class="row comment">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <img class="w-100 h-100 rounded-circle border border-light" src="../assets/person.jpg">
                    </div>
                    <div class="col-md-6 col-sm-9">
                        <p class="name">Mohammad Faruque</p>
                        <p class="date">2 days ago</p>
                        <div class="row review">
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col far fa-star"></i>
                            <i class="col far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="row">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non sodales quam. Etiam venenatis est ex, id gravida nulla hendrerit sit amet. Quisque vel nibh.
                </p>
            </div>
        </article>
    </div>
</section>
<?php
make_footer();
?>