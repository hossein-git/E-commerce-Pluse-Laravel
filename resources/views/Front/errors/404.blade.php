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
         <h1 class="block-title large"> Ooops, we cannot find what you are looking for. Please try again.</h1>
         <div class="description">
            Please try one of the following pages:
         </div>
         <a class="btn btn-border color-default" href="{{ route('home') }}">HOME PAGE</a>
      </div>
   </div>
@endsection
@section('extra_js')
@endsection