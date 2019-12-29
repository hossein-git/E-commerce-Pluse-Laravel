@extends('layout.front.index')
@section('title')
   Home
@endsection
@section('extra_css')
@endsection
@section('content')

   <!-- CATEGORIES -->
   <div class="row indent-col-none custom-layout">
      <div class="col-sm-6">
         <div class="row indent-col-none">
            <div class="col-extra-400 col-xs-6 col-md-6">
               <a href="listing-left-column.html" class="promo-box zoom-in design-14">
                  <img src="{{asset('images/promo-img-42.jpg')}}" alt="">
                  <div class="description point-left">
                     <div class="block-table">
                        <div class="block-table-cell">
                           <div class="title color-defaulttext2">Shoes</div>
                           <span class="btn btn-lg btn-underline color-base">SHOP NOW!</span>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-extra-400 col-xs-6 col-md-6">
               <a href="listing-left-column.html" class="promo-box zoom-in design-14">
                  <img src="{{asset('images/promo-img-43.jpg')}}" alt="">
                  <div class="description point-left">
                     <div class="block-table">
                        <div class="block-table-cell">
                           <div class="title color-defaulttext2">Sunglasses</div>
                           <span class="btn btn-lg btn-underline color-base">SHOP NOW!</span>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="row indent-col-none">
            <div class="col-extra-400 col-xs-6 col-md-6">
               <a href="listing-left-column.html" class="promo-box zoom-in design-14">
                  <img src="{{asset('images/promo-img-42.jpg')}}" alt="">
                  <div class="description point-left">
                     <div class="block-table">
                        <div class="block-table-cell">
                           <div class="title color-defaulttext2">Shoes</div>
                           <span class="btn btn-lg btn-underline color-base">SHOP NOW!</span>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-extra-400 col-xs-6 col-md-6">
               <a href="listing-left-column.html" class="promo-box zoom-in design-14">
                  <img src="{{asset('images/promo-img-43.jpg')}}" alt="">
                  <div class="description point-left">
                     <div class="block-table">
                        <div class="block-table-cell">
                           <div class="title color-defaulttext2">Sunglasses</div>
                           <span class="btn btn-lg btn-underline color-base">SHOP NOW!</span>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
         </div>
      </div>
      <div class="col-sm-6">
         <a href="listing-left-column.html" class="promo-box zoom-in design-08">
            <img src="{{ asset('images/promo-img-37.jpg') }}" alt="">
            <div class="description">
               <div class="block-table">
                  <div class="block-table-cell">
                     <p>Our Experience Gives us the Ability to</p>
                     <div class="title">Create Stunning Webstore</div>
                     <span class="btn btn-lg btn-red">SHOP NOW!</span>
                  </div>
               </div>
            </div>
         </a>
      </div>
   </div>
   <!-- /CATEGORIES -->
   <hr>
   <hr>
   <!-- BRANDS -->
   <div class="container" style="margin-top: -0.0rem">
      <div class="row">
         <div class="carousel-brands">
            @forelse($brands as $brand)
               <div>
                  <a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $brand->brand_slug ]) }}"
                     class="load_page">
                     <img src="{{ $brand->src }}" alt="{{ $brand->brand_name }}">
                  </a>
               </div>
            @empty
               NO BRANDS
            @endforelse
         </div>
      </div>
   </div>
   <!-- /BRANDS -->
   <hr>
   <hr>
   <!-- PRODUCTS -->
   <div class="container" style="margin-top: -0.0rem">
      <div class="row">
         <div class="filter-isotop">
            <div class="grid" id="products_data">
               @include('Front._data')

            </div>
            <center><img alt="" src="{{ asset('admin-assets/5.gif') }}" class="center preview ajax-load"></center>
            <hr>
{{--            <center id="load" style="display: none">MORE PRODUCTA COMING SOON....</center>--}}
            <div class="divider"></div>
         </div>
      </div>
   </div>
   <!-- /PRODUCTS -->

   <div class="row custom-layout indent-col-none" id="bot_box">

      <div class="item-large">
         <a href="#" class="promo-box zoom-in design-default">
            <img src="{{ asset('images/promo-img-03.jpg') }}" alt="">
            <div class="description point-center-vertical point-left left-offset text-center">
               <div class="block-table">
                  <div class="block-table-cell">
                     <div class="title color-base">High Perfomance<br>and Pixel Perfect Design</div>
                     <p class="color-defaulttext">High Perfomance and pixel perfect design gives your customers a<br>seamless
                        user experience on both desktop and mobile devices. It is a<br>perfect choice for any type of
                        webstore.</p>
                     <span class="btn btn-lg">SHOP NOW!</span>
                  </div>
               </div>
            </div>
         </a>
      </div>
      <div class="item-small">
         <a href="listing-left-column.html" class="promo-box zoom-in design-default">
            <img src="{{ asset('images/promo-img-04.jpg') }}" alt="">
            <div class="description">
               <div class="block-table">
                  <div class="block-table-cell">
                     <div class="title">It Does not Matter -<br>what Kind of Products do<br>You Want to Sell.</div>
                     <p>Be amazed how quickly you get your next<br>website up and running.</p>
                     <span class="btn btn-lg btn-white btn-border">SHOP NOW!</span>
                  </div>
               </div>
            </div>
         </a>
      </div>
   </div>
   <input type="hidden" id="lastPage" value="{{ $products->lastPage() }}">
@endsection
@section('extra_js')
   <script type="text/javascript">
       var page = 1;
       $(window).scroll(function () {
           if ($(window).scrollTop() +
               ($('#product_data').height() + $('#footer').height() + 900) >= $(document).height()) {
               page++;
               //this will avoid send more request when all data has loaded
               if (page > $("#lastPage").val()) {
                   $('.ajax-load').hidden;
                   $('#load').show();
                   return;
               }
               //avoid to show more than 3 page
               if (page === 3){
                   return;
               }
               // console.log(page);
               loadMoreData(page);
           }
           function loadMoreData(page) {

               $.ajax(
                   {
                       url: '/?page=' + page,
                       type: "get",
                       beforeSend: function () {
                           $('.ajax-load').show();
                       }
                   })
                   .done(function (data) {
                       if (data.html == " ") {
                           $('.ajax-load').attr('src', '');
                           $('#load').show();
                           return;
                       }
                       $('.ajax-load').hide();
                       $("#products_data").append(data.html);
                   })
                   .fail(function (jqXHR, ajaxOptions, thrownError) {
                       console.log(jqXHR);
                   });
           }
       });
   </script>
@endsection