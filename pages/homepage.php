<?php
    include_once('../components/footer.php');
    include_once('../components/header.php');
    include_once('../components/carousel.php');

    make_header();
    ?>
    <div id="main-banner" class="container">
        <h1>Fytá</h1>
        <img src="../resources/images/plantas-interior-1.jpg" alt="banner background" id="banner-bg">
    </div>
        <h2>Best Sellers</h2>
<?php 
    carousel();
    make_footer();
?>