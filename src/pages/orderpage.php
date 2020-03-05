<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/payment_details.php');

    make_header([], ['../styles/orderpage.css','../styles/homepage.css']);
    payment_details();
    make_footer();
?>