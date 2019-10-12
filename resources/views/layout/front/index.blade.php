<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8">
   <title>@yield('title')</title>
   <meta name="keywords" content="@yield('keywords')">
   <meta name="description" content="@yield('description')">
   <meta name="author" content="{{ env('APP_NAME') }}">
{{--   <link rel="shortcut icon" href="favicon.ico">--}}
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="{{ asset('front-assets/external/bootstrap/bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{ asset('front-assets/external/slick/slick.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/external/rs-plugin/css/settings.min.css')}}" media="screen" />
   <link rel="stylesheet" href="{{ asset('front-assets/css/template.css')}}">
   <link rel="stylesheet" href="{{ asset('front-assets/css/footer-dark.css') }}">
{{--   <link rel="stylesheet" href="{{ asset('front-assets/css/template-rtl.css')}}">--}}
   <link rel="stylesheet" href="{{ asset('front-assets/font/icont-fonts.min.css')}}">
   <!--
      *THIS SCRIPT TAKES CHILDREN VALUES OF CATEGORY
      *AND PASS IT TO DIV
    -->
   <script>
      function nav_over(e) {
          var item = (e);
          id = item.dataset.id;
          if (document.getElementById("nav_info" + id).innerText != null){
            var info = document.getElementById("nav_info" + id).innerHTML ;
              var a =document.getElementById('category-chiled').innerHTML = info ;
              console.log(a);
          }
      }
   </script>
   <!-- EXTRA CSS -->
   @yield('extra_css')
   <!-- /EXTRA CSS -->
</head>
<body class="loaded">
<div class="loader-wrapper">
   <div class="loader">
      <svg class="circular" viewBox="25 25 50 50">
         <circle class="loader-animation" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
      </svg>
   </div>
</div>
@include('layout.front.partials._mobil-nav')
@include('layout.front.partials._header')

<!-- Content -->
<div id="pageContent">
   <div class="container">
      @yield('content')
   </div>
</div>

@include('layout.front.partials._footer')

<script src="{{asset('front-assets/external/jquery/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('front-assets/external/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('front-assets/external/countdown/jquery.plugin.min.js')}}"></script>
<script src="{{asset('front-assets/external/countdown/jquery.countdown.min.js')}}"></script>
<script src="{{asset('front-assets/external/slick/slick.min.js')}}"></script>

<script src="{{asset('front-assets/external/instafeed/instafeed.min.js')}}"></script>

<script src="{{asset('front-assets/external/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('front-assets/external/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
<script src="{{asset('front-assets/external/panelmenu/panelmenu.js')}}"></script>
<script src="{{asset('front-assets/js/quick-view.js')}}"></script>
<script src="{{asset('front-assets/js/main.js')}}"></script>
<!-- EXTRA JS -->
@yield('extra_js')
<!-- /EXTRA JS -->
</body>
</html>