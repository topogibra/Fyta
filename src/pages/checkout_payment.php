<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/payment_method.php');
    include_once('../components/order_summary.php');
    include_once('../components/checkoutprogress.php');


    make_header([], ['../styles/payment_method.css', '../styles/checkoutprogress.css']);
    make_checkoutprogress(2);
    payment_method();
    make_footer();
?>