@extends('layout.admin.index')
@section('extra_css')
   <!-- the script in this page wont work with pjax so i hava to reload it  -->
   @if (env('APP_AJAX'))
      <script type="text/javascript">
          $(document).on('pjax:complete', function() {
              pjax.reload();
          })
      </script>
   @endif
   <link rel="stylesheet" href="{{ asset('admin-assets/css/w3.css') }}">
@endsection
@section('content')
   <div class="hr dotted"></div>
   <div>
      <div id="user-profile-1" class="user-profile row">
         <div class="col-xs-12 col-sm-3 center">
            <div>
               <span class="profile-picture">
                  <a href="{{ ($product->cover) }}" target="_blank">
                     <img id="avatar"
                          class="editable img-responsive editable-click editable-empty"
                          alt="Alex's Avatar" src="{{ ($product->cover) }}"></a>
               </span>
               <div class="space-4"></div>
               <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                  <div class="inline position-relative">
                     <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                        <i class="ace-icon fa fa-circle light-green"></i>
                        &nbsp;
                        <span class="white">{{ $product->product_name }}</span>
                     </a>
                  </div>
               </div>
            </div>

            <div class="space-6"></div>

            <div class="profile-contact-info">

               <!-- DISPLAY RATING -->
               @for( $i = 0 ; $i < round($averageRating) ; $i++)
                  <span class="fa fa-stack" style="color: gold">
                     <i class="fa fa-star fa-stack-2x "></i>
                     <i class="fa fa-star-o fa-stack-2x "></i>
                  </span>
               @endfor
               @for( $i = 5 ; $i > round($averageRating) ; $i--)
                  <span class="fa fa-stack yellow">
                     <i class="fa fa-star-o fa-stack-2x"></i>
                  </span>
            @endfor
            <!-- /DISPLAY RATING -->
               <div class="space-6"></div>
            </div>
            <div class="hr hr12 dotted"></div>
            @if ($product->photos->count() > 0)
               <div class="clearfix w3-display-container">
                  @foreach($product->photos as $key => $photo)
                     <a href="{{$photo->src}}" target="_blank">
                        <img class="mySlides" src="{{ $photo->thumbnail }}"
                             alt="{{ $photo->photo_name }}" style="width:100%">
                     </a>
                  @endforeach
                  <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
                  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
               </div>
               @else
               <div class="clearfix">
                  <h2 class="text-danger bolder">WITHOUT PHOTO</h2>
               </div>
            @endif

           {{-- <div class="clearfix">
               <div class="grid2">
                  <span class="bigger-175 blue">25</span>
                  <br>
                  Followers
               </div>

               <div class="grid2">
                  <span class="bigger-175 blue">12</span>
                  <br>
                  Following
               </div>
            </div>--}}
            @can('product-edit')
               <div class="hr hr16 dotted"></div>
               <div class="profile-contact-links align-left ">
                  <a href="{{route('product.edit',$product->product_id)}}" class="btn btn-link">
                     <i class="ace-icon fa fa-plus-circle bigger-120 warning"></i>
                     Edit product
                  </a>
               </div>

               <div class="space-2"></div>
               <div class="profile-contact-links align-left ">
                  <a href="{{ route('attribute.edit',$product->product_id) }}" class="btn btn-link">
                     <i class="ace-icon fa fa-plus-circle bigger-120 green"></i>
                     Edit Attributes
                  </a>
               </div>
            @endcan
         </div>

         <div class="col-xs-12 col-sm-9">
            <div class="">
               <span>
                  <img src="{{ $product->brands->src }}" alt="{{ $product->brands->brand_name }}">
               </span>
               <span class="btn btn-app btn-sm btn-light no-hover">
                  <span class="line-height-1 bigger-170 blue"> {{ $product->quantity }} </span>
                  <br>
                  <span class="line-height-1 smaller-90"> Quantity </span>
               </span>

               <span class="btn btn-app btn-sm btn-yellow no-hover">
                  <span class="line-height-1 bigger-170"> {{ $product->weight }} </span>

                  <br>
                  <span class="line-height-1 smaller-90"> Weight </span>
               </span>

               <span class="btn btn-app btn-sm btn-pink no-hover">
                  <span class="line-height-1 bigger-170"> {{ $product->photos()->count() }} </span>
                  <br>
                  <span class="line-height-1 smaller-90"> Photos </span>
               </span>

               <span class="btn btn-app btn-sm btn-grey no-hover">
                  <span class="line-height-1 bigger-170"> {{ $comments->count() }} </span>

                  <br>
                  <span class="line-height-1 smaller-90"> Reviews </span>
               </span>
               <span class="btn btn-app btn-sm btn-success no-hover">
                  <span class="line-height-1 bigger-170"> {{ $categories->count() }} </span>

                  <br>
                  <span class="line-height-1 smaller-90"> Categories </span>
               </span>


            </div>

            <div class="space-12"></div>

            <div class="profile-user-info profile-user-info-striped">
               <div class="profile-info-row">
                  <div class="profile-info-name">Product Name</div>

                  <div class="profile-info-value">
                     <span class="editable editable-click" id="username">{{ $product->product_name }}</span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name"> SKU</div>

                  <div class="profile-info-value">
                     <span class="editable editable-click" id="country">{{ $product->sku }}</span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name"> Buy Price</div>

                  <div class="profile-info-value">
                     <span class="editable editable-click" id="age">{{ $product->buy_price }}</span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name">Sell Price</div>

                  <div class="profile-info-value">
                     <span class="editable editable-click" id="age">{{ $product->sale_price }}</span>
                  </div>
               </div>


               <div class="profile-info-row">
                  <div class="profile-info-name">Discount</div>
                  <div class="profile-info-value">
                     <span class="editable editable-click" id="age">
                        @if($product->is_off)
                           <span class='label label-warning smaller-80'>HAS-OFF</span>
                        @else
                           <span class="label label-default smaller-80">NOT OFF</span>
                        @endif</span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name">Off Price</div>

                  <div class="profile-info-value">
                     <span class="editable editable-click" id="age">{{ $product->off_price }}</span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name">Colors</div>
                  <div class="profile-info-value">
                     <span class="editable editable-click" id="about">
                         @foreach($colors as $color)
                           <span class="badge"
                                 style="background: {{ $color->color_code }}">{{ $color->color_name }}</span>
                        @endforeach
                     </span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name">Categories</div>
                  <div class="profile-info-value">
                     <span class="editable editable-click" id="about">
                        @foreach($categories as $category)
                           <span class='label label-default'>{{ $category->category_name }}</span>
                        @endforeach
                     </span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name">Tags</div>
                  <div class="profile-info-value">
                     <span class="editable editable-click" id="about">
                        @foreach($product->tags as $tag)
                           <span class='label label-info'>{{ $tag->tag_name }}</span>
                        @endforeach
                     </span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name">Attributes</div>
                  <div class="profile-info-value">
                     <span class="editable editable-click" id="about">
                        @forelse($product->attributes as $attribute)
                           <b>{{ $attribute->attr_name }}:</b>
                           @foreach($attribute->attributeValues as $value)
                              <span class='label label-default'>{{ $value->value }}</span>
                           @endforeach
                        @empty
                           <b>NO ATTRIBUTES</b>
                        @endforelse
                     </span>
                  </div>
               </div>

               <div class="profile-info-row">
                  <div class="profile-info-name"> Created Date</div>

                  <div class="profile-info-value">
                     <span class="editable editable-click" id="signup">{{ $product->created_at }}</span>
                  </div>
               </div>
               <div class="profile-info-row">
                  <div class="profile-info-name"> Updated Date</div>

                  <div class="profile-info-value">
                     <span class="editable editable-click" id="signup">{{ $product->updated_at }}</span>
                  </div>
               </div>
            </div>
            <h2>Comments</h2>
            <h6>red color not approved yet </h6>
            <div class="col-sm-6">
               @forelse($comments as $comment)
                  <div class="well well-lg"
                       style="background-color: {{ $comment->approved == 1 ? '#79ffb2': '#ffaf93'}}">
                     <h4 class="">
                        @if($comment->commenter_id =! null)
                           <span class="tag blue"><b>{{ $comment->guest_name }}</b></span>
                           <small><a href="mailTo:{{ $comment->guest_email }}">{{ $comment->guest_email }}</a></small>
                        @else
                           {{ $comment->commenter() }}
                        @endif
                     </h4>
                     {{$comment->comment}}
                  </div>
               @empty
                  no comments yet
               @endforelse
               {{ $comments->links() }}
            </div>
         </div>
      </div>
   </div>
@endsection
@section('extra_js')
   <!-- FOR IMAGE SLIDER -->
   <script type="text/javascript">
       var slideIndex = 1;
       showDivs(slideIndex);

       function plusDivs(n) {
           showDivs(slideIndex += n);
       }

       function showDivs(n) {
           var i;
           var x = document.getElementsByClassName("mySlides");
           if (n > x.length) {
               slideIndex = 1
           }
           if (n < 1) {
               slideIndex = x.length
           }
           for (i = 0; i < x.length; i++) {
               x[i].style.display = "none";
           }
           x[slideIndex - 1].style.display = "block";
       }
   </script>
@stop