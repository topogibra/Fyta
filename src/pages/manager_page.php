<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header(['../js/manager_page.js'], ['../styles/profile_page.css', '../styles/registerpage.css']);
?>
<div class="container-fluid profile">
    <div class="row">
        <div class="col-md-9">
            <h3>Stock</h3>
            <div class="container" id="managers">
                <div class="row">
                    <div>
                        <img src="../assets/mohammad-faruque-AgYOuy8kA7M-unsplash.jpg">
                    </div>
                    <div class="col description">
                        <h5>Simone Biles</h5>
                        <p>Added on Aug 17 2016</p>
                    </div>
                    <span class="delete-button">
                        <a class="btn btn-secondary" href="#" role="button">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3 mb-3 center">
                    <button class="btn btn-primary w-100 mt-3" id="add-manager" data-toggle="modal" data-target="#addManager" type="button">Add New Manager</button>
                </div>
                <div class="modal fade" id="addManager" tabindex="-1" role="dialog" aria-labelledby="addManagerLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addManagerLabel">Add New Manager</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
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