@extends('layouts.app', ['scripts' => ['js/register.js'], 'styles' => ['css/registerpage.css']])

@section('content')
<div class="container" id="page">
  <form action="/change-password" method="POST" class=".form form justify-content-center" id='registerForm' enctype="multipart/form-data">
    @csrf
    <fieldset class="row ">
      <div class="col">
        <h1 class="text-center form-title">Password Recovery</h1>
      </div>
    </fieldset>
    <!--  -->
    <fieldset class="form-group row ">
      <div class="col mt-4">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control registerinput" placeholder="Password" >
      </div>
    </fieldset>
    <!--  -->
    <div class="row ">
      <div class="col ">
        <label for="submitbutton"> </label>
        <input type="submit" class="btn rounded-0 btn-lg shadow-none" id="submitbutton" value="Recover Account">
      </div>
    </div>
  </form>
</div>
@include('components.errors')
@endsection
