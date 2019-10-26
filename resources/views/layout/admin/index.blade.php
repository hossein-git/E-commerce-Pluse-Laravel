<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layout.admin._header')
<body class="no-skin">
@include('layout.admin.components')
<!-- navBar -->
@include('layout.admin._navbar')
<!-- /navbar -->
<div class="main-container ace-save-state" id="main-container">
   <script type="text/javascript">
       try {
           ace.settings.loadState('main-container')
       } catch (e) {
       }
   </script>

   <!-- MENU -->
@include('layout.admin._sidebar')
<!-- /MENU -->

   <div class="main-content">
      <div class="main-content-inner">
         <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb" id="site_map">
               <li>
                  <i class="ace-icon fa fa-home home-icon"></i>
                  <a href="#" class="click_me" data-route="{{ route('admin.dashboard') }}">Dashboard</a>
               </li>
            </ul>
            <!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
               <form class="form-search">
                  <span class="input-icon">
                     <input type="text" placeholder="Search ..." class="nav-search-input"
                            id="nav-search-input" autocomplete="off"/>
                     <i class="ace-icon fa fa-search nav-search-icon"></i>
                  </span>
               </form>
            </div>
            <!-- /.nav-search -->
         </div>

         <div class="page-content">
            <div class="ace-settings-container" id="ace-settings-container">
               <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                  <i class="ace-icon fa fa-cog bigger-130"></i>
               </div>

               <div class="ace-settings-box clearfix" id="ace-settings-box">
                  <div class="pull-left width-50">
                     <div class="ace-settings-item">
                        <div class="pull-left">
                           <select id="skin-colorpicker" class="hide">
                              <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                              <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                              <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                              <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                           </select>
                        </div>
                        <span>&nbsp; Choose Skin</span>
                     </div>

                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar"
                               autocomplete="off"/>
                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                     </div>

                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar"
                               autocomplete="off"/>
                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                     </div>

                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs"
                               autocomplete="off"/>
                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                     </div>

                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off"/>
                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                     </div>

                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container"
                               autocomplete="off"/>
                        <label class="lbl" for="ace-settings-add-container">
                           Inside
                           <b>.container</b>
                        </label>
                     </div>
                  </div><!-- /.pull-left -->

                  <div class="pull-left width-50">
                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off"/>
                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                     </div>

                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off"/>
                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                     </div>

                     <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight"
                               autocomplete="off"/>
                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                     </div>
                  </div><!-- /.pull-left -->
               </div><!-- /.ace-settings-box -->
            </div>
            <!-- /.ace-settings-container -->
            <div class="row">
               <div class="col-xs-12" id="content-load">
                  <!-- PAGE CONTENT BEGINS -->
                  @yield('content')
                  <!-- PAGE CONTENT ENDS -->
               </div><!-- /.col -->
            </div><!-- /.row -->
         </div><!-- /.page-content -->
      </div>
   </div><!-- /.main-content -->

   <div class="footer">
      <div class="footer-inner">
         <div class="footer-content">
            <span class="bigger-120">
               <span class="blue bolder">{{ env('APP_NAME') }}</span>
              <a href="http://findhossein.ir/">developed by HOSSEIN HAGHPARAST</a> ; 2019
            </span>

            &nbsp; &nbsp;
            <span class="action-buttons">
               <a href="#">
                  <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
               </a>

               <a href="#">
                  <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
               </a>

               <a href="#">
                  <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
               </a>
            </span>
         </div>
      </div>
   </div>

   <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
      <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
   </a>
</div>
<!-- /.main-container -->

<!-- basic scripts -->


<script type="text/javascript">
{{--    if ('ontouchstart' in document.documentElement) document.write("<script src='{{ asset(`admin-assets/js/jquery.mobile.custom.min.js`) }}'>" + "<" + "/script>");--}}
</script>
<script src="{{ asset('admin-assets/js/bootstrap.min.js')}}"></script>
<!-- LOAD MY JS CODES  -->
<script src="{{ asset('admin-assets/js/myCodes.js')}}"></script>
<!-- //LOAD MY JS CODES  -->

<!-- LOAD PJAX -->
<script src="{{ asset('js/pjax/pjax.min.js') }}"></script>

<!-- page specific plugin scripts -->

{{--<script src="{{asset('admin-assets/js/jquery-ui.custom.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/jquery.ui.touch-punch.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/chosen.jquery.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/spinbox.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/bootstrap-datepicker.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/bootstrap-timepicker.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/moment.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/daterangepicker.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/bootstrap-datetimepicker.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/bootstrap-colorpicker.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/jquery.knob.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/autosize.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/jquery.inputlimiter.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/jquery.maskedinput.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/bootstrap-tag.min.js')}}"></script>--}}
{{--<script src="{{ asset('admin-assets/js/select2.min.js') }}"></script>--}}
<script src="{{asset('admin-assets/js/jquery.bootstrap-duallistbox.min.js')}}"></script>
<script src="{{asset('admin-assets/js/jquery.validate.min.js')}}"></script>
{{--<script src="{{asset('admin-assets/js/jquery.raty.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/bootstrap-multiselect.min.js')}}"></script>--}}
{{--<script src="{{asset('admin-assets/js/select2.min.js')}}"></script>--}}
<script src="{{asset('admin-assets/js/jquery-typeahead.js')}}"></script>
<script src="{{asset('admin-assets/js/tree.min.js')}}"></script>
{{--<script src="{{ asset('dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ asset('dist/custom.js') }}" type="text/javascript"></script>--}}

<!-- ace scripts -->
<script src="{{ asset('admin-assets/js/ace-elements.min.js')}}"></script>
<script src="{{ asset('admin-assets/js/ace.min.js')}}"></script>
<!-- script for load page on AJAX-->
<script>
    jQuery(document).ready(function () {
        jQuery(".click_me").one('click', function (e) {
            e.preventDefault();
            var route = $(this).attr('href');
            var pjax = new Pjax({
                selectors: ["title", "#extra_css", "#content-load", "#extra_js"]
            });
            pjax.loadUrl(route);
        });
    });
</script>
<!-- END script for load page on ajax-->
<!-- BEGIN EXTRA JS-->
<div id="extra_js">
   @yield('extra_js')
</div>
<!-- END EXTRA JS-->

</body>
</html>

