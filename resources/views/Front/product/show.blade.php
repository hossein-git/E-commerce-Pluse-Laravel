@extends('layout.front.index')
@section('title')
   {{ $product->product_name }}
@endsection
@section('extra_css')
   <link rel="stylesheet" href="{{ asset('front-assets/css/easyzoom.css') }}">
   <style type="text/css">
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

      /**** CSS Magic to Highlight Stars on Hover *****/
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
   <div class="row">
      <!-- IMAGE -->
      <div class="col-md-6 hidden-xs">
         <div class="col-sm-3">
            <div class="thumbnails ">
               @foreach($product->photos as $photo)
                  <a href="{{ $photo->src }}" data-standard="{{ $photo->src }}">
                     <img src="{{ ($photo->thumbnail ) }}" alt="product photo" class="img-thumbnail"/>
                  </a>
               @endforeach
            </div>
         </div>
         <div class="col-sm-9">
            <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails product-main-image-item">
               <a href="{{ ($product->cover) }}">
                  <img id="p_src" src="{{ $product->cover }}" alt="" width="330" height="490"/>
               </a>
            </div>
         </div>
         <!--  BRAND -->
         <div class="wrapper">
            <div class="brand text-center">
               <img src="{{ $product->brands->src }}" alt="LOGO">
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
                  <li><img src="{{ $photo->src }}" alt="?" class="img-thumbnail"/></li>
               @empty
               @endforelse
            </ul>
            <!--  BRAND -->
            <div class="brand text-center">
               <img src="{{ $product->brands->src }}" alt="LOGO">
            </div>
            <div class="text">
               {{ $product->brands->brand_description }}
            </div>
            <br>
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
                  <span class="new-price" id="p_price">{{ $product->price }}</span>
                  <span class="old-price">{{ number_format($product->sale_price) }}</span>
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
               <form>
                  <div class="col-sm-6">
                     <!-- COLOR -->
                     @if ($product->colors->count())
                        <div class="wrapper">
                           <div class="title-options">
                              COLOR<span class="color-required">*</span>
                           </div>
                           <ul class="options-swatch-color">
                              @foreach($product->colors()->get(['color_code','color_name']) as $color)
                                 <li class="">
                                    <a class="p_color" href="#" data-id="{{ $color->color_name }}">
                                    <span class="swatch-label color-orange active"
                                          style="background: {{ $color->color_code }}">
                                    </span>
                                    </a>
                                 </li>
                              @endforeach
                              <span class="tab swatch-label color-orange"></span>
                           </ul>
                        </div>
                     @else
                        <input type="hidden" id="p_color" class="p_color" value="-">
                  @endif
                  <!-- SIZE -->
                  @if ($product->has_size)
                        <div class="wrapper">
                           <div class="title-options">SIZE<span class="color-required">*</span></div>
                           <ul class="tags-list _size">
                              <li><a href="#" size="XS">XS</a></li>
                              <li><a href="#" size="S">S</a></li>
                              <li><a href="#" size="M">M</a></li>
                              <li><a href="#" size="L">L</a></li>
                           </ul>
                        </div>
                     @else
                        <input type="hidden" class="p_size" id="p_size" value="-">
                  @endif


                  </div>

                  <!-- ATTRIBUTES -->
                  <div class="col-sm-6">
                     @forelse($product->attributes as $attribute)
                        <div class="wrapper">
                           <label class="title-options" for="{{ $attribute->attr_name }}"><span
                                      class="color-required">*</span>{{ $attribute->attr_name }}:</label>
                           <select name="attr_name[]" class="form-control select-inline"
                                   id="{{ $attribute->attr_name }}" required>
                              @forelse($attribute->attributeValues as $value)
                                 <option value="{{$attribute->attr_name.':'.$value->value.'-' }}">{{ $value->value }}</option>
                              @empty
                              @endforelse
                           </select>
                        </div>
                     @empty
                        <input type="hidden" name="select-inline">

                     @endforelse
                  </div>
               </form>
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
                  <a href="#" id="add_to_cart" class="btn btn-lg btn-addtocart add_to_cart" style="">
                     <span class="icon icon-shopping_basket"></span>SHOP
                     NOW!
                  </a>
               </div>


               <ul class="product_inside_info_link">
                  <li class="text-right">
                     @auth()
                        @if($product->favorited())
                           <a href="#" id="unfavorites" data-id="{{ $product->product_id }}">
                              <span id="dislike_span" class="fa fa-heart"></span>
                              <span class="text">Delete from WISHLIST</span>
                           </a>
                        @else
                           <a href="#" id="favorite" data-id="{{ $product->product_id }}">
                              <span id="like_span" class="fa fa-heart-o"></span>
                              <span class="text">ADD TO WISHLIST</span>
                           </a>
                        @endif
                     @else
                        <i>for wish List please<a href="{{ route('login') }}">login</a></i>
                     @endauth
                  </li>
                  <li class="text-left">
                     <a data-id="{{ $product->product_id }}" class="compare-link">
                        <span class="fa fa-balance-scale"></span>
                        <span id="compare_text" class="text">
                              {{--@if (request()->cookie('P_compare_1') == $product->product_id
                                    or request()->cookie('P_compare_2') == $product->product_id )
                                  already in compare list
                                 @else
                                 ADD TO COMPARE
                              @endif--}}
                              ADD TO COMPARE
                           </span>
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
   <input type="hidden" id="p_color">
   <input type="hidden" id="p_size">
   <input type="hidden" id="p_slug" value="{{ $product->product_slug }}">
   <input type="hidden" id="p_id" value="{{ $product->product_id }}">
   <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
   <input type="hidden" id="_url" value="{{ route('cart.store')}}">
   <div id="review1">
      <div class="tt-product-page__tabs tt-tabs">
         <div class="tt-tabs__head">
            <ul>
               <li data-active="true"><span>DESCRIPTION</span></li>
               <li><span>SHOPPING METHOD</span></li>
               @if ($product->has_size)
                  <li><span>SIZING GUIDE</span></li>
               @endif
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
                     <li><span class="font-weight-600">Made In :</span> {{ $product->made_in }}</li>
                     @forelse($product->attributes as $attribute)
                        <li>
                           <span class="badge-grey font-weight-600">{{ $attribute->attr_name }} : </span>
                           @forelse($attribute->attributeValues as $value)
                              <span class="badge-dark">{{ $value->value }}</span>
                           @empty
                           @endforelse
                        </li>
                     @empty
                     @endforelse
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
            @if ($product->has_size)
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
            @endif

            <div>
               <span class="tt-tabs__title">TAGS</span>
               <div class="tt-tabs__content">
                  <h5 class="tab-title">TAGS</h5>
                  <ul>
                     @forelse($product->tags as $tag)
                        <li>
                           <a class="badge-01 badge-primary"
                              href="{{ route('front.lists',['list' => 'tags','slug' => "$tag->tag_slug", ]) }}">{{ $tag->tag_name }}</a>
                        </li>
                     @empty
                        <b>NO TAG</b>
                     @endforelse
                  </ul>
               </div>
            </div>
            <!-- COMMENTS -->
            <div id="">
               <span class="tt-tabs__title badge-">REVIEWS</span>
               <div class="tt-tabs__content">
                  <h5 class="right tab-title">CUSTOMER REVIEWS</h5>
                  <h6 id="comment_answer"></h6>
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
            @forelse($related_products as $product)
               <div>
                  <div class="product">
                     <div class="product_inside">
                        <div class="image-box">
                           <a href="{{ route('front.show',$product->product_slug) }}">
                              <img src="{{ $product->cover }}" alt="product image" class="img-thumbnail">
                           </a>
                           @if($product->is_off)
                              <div class="label-sale">Sale<br>{{ $product->off }}% Off</div>
                           @endif
                        </div>
                        <div class="title">
                           <a href="{{ route('front.show',$product->product_slug) }}">{{ $product->product_name }}</a>
                        </div>
                        <div class="price">
                           @if($product->is_off == 1)
                              <span class="new-price">{{ number_format($product->sale_price) }}</span>
                              <span class="old-price">{{ $product->price }}</span>
                           @else
                              <span class="price view">{{ $product->price }}</span>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            @empty
            @endforelse

         </div>
      </div>
   </div>


@endsection
@section('extra_js')
   <script src="{{ asset('front-assets/js/easyzoom.js') }}"></script>

   <script type="text/javascript">
       var $easyzoom = $('.easyzoom').easyZoom();
       // Setup thumbnails example
       var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');
       $('.thumbnails').on('click', 'a', function (e) {
           var $this = $(this);

           e.preventDefault();

           // Use EasyZoom's `swap` method
           api1.swap($this.data('standard'), $this.attr('href'));
       });
   </script>
   <!-- to load uploadAjax function -->
   <script src="{{ asset('front-assets/js/checkOut.js') }}"></script>
   <!-- FOR CREATE COMMENT WITH AJAX  -->
   <script type="text/javascript">
       function getRatingVal(e) {
           $('#rating_value').val($(e).val());
       }

       $(document).ready(function () {
           //submit comment
           $('#comment_form').submit(function (e) {
               e.preventDefault();
               var data = {
                   commentable_type: $('#commentable_type').val(),
                   commentable_id: $('#commentable_id').val(),
                   rating: $("#rating_value").val(),
                   message: $('#comment_message').val(),
               };
               if (upload_ajax("{{ route('comment.store') }}", data)) {
                   $('#comment_answer').addClass('text-center badge-success').text('your comment has uploaded successfully');
                   $('#comment_form').remove();
               }
           });
           //add favorite
           jQuery('#favorite').click(function (e) {
               e.preventDefault();
               var data = {
                   id: jQuery('#favorite').attr('data-id')
               };
               if (upload_ajax("{{ route('favorite') }}", data)) {
                   $('#favorite').empty().append('<span class="fa fa-heart"></span><span class="text">Delete From WISHLIST</span>');
                   $(this).attr('id', 'unfavorites');
               }
           });

           //remove favorite
           jQuery('#unfavorites').click(function (e) {
               e.preventDefault();
               var data = {
                   id: jQuery('#unfavorites').attr('data-id')
               };
               if (upload_ajax("{{ route('unfavorite') }}", data)) {
                   $('#unfavorites').empty().append('<span class="fa fa-heart-o"></span><span class="text">ADD TO WISHLIST</span>');
               }
           });

           //add To Compare
           jQuery('.compare-link').click(function (e) {
               e.preventDefault();
               var data = {
                   id: jQuery(this).attr('data-id')
               };
               if (upload_ajax("{{ route('front.productsCompare') }}", data)) {
                   $('#compare_text').empty().text('added to Compare list');
               }
           });


       });
   </script>
@endsection
