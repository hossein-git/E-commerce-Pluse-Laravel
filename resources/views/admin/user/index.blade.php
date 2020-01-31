@extends('layout.admin.index')
@section('title')
Users List
@endsection
@section('extra_css')
@endsection
@section('content')
   <table class="table table-bordered table-hover">
      <thead>
      <tr class="info">
         <th class="center">
            ID
         </th>
         <th class="center">Name</th>
         <th class="center">Email</th>
         <th class="center">Role</th>
         <th class="center">Created Date</th>
         <th class="center">Operations</th>
      </tr>
      </thead>
      <tbody class="table_data">
         @include('admin.user._data')

      </tbody>
   </table>
{{ $users->links() }}



@endsection
@section('extra_js')
   <script type="text/javascript">
      $(document).ready(function () {
          deleteAjax('/admin/user/','delete_user','user')
      });
      @if(env('APP_AJAX'))
      jQuery(".edit_user").bind('click', function () {
          var route = $(this).attr('href');
          var pjax = new Pjax({
              selectors: ["title", "#extra_css", "#content-load", "#extra_js"]
          });
          pjax.loadUrl(route);
      });
      jQuery(".show_user").bind('click', function () {
          var route = $(this).attr('href');
          var pjax = new Pjax({
              selectors: ["title", "#extra_css", "#content-load", "#extra_js"]
          });
          pjax.loadUrl(route);
      });
      @endif

   </script>
@endsection