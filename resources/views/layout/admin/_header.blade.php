<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>

    <meta name="description" content="e-commerce"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="_token" content="{{ csrf_token()}}"/>
    <link rel="shortcut icon" href="">

    <link rel="stylesheet" href="{{asset('admin-assets/css/admin-style.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin-assets/font-awesome/4.5.0/css/font-awesome.min.css')}}"/>
    <!-- page specific plugin styles -->
    <div id="extra_css">
        @yield('extra_css')
    </div>
    <!-- /page specific plugin styles -->
    <link href="{{asset('admin-assets/dist/font/font-fileuploader.css')}}" rel="stylesheet">
    <link href="{{asset('admin-assets/dist/jquery.fileuploader.min.css')}}" rel="stylesheet">
    <!-- text fonts -->
    <script src="{{ asset('admin-assets/js/jquery-2.1.4.min.js')}}"></script>
</head>