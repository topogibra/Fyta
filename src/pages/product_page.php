<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header(['../js/product_page.js'], ['../styles/product_page.css']);
?>

<section class="container">
    <div class="row product-section">
        <div class="col-md product-img ">
            <img class="border" src="../assets/bonsai.jpg">
        </div>
        <div class="col-md">
            <div class="container title">
                <div class="row justify-content-between ">
                    <h3 class="col-xs-1-12 col-5">
                        Bonsai CRT
                    </h3>
                    <span class="col-xs-1-12  review">
                        <h6>4.0</h6>
                        <i class="far fa-star"></i>
                    </span>
                    <span class="col-5  view-reviews">
                        <a href="#reviews">View Reviews</a>
                    </span>

                </div>
                <div class="row price">
                    35€
                </div>
                <div id="description" class="row">
                    <p>
                        Have you ever thought of tending a plant? 
                        Do you watch asian movies and feel like going into that rich culture? 
                        Now you can have a piece of that by ordering one of our premium Bonsai CRT, 
                        that will give your home a deep sense of oriental energy.
                    </p>
                </div>
                <div class="row ">
                    <div class="col-md-1-12 pr-3">
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle " href="#" role="button" id="numItems" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a name="" id="addbasket" class="btn btn-success pr-3 " href="shopping_cart_page.php" role="button">
                            Add To Basket
                        </a>
                        <a name="" id="buynow" class="btn btn-light pr-3 " href="checkout_order_details.php" role="button">
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
    <h3>
        Related Products
    </h3>
    <div class="row product-section">
        <div class="row related-products justify-content-center">
            <article class="col-md-4 col-sm-12">
                <div class="card align-items-center">
                    <img class="card-img-top border border-dark" src="../assets/supreme_vase.jpg" alt="Supreme Bonsai Pot">
                    <div class="card-body row">
                        <h4 class="card-title col">Supreme Bonsai Pot</h4>
                        <p class="card-text">40€</p>
                    </div>
                </div>
            </article>
            <article class="col-md-4 col-sm-12">
                <div class="card align-items-center">
                    <img class="card-img-top border border-dark" src="../assets/gloves_tool.jpg" alt="Blue Garden Gloves">
                    <div class="card-body row">
                        <h4 class="card-title col">Blue Garden Gloves</h4>
                        <p class="card-text">9€</p>
                    </div>
                </div>
            </article>
            <article class="col-md-4 col-sm-12">
                <div class="card align-items-center">
                    <img class="card-img-top border border-dark " src="../assets/pondlilies_outdoor.jpg" alt="Pond White Lilies">
                    <div class="card-body row">
                        <h4 class="card-title col">Pond White Lilies</h4>
                        <p class="card-text">40€</p>
                    </div>
                </div>
            </article>
            
        </div>
    </div>
    <div id="reviews" class="row product-section">
        <span class="row reviews-title">
            <h3>345 Reviews</h3>
            <div class="stars">
                <i class=" fas fa-star"></i>
                <i class=" fas fa-star"></i>
                <i class=" fas fa-star"></i>
                <i class=" fas fa-star"></i>
                <i class=" far fa-star"></i>
            </div>
        </span>
        <article class="row comment">
            <div class="container w-100">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <img class="w-100 h-100 rounded-circle border border-light" src="../assets/frederique_cousteau.jpg">
                    </div>
                    <div class="col-md-6 col-sm-9">
                        <p class="name">Frederique Cousteau</p>
                        <p class="date">2 days ago</p>
                        <div class="row review">
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col far fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="row">
                    This is a bonsai alright, but the premium bit makes me twitch my nose. It's not that high quality, but good for beginners.
                </p>
            </div>
        </article>
        <article class="row comment">
            <div class="container w-100">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <img class="w-100 h-100 rounded-circle border border-light" src="../assets/josh_miller.jpg">
                    </div>
                    <div class="col-md-6 col-sm-9">
                        <p class="name">Josh Miller</p>
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
                    I like this bonsai, but this is expensive! I'll never pay off my student loans at this rate... #stayoffwifiwhenhigh
                </p>
            </div>
        </article>
        <article class="row comment">
            <div class="container w-100">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <img class="w-100 h-100 rounded-circle border border-light" src="../assets/kelly_mahagan.jpg">
                    </div>
                    <div class="col-md-6 col-sm-9">
                        <p class="name">Kelly Mahagan</p>
                        <p class="date">2 days ago</p>
                        <div class="row review">
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                            <i class="col fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="row">
                    OMG, this bonsai is so F.A.B.U.L.O.U.S.! My dad thought this was a scam, but i totally convinced him to buy it and I couldn't love this more. Love you too daddy xoxo
                </p>
            </div>
        </article>
    </div>
</section>
<?php
make_footer();
?>