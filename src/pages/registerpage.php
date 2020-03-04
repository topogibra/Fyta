<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header([], ["../styles/registerpage.css"]); ?>
<div class="container-xl">
  <form action="" class=".form-inline">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <h1 class="text-center">Register</h1>
      </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
      <img src="../assets/user.png" class="mx-auto d-block img-fluid rounded-circle" alt="User Image" id="registerUserImg">
    </div>
    <!-- -->
    <div class="row form-group justify-content-center">
      <div class="col-sm-6">
        <input type="text" name="registerUsername" id="registerUsername" class="form-control" placeholder="Username" aria-describedby="helpUser">
        <label for="registerPassword"></label>
        <input type="email" name="registerEmail" id="registerEmail" class="form-control" placeholder="Email" aria-describedby="helpId">
        <label for="registerPassword"></label>
        <input type="text" name="registerAddress" id="registerAddress" class="form-control" placeholder="Address" aria-describedby="helpId">
      </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <h4 id="registerBirthday">Birthday</h4>
      </div>
    </div>
    <!--  -->
    <div class="row form-group justify-content-center">
      <div class="col-sm-2">
        <input type="text" name="registerDay" id="registerDay" class="form-control" placeholder="Day" aria-describedby="helpId">
      </div>
      <div class="col-sm-2">
        <input type="text" name="registerMonth" id="registerMonth" class="form-control" placeholder="Month" aria-describedby="helpId">
      </div>
      <div class="col-sm-2">
        <input type="text" name="registerYear" id="registerYear" class="form-control" placeholder="Year" aria-describedby="helpId">
      </div>
    </div>
    <!--  -->
    <div class="form-group row justify-content-center">
      <div class="col-sm-6">
        <input type="password" name="registerPassword" id="registerPassword" class="form-control" placeholder="Password" aria-describedby="helpId">
      </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
      <div class="col-sm-6 ">
        <button type="submit" class="btn btn-primary col-sm-12">Register</button>
      </div>
    </div>
  </form>
</div>
<?php
make_footer();
?>