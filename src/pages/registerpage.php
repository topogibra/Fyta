<?php
include_once('../components/footer.php');
include_once('../components/header.php');

make_header([], ["../styles/registerpage.css"]); ?>
<div class="container-xl">
  <form action="" class=".form-inline">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <h1 class="text-center form-title">Register</h1>
      </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
      <img src="../assets/user.png" class="mx-auto d-block img-fluid rounded-circle border border-dark rounded" alt="User Image" id="registerUserImg">

    </div>
    <!-- -->
    <div class="row form-group justify-content-center">
      <div class="col-sm-6">
        <input type="text" name="registerUsername" id="registerUsername" class="form-control registerinput" placeholder="Username" aria-describedby="helpUser">
        <label for="registerPassword"></label>
        <input type="email" name="registerEmail" id="registerEmail" class="form-control registerinput" placeholder="Email" aria-describedby="helpId">
        <label for="registerPassword"></label>
        <input type="text" name="registerAddress" id="registerAddress" class="form-control registerinput" placeholder="Address" aria-describedby="helpId">
      </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <h4 id="registerBirthday">Birthday</h4>
      </div>
    </div>
    <!--  -->
    <div class="row form-group justify-content-center registerBirthday">
      <div class="col-sm-2 ">
        <select class="custom-select custom-select-sm registerinput registerSelect" name="registerDay" id="registerDay">
          <option selected class="text-muted optionplaceholder" hidden>Day</option>
          <option value="">1</option>
          <option value="">2</option>
          <option value="">3</option>
        </select>
      </div>
      <div class="col-sm-2 ">
        <select class="custom-select custom-select-sm registerinput registerSelect" name="registerMonth" id="registerMonth">
          <option selected class="text-muted optionplaceholder" hidden>Month</option>
          <option value="">January</option>
          <option value="">February</option>
          <option value="">December</option>
        </select>
      </div>
      <div class="col-sm-2 ">
        <select class="custom-select custom-select-sm registerinput registerSelect" name="registerYear" id="registerYear">
          <option selected class="text-muted optionplaceholder" hidden>Year</option>
          <option value="">1999</option>
          <option value="">2000</option>
          <option value="">2001</option>
        </select>
      </div>

    </div>
    <!--  -->
    <div class="form-group row justify-content-center">
      <div class="col-sm-6">
        <input type="password" name="registerPassword" id="registerPassword" class="form-control registerinput" placeholder="Password" aria-describedby="helpId">
      </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
      <div class="col-sm-6 ">
        <button type="submit" class="btn btn-primary col-sm-12" id="registerbutton">Register</button>
      </div>
    </div>
  </form>
</div>
<?php
make_footer();
?>