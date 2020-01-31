@forelse($orders as $key=> $order)
   @php($address = $order->address)
   @php($gift = $order->giftCard)
   <tr>
      <td class="center">{{$order->order_id}}</td>
      <td class="center order_status" >
         @switch($order->order_status)
            @case(0)
            <span class="label label-grey arrowed bolder smaller-90">NOT Complete</span>
            @break
            @case(1)
            <span class="label label-danger arrowed bolder smaller-90">NOT Sent Yet</span>
            @break
            @case(2)
            <span class="label label-warning arrowed-right bolder smaller-90">Has Sent</span>
            @break
            @case(3)
            <span class="label label-success arrowed-in bolder smaller-90">Delivered</span>
            @break
            @case(5)
            <span class="label label-yellow bolder smaller-90">Canceled</span>
            @break
         @endswitch
      </td>
      <td><b>{{ $order->track_code }}</b></td>
      <td class="center">
         @if ($order->payment)
            @if ($order->payment->status )
               <span class="label label-success label-large">VALID</span>
            @else
               <span class="label label-danger label-large">INVALID</span>
            @endif
         @else
            <span class="label label-warning label-large">NOTHING</span>
         @endif
      </td>
      <td class="center">
         <a href="#addr{{$order->order_id}}" class="bolder" data-toggle="modal">
            <b><i class="fa fa-book bigger-250"></i>Address</b>
         </a>
      </td>
      <td class="center">
         @if($order->user_id)
            <a href="{{ route('user.show',$order->users->user_id)}}">{{ $order->users->name}}</a>
         @else
            <span class="label label-default">GUEST</span>
         @endif
      </td>
      <td class="center">{{ $order->client_name }}</td>
      <td class="center">
         <span>{{ $order->client_phone }}</span>
         <strong>{{ $order->client_email }}</strong>
      </td>
{{--      <td class="center">{{ $order->employee }}</td>--}}

      <td class="bolder">{{ number_format($order->total_price) }}</td>
      <td CLASS="center">
         @if($gift)
            <a href="#gift{{$order->order_id}}" class="bolder" data-toggle="modal">
               {{ $gift->gift_name }}
            </a>
         @else
            <i>NO GIFTCARD</i>
         @endif
      </td>
      <td>{{ $order->created_at }}
      </td>

      <td class="center">

         <div class="hidden-md hidden-lg">
            <div class="inline pos-rel">
               <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                  <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
               </button>

               <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                 <li>
                    <a class="btn btn-info2 btn-xs click_me" title="Show Details"
                         href="{{ route('order.show',$order->order_id) }}">
                       <i class="ace-icon fa fa-eye bigger-120"></i>
                    </a>
                 </li>
                  @can('order-edit')
                     {{--<li><a class="btn btn-warning btn-xs click_me" title="Edit"
                            href="" data-id="{{ $order->order_id }}">
                           <i class="ace-icon fa fa-pencil bigger-120"></i>
                        </a></li>--}}
                     @if($order->order_status == 2 )
                        <li>
                           <a class="btn btn-success btn-xs sent_me" title="Delivered"
                                href="{{ route('order.status',[$order->order_id,'delivered']) }}" data-status="delivered">
                              <i class="ace-icon fa fa-thumbs-up bigger-120"></i>
                           </a>
                        </li>

                     @endif
                     @if($order->order_status == 1 )
                        <li>
                           <a class="btn btn-info btn-xs sent_me" title="Sent"
                               href="{{ route('order.status',[$order->order_id,'sent']) }}" data-status="sent">
                              <i class="ace-icon fa fa-send-o bigger-120"></i>
                           </a>
                        </li>
                     @endif
                  @endcan
                  @can('order-delete')
                     <li>
                        <a class="btn btn-sm btn-danger delete_me" title="Delete" data-id="{{ $order->order_id }}">
                           <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        </a>
                     </li>
                  @endcan
               </ul>
            </div>
         </div>

         <div class="hidden-sm hidden-xs btn-group">
            <form>
               <a class="btn btn-info2 btn-xs click_me" title="Show Details"
                  href="{{ route('order.show',$order->order_id) }}">
                  <i class="ace-icon fa fa-eye bigger-120"></i>
               </a>
               @can('order-edit')
                  {{--<a class="btn btn-warning btn-xs click_me" title="Edit"
                     href="" data-id="{{ $order->order_id }}">
                     <i class="ace-icon fa fa-pencil bigger-120"></i>
                  </a>--}}

               @if($order->order_status == 2 )
                  <a class="btn btn-success btn-xs sent_me" title="Delivered"
                     href="{{ route('order.status',[$order->order_id,'delivered']) }}" data-status="delivered">
                     <i class="ace-icon fa fa-thumbs-up bigger-120"></i>
                  </a>
               @endif
               @if($order->order_status == 1 )
                  <a class="btn btn-info btn-xs sent_me" title="Sent"
                     href="{{ route('order.status',[$order->order_id,'sent']) }}" data-status="sent">
                     <i class="ace-icon fa fa-send-o bigger-120"></i>
                  </a>
               @endif
               @endcan
               @can('order-delete')
                  <button class="btn btn-sm btn-danger delete_me" title="Delete" data-id="{{ $order->order_id }}">
                     <i class="ace-icon fa fa-trash-o bigger-120"></i>
                  </button>
               @endcan
            </form>
         </div>

      </td>
   </tr>
   <!--***POP UP MODELS*** -->

   <!-- GIFT -->
   @if($gift)
      <div id="gift{{$order->order_id}}" class="modal fade" tabindex="-1" style="display: none;">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h3 class="smaller lighter blue no-margin">{{ $gift->gift_name }}</h3>
               </div>
               <div class="modal-body">
                  <ul>
                     <li><b>Gift Price:</b>{{ $gift->gift_amount }}</li>
                     <li><b>Gift Code :</b>{{ $gift->gift_code }}</li>
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
               <h3 class="smaller lighter blue no-margin">{{ ($address)  ? ($address->name) : 'NO ADDRESS' }}</h3>
            </div>
            <div class="modal-body">
               @if(($address) )
                  <div class="row">
                     <div class="col-sm-4">
                        <ul class="list-unstyled  spaced">
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
                     <div class="col-sm-8">
                        <ul class=" spaced">
                           <li class="bolder">{{ $address->name }} </li>
                           <li class="bolder">{{ $address->surname }} </li>
                           <li class="bolder">{{ $address->state }} </li>
                           <li class="bolder">{{ $address->city }} </li>
                           <li class="bolder">{{ $address->area }} </li>
                           <li class="bolder">{{ $address->avenue }} </li>
                           <li class="bolder">{{ $address->street }} </li>
                           <li class="bolder">{{ $address->number }} </li>
                           <li class="bolder">{{ $address->phone_number }} </li>
                           <li class="bolder">{{ $address->postal_code }} </li>
                        </ul>
                     </div>
                  </div>

               @else
                  <h2 class="danger bolder h2"> NO ADDRESS!</h2>
               @endif
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
   <tr class="center">
      <td colspan="12">No Data</td>
   </tr>
@endforelse