@extends('layout.front.index')
@section('title')
   My Shopping cart
@endsection
@section('extra_css')
@endsection
@section('content')

   <div class="row">
      <div class="col-lg-8">
         <div class="shopping-cart-col">
            <table class="shopping-cart-table">
               <tbody>
               @forelse(Cart::content() as $cart)
                  <tr>
                     <td>
                        <div class="product-image">
                           <a href="{{ route('front.show',$cart->id) }}" class="load_page">
                              <img src="{{ $cart->options->src }}" alt="">
                           </a>
                        </div>
                     </td>
                     <td>
                        <h5 class="product-title">
                           <a href="{{ route('front.show',$cart->id) }}" class="load_page">{{ $cart->name }} </a>
                        </h5>
                        <ul class="list-parameters">
                           <li>
                              {{ $cart->options->color }}, {{ $cart->options->size }}
                           </li>
                           <li class="visible-xs visible-sm">
                              <div class="product-price unit-price">{{ number_format($cart->price) }}</div>
                           </li>
                           <li class="visible-xs visible-sm">
                              <div class="detach-quantity-mobile">

                              </div>
                           </li>
                           <li class="visible-xs visible-sm">
                              <div class="product-price subtotal">{{ $cart->price }}</div>
                           </li>
                        </ul>
                     </td>
                     <td>
                        <div class="product-price unit-price">

                        </div>
                     </td>
                     <td>
                        <div class="detach-quantity-desctope">
                           <div class="input">
                              <label>Qty:</label>
                              <div class="style-2 input-counter">
                                 <span class="minus-btn"></span>
                                 <input type="text" value="{{ $cart->qty }}" size="5"/>
                                 <span class="plus-btn"></span>
                              </div>
                           </div>
                        </div>
                     </td>
                     <td>
                        <div class="product-price subtotal">
                           {{ $cart->price }}
                        </div>
                     </td>
                     <td>
                        <a class="product-delete icon icon-delete cart_delete_" data-id="{{ $cart->id }}" href="#"></a>
                     </td>
                  </tr>
               @empty
                  <center><h2>your Cart is empty</h2></center>
               @endforelse
               </tbody>
            </table>
            <div class="shopping-cart-btns">
               @if (Cart::count() > 0)
                  <div class="pull-right">
                     <a class="btn-link" href="#"><span class="icon icon-cached color-base"></span>UPDATE CART</a>
                     <div class="clearfix visible-xs visible-sm"></div>
                     <a class="btn-link" href="{{ route('cart.clear') }}"><span class="icon icon-delete"></span>CLEAR
                        SHOPPING CART</a>
                  </div>
                  <div class="pull-left">
                     <a class="btn-link" href=""><span class="icon icon-keyboard_arrow_left"></span>CONTINUE SHOPPING
                     </a>
                  </div>
               @else
                  <div class="pull-left">
                     <a class="btn-link load_page" href="{{ route('front.productsList') }}" ><span
                                class="icon icon-keyboard_arrow_left"></span>CONTINUE SHOPPING
                     </a>
                  </div>
               @endif
            </div>
         </div>
      </div>
   </div>

@endsection
@section('extra_js')
@endsection