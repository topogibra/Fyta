<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/payment_method.php');

    make_header([], ['../styles/checkout.css','../styles/homepage.css']);
    payment_method();
    make_footer();
?>