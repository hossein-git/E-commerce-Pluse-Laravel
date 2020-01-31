@extends('layout.admin.index' )
@section('title')
   Order List
@stop
@section('extra_css')
@stop
@section('content')


   <form method="post" action="{{ route('admin.search') }}" id="form-search"
   onsubmit="event.preventDefault()">
      @csrf
      <input type="hidden" value="orders" name="search_kind">
      <span class="input-icon">
         <input type="number" placeholder="Search ..." class="nav-search-input"
                autocomplete="off" name="search"/>
         <i class="ace-icon fa fa-search nav-search-icon"></i>
         <button type="submit" class="btn btn-sm">
            <span class="fa fa-search"></span>
         </button>
      </span>
      <span><i>search for <b>TRACK CODE</b></i></span>
   </form>
   <div class="">
      <table id="simple-table" class="table table-bordered table-hover table-responsive">
         <thead>
         <tr class="info">
            <th class="center">
               ID
            </th>
            <th class="center">Order Status</th>
            <th class="center">Track Code</th>
            <th class="center">Payments</th>
            <th class="center">Address</th>
            <th class="center">Customer User</th>
            <th class="center">Client Name</th>
            <th class="center">Client Phone, Email</th>
            {{--         <th class="center">Employee Name</th>--}}
            <th class="center">Total Price</th>
            <th class="center">Gift Card</th>
            <th class="center">Date</th>
            <th class="center">Operations</th>
         </tr>
         </thead>
         <tbody class="table_data">
         @include('admin.orders._data')

         </tbody>
      </table>
   </div>


   {{ $orders->links() }}

@endsection
@section('extra_js')
   <script>
       $(document).ready(function () {
          @can('order-delete')
           <!-- DELETE -->
           deleteAjax("/admin/orders/", "delete_me", "Order");
          @endcan
           <!-- SENT -->
           $(".sent_me").click(function (e) {
               e.preventDefault();
               if (!confirm('DO YOU WANT TO CHANGE STATUS?')) {
                   return false
               }
               var obj = $(this); // first store $(this) in obj
               var status = $(this).data("status");
               var href = $(this).attr("href");
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: href,
                   method: "get",
                   success: function ($results) {
                       alert($results.message);
                       $(obj).closest("a").remove(); //delete icon
                       // var x = $(obj).parents('tr').load(location.href + obj); //delete icon

                       console.log($results);
                   },
                   error: function (xhr) {
                       alert(xhr.responseText.message);
                       console.log(xhr.responseText);
                   }
               });
           });
       });
   </script>
@stop