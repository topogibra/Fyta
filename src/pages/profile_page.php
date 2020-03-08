<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header(['../js/profile_page.js'], ['../styles/profile_page.css', '../styles/registerpage.css', '../styles/homepage.css']);
?>
<div class="container-fluid profile">
    <div class="row">
        <div class="col-md-9">
        </div>
        <div class="col-md-3 account-sections">
            <h3>My Account</h3>
            <ul class="list-group list-group-flush">
            </ul>
        </div>
    </div>
</div>
<?php
make_footer();
?>