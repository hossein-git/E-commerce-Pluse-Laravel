@extends('layout.front.index')
@section('title')
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="col-sm-12 col-xs-12">
      <div class="widget-box transparent">
         <div class="widget-header widget-header-large">
            <h3 class="widget-title grey lighter">
               <i class="ace-icon fa fa-leaf green"></i>
               Track Code:<span>#{{ $order->track_code}}</span>
               <span class="pull-right">Date: <span class="">{{ $order->created_at }}</span></span>
            </h3>
            {{--<div class="widget-toolbar hidden-480">
               <a href="#">
                  <i class="ace-icon fa fa-print"></i>
               </a>
            </div>--}}
         </div>

         <div class="widget-body">
            <div class="widget-main padding-24">
               <div class="row">
                  <div class="col-sm-6">
                     <div class="row">
                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                           <b>Shipper Info</b>
                        </div>
                     </div>

                     <div>
                        <ul class="list-unstyled spaced">
                           <li>
                              <i class="ace-icon fa fa-caret-right blue"></i>Name:
                              <span> {{ $order->client_name }}</span>
                           </li>

                           <li>
                              <i class="ace-icon fa fa-caret-right blue"></i>
                              Phone:
                              <b class="red">{{ $order->client_phone }}</b>
                           </li>
                           <li>
                              <i class="ace-icon fa fa-caret-right blue"></i>
                              Email:
                              <b class="red">{{ $order->client_email }}</b>
                           </li>

                           <li class="divider"></li>

                           <li>
                              <i class="ace-icon fa fa-caret-right blue"></i>
                              <b>Gift Card:</b>
                              @if ($gift = $order->giftCard)
                                 <span>{{ $gift->gift_name }}</span>
                                 <ul>
                                    <li>
                                       <b>Gift Price:</b>
                                       <span class="badge badge-primary">{{ $gift->gift_amount }}</span>
                                    </li>
                                    <li><b>Gift Code :</b>
                                       <span class="badge badge-primary">{{ $gift->gift_code }}</span>
                                    </li>
                                 </ul>
                              @else
                                 <span class="badge badge-warning">NO GIFT CARD</span>
                              @endif

                           </li>
                        </ul>
                     </div>
                  </div><!-- /.col -->

                  <div class="col-sm-6">
                     <div class="row">
                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                           <b>Invoice Address</b>
                        </div>
                     </div>
                     @if ($address = $order->address)
                        <div class="row">
                           <div class="col-sm-6 col-xs-6 col-md-6">
                              <ul class="list-unstyled">
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>NAME :</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>SURNAME:</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>STATE :</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>CITY :</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>AREA :</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>AVENUE :</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>STREET :</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>NOM :</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>PHONE NUMBER:</li>
                                 <li><i class="ace-icon fa fa-caret-right blue"></i>POSTAL CODE :</li>
                              </ul>
                           </div>
                           <div class="col-sm-6 col-xs-6 col-md-6">
                              <ul>
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
                     @endif

                  </div><!-- /.col -->
               </div><!-- /.row -->
               <!-- payment -->
               <div class="space"></div>
               @if ($payment = $order->payment)
                  <div class="panel @if ($payment->status) panel-success @else panel-danger @endif ">
                     <div class="panel-heading">
                        <div class="panel-title">
                           <span class="h4">Payment Info:</span>
                           @if ($payment->status )
                              <span class="label label-success label-large">PAID</span>
                           @else
                              <span class="label label-danger label-large">NOT-PAID</span>
                           @endif
                        </div>
                     </div>
                     <div class="panel-body">
                        <ul class="list-unstyled">
                           <li><i class="ace-icon fa fa-caret-right blue"></i>Status :
                              <b>{{ $payment->payment_status }}</b></li>
                           <li><i class="ace-icon fa fa-caret-right blue"></i>sub total:<b>{{ $payment->sub_total }}</b>
                           </li>
                           <li><i class="ace-icon fa fa-caret-right blue"></i>Date :<b>{{ $payment->created_at }}</b>
                           </li>
                        </ul>
                     </div>
                  </div>
               @else
                  <h2><span>Payment:</span><span class="label label-warning">NOTHING PAID</span></h2>
               @endif


               <div>
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
                     </tr>
                     </thead>
                     <tbody>
                     @forelse($order->detailsOrder as $key=> $d_order)
                        <tr>
                           <td class="center">{{$key++}}</td>
                           <td class="center">
                              <a href="{{ route('front.show',$d_order->product_slug) }}">
                                 {{($d_order->products->product_name)}}</a>
                           </td>
                           <td class="center">{{$d_order->size ?? - ''}}</td>
                           <td class="center">{{$d_order->color ?? '-'}}</td>
                           <td class="center">{{$d_order->attributes ?: '-'}}</td>
                           <td class="center">{{$d_order->product_price}}</td>
                           <td class="center">{{$d_order->quantity}}</td>
                           <td class="center">{{$d_order->created_at}}</td>

                        </tr>
                     @empty
                        <tr>
                           <td colspan="10">No Data</td>
                        </tr>
                     @endforelse
                     </tbody>
                  </table>
               </div>

               <div class="hr hr8 hr-double hr-dotted"></div>

               <div class="row">
                  <div class="col-sm-5 pull-right">
                     <h4 class="pull-right">
                        Total amount :
                        <span class="red">{{ $order->total_price }}</span>
                     </h4>
                  </div>
                  <div class="col-sm-7 pull-left"><b>Extra Information:</b>
                     <p class="">
                        {{ $order->details }}
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>


@endsection
@section('extra_js')
@endsection