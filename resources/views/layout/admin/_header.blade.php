<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>@yield('title','Admin Panel')</title>

    <meta name="description" content="e-commerce"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="_token" content="{{ csrf_token()}}"/>
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin-assets/font-awesome/4.5.0/css/font-awesome.min.css')}}"/>

    <!-- page specific plugin styles -->
    @yield('extra_css')
    <link href="{{asset('dist/font/font-fileuploader.css')}}" rel="stylesheet">
    <link href="{{asset('dist/jquery.fileuploader.min.css')}}" rel="stylesheet">


    {{--    <link rel="stylesheet" href="{{asset('admin-assets/css/jquery-ui.custom.min.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('admin-assets/css/chosen.min.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap-datepicker3.min.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap-timepicker.min.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('admin-assets/css/daterangepicker.min.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap-datetimepicker.min.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap-colorpicker.min.css')}}" />--}}
    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap-duallistbox.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin-assets/css/bootstrap-multiselect.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin-assets/css/select2.min.css')}}" />


    <!-- text fonts -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/fonts.googleapis.com.css')}}"/>
    <!-- ace styles -->
    <link rel="stylesheet" href="{{asset('admin-assets/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset('admin-assets/css/ace-part2.min.css') }}" class="ace-main-stylesheet"/>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('admin-assets/css/ace-skins.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin-assets/css/ace-rtl.min.css')}}"/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{asset('admin-assets/css/ace-ie.min.css')}}"/>
    <![endif]-->
    <!-- inline styles related to this page -->
    <!-- ace settings handler -->
    <script src="{{asset('admin-assets/js/ace-extra.min.js')}}"></script>
    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
    <!--[if lte IE 8]>
    <script src="{{ asset('admin-assets/js/html5shiv.min.js')}}"></script>
    <script src="{{ asset('admin-assets/js/respond.min.js') }}"></script>
    <![endif]-->

    <!--[if !IE]> -->
    <script src="{{ asset('admin-assets/js/jquery-2.1.4.min.js')}}"></script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script src="{{ asset('admin-assets/js/jquery-1.11.3.min.js') }}"></script>
    <![endif]-->
</head>