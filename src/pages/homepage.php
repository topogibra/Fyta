<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/banner_card.php');
    include_once('../components/top_sold.php');

    make_header([], ['../styles/homepage.css']);
    banner();
    top_deals();
    top_indoor();
    top_outdoor();
    top_vases();
    top_tools();
    make_footer();
?>