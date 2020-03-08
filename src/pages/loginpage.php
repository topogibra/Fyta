<?php
include_once("../components/header.php");
include_once("../components/footer.php");

make_header([], [ "../styles/loginpage.css"]);
?>
<div class="container">
  <form>
  <div class="form">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="text-center form-title">Login</h1>
      </div>
    </div>
    <div class="form-group row justify-content-center">
      <div class="col-md-6">
        <label for="loginEmail">Email or Username</label>
        <input type="text" name="loginEmail" id="loginEmail" class="form-control" placeholder="" aria-describedby="loginRegisterHelp">
      </div>
    </div>
    <div class="form-group row justify-content-center">
      <div class="col-md-6">
        <label for="loginPassword ">Password</label>
        <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="" aria-describedby="loginRegisterHelp">
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6 ">
        <button type="submit" class="btn btn-primary col-sm-12 next-btn">Start Session</button>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-3 ">
        <small id="helpId" class="text-center text-muted">Don't have an account yet? <a href="../pages/registerpage.php">Register now</a>
        </small>
      </div>
    </div>
  </div>
  </form>
</div>
<?php
make_footer();
?>