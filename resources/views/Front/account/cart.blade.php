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
                        <h5 class="product-title ">
                           <a href="{{ route('front.show',$cart->id) }}" class="load_page font-weight-500">{{ $cart->name }} </a>
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
                        <div class="font-weight-600">
                           {{ $cart->options->attr }}
                        </div>
                     </td>
                     <td>
                        <div class="detach-quantity-desctope">
                           <div class="input">
                              <form >
                                 @csrf
                                 <div class="style-2 input-counter">
                                    <input type="number" id="qty_update" name="qty" class="" value="{{ $cart->qty }}" size="5" min="1"/>
                                    <button href="#" data-url="{{ route('cart.update') }}" onclick="event.preventDefault();editCart(this)" data-id="{{ $cart->rowId }}" class="btn icon icon-edit cart_edit_" title="Edit"></button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </td>
                     <td>
                        <div class="product-price subtotal">
                           {{ $cart->price }}
                        </div>
                     </td>
                     <td>
                        <a class="product-delete icon icon-delete" onclick="deleteCart(this)" data-id="{{ $cart->rowId }}" href="#"></a>
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