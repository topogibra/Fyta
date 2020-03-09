<?php
function order_summary()
{ ?>
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
                    <a href="product_page.php">
                        <img class="product-image img-fluid border border-dark" src="../assets/sativa_indoor.jpg" alt="Sativa Prime">
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-xs-2">
                <a href="product_page.php">
                    <p class="product-name">Sativa Prime</p>
                </a>
            </div>
            <div class="col-md-3 col-xs-2">
                <p class="product-price">12.60€</p>
            </div>
            <div class="col-md-3 col-xs-4">
                <div class="quantity-box">3</div>
            </div>
        </div>
        <div class="row order-list-item">
            <div class="col-md-3">
                <div class="img-wrapper">
                    <a href="product_page.php">
                        <img class="product-image img-fluid border border-dark" src="../assets/supreme_vase.jpg" alt="Supreme Bonsai Pot">
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <a href="product_page.php">
                    <p class="product-name ">Supreme Bonsai Pot</p>
                </a>
            </div>
            <div class="col-md-3">
                <p class="product-price">40€</p>
            </div>
            <div class="col-md-3">
                <div class="quantity-box">1</div>
            </div>
        </div>
        <div class="row order-list-item">
            <div class="col-md-3">
                <div class="img-wrapper">
                    <a href="product_page.php">
                        <img class="product-image img-fluid border border-dark" src="../assets/watercan_tool.jpg" alt="Green Watercan 12l">
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <a href="product_page.php">
                    <p class="product-name">Green Watercan 12l</p>
                </a>
            </div>
            <div class="col-md-3">
                <p class="product-price">5€</p>
            </div>
            <div class="col-md-3">
                <div class="quantity-box">1</div>
            </div>
        </div>
        <div class="delivery-fee row justify-content-end">
            <p class="text-right">Delivery:</p>
            <p class="fee text-right">FREE</p>
        </div>
        <div class="order-total row justify-content-end ">
            <p class="total text-right">Total Value:</p>
            <p class="total-value text-right">47.60€</p>
        </div>
    </div>
<?php } ?>