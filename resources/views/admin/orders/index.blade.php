@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty' )
@section('content')
   @include('layout.errors.notifications')
   <table id="simple-table" class="table table-bordered table-hover">
      <thead>
      <tr class="info">
         <th class="center">
            ID
         </th>
         <th class="center">Order Status</th>
         <th class="center">Track Code</th>
         <th class="center">Address</th>
         <th class="center">Customer User</th>
         <th class="center">Client Name</th>
         <th class="center">Employee Name</th>
         <th class="center">Payments</th>
         <th class="center">Total Price</th>
         <th class="center">Gift Card</th>
         <th class="center">Details</th>
         <th class="center">Date</th>
         <th class="center">Operations</th>
      </tr>
      </thead>
      <tbody>

      @forelse($orders as $key=> $order)
         {{--                  {{ dd($order->giftcard() )}}--}}
         <tr>
            <td class="center">{{$order->order_id}}</td>
            <td class="center">
               @switch($order->order_status)
                  @case(0)
                  <span class="label label-danger arrowed bolder smaller-90">NOT Sent Yet</span>
                  @break
                  @case(1)
                  <span class="label label-warning arrowed-right bolder smaller-90">Has Sent</span>
                  @break
                  @case(2)
                  <span class="label label-success arrowed-in bolder smaller-90">Delivered</span>
                  @break
               @endswitch
            </td>
            <td><b>{{ $order->track_code }}</b></td>
            <td class="center">
               <a href="#addr{{$order->order_id}}" class="bolder" data-toggle="modal">
                  <b><i class="fa fa-book bigger-250"></i>Address</b>
               </a>
            </td>
            <td class="center">
               @if($order->costumer_id == null)
               <span class="label label-default">GUEST</span>
                  @else
                  {{ $order->costumer_id }}
               @endif
            </td>
            <td class="center">{{ $order->client_name }}</td>
            <td class="center">{{ $order->employee }}</td>
            <td class="center">{{ $order->payment_id }}</td>
            <td class="bolder">{{ number_format($order->total_price) }}</td>
            <td CLASS="center">
               @if($order->gift_id != null)
                  <a href="#gift{{$order->order_id}}" class="bolder" data-toggle="modal">
                     {{ $order->giftcard()->gift_name }}
                  </a>
               @else
                  <i>NO GIFTCARD</i>
               @endif
            </td>
            <td>
               {{ str_limit($order->details,50) }}</td>
            <td>{{ $order->created_at }}
            </td>
            <td class="center">
               <div class="hidden-sm hidden-xs btn-group">
                  <form>
                     <a class="btn btn-info2 btn-xs show_me" title="Show Details"
                        href="{{ route('order.show',$order->order_id) }}" data-id="{{ $order->order_id }}">
                        <i class="ace-icon fa fa-eye bigger-120"></i>
                     </a>
                     <a class="btn btn-warning btn-xs edit_me" title="Edit"
                        {{--                        data-path="{{ str_replace("","",route('order.update',[],false)) }}"--}}
                        href="" data-id="{{ $order->order_id }}">
                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                     </a>
                     @if($order->order_status == 1 )
                        <a class="btn btn-success btn-xs sent_me" title="Delivered"
                           href="{{ route('order.status',[$order->order_id,'delivered']) }}" data-status="delivered">
                           <i class="ace-icon fa fa-thumbs-up bigger-120"></i>
                        </a>
                     @endif
                     @if($order->order_status == 0 )
                        <a class="btn btn-info btn-xs sent_me" title="Sent"
                           href="{{ route('order.status',[$order->order_id,'sent']) }}" data-status="sent">
                           <i class="ace-icon fa fa-send-o bigger-120"></i>
                        </a>
                     @endif
                     <button class="btn btn-sm btn-danger delete_me" title="Delete" data-id="{{ $order->order_id }}">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                     </button>
                  </form>
               </div>
            </td>
         </tr>
         <!--***POP UP MODELS*** -->

         <!-- GIFT -->
         @if($order->gift_id != null)
            <div id="gift{{$order->order_id}}" class="modal fade" tabindex="-1" style="display: none;">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="smaller lighter blue no-margin">{{ $order->giftcard()->gift_name }}</h3>
                     </div>
                     <div class="modal-body">
                        <ul>
                           <li><b>Gift Price:</b>{{ $order->giftcard()->gift_amount }}</li>
                           <li><b>Gift Code :</b>{{ $order->giftcard()->gift_code }}</li>
                        </ul>
                     </div>

                     <div class="modal-footer">
                        <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
                           <i class="ace-icon fa fa-times"></i>
                           Close
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         @endif
         <!-- ADDRESS MODEL -->

         <div id="addr{{$order->order_id}}" class="modal fade" tabindex="-1" style="display: none;">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h3 class="smaller lighter blue no-margin">{{ $order->address() != null ? $order->address()->name : 'NO ADDRESS' }}</h3>
                  </div>
                  <div class="modal-body">
                     <ul>
                        @if($order->address() != null)
                           <li><i>NAME :</i><b>{{ $order->address()->name }}</b></li>
                           <li><i>SURNAME:</i><b>{{ $order->address()->surname }}</b></li>
                           <li><i>STATE :</i><b>{{ $order->address()->state }}</b></li>
                           <li><i>CITY :</i><b>{{ $order->address()->city }}</b></li>
                           <li><i>AREA :</i><b>{{ $order->address()->area }}</b></li>
                           <li><i>AVENUE :</i><b>{{ $order->address()->avenue }}</b></li>
                           <li><i>STREET :</i><b>{{ $order->address()->street }}</b></li>
                           <li><i>NOM :</i><b>{{ $order->address()->number }}</b></li>
                           <li><i>PHONE NUMBER :</i><b>{{ $order->address()->phone_number }}</b></li>
                           <li><i>POSTAL CODE :</i><b>{{ $order->address()->postal_code }}</b></li>
                        @else
                           <h2 class="danger bolder h2"> NO ADDRESS!</h2>
                        @endif
                     </ul>
                  </div>

                  <div class="modal-footer">
                     <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Close
                     </button>
                  </div>
               </div>
            </div>
         </div>

         <!-- /.POP UP MODELS -->
      @empty
         <tr>
            <td colspan="12">No Data</td>
         </tr>
      @endforelse
      </tbody>
   </table>

   {{ $orders->links() }}
   <script>
       $(document).ready(function () {
           $(".delete_me").click(function (e) {
               e.preventDefault();
               if (!confirm('ARE YOU SURE TO DELETE IT?')) {
                   return false
               }
               var obj = $(this); // first store $(this) in obj
               var id = $(this).data("id");
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: "/admin/orders/" + id,
                   method: "DELETE",
                   dataType: "Json",
                   data: {"id": id},
                   success: function ($results) {
                       alert('Order Has Been successfully Deleted');
                       $(obj).closest("tr").remove(); //delete row
                       console.log($results);
                   },
                   error: function (xhr) {
                       alert('error,Order not deleted');
                       console.log(xhr.responseText);
                   }
               });
           });
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
                       alert('Order Status Has Been successfully changed');
                       $(obj).closest("a").remove(); //delete row
                       console.log($results);
                   },
                   error: function (xhr) {
                       alert('error,');
                       console.log(xhr.responseText);
                   }
               });
           });
           <!-- LOAD THE EDIT PAGE-->
           jQuery(".edit_me").bind('click', function () {
               var route = $(this).attr('href');
               var id = $(this).data('id');
               window.history.pushState("", "edit", "order/" + id + "/edit");
               $("#content-load").load(route);
               $(window).bind('popstate', function () {
                   window.location.href = window.location.href;
               });
               return false;
           });
           jQuery(".show_me").bind('click', function () {
               var route = $(this).attr('href');
               var id = $(this).data('id');
               window.history.pushState("", "", "orders/" + id);
               $("#content-load").load(route);
               $(window).bind('popstate', function () {
                   window.location.href = window.location.href;
               });
               return false;
           });
       });
   </script>
@endsection