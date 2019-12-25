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
                     <a href="{{ route('front.checkout') }}" style="background-color: #1d78cb;"  class="btn btn-full bg-brown load_page">Continue as Guest!<span class="icon icon-keyboard_arrow_right"></span></a>
                  </div>
               </div>

               <div class="form-group">
                  <div class="">
                     <a href="{{ route('auth.google') }}" class="btn btn-full bg-blue"><span class="fa fa-google"></span>log in with google!</a>
                  </div>
               </div>

            </div>
         </div>
         <div class="col-sm-6">
            <form method="POST" action="{{ route('login') }}">
               @csrf
               <input type="hidden" name="before_checkout_form" value="1">
               <!-- SET THIS EMPTY INPUT FORM MORE SECURITY  -->
               <input type="hidden" name="input" value="">
               <div class="form-group @error('email') is-invalid @enderror">
                  <div class="input-group">
                     <span class="input-group-addon">
                        <span class="icon icon-person_outline"></span>
                     </span>
                     <input id="email" type="email" class="form-control " name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                     @error('email')
                     <span class="form-control-hint" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group @error('password') is-invalid @enderror">
                  <div class="input-group">
                     <span class="input-group-addon">
                        <span class="icon icon-lock_outline"></span>
                     </span>
                     <input id="password" type="password" class="form-control " name="password" placeholder="Password" required autocomplete="current-password">

                     @error('password')
                     <span class="form-control-hint" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                     @enderror
                  </div>
               </div>
               <div class="checkbox-group">
                  <input type="checkbox" name="remember" id="checkBox2" {{ old('remember') ? 'checked' : '' }}>
                  <label for="checkBox2">
                     <span class="check"></span>
                     <span class="box"></span>
                     Remember me
                  </label>
               </div>
               <div class="pull-right">
                  @if (Route::has('password.request'))
                     <a  href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                     </a>
                  @endif</div>
               <br>

               <div class="pull-left">
                  <button type="submit" class="btn btn-lg" >SIGN IN</button>
               </div>
               <div class="pull-right">
                  <a  href="{{ route('register') }}" class="btn btn-lg btn-inversion">SIGN UP</a>
               </div>

               <div class="text-center"></div>

            </form>
         </div>

      </div>
   </div>

@endsection
@section('extra_js')
@endsection