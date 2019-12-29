@extends('layout.front.index')
@section('title')
   Your Session Expired
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="offset-80">
      <div class="on-duty-box">

         <h1 class="block-title large"> Your session has expired!</h1>
         <h1 class="text-danger">440</h1>
         <div class="description">
            Please try one of the following pages:
         </div>
         <a class="btn btn-border color-default" href="{{ route('front.checkout') }}">Check Out</a>
      </div>
   </div>

@endsection
@section('extra_js')
@endsection