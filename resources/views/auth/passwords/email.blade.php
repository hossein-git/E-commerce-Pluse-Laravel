@extends('layout.front.index')
@section('title')
   Reset Password
@endsection
@section('extra_css')
@endsection
@section('content')
   <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="row">
         @if (session('status'))
            <div class="alert alert-success" role="alert">
               {{ session('status') }}
            </div>
         @endif
         <div class="col-sm-7">
            <div class="form-group">
               <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>
               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                      value="{{ old('email') }}" required autocomplete="email" autofocus>
               @error('email')
               <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
               @enderror
            </div>
            <div class="form-group">
               <label class="control-label"></label>
               <button type="submit" class="btn btn-primary">
                  {{ __('Send Password Reset Link') }}
               </button>
            </div>
         </div>
      </div>
   </form>
@endsection
