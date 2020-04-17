@extends('layouts.app', ['scripts' => [], 'styles' => ['css/loginpage.css']])


@section('content')
<div class="container">
  <form method="POST" action="\login">
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
          <input type="submit" class="btn rounded-0 btn-lg shadow-none" id="start" value="Start Session">
        </div>
      </div>
      <div class="row register-info justify-content-center">
          <p>Don't have an account yet?  </p>
          <small id="helpId" class=" text-muted">
            <a href="/register">Register now</a>
          </small>
      </div>
    </div>
    {{ csrf_field() }}
  </form>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection