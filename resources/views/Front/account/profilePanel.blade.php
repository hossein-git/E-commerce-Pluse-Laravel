@extends('layout.front.index')
@section('title')
   Profile
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
         <h4>Account Details</h4>
         <div class="responsive-table">
            <table class="table table-params">
               <tbody>
               <tr>
                  <td>Name:</td>
                  <td>{{ $user->name }}</td>
               </tr>
               <tr>
                  <td>E-mail:</td>
                  <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
               </tr>
               <tr>
                  <td>joined:</td>
                  <td>{{ $user->created_at }}</td>
               </tr>
               </tbody>
            </table>
         </div>
         {{--            <a href="#" class="btn">VIEW ADDRESSES (1)</a>--}}
         <a href="{{ route('front.myOrders') }}" class="click_me btn ">MY ORDERS</a>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

         <div class="panel panel-default">
            <div class="panel-heading">
               <span class="panel-title">Default Address</span>
               <a href="{{ route('front.address.edit') }}" class="pull-right btn btn-primary btn-xs ">
                  {{ $address  ? 'Edit Address' : 'Add New Address' }}
               </a><br><br>
            </div>
            <div class="panel-body">
               @if ($address)
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
                        <div>
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
                  </div>
               @else
                  <h4>YOU DONT HAVE SAVED ADDRESS</h4>
               @endif
            </div>
         </div>
      </div>
   </div>


@endsection
@section('extra_js')

@endsection