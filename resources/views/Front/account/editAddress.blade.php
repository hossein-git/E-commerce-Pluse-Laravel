@extends('layout.front.index')
@section('title')
   Edit Address
@endsection
@section('extra_css')
@endsection
@section('content')
   @include('layout.errors.notifications')

   <form id="front_address_edit"
           {{--                    method="post" action="{{ route('front.address.update',auth()->id()) }}"--}}
   >
      @csrf
      @method('put')
      @if (isset($order_id))
         <input id="order_id" type="hidden" name="order_id" value="{{ $order_id }}">
      @endif
      <div class="row">
         <div class="col-sm-6">
            <div class="form-group required">
               <label for="name" class=" control-label">First Name: <span>*</span></label>
               <input type="text" value="{{ $address ? $address->name  : ''}}" name="name" class="form-control"
                      id="name" required>
            </div>
            <div class="form-group required">
               <label for="number" class="control-label">Number: <span>*</span></label>
               <input type="number" value="{{ $address ? $address->number  : '' }}" name="number" class="form-control"
                      id="number" required>
            </div>
            <div class="form-group required">
               <label for="area" class=" control-label">Area: </label>
               <input type="text" name="area" value="{{ $address ? $address->area  : '' }}" class="form-control"
                      id="area">
            </div>
            <div class="form-group required">
               <label for="city" class=" control-label">City: <span>*</span></label>
               <input type="text" name="city" value="{{ $address ? $address->city  : '' }}" class="form-control"
                      id="city" required>
            </div>
            <div class="form-group required">
               <label for="postal_code" class=" control-label">Zip/Postal Code: <span>*</span></label>
               <input type="text" class="form-control" value="{{ $address ? $address->postal_code : ''  }}"
                      name="postal_code" id="postal_code" required>
            </div>
            <button class="btn btn-primary btn-lg pull-left" id="edit_address" type="submit">EDIT ADDRESS</button>

         </div>
         <div class="col-sm-6">
            <div class="form-group required">
               <label for="surname" class=" control-label">Last Name: <span>*</span></label>
               <div class="">
                  <input type="text" name="surname" value="{{ $address ? $address->surname : '' }}" class="form-control"
                         id="surname" required>
               </div>
            </div>
            <div class="form-group required">
               <label for="street" class=" control-label">Street: <span>*</span></label>
               <input type="text" name="street" value="{{ $address ? $address->street : '' }}" class="form-control"
                      id="street">
            </div>
            <div class="form-group required">
               <label for="avenue" class=" control-label">Avenue:</label>
               <input type="text" name="avenue" value="{{ $address ? $address->avenue : '' }}" class="form-control"
                      id="avenue">
            </div>
            <div class="form-group required">
               <label for="state" class=" control-label">State/Province: <span>*</span></label>
               <input type="text" name="state" value="{{ $address ? $address->state : '' }}" class="form-control"
                      id="state" required>
            </div>
            <div class="form-group required">
               <label for="phone_number" class=" control-label">Phone Number: <span>*</span>
                  <small>Like +905534676564</small>
               </label>
               <input type="text" name="phone_number" value="{{ $address ? $address->phone_number : ''}}"
                      class="form-control" id="phone_number" required>
            </div>

         </div>
      </div>
   </form>

@endsection
@section('extra_js')
   <script type="text/javascript" src="{{ asset('front-assets/external/jquery/jquery-validation.js') }}"></script>
   <script src="{{ asset('front-assets/js/checkOut.js') }}"></script>
   <script type="text/javascript">
       $("#edit_address").click(function () {
           //save address
           var data = {
                   name: $("#name").val(),
                   surname: $("#surname").val(),
                   number: $("#number").val(),
                   area: $("#area").val(),
                   city: $("#city").val(),
                   postal_code: $("#postal_code").val(),
                   street: $("#street").val(),
                   avenue: $("#avenue").val(),
                   state: $("#state").val(),
                   phone_number: $("#phone_number").val(),
                   def_addr: $("#def_addr").prop('checked'),
                   order_id: $("#order_id").val(),
                   _method: 'PUT'

               },
               rules = {
                   name: {
                       required: true,
                       lettersonly: true
                   },
                   surname: {
                       required: true,
                       lettersonly: true
                   },
                   number: "required",
                   city: {
                       required: true,
                       lettersonly: true
                   },
                   postal_code: {
                       required: true,
                       post_code: true
                   },
                   state: {
                       required: true,
                       lettersonly: true
                   },
                   phone_number: {
                       required: true,
                       phone: true
                   },
               };
           if (upload_ajax("{{ route('front.address.update')}}", data, "front_address_edit", rules)) {
               alert('update successfully');
               var pjax = new Pjax({
                   selectors: ["title", "meta[name=keywords]", "#extra_css", "#content-load", "#extra_js"]
               });
               pjax.loadUrl("{{ route('front.profile') }}");

           }
       });
   </script>
@endsection