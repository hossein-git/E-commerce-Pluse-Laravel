@extends('layout.front.index')
@section('title')
   Page Not Found!
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="offset-80">
      <div class="on-duty-box">
         <img src="{{ asset('front-assets/empty-404-icon.png') }}" alt="">
         <h1 class="block-title large">Please login or register!</h1>
         <div class="description">
            Sorry, this page is restricted to authorized users only
         </div>
         <a class="btn btn-border color-default" href="{{ route('login') }}">Login PAGE</a>
      </div>
   </div>
@endsection
@section('extra_js')
@endsection