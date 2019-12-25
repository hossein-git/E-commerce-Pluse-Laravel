@extends('layout.front.index')
@section('title')
   Empty Shopping Cart
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="container offset-80">
      <div class="on-duty-box">
         <img src="{{ asset('front-assets/empty-shopping-cart-icon.png') }}" alt="">
         <h1 class="block-title large">Shopping Cart is Empty</h1>
         <div class="description">
            You have no items in your shopping cart.
         </div>
         <a class="btn btn-border color-default" href="{{ route('front.productsList') }}">CONTINUE SHOPPING </a>
      </div>
   </div>
@endsection
@section('extra_js')
@endsection