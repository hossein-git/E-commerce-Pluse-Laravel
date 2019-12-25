@extends('layout.admin.index' )
@section('title')
   Order Details
@stop
@section('extra_css')
@stop
@section('content')
   @include('layout.errors.notifications')
      <table id="simple-table" class="table table-bordered table-hover table-responsive">
         <thead>
         <tr class="info">
            <th class="center">
               #
            </th>
            <th class="center">Product Name</th>
            <th class="center">Size</th>
            <th class="center">Color</th>
            <th class="center">Attributes</th>
            <th class="center">Product Price</th>
            <th class="center">Quantity</th>
            <th class="center">Create Date</th>
            <th class="center">Operations</th>
         </tr>
         </thead>
         <tbody>
         @forelse($detailsOrder as $key=> $d_order)
            <tr>
               <td class="center">{{$key++}}</td>
               <td class="center">
                  <a class="click_me" href="{{ route('product.show',$d_order->product_id) }}">
                     {{($d_order->products->product_name)}}</a>
               </td>
               <td class="center">{{$d_order->size}}</td>
               <td class="center">{{$d_order->color}}</td>
               <td class="center">{{$d_order->attributes ?: ''}}</td>
               <td class="center">{{$d_order->product_price}}</td>
               <td class="center">{{$d_order->quantity}}</td>
               <td class="center">{{$d_order->created_at}}</td>
               <td class="center">

                        @can('order-delete')
                           <div class="hidden-md hidden-lg">
                              <div class="inline pos-rel">
                                 <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                    <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                 </button>

                                 <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                    <li>
                                       <a class="btn btn-xs btn-danger delete_me" data-id="{{ $d_order->details_order_id }}">
                                          <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                           </div>

                           <div class="hidden-sm hidden-xs btn-group">
                              <a class="btn btn-xs btn-danger delete_me" data-id="{{ $d_order->details_order_id }}">
                                 <i class="ace-icon fa fa-trash-o bigger-120"></i>
                              </a>
                           </div>
                        @endcan




               </td>
            </tr>
         @empty
            <tr>
               <td colspan="11">No Data</td>
            </tr>
         @endforelse
         </tbody>
      </table>



@endsection
@section('extra_js')
   @can('order-delete')
      <script>
          $(document).ready(function () {
              deleteAjax("/admin/orders/orders-status/", "delete_me", "Order Details");
          });
      </script>
   @endcan
@stop