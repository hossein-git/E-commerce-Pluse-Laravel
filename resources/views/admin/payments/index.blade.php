@extends('layout.admin.index')
@section('title')
   Payments
@endsection
@section('extra_css')
@endsection
@section('content')
   <table id="simple-table" class="table table-hover table-responsive table-bordered">
      <thead class="table-header">
      <tr class="info">
         <td class="center">id</td>
         <td class="center">User</td>
         <td class="center">Order</td>
         <td class="center">sub total</td>
         <td class="center">Status</td>
         <td class="center">Payment Status</td>
         <td class="center">Data</td>
{{--         <td class="center">Operations</td>--}}
      </tr>
      </thead>
      <tbody>
      @forelse ($payments as $payment)

         <tr>
            <td class="center">{{ $payment->payment_id }}</td>
            <td class="center">
               @if ($payment->users)
                  <a href="{{ route('user.show',$payment->user_id) }}">{{ $payment->users->name }}</a>3
                  @else
                  <span class="label label-default">GUEST</span>
               @endif
            </td>
            <td class="center">
               <a href="{{ route('order.show', $payment->order_id) }}">{{ $payment->order->track_code }}</a>
            </td>
            <td class="center">{{ $payment->sub_total }}</td>
            <td class="center">
               @if ($payment->status )
                  <span class="label label-success label-large">PAID</span>
               @else
                  <span class="label label-danger label-large">NOT-PAID</span>
               @endif

            </td>
            <td class="center">{{ $payment->payment_status }}</td>
            <td class="center">{{ $payment->created_at }}</td>

         </tr>


      @empty
         <tr>
            <td colspan="9">NO Data</td>
         </tr>
      @endforelse
      </tbody>

   </table>




@endsection
@section('extra_js')
@endsection