@extends('layout.front.index')
@section('title')
   list
@endsection
@section('extra_css')
   <meta name="_token" content="{{ csrf_token()}}"/>
@endsection
@section('content')
   <div class="row">
      <!-- left col -->
   @include('Front.listing._leftMenu')
   <!-- center col -->
      <div class="col-md-9 col-lg-10 col-xl-10">
         <div class="pull-left hidden-lg hidden-md">
            <a class="btn slide-column-open" href="#">FILTER</a>
            <hr>
         </div>
         <div class="product-listing row" id="product_data">
            @include('Front.listing._data')
         </div>
         <div class="content">
            <hr>
         </div>
      </div>
   </div>
   <input type="hidden" id="lastPage" value="{{ $products->lastPage() }}">
@endsection
@section('extra_js')
   <script src="{{asset('front-assets/external/nouislider/nouislider.min.js')}}"></script>
{{--   for pagination :--}}
   <script type="text/javascript">
       $(window).on('hashchange', function () {
           if (window.location.hash) {
               var page = window.location.hash.replace('#', '');
               if (page == Number.NaN || page <= 0) {
                   return false;
               } else {
                   getData(page);
               }
           }
       });

       $(document).ready(function () {
           $(document).on('click', '.pagination a', function (event) {
               event.preventDefault();
               $('li').removeClass('active');
               $(this).parent('li').addClass('active');
               var myurl = $(this).attr('href');
               var page = $(this).attr('href').split('page=')[1];
               // console.log(myurl)
               getData(page);
               window.history.pushState("", "", myurl);
           });
       });

       function getData(page) {
           $.ajax(
               {
                   url: '?page=' + page,
                   type: "get",
                   datatype: "html"
               })
               .done(function (data) {
                   $("#product_data").empty().append(data.html);
               location.hash = page;
           })
               .fail(function (jqXHR, ajaxOptions, thrownError) {
               alert('No response from server');
           });
       }
   </script>
{{--   FOR SORT--}}
   <script type="text/javascript">
       $(document).ready(function () {

           $("#order_form").submit(function (e) {
               e.preventDefault();
               var form = $(this);
               var form_data = new FormData(this);
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   //if we r in products page go to related route
                   url: "{{ (\Request::route()->getName()) == 'front.productsList' ? route('front.productsList') :   route('front.lists',['list' => \Request::route('list'), 'slug' => \Request::route('slug') ])}}",
                   method: "post",
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   beforeSend: function () {
                       $(".ajax-load").show();
                   },

               })
                   .done(function (data) {
                       if (data.html == " ") {
                           $('#load').hide();
                           $('.ajax-load').html("No more records found");
                           return;
                       }
                       $("#product_data").empty().append(data.html);
                       $('.ajax-load').hide();
                   }).fail(function () {
                   alert('error');
               })
           });
       });
   </script>
@endsection
