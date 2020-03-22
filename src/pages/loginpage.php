<?php
include_once("../components/header.php");
include_once("../components/footer.php");

make_header([], ["../styles/loginpage.css"]);
?>
<div class="container">
  <form>
    <div class="form ">
      <div class="row ">
        <div class="col">
          <h1 class="text-center form-title">Login</h1>
        </div>
      </div>
      <div class="form-group row">
        <div class="col">
          <label for="loginEmail">Email or Username</label>
          <input type="text" name="loginEmail" id="loginEmail" class="form-control" placeholder="" aria-describedby="loginRegisterHelp">
        </div>
      </div>
      <div class="form-group row">
        <div class="col">
          <label for="loginPassword ">Password</label>
          <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="" aria-describedby="loginRegisterHelp">
        </div>
      </div>
      <div class="row ">
        <div class="col button">
          <a class="btn rounded-0 btn-lg shadow-none" id="start" href="profile_page.php">
            Start Session
          </a>
        </div>
      </div>
      <div class="row register-info justify-content-center">
          <p>Don't have an account yet?  </p>
          <small id="helpId" class=" text-muted">
            <a href="../pages/registerpage.php">Register now</a>
          </small>
      </div>
    </div>
  </form>
</div>
<?php
make_footer();
?>