<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/order_summary.php');

    make_header([], ['../styles/order_summary.css']); 
?>
    <div class="order-summary container-fluid">
        <div class="row summary-header">
            <h3 class="col-6 text-nowrap">Order 125877</h3>
            <div class="order-status col-6 row justify-content-center ">
                <p class="font-weight-bold text-nowrap">Order Status:</p>
                <p class="status font-weight-normal">Processed</p>
            </div>
        </div>
<?php 
    order_summary(); 
    make_footer();
?>