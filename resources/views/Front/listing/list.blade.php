@extends('layout.front.index')
@section('title')
   list
@endsection
@section('extra_css')
   <meta name="_token" content="{{ csrf_token()}}"/>
@endsection
@section('content')
   {{--   {{ dd(\Request::route('slug')) }}--}}
   <div class="row">
      <!-- left col -->
   @include('Front.listing._leftMenu')
   <!-- center col -->
      <div class="col-md-9 col-lg-10 col-xl-10">
         <div class="product-listing row" id="product_data">
            @include('Front.listing._data')
         </div>
         <div class="content">
            <center><img alt="" src="{{ asset('admin-assets/5.gif') }}" class="center preview ajax-load"
                         style="display: none"></center>
            {{--            <center id="load" style="display: none">NO MORE DATA</center>--}}
            <hr>
         </div>
      </div>

   </div>
   <input type="hidden" id="lastPage" value="{{ $products->lastPage() }}">
@endsection
@section('extra_js')
   <script src="{{asset('front-assets/external/nouislider/nouislider.min.js')}}"></script>
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
                   url: "{{ (\Request::route()->getName()) == 'front.productsList' ? route('front.productsList') :   route('front.lists',['lists' => \Request::route('list'), 'slug' => \Request::route('slug') ])}}",
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
                           // $('.ajax-load').attr('src', '');
                           $('#load').hide();
                           $('.ajax-load').html("No more records found");
                           return;
                       }
                       // $("#product_data").empty();
                       $("#product_data").empty().append(data.html);
                       $('.ajax-load').hide();
                   }).fail(function () {
                   alert('error');
               })
           });

       });

   </script>
@endsection
