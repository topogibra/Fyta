<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header([], ['../styles/profile_page.css']);
?>
<div class="container-fluid profile">
    <div class="row">
        <div class="col-md-9">
            <h3>Personal Information</h3>
            <div class="container orders">
                <div class="row header">
                    <div class="col-md-2">
                        Order #
                    </div>
                    <div class="col-md-2">
                        Purchase Date
                    </div>
                    <div class="col-md-2">
                        Amount
                    </div>
                    <div class="col-md-2">
                        Status
                    </div>
                    <div class="col-md-2">
                        Reorder
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-2 col-6 order">
                        125877
                    </div>
                    <div class="col-md-2 col-6 date">
                        Dec 24 2019
                    </div>
                    <div class="col-md-2 col-6 price">
                        23.45€
                    </div>
                    <div class="col-md-2 col-6 state">
                        Processed
                    </div>
                    <div class="col-md-2 col-6 re-order">
                        <i class="fas fa-plus-circle"></i>
                        <span>
                            23.45€
                        </span>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-2 col-sm-6 order">
                        125877
                    </div>
                    <div class="col-md-2 col-sm-6 date">
                        Dec 24 2019
                    </div>
                    <div class="col-md-2 col-sm-6 price">
                        23.45€
                    </div>
                    <div class="col-md-2 col-sm-6 state">
                        Processed
                    </div>
                    <div class="col-md-2 col-sm-6 re-order">
                        <i class="fas fa-plus-circle"></i>
                        <span>
                            23.45€
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 account-sections">
            <h3>My Account</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="#" class="badge badge-light">
                        Personal Information
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="badge badge-light">
                        My Wishlists
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="badge badge-light">
                        Orders History
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
make_footer();
?>