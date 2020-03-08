<?php
function orderdetails()
{ ?>

    <h3>Order Details</h3>
    <div class="form">
        <form>
            <div class="form-group">
                <input type="text" class="form-control" id="checkoutemail" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="checkoutname" placeholder="Full Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="deliveryaddress" placeholder="Delivery Address">
            </div>
            <h6>Billing Address </h6>

            <div class="radios">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="addresses" id="sameradio" value="same">
                    <label class="form-check-label" for="sameradio">Same as delivery</label>
                </div>
                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="addresses" id="differentradio" value="different">
                    <label class="form-check-label" for="differentradio">Different from delivery address</label>
                </div>
            </div>


            <div class="form-group">
                <input type="text" class="form-control" id="billingaddress" placeholder="Billing Address">
            </div>
            <div class="d-flex flex-row-reverse">
                <button type="button" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Next</button>
            </div>
        </form>
    </div>
<?php } ?>