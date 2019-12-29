{{-- VARIABLE TO TAKE PRODUCTS IN LAST WEEK FOR DISPLAYING -NEW- LABEL  --}}
@php
   $data = \Carbon\Carbon::today()->subDays(7)
@endphp
@forelse($products as $product)
   <div class="element-item filter1">
      <div class="product small">
         <div class="product_inside" style="margin-bottom: -2.3rem">
            <div class="image-box">
               <a class="promo-box zoom-in design-default load_page"
                  href="{{ route('front.show',$product->product_slug) }}">
                  <img src="{{ $product->thumbnail }}" alt="product image" class="img-responsive img-thumbnail">
                  @if($product->is_off == 1)
                     <div class="label-sale ">Sale<br>{{ $product->off }}% Off</div>
                  @endif
                  @if($product->created_at > $data)
                     <div class="label-new">New</div>
                  @endif
                  @if($product->status != 1)
                     <div class="label-sale">coming soon!</div>
                  @endif
               </a>
               <a href="{{ route('front.show',$product->product_slug) }}" class="load_page"
                  class="quick-view">
                  {{-- <span>
                      <span class="icon icon-visibility"></span>QUICK VIEW
                   </span>--}}
               </a>
               @if($product->status != 1)
                  <div class="countdown_box">
                     <div class="countdown_inner">
                        <div class="countdown" data-date="{{ $product->data_available }}"><span class="countdown-row"><span class="countdown-section"><span class="countdown-amount">0</span><span class="countdown-period">Day</span></span><span class="countdown-section"><span class="countdown-amount">0</span><span class="countdown-period">Hrs</span></span><span class="countdown-section"><span class="countdown-amount">0</span><span class="countdown-period">Min</span></span><span class="countdown-section"><span class="countdown-amount">0</span><span class="countdown-period">Sec</span></span></span></div>
                     </div>
                  </div>
               @endif
            </div>
            <h2 class="title">
               <a class="bolder"
                  href="{{ route('front.show',$product->product_slug) }}" class="load_page">{{ $product->product_name }} </a>
            </h2>
            <div class="price">
               @if($product->is_off == 1)
                  <span class="new-price">{{ number_format($product->sale_price) }}</span>
                  <span class="old-price">{{ $product->price }}</span>
               @else
                  <span class="price view">{{ $product->price }}</span>
               @endif
            </div>
            {{-- <div class="description">
                Silver, metallic-blue and metallic-lavender silk-blend jacquard, graphic pattern, pleated ruffle along collar, long sleeves with button-fastening cuffs, buckle-fastening silver skinny belt, large pleated rosettes at hips. Dry clean. Zip and hook fastening at back. 100% silk. Specialist clean
             </div>--}}
            <div class="product_inside_hover">
               <div class="product_inside_info">
                  <!--  COLOR -->
               {{--<ul class="options-swatch options-swatch-color">
                  <li>
                     <a href="#">
                        <span class="swatch-label color-dark-grey"></span>
                     </a>
                  </li>
                  <li class="active">
                     <a href="#">
                        <span class="swatch-label color-pale-gold"></span>
                     </a>
                  </li>
                  <li>
                     <a href="#">
                        <span class="swatch-label color-white border-bg"></span>
                     </a>
                  </li>
               </ul>--}}
               <!-- /COLOR -->
                  <div class="rating">
                     @for( $i = 0 ; $i < round($product->averageRating) ; $i++)
                        <span class="icon-star"></span>
                     @endfor
                     @for( $i = 5 ; $i > round($product->averageRating) ; $i--)
                        <span class="icon-star empty-star"></span>
                     @endfor
                  </div>
                  {{-- <a class="btn btn-product_addtocart" href="#" data-toggle="modal"
                      data-target="#modalAddToCartProduct">
                      <span class="icon icon-shopping_basket"></span>ADD TO CART
                   </a>--}}
                  {{--<ul class="product_inside_info_link">
                     <li class="text-right">
                        <a href="#" class="wishlist-link">
                           <span class="fa fa-heart-o"></span>
                           <span class="text">Add to wishlist</span>
                        </a>
                     </li>
                     <li class="text-left">
                        <a href="#" class="compare-link">
                           <span class="fa fa-balance-scale"></span>
                           <span class="text">Add to compare</span>
                        </a>
                     </li>
                     <li>
                        <a href="#" data-toggle="modal" data-target="#ModalquickView"
                           class="quick-view">
                           <span class="icon icon-visibility"></span>
                        </a>
                     </li>
                  </ul>--}}
               </div>
            </div>
         </div>
      </div>
   </div>
@empty
@endforelse
