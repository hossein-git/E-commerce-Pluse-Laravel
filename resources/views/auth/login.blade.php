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
               <a href="{{ route('register') }}" class="btn btn-border color-default">CREATE AN ACCOUNT</a>
            </div>
         </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6" style="margin-top: -3.5rem">
         <div class="login-form-box">
            <h2>REGISTERED CUSTOMERS</h2>
            <p>
               If you have an account with us, please log in.
            </p>
            <form method="POST" action="{{ route('login') }}">
               @csrf
               <!-- SET THIS EMPTY INPUT FORM MORE SECURITY  -->
                  <input type="hidden" name="input" value="">
               <div class="form-group ">
                  <div class="input-group @error('email') has-error @enderror">
                     <span class="input-group-addon">
                        <span class="icon icon-person_outline"></span>
                     </span>
                     <input id="email" type="email" class="form-control " name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                     @error('email')
                     <span class="form-control-hint" role="alert">
                        <strong>{{ $message }}</strong</span>
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
               <div class="row">
                  <div class="col-md-12 col-lg-3">
                     <button type="submit" class="btn" onclick="document.getElementById('form-returning').submit();">
                        SIGN IN
                     </button>
                     <div class="checkbox-group pull-right">
                        <input type="checkbox" name="remember" id="checkBox2" {{ old('remember') ? 'checked' : '' }}>
                        <label for="checkBox2">
                           <span class="check"></span>
                           <span class="box"></span>
                           Remember me
                        </label>
                     </div>
                  </div>
                  <div class="col-md-12 col-lg-9">
                     <ul class="additional-links">
                        <li>
                           @if (Route::has('password.request'))
                              <a class="btn btn-link" href="{{ route('password.request') }}">
                                 {{ __('Forgot Your Password?') }}
                              </a>
                           @endif
                        </li>

                     </ul>
                     <a href="{{ route('auth.google') }}" class="btn btn-full bg-blue"><span class="fa fa-google"></span>log in with google!</a>

                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection
@section('extra_js')
@endsection