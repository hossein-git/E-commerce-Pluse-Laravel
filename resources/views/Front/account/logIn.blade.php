@extends('layout.front.index')
@section('title')
   Log In
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="row" style="margin-top: -3rem">
      <div class="col-sm-12 col-md-6 col-lg-6" style="margin-top: -3.5rem">
         <div class="login-form-box">
            <h2>NEW CUSTOMERS</h2>
            <div class="extra-indent-bottom">
               <p>By creating an account with our store, you will be able to move through the checkout process faster,
                  store multiple shipping addresses, view and track your orders in your account and more.</p>
            </div>
            <div class="">
               <button class="btn btn-border color-default">CREATE AN ACCOUNT</button>
            </div>
         </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6" style="margin-top: -3.5rem">
         <div class="login-form-box">
            <h2>REGISTERED CUSTOMERS</h2>
            <p>
               If you have an account with us, please log in.
            </p>
            <form>
               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon">
                        <span class="icon icon-person_outline"></span>
                     </span>
                     <input type="text" id="LoginFormName1" class="form-control" placeholder="Name">
                  </div>
               </div>
               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon">
                        <span class="icon icon-lock_outline"></span>
                     </span>
                     <input type="password" id="LoginFormPass1" class="form-control" placeholder="Password">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12 col-lg-3">
                     <button type="submit" class="btn" onclick="document.getElementById('form-returning').submit();">
                        SIGN IN
                     </button>
                  </div>
                  <div class="col-md-12 col-lg-9">
                     <ul class="additional-links">
                        <li><a href="#">Forgot your username?</a></li>
                        <li><a href="#">Forgot your password?</a></li>
                     </ul>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection
@section('extra_js')
@endsection