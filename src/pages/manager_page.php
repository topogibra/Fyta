<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header(['../js/manager_page.js'], ['../styles/profile_page.css']);
?>
<div class="container-fluid profile">
    <div class="row">
        <div class="col-md-9">
            <h3>Stock</h3>
            <div class="container">
                <div class="row header">
                    <div class="col-md-3">
                        Product
                    </div>
                    <div class="col-md-3">
                        Price
                    </div>
                    <div class="col-md-3">
                        Stock
                    </div>
                    <div class="col-md-3">
                        Delete
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-6 name">
                        Orquidea PW
                    </div>
                    <div class="col-md-3 col-6 price">
                        20€
                    </div>
                    <div class="col-md-3 col-6 stock">
                        20
                    </div>
                    <div class="col-md-3 col-6 delete">
                        <i class="fas fa-trash"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-6 name">
                        Orquidea PW
                    </div>
                    <div class="col-md-3 col-6 price">
                        20€
                    </div>
                    <div class="col-md-3 col-6 stock">
                        20
                    </div>
                    <div class="col-md-3 col-6 delete">
                        <i class="fas fa-trash"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2 ml-auto pr-0">
                    <a class="btn btn-primary w-100 mt-3" href="#" role="button">Edit</a>
                </div>
            </div>
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