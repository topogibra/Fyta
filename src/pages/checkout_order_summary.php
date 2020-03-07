<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/payment_method.php');
    include_once('../components/order_summary.php');

    make_header([], ['../styles/order_summary.css','../styles/payment_method.css']);
    order_summary();
    make_footer();
?>