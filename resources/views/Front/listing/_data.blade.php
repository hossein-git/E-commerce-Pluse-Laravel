@php
   //VARIABLE TO TAKE PRODUCTS IN LAST WEEK FOR DISPLAYING -NEW- LABEL
      $data = \Carbon\Carbon::today()->subDays(7)
@endphp
@forelse($products as $product)
   <div class="col-xs-6 col-sm-4 col-md-4 col-lg-one-three">
      <div class="product">
         <div class="product_inside">
            <div class="image-box">
               <a href="{{ route('front.show',$product->product_slug) }}" class="load_page">
                  <img src="{{ $product->thumbnail }}" alt="">
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
            </div>
            <h2 class="title">
               @if($product->status != 1)
                  <div class="countdown_box">
                     <div class="countdown_inner">
                        <div class="countdown" data-date="{{ $product->data_available }}">
                           <span class="countdown-row"><span class="countdown-section"><span class="countdown-amount">0</span><span
                                         class="countdown-period">Day</span></span><span class="countdown-section"><span
                                         class="countdown-amount">0</span><span
                                         class="countdown-period">Hrs</span></span><span class="countdown-section"><span
                                         class="countdown-amount">0</span><span
                                         class="countdown-period">Min</span></span><span class="countdown-section"><span
                                         class="countdown-amount">0</span><span
                                         class="countdown-period">Sec</span></span></span></div>
                     </div>
                  </div>
               @endif
               <a href="{{ route('front.show',$product->product_slug) }}" class="load_page">{{ $product->product_name }}</a>
            </h2>
            <div class="price">
               @if($product->is_off == 1)
                  <span class="new-price">{{ number_format($product->sale_price) }}</span>
                  <span class="old-price">{{ $product->price }}</span>
               @else
                  <span class="price view">{{ $product->price }}</span>
               @endif
            </div>
            <div class="description">
               {{ $product->description }}
            </div>
            <div class="product_inside_hover">
               <div class="product_inside_info">
                  <div class="rating">
                     @for( $i = 0 ; $i < round($product->averageRating) ; $i++)
                        <span class="icon-star"></span>
                     @endfor
                     @for( $i = 5 ; $i > round($product->averageRating) ; $i--)
                        <span class="icon-star empty-star"></span>
                     @endfor
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@empty
   <br><br>
   <center><h3>NOTHING FOUND</h3></center>
@endforelse
<div class="container">
   <div class="pagination">
      {{ $products->links() }}
   </div>
</div>

