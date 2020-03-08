<?php
include_once('../components/footer.php');
include_once('../components/header.php');
include_once('../components/checkoutprogress.php');
include_once('../components/order_details.php');



make_header(["../js/checkout.js"], ["../styles/orderdetails.css","../styles/checkoutprogress.css"]);

make_checkoutprogress(1);

orderdetails();
make_footer();
?>