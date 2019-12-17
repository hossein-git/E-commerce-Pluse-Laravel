@extends('layout.admin.index' )
@section('title')
   Order Details
@stop
@section('extra_css')
@stop
@section('content')
   @include('layout.errors.notifications')
   <table id="simple-table" class="table table-bordered table-hover">
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
               <div class="hidden-sm hidden-xs btn-group">
                  <form>
                     @can('order-delete')
                        <button class="btn btn-xs btn-danger delete_me" data-id="{{ $d_order->details_order_id }}">
                           <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        </button>
                     @endcan
                  </form>
               </div>
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