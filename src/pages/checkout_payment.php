<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/payment_method.php');
    include_once('../components/order_summary.php');

    make_header([], ['../styles/checkout_payment.css']);
    payment_method();
    make_footer();
?>