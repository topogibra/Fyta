<?php
    function payment_details() { ?>
        <div class="payment-details container-fluid">
            <h3>Payment Details</h3>
            <div class="row options">
                <a href="#mb" class="col-6">
                    <div class="img-wrapper border">
                        <img src="../assets/mb.png" alt="mb" class="payment-img img-fluid">
                    </div>
                    <div class="name w-100 text-center">Bank Transfer</div>
                </a>
                <a href="#stripe" class="col-6">
                    <div class="img-wrapper border">
                        <img src="../assets/stripe.png" alt="stripe" class="payment-img img-fluid">
                    </div>
                    <div class="name text-center">Stripe Payment</div>
                </a>
            </div>
            <div class="row buttons lg-content-between sm-space-around">
                <button type="button" id="back-btn" class="btn rounded-0 btn-lg">Back</button>
                <button type="button" id="next-btn" class="btn rounded-0 btn-lg">Next</button>
            </div>
        </div>
<?php } ?>