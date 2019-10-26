@forelse(Cart::content() as $cart)

   <li class="item">
      <div class="img">
         <a href="{{ route('front.show',$cart->options->slug) }}" class="load_page"><img src="{{ $cart->options->src }}" alt="product image"/></a>
      </div>
      <div class="info">
         <div class="title-col">
            <h2 class="title">
               <a href="{{ route('front.show',$cart->options->slug) }}" class="load_page">{{ $cart->name }}</a>
            </h2>
            <div class="details">
               <span class="swatch-label color-orange">{{ $cart->options->color }}</span>, {{ $cart->options->size }}
            </div>
         </div>
         <div class="price">
            {{ number_format($cart->price) }}
         </div>
         <div class="qty">
            <div class="qty-label">Qty:</div>
            <form class="cart_edit_form" method="post" action="{{ route('cart.update') }}" data-id="{{ $cart->rowId }}">
               @csrf
               <div class="style-2 input-counter">
                  <span class="minus-btn"></span>
                  <input type="text" id="qty_update" name="qty" class="" value="{{ $cart->qty }}" size="5"/>
                  <span class="plus-btn"></span>
               </div>
               <button href="#" data-url="{{ route('cart.update') }}" data-id="{{ $cart->rowId }}" class="btn icon icon-edit cart_edit_" title="Edit"></button>

            </form>
         </div>

      </div>
      <div class="item-control">
         <div class="delete" ><a href="#" data-id="{{ $cart->rowId }}" onclick="" class="icon icon-delete cart_delete_" title="Delete"></a></div>
      </div>
   </li>

@empty
   <b>Your Cart is empty</b>
@endforelse
