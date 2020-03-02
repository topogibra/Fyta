<?php 
    function carousel() { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel" class="carousel slide multi-item-carousel" >
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-xs-4"><a href="#1"><img src="../resources/images/orquideas.jpg" alt="First slide" class="img-responsive"></a></div>
                            </div>
                            <div class="item">
                                <div class="col-xs-4"><a href="#1"><img src="../resources/images/vaso.jpg" alt="Second slide" class="img-responsive"></a></div>
                            </div>
                            <div class="item">
                                <div class="col-xs-4"><a href="#1"><img src="../resources/images/bomsai2.jpg" alt="Third slide" class="img-responsive"></a></div>
                            </div>
                            <div class="item">
                                <div class="col-xs-4"><a href="#1"><img src="../resources/images/tulipas.jpg" alt="Third slide" class="img-responsive"></a></div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>