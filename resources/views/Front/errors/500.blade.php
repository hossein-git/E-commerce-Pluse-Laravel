@extends('layout.front.index')
@section('title')
   Page Not Found!
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="offset-80">
      <div class="on-duty-box">
         <h1 class="green font-weight-bold">500</h1>
         <h1 class="block-title large">Service Unavailable!</h1>
         <div class="description">
            {{ $exception->getMessage() }}
            <p>Ooops, server error occurred.</p> Please check again later.
         </div>
         <a class="btn btn-border color-default" href="{{ route('home') }}">HOME PAGE</a>
      </div>
   </div>
@endsection
@section('extra_js')
@endsection