@extends('layout.front.index')
@section('title')
   Search
@endsection
@section('extra_css')
@endsection
@section('content')

   @if (count($products) > 0)
      @include('Front.listing._data')
   @else
      <br>
      <h1 class="text-center">NOTHING FOUND</h1>
   @endif

@endsection
@section('extra_js')
@endsection