@extends('layouts.app', ['scripts' => ['js/register.js'], 'styles' => ['css/registerpage.css']])

@section('content')
<div class="container">
  <form action="/register" method="POST" class=".form form justify-content-center" id='registerForm' enctype="multipart/form-data">
    @csrf
    <div class="row ">
      <div class="col">
        <h1 class="text-center form-title">Register</h1>
      </div>
    </div>
    <!--  -->
    <div class="row ">
      <label for="img" class="mx-auto d-block ">
        <img src={{asset("img/user.png")}} class="img-fluid rounded-circle border border-dark rounded" alt="User Image" id="user-img">
      </label>
      <input type="file" name="img" id="img">
    </div>
    <!-- -->
    <div class="row form-group ">
      <div class="col">
        <input type="text" name="username" id="username" class="form-control registerinput" placeholder="Username">
        <input type="email" name="email" id="email" class="form-control registerinput" placeholder="Email" >
        <input type="text" name="address" id="address" class="form-control registerinput" placeholder="Address">
      </div>
    </div>
    <!--  -->
    <div class="row">
      <div class="col">
        <h4 id="titlebirthday">Birthday</h4>
      </div>
    </div>
    <!--  -->
    <input name="birthday" type="hidden" value="" id="birthday"/>
    <div class="row form-group  birthday">
      <div class="col ">
        <select class="custom-select custom-select-sm registerinput registerSelect" name="day" id="day">
          <option selected class="text-muted optionplaceholder" hidden>Day</option>
         @for ($i = 1; $i <= 31; $i++)
          <option value={{$i}}>{{$i}}</option>
         @endfor
        </select>
      </div>
      <div class="col ">
        <select class="custom-select custom-select-sm registerinput registerSelect" name="month" id="month">
          <option selected class="text-muted optionplaceholder" hidden>Month</option>
          <option value="1">January</option>
          <option value="2">February</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">August</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      </div>
      <div class="col ">
        <select class="custom-select custom-select-sm registerinput registerSelect" name="year" id="year">
          <option selected class="text-muted optionplaceholder" hidden>Year</option>
         @for ($i = date("Y"); $i >= 1920; $i--)
          <option value={{$i}}>{{$i}}</option>
         @endfor
        </select>
      </div>

    </div>
    <!--  -->
    <div class="form-group row ">
      <div class="col">
        <input type="password" name="password" id="password" class="form-control registerinput" placeholder="Password" >
      </div>
    </div>
    <!--  -->
    <div class="row ">
      <div class="col ">
        <input type="submit" class="btn rounded-0 btn-lg shadow-none" id="submitbutton" value="Register">
      </div>
    </div>
  </form>
</div>
@include('components.errors')
@endsection
