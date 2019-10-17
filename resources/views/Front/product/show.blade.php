@extends('layout.front.index')
@section('title')
   {{ $product->product_name }}
@endsection
@section('extra_css')
   <link rel="stylesheet" href="{{ asset('front-assets/external/magnific-popup/magnific-popup.css') }}">
   <style type="text/css">
   /*@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);*/
   /****** Style Star rating0 Widget *****/

   .rating0 {
      border: none;
      float: left;
   }

   .rating0 > input {
      display: none;
   }

   .rating0 > label:before {
      margin: 5px;
      font-size: 1.25em;
      font-family: FontAwesome;
      display: inline-block;
      content: "\f005";
   }

   .rating0 > .half:before {
      content: "\f089";
      position: absolute;
   }

   .rating0 > label {
      color: #ddd;
      float: right;
   }

   /***** CSS Magic to Highlight Stars on Hover *****/

   .rating0 > input:checked ~ label, /* show gold star when clicked */
   .rating0:not(:checked) > label:hover, /* hover current star */
   .rating0:not(:checked) > label:hover ~ label {
      color: #FFD700;
   }

   /* hover previous stars in list */

   .rating0 > input:checked + label:hover, /* hover current star when changing rating0 */
   .rating0 > input:checked ~ label:hover,
   .rating0 > label:hover ~ input:checked ~ label, /* lighten current selection */
   .rating0 > input:checked ~ label:hover ~ label {
      color: #FFED85;
   }
</style>
@endsection
@section('content')
   <div class="">
      <div class="row">
         <!-- IMAGE -->
         <div class="col-md-6 hidden-xs">
            <div class="product-col-image">
               <div class="product-main-image">
                  <div class="product-main-image-item">
                     <img class="zoom-product" id="p_src" src='{{ ($product->cover) }}'
                          data-zoom-image="{{ ($product->cover) }}" alt="product image"/>
                  </div>
               </div>
               <div class="product-images-carousel-vertical">
                  <ul id="smallGallery">
                     @foreach($product->photos as $photo)
                        <li>
                           <a class="zoomGalleryActive" href="#"
                               data-image="{{ ($photo->src) }}"
                               data-zoom-image="{{ ($photo->src) }}">
                              <img src="{{ ($photo->thumbnail ) }}" alt="{{ $photo->title }}"/>
                           </a>
                           fff
                        </li>
                     @endforeach
                  </ul>
               </div>
            </div>
            <!--  BRAND -->
            <div class="wrapper">
               <div class="brand">
                  <img src="{{ $product->brands->src }}" alt="">
               </div>
               <div class="text">
                  {{ $product->brands->brand_description }}
               </div>
            </div>

            <hr>
            <!--  /BRAND -->
         </div>
         <!-- /IMAGE -->
         <div class="col-md-6">
            <div class="visible-xs">
               <div class="clearfix"></div>
               <ul class="mobileGallery-product">
                  @forelse($product->photos as $photo)
                     <li><img src="{{ $photo->src }}" alt=""/></li>
                     @empty
                     <li><img src="{{ asset('front-assets/images/product/product-big-2.jpg') }}" alt=""/></li>
                   @endforelse
               </ul>
            </div>
            <div class="product-info product-info1">
               <div class="add-info">
                  <div class="pull-left">
                     <div class="sku">
                        <span class="font-weight-medium color-defaulttext2">SKU:</span> {{ $product->sku }}
                     </div>
                  </div>
                  <div class="pull-left">
                     <div class="availability">
                        <span class="font-weight-medium color-defaulttext2">Availability:</span>
                        @if($product->status == 1)
                           <span class="color-base">In stock</span>
                        @else
                           <span class="color-red">Out stock</span>
                           <span class="btn-info">Coming On :{{ $product->data_available }}</span>
                        @endif
                     </div>
                  </div>
               </div>
               <h1 class="title" id="p_name">{{ $product->product_name }}</h1>
               <div class="price">
                  @if($product->is_off == 1)
                     <span class="old-price">{{ number_format($product->sale_rice) }}</span>
                     <span class="new-price" id="p_price">{{ $product->price }}</span>
                  @else
                     <span class="price" id="p_price">{{ $product->price }}</span>
                  @endif
               </div>
               <!-- RATING -->
               <div class="review">
                  @for( $i = 0 ; $i < round($product->averageRating) ; $i++)
                     <span class="fa fa-stack" style="color: gold">
                        <i class="fa fa-star fa-stack-2x"></i>
                        <i class="fa fa-star-o fa-stack-2x"></i>
                     </span>
                  @endfor
                  @for( $i = 5 ; $i > round($product->averageRating) ; $i--)
                     <span class="fa fa-stack" style="color: gold">
                        <i class="fa fa-star-o fa-stack-2x"></i>
                     </span>
                  @endfor
                  <a href="#review1">{{ $product->comments->count() }} Review(s)</a>
                  <a href="#review1">Add Your Review</a>
               </div>
               <!-- /RATING -->
               <div class="row">
                  <!-- COLOR -->
                  <div class="col-sm-6">
                     <div class="wrapper">
                        <div class="title-options">
                           COLOR<span class="color-required">*</span>
                        </div>
                        <ul class="options-swatch-color">
                           @foreach($product->colors()->get(['color_code','color_name']) as $color)
                              <li class="">
                                 <a href="#" class="p_color" data-id="{{ $color->color_name }}">
                                    <span class="swatch-label color-orange active"
                                          style="background: {{ $color->color_code }}">
                                    </span>
                                 </a>
                              </li>
                           @endforeach
                           <span class="tab swatch-label color-orange"></span>
                        </ul>
                     </div>
                  </div>
                  <!-- /COLOR -->
                  <!-- SIZE -->
                  <div class="col-sm-6">
                     <div class="wrapper">
                        <div class="title-options">SIZE<span class="color-required">*</span></div>
                        <ul class="tags-list _size">
                           <li><a href="#" size="XS">XS</a></li>
                           <li><a href="#" size="S">S</a></li>
                           <li><a href="#" size="M">M</a></li>
                           <li><a href="#" size="L">L</a></li>
                        </ul>
                     </div>
                  </div>.
                  <!-- /SIZE -->
               </div>
               <b id="p_error" style="display: none;color: red;">ddd</b>
               <div class="wrapper">
                  <div class="pull-left"><label class="qty-label">QTY</label></div>
                  <div class="pull-left">
                     <div class="style-2 input-counter">
                        <span class="minus-btn"></span>
                        <input type="text" value="1" size="10" id="p_qty"/>
                        <span class="plus-btn"></span>
                     </div>
                     <a href="#" id="add_to_cart" class="btn btn-lg btn-addtocart" style="">
                        <span class="icon icon-shopping_basket"></span>SHOP
                        NOW!
                     </a>
                  </div>


                     <ul class="product_inside_info_link">
                        <li class="text-right">
                           <a href="#">
                              <span class="fa fa-heart-o"></span>
                              <span class="text">ADD TO WISHLIST</span>
                           </a>
                        </li>
                        <li class="text-left">
                           <a href="#" class="compare-link">
                              <span class="fa fa-balance-scale"></span>
                              <span class="text">ADD TO COMPARE</span>
                           </a>
                        </li>
                     </ul>
               </div>
               <!-- SOCIALS -->
            {{--<ul class="social-icon-square">
               <li><a class="icon-01" href="#"></a></li>
               <li><a class="icon-02" href="#"></a></li>
               <li><a class="icon-03" href="#"></a></li>
               <li><a class="icon-04" href="#"></a></li>
               <li><a class="icon-05" href="#"></a></li>
            </ul>--}}
            <!-- /SOCIALS -->
            </div>
         </div>
      </div>
   </div>
   <div id="review1">
      <div class="tt-product-page__tabs tt-tabs">
         <div class="tt-tabs__head">
            <ul>
               <li data-active="true"><span>DESCRIPTION</span></li>
               <li><span>SHOPPING METHOD</span></li>
               <li><span>SIZING GUIDE</span></li>
               <li><span>TAGS</span></li>
               <li><span>REVIEWS</span></li>
            </ul>
            <div class="tt-tabs__border"></div>
         </div>
         <div class="tt-tabs__body">
            <div>
               <span class="tt-tabs__title">DESCRIPTION</span>
               <div class="tt-tabs__content">
                  <h5 class="tab-title">DESCRIPTION</h5>
                  <P>
                     {{ $product->description }}
                  </P>
                  <ul class="list-simple-dot">
                     <li><a href="#">{{ $product->made_in }}</a></li>
                  </ul>
               </div>
            </div>
            <div>
               <span class="tt-tabs__title">SHOPPING METHOD</span>
               <div class="tt-tabs__content">
                  <h5 class="tab-title">SHOPPING METHOD</h5>
                  <h6><span class="color-base icon icon-local_shipping"></span> Shipping and Delivery</h6>
                  We're dedicated to delivering your purchase as quickly and affordably as possible. We offer a range of
                  delivery and pickup options, so you can choose the shipping method that best meets your needs.
                  <div class="divider"></div>
                  <h6><span class="color-base icon icon-payment"></span> Payment Methods</h6>
                  Every country and shopper has their prefered method to pay online. Offering your buyers safe and
                  convenient payment choices can help your sale go smoothly, earn you positive Feedback, and bring them
                  back for more.
               </div>
            </div>
            <div>
               <span class="tt-tabs__title">SIZING GUIDE</span>
               <div class="tt-tabs__content">
                  <h5 class="tab-title">CLOTHING - SINGLE SIZE CONVERSION (CONTINUED)</h5>
                  <div class="table-responsive">
                     <table class="table table-parameters">
                        <tbody>
                        <tr>
                           <td>UK</td>
                           <td>18</td>
                           <td>20</td>
                           <td>22</td>
                           <td>24</td>
                           <td>26</td>
                        </tr>
                        <tr>
                           <td>European</td>
                           <td>46</td>
                           <td>48</td>
                           <td>50</td>
                           <td>52</td>
                           <td>54</td>
                        </tr>
                        <tr>
                           <td>US</td>
                           <td>14</td>
                           <td>16</td>
                           <td>18</td>
                           <td>20</td>
                           <td>22</td>
                        </tr>
                        <tr>
                           <td>Australia</td>
                           <td>8</td>
                           <td>10</td>
                           <td>12</td>
                           <td>14</td>
                           <td>16</td>
                        </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div>
               <span class="tt-tabs__title">TAGS</span>
               <div class="tt-tabs__content">
                  <h5 class="tab-title">TAGS</h5>
                  <ul class="tags-list">
                     <li><a href="#">Vintage</a></li>
                     <li><a href="#">Style</a></li>
                     <li><a href="#">Street Style</a></li>
                  </ul>
               </div>
            </div>
            <!-- COMMENTS -->
            <div id="">
               <span class="tt-tabs__title">REVIEWS</span>
               <div class="tt-tabs__content">
                  <h5 class="right tab-title">CUSTOMER REVIEWS</h5>
                  <h6>Write a review</h6>
                  @comments([
                  'model' => $product,
                  'approved' => true
                  ])
               </div>
            </div>
            <!-- /COMMENTS -->
         </div>
      </div>
   </div>
   <div class="divider"></div>
   <div class="">
      <h3 class="block-title small">YOU MAY ALSO BE INTERESTED IN THE FOLLOWING PRODUCT(S)</h3>
      <div class="row">
         <div class="carousel-products-2 carouselTab slick-arrow-top slick-arrow-top2">
            <div>
               <div class="product">
                  <div class="product_inside">
                     <div class="image-box">
                        <a href="product.html">
                           <img src="{{ asset('front-assets/images/product/product-04.jpg') }}" alt="">
                        </a>
                        <a href="#" data-toggle="modal" data-target="#ModalquickView" class="quick-view">
										<span>
										<span class="icon icon-visibility"></span>QUICK VIEW
										</span>
                        </a>
                     </div>
                     <div class="title">
                        <a href="product.html">Leg Avenue Tights With All Over Vintage Bows</a>
                     </div>
                     <div class="price">
                        $20
                     </div>
                     <div class="description">
                        Silver, metallic-blue and metallic-lavender silk-blend jacquard, graphic pattern, pleated ruffle
                        along collar, long sleeves with button-fastening cuffs, buckle-fastening silver skinny belt,
                        large pleated rosettes at hips. Dry clean. Zip and hook fastening at back. 100% silk. Specialist
                        clean
                     </div>
                     <div class="product_inside_hover">
                        <div class="product_inside_info">
                           <ul class="options-swatch options-swatch-color">
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
                           </ul>
                           <div class="rating">
                              <span class="icon-star"></span>
                              <span class="icon-star"></span>
                              <span class="icon-star"></span>
                              <span class="icon-star"></span>
                              <span class="icon-star empty-star"></span>
                           </div>
                           <a class="btn btn-product_addtocart" href="#" data-toggle="modal"
                              data-target="#modalAddToCartProduct">
                              <span class="icon icon-shopping_basket"></span>ADD TO CART
                           </a>
                           <a href="#" class="quick-view btn" data-toggle="modal" data-target="#ModalquickView">
                              <span>
                                 <span class="icon icon-visibility"></span>QUICK VIEW
                              </span>
                           </a>
                           <ul class="product_inside_info_link">
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
                                 <a href="#" data-toggle="modal" data-target="#ModalquickView" class="quick-view">
                                    <span class="icon icon-visibility"></span>
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

<input type="hidden" id="p_color">
<input type="hidden" id="p_size">
<input type="hidden" id="p_slug" value="{{ $product->product_slug }}">
<input type="hidden" id="p_id" value="{{ $product->product_id }}">
<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
<input type="hidden" id="_url" value="{{ route('cart.store')}}">
@endsection
@section('extra_js')
   <script src="{{ asset('front-assets/external/isotope/isotope.pkgd.min.js') }}"></script>
   <script src="{{ asset('front-assets/external/elevatezoom/jquery.elevatezoom.js') }}"></script>
@endsection
