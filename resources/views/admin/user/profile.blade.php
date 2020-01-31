@extends('layout.admin.index')
@section('title')
   {{'Profile:'. $user->name }}
@endsection
@section('extra_css')
@endsection
@section('content')
   <!-- if user has roles background color will change -->
   <div @if ($user->getRoleNames()->count()) style="background-color: lightgoldenrodyellow" @endif >
      <div id="user-profile-2" class="user-profile">
         <div class="tabbable">
            <div class="tab-content no-border padding-24">
               <div id="home" class="tab-pane active">
                  <div class="row">
                     <div class="col-xs-12 col-sm-3 center">
                        <span class="profile-picture">
                           <img class="editable img-responsive" alt="Alex's Avatar" id="avatar2"
                                src="{{ asset('user.jpeg') }}">
                        </span>

                        <div class="space space-4"></div>

                        <a href="{{ route('user.edit',$user->user_id) }}" class="btn btn-sm btn-block btn-success">
                           <i class="ace-icon fa fa-plus-circle bigger-120"></i>
                           <span class="bigger-110">Edit this User</span>
                        </a>
                        @if ($user->address)
                           <a href="{{ route('admin.address.edit',$user->user_id) }}" class="btn btn-sm btn-block btn-primary">
                              <i class="ace-icon fa fa-envelope-o bigger-110"></i>
                              <span class="bigger-110">Edit Address</span>
                           </a>
                        @endif
                     </div><!-- /.col -->

                     <div class="col-xs-12 col-sm-9">
                        <h4 class="blue">
                           <span class="middle">{{ $user->name }}</span>

                           <span class="label @if ($user->getRoleNames()->count() > 0) label-danger @endif arrowed-in-right">
                              <i class="ace-icon fa fa-circle smaller-80 align-middle"></i>
                               @if($user->getRoleNames()->count() > 0)
                                 @foreach($user->getRoleNames() as $role)
                                    {{ $role }}
                                 @endforeach
                              @else
                                 Normal user>
                              @endif
                           </span>

                           @if ($user->isOnline())
                              <span class="label label-success arrowed-in-right">
                              <i class="ace-icon fa fa-circle smaller-80 align-middle"></i>
                              online
                              </span>
                           @else
                              <span class="label label-grey arrowed-in-right">
                              <i class="ace-icon fa fa-circle smaller-80 align-middle"></i>
                              off-line
                              </span>
                           @endif
                        </h4>

                        <div class="profile-user-info">
                           <div class="profile-info-row">
                              <div class="profile-info-name"> Email</div>

                              <div class="profile-info-value">
                                 <span>{{ $user->email }}</span>
                              </div>
                           </div>

                           <div class="profile-info-row">
                              <div class="profile-info-name"> Joined</div>

                              <div class="profile-info-value">
                                 <span>{{ $user->created_at }}</span>
                              </div>
                           </div>

                           <div class="profile-info-row">
                              <div class="profile-info-name"> Updated</div>

                              <div class="profile-info-value">
                                 <span>{{ $user->updated_at }}</span>
                              </div>
                           </div>

                           <div class="profile-info-row">
                              <div class="profile-info-name"> Default Address </div>

                              @if ($address = $user->address)
                                 <div class="row">
                                    <div class="col-sm-4">
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
                                    <div class="col-sm-8">
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
                              @else
                                 <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    <b>WITHOUT SAVED ADDRESS</b>
                                 </div>
                              @endif

                           </div>

                           {{--                           <div class="profile-info-row">--}}
                           {{--                              <div class="profile-info-name"> Last Online </div>--}}

                           {{--                              <div class="profile-info-value">--}}
                           {{--                                 <span>3 hours ago</span>--}}
                           {{--                              </div>--}}
                           {{--                           </div>--}}
                        </div>

                        <div class="hr hr-8 dotted"></div>

                     </div><!-- /.col -->
                  </div><!-- /.row -->

                  <div class="space-20"></div>

                  <table class="table table-bordered table-hover">
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
               </div><!-- /#home -->

            </div>
         </div>
      </div>
   </div>




@endsection
@section('extra_js')
@endsection