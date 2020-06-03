@extends('layouts.app', ['scripts' => ['js/register.js'], 'styles' => ['css/registerpage.css'], 'title' => 'Password Recovery'])

@section('content')
<div class="container" id="page">
  <form action="/password-recovery" method="POST" class=".form form justify-content-center" id='registerForm' enctype="multipart/form-data">
    @csrf
    <fieldset class="row ">
      <div class="col">
        <h1 class="text-center form-title">Password Recovery</h1>
      </div>
    </fieldset>
    <!--  -->
    <fieldset class="form-group row ">
      <div class="col mt-4">
        <label for="email"> Email </label>
        <input type="email" name="email" id="email" class="form-control registerinput" placeholder="Email" >  
      </div>
      <div class="col mt-4">
        <label for="security-question">What was the name of your first animal? </label>
        <input type="security-question" name="security-question" id="security-question" class="form-control registerinput" placeholder="Enter your answer here" >
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
