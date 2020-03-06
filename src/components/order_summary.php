<?php 
    function order_summary() { ?>
    <div class="order-summary container-fluid">
        <div class="row summary-header">
            <h3 class="col-6 text-nowrap">Order Summary</h3>
            <div class="order-status col-6 row justify-content-center ">
                <p class="font-weight-bold text-nowrap">Order Status:</p>
                <p class="status font-weight-normal">Processed</p>
            </div>
        </div>
        <div class="container summary">
            <div class="row header justify-space-around">
                <div class="col-md-5 col-sm-6 order-ref text-left">
                    <p class="order-id font-weight-bold text-nowrap">Order #125877</p>
                    <div class="order-placed row">
                        <p class="text-nowrap">Placed on:</p>
                        <p class="order-date font-weight-bold text-nowrap">Dec 24 2019</p> 

                    </div>
                </div>
                <div class="col-md-6 col-sm-6 deliver-address">
                    <p class="font-weight-bold ">Deliver to:</p>
                    <p class="order-recipient">Ellie Black</p>
                    <p class="order-address">Marcombe Dr NE, 334 3rd floor</p>
                    <p class="order-location ">Calgary, Canada</p>
                </div>
            </div>
            <div class="row order-list-item">
                <div class="col-md-3 col-xs-4">
                    <div class="img-wrapper">
                        <img class="product-image img-fluid border border-dark" src="../assets/vaso.jpg" alt="Vaso">
                    </div>
                </div>
                <div class="col-md-3 col-xs-2">
                    <p class="product-name">Vaso CRTF</p>
                </div>
                <div class="col-md-3 col-xs-2">
                    <p class="product-price">20€</p>
                </div>
                <div class="col-md-3 col-xs-4">
                    <div class="quantity-box">1</div>
                </div>
            </div>
            <div class="row order-list-item">
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img class="product-image img-fluid border border-dark" src="../assets/vaso.jpg" alt="Vaso">
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="product-name ">Vaso CRTF</p>
                </div>
                <div class="col-md-3">
                    <p class="product-price">20€</p>
                </div>
                <div class="col-md-3">
                    <div class="quantity-box">1</div>
                </div>
            </div>
            <div class="row order-list-item">
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img class="product-image img-fluid border border-dark" src="../assets/vaso.jpg" alt="Vaso">
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="product-name">Vaso CRTF</p>
                </div>
                <div class="col-md-3">
                    <p class="product-price">20€</p>
                </div>
                <div class="col-md-3">
                    <div class="quantity-box">1</div>
                </div>
            </div>
            <p class="delivery-fee">Delivery: FREE</p>
            <div class="order-total">
                <p class="total">Total Value:</p>
                <p class="total-value">60€</p>
            </div>
        </div>
        <div class="row buttons lg-content-between sm-space-around">
                <button type="button" id="back-btn" class="btn rounded-0 btn-lg shadow-none">Back</button>
                <button type="button" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Finish</button>
        </div>
    
    </div>
<?php } ?>