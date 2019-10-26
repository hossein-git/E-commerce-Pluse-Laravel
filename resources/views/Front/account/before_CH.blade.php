@extends('layout.front.index')
@section('title')
{{ env('APP_NAME') }}
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="container">
      <div class="row">
         <div class="col-sm-6">
            <div class="">
               <div class="form-group">
                  <div class="">
                     <a href="{{ route('front.checkout') }}" style="background-color: #1d78cb;"  class="btn btn-full load_page">Continue as Guest!<span class="icon icon-keyboard_arrow_right"></span></a>
                  </div>
               </div>

               <div class="form-group">
                  <div class="">
                     <a href="#" class="btn btn-full"><span class="fa fa-google"></span>log in with google!</a>
                  </div>
               </div>

            </div>
         </div>
         <div class="col-sm-6">
            <form>
               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon">
                        <span class="icon icon-person_outline"></span>
                     </span>
                     <input type="text" id="LoginFormName" class="form-control" placeholder="User Name:">
                  </div>
               </div>
               <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-addon">
                        <span class="icon icon-lock_outline"></span>
                     </span>
                     <input type="password" id="LoginFormPass" class="form-control" placeholder="Password:">
                  </div>
               </div>
               <div class="checkbox-group">
                  <input type="checkbox" id="checkBox2">
                  <label for="checkBox2">
                     <span class="check"></span>
                     <span class="box"></span>
                     Remember me
                  </label>
               </div>
               <div class="pull-right"><a href="#">Forgot your password?</a></div>
               <br>

               <div class="pull-left">
                  <button type="button" class="btn btn-lg">SIGN IN</button>
               </div>
               <div class="pull-right">
                  <a class="btn btn-lg btn-inversion">SIGN UP</a>
               </div>

               <div class="text-center"></div>

            </form>
         </div>

      </div>
   </div>

@endsection
@section('extra_js')
@endsection