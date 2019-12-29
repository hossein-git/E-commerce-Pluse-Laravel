@extends('layout.front.index')
@section('title')
Cancel
@endsection
@section('extra_css')
@endsection
@section('content')
<div class="offset-80">
   <div class="on-duty-box">
      <h1 class="block-title large">Your order canceled </h1>
      <h3>track code : {{ $track_code }}</h3>
      <div class="description">
         try one of the following pages:
      </div>
      <a class="btn btn-border color-default" href="{{ route('home') }}">HOME PAGE</a>
   </div>
</div>



@endsection
@section('extra_js')
@endsection