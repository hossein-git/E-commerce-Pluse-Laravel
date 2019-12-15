@extends('layout.front.index')
@section('title')
   My Orders
@endsection
@section('extra_css')
@endsection
@section('content')
   <h4>Order History</h4>
   <table class="table-order-history">
      <thead>
      <tr>
         <th>Track Code</th>
         <th>Date</th>
         <th>Address</th>
         <th>Payment Status</th>
         <th>Fulfillment Status</th>
         <th>Gift Card</th>
         <th>Total Price</th>
         <th>Details</th>
         <th>show orders</th>
      </tr>
      </thead>
      <tbody>
      @forelse($orders as $order)

         <tr>
            <td>
               <a href="#" data-cls="{{ "_details$order->order_id" }}"
                  onclick="event.preventDefault();show_order_details(this)">{{ $order->track_code }}</a>
            </td>
            <td>
               <div class="th-title visible-xs">Date</div>
               {{ $order->created_at }}
            </td>
            <td>
               <a href="" data-toggle="modal" data-target="{{ "#ModalquickView$order->order_id" }}" class="quick-view">
                  <span><i class="icon icon-book"></i></span>
               </a>
            </td>
            <td>
               <div class="th-title visible-xs">Payment Status</div>
               ????
            </td>
            <td class="status_">
               <div class="th-title visible-xs">Fulfillment Status</div>
               @switch($order->order_status)
                  @case(0)
                  <span class="label badge-normal smaller-90">NOT Complete</span>
                  @break
                  @case(1)
                  <span class="label label-default arrowed bolder smaller-90">NOT Sent Yet</span>
                  @break
                  @case(2)
                  <span class="label label-warning bolder smaller-90">Has Sent</span>
                  @break
                  @case(3)
                  <span class="label label-success bolder smaller-90">Delivered</span>
                  @break
                  @case(5)
                  <span class="label bg-brown">Canceled</span>
                  @break
               @endswitch
            </td>
            <td>
               @if($order->giftCard)
                  <a href="#gift{{$order->order_id}}" class="bolder" data-toggle="modal">
                     {{ $order->giftCard->gift_name }}
                  </a>
               @else
                  <i>NO GIFTCARD</i>
               @endif
            </td>
            <td>
               <div class="th-title visible-xs">Total</div>
               {{ number_format($order->total_price) }}
            </td>
            <td>
               {{ $order->details }}
            </td>
            <td>
               <!-- show order details -->
               <a href="#" data-cls="{{ "_details$order->order_id" }}" class="btn btn-info btn-xs"
                  onclick="event.preventDefault();show_order_details(this)">
                  <i class="icon icon-open_in_browser"></i>
               </a>
               @if ($order->order_status == 0)
                  <div class="_operations">
                     <a class="btn btn-xs bg-orange" title="edit address"
                        href="{{ route('front.order.address.edit',$order->order_id) }}">
                        <i class="icon icon-edit"></i>
                     </a>

                     <a class="btn btn-xs btn-red cancel_order" data-id="{{$order->order_id}}" title="Cancel Order"
                        onclick="return confirm('Are you sure to cancel this order?')"
                        href="{{ route('front.cancel.order') }}">
                        <i class="icon icon-delete"></i>
                     </a>
                  </div>
               @endif

            </td>
            <td style="display: none">
               <div class="{{ "_details$order->order_id" }}">
                  <div class="offset-36">
                     <h4 class="text-info">ORDER : {{ $order->track_code }}</h4>
                     <div class="offset-30">
                        <div class="responsive-table-order-history-02">
                           <table class="table-order-history-02 table-hover table-bordered">
                              <thead class="">
                              <tr>
                                 <th>Product</th>
                                 <th>size</th>
                                 <th>color</th>
                                 <th>attributes</th>
                                 <th>Price</th>
                                 <th>Quantity</th>
                              </tr>
                              </thead>
                              <tbody>
                              @forelse($order->detailsOrder as $details)
                                 <tr>
                                    <td>
                                       <a class="click_me" href="{{ route('front.show',$details->product_slug) }}">
                                          {{($details->product_slug)}}</a>
                                    </td>
                                    <td class="">{{$details->size}}</td>
                                    <td class="">{{$details->color}}</td>
                                    <td class="">{{$details->attributes ?: '-'}}</td>
                                    <td class="">{{$details->product_price}}</td>
                                    <td class="">{{$details->quantity}}</td>
                                 </tr>
                              @empty
                                 <tr>
                                    <td colspan="6">ORDER WITHOUT ANY PRODUCT</td>
                                 </tr>
                              @endforelse
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </td>
         </tr>
         <tr>
            @if ($order->giftCard)
               <div class="modal fade" id="{{ "gift$order->order_id" }}" tabindex="-1" role="dialog"
                    aria-label="myModalLabel" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content ">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                                      class="icon icon-clear"></span></button>
                        </div>
                        <form>
                           <div class="modal-body">
                              <!--modal-quick-view-->
                              <div class="modal-quick-view">
                                 <div class="row">
                                    <ul>
                                       <li><b>Gift Price :</b><span
                                                  class="red">{{ $order->giftCard->gift_amount }}</span></li>
                                       <li><b>Gift Code :</b><span
                                                  class="orange">{{ $order->giftCard->gift_code }}</span></li>
                                    </ul>
                                 </div>
                              </div>
                              <!--/modal-quick-view-->
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            @endif
            <div class="modal fade" id="{{ "ModalquickView$order->order_id" }}" tabindex="-1" role="dialog"
                 aria-label="myModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content ">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                                   class="icon icon-clear"></span></button>
                     </div>
                     <form>
                        <div class="modal-body">
                           <!--modal-quick-view-->
                           <div class="modal-quick-view">
                              <div class="row">
                                 <div class="col-sm-5 col-lg-6">
                                    <ul>
                                       <li>NAME :</li>
                                       <li>SURNAME:</li>
                                       <li>STATE :</li>
                                       <li>CITY :</li>
                                       <li>AREA :</li>
                                       <li>AVENUE :</li>
                                       <li>STREET :</li>
                                       <li>NOM :</li>
                                       <li>PHONE NUMBER :</li>
                                       <li>POSTAL CODE :</li>
                                    </ul>
                                 </div>
                                 <div class="col-sm-7 col-lg-6">
                                    <div class="product-info">
                                       @if ($order->address)
                                          <ul>
                                             <li class="bolder">{{ $order->address->name }} </li>
                                             <li class="bolder">{{ $order->address->surname }} </li>
                                             <li class="bolder">{{ $order->address->state }} </li>
                                             <li class="bolder">{{ $order->address->city }} </li>
                                             <li class="bolder">{{ $order->address->area }} </li>
                                             <li class="bolder">{{ $order->address->avenue }} </li>
                                             <li class="bolder">{{ $order->address->street }} </li>
                                             <li class="bolder">{{ $order->address->number }} </li>
                                             <li class="bolder">{{ $order->address->phone_number }} </li>
                                             <li class="bolder">{{ $order->address->postal_code }} </li>
                                          </ul>
                                       @else
                                          <h2 class="text-danger">NO ADDRESS FOR THIS ORDER! </h2>
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--/modal-quick-view-->
                        </div>
                     </form>
                  </div>
               </div>
            </div>

         </tr>
      @empty
         <tr>
            <td colspan="6">You haven't placed any orders yet.</td>
         </tr>

      @endforelse
      </tbody>
   </table>
   <hr id="here">
   <div id="show_details"></div>


@endsection
@section('extra_js')
   <script src="{{ asset('front-assets/js/checkOut.js') }}"></script>
   <script type="text/javascript">
      //show order details
       function show_order_details(e) {
           var cls = $(e).data('cls');
           var details = $('.' + cls).html();
           $('#show_details').empty().append(details);
           $('html, body').animate({
               scrollTop: $("#here").offset().top
           }, 1000);
       }
      //cancel order
       $(document).ready(function () {
           $('.cancel_order').on('click', function (e) {
               e.preventDefault();
               var data = {
                   _method: 'put',
                   order_id: $(this).data('id')
               };
               if (upload_ajax("{{ route('front.cancel.order') }}", data)) {
                   alert('your order has been canceled');
                   $(this).closest("tr").find('.status_').empty().append('<span class="label bg-brown">Canceled</span>');
                   $(this).closest('div').remove();

               }
           })
       });
   </script>
@endsection