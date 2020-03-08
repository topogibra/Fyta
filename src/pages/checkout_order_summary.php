<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/payment_method.php');
    include_once('../components/order_summary.php');
    include_once('../components/checkoutprogress.php');


    make_header([], ['../styles/order_summary.css','../styles/payment_method.css','../styles/checkoutprogress.css']);
    

make_checkoutprogress(3);?>
    <div class="order-summary container-fluid">
        <div class="row summary-header">
            <h3 class="col-6 text-nowrap">Order Summary</h3>
            <div class="order-status col-6 row justify-content-center ">
                <p class="font-weight-bold text-nowrap">Order Status:</p>
                <p class="status font-weight-normal">Processed</p>
            </div>
        </div>
<?php order_summary(); ?>
        <div class="row buttons lg-content-between sm-space-around">
                <button type="button" id="back-btn" class="btn rounded-0 btn-lg shadow-none">Back</button>
                <button type="button" id="next-btn" class="btn rounded-0 btn-lg shadow-none">Finish</button>
        </div>
    </div>
<?php    
    make_footer();
?>