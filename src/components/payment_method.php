<?php
    function payment_method() { ?>
        <div class="payment-method container-fluid text-nowrap">
            <h3>Payment Method</h3>
            <div class="row options">
                <a href="#mb" class="col-6">
                    <div class="img-wrapper">
                        <img src="../assets/mb.png" alt="mb" class="payment-img img-fluid border">
                    </div>
                    <div class="name w-100 text-center">Bank Transfer</div>
                </a>
                <a href="#stripe" class="col-6">
                    <div class="img-wrapper ">
                        <img src="../assets/stripe.png" alt="stripe" class="payment-img img-fluid border">
                    </div>
                    <div class="name text-center">Stripe Payment</div>
                </a>
            </div>
            <div class="row buttons lg-content-between sm-space-around">
                <button type="button" id="back-btn" class="btn rounded-0 btn-lg shadow-none">Back</button>
                <button type="button" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Finish</button>
            </div>
        </div>
<?php } ?>