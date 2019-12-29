@extends('layout.front.index')
@section('title')
   check Out
@endsection
@section('extra_css')
   <style>
      body {
         margin-top: 30px;
      }

      .stepwizard-step p {
         margin-top: 0px;
         color: #666;
      }

      .stepwizard-row {
         display: table-row;
      }

      .stepwizard {
         display: table;
         width: 100%;
         position: relative;
      }

      .stepwizard-step button[disabled] {
         /*opacity: 1 !important;
         filter: alpha(opacity=100) !important;*/
      }

      .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
         opacity: 1 !important;
         color: #bbb;
      }

      .stepwizard-row:before {
         top: 14px;
         bottom: 0;
         position: absolute;
         content: " ";
         width: 100%;
         height: 1px;
         background-color: #ccc;
         z-index: 0;
      }

      .stepwizard-step {
         display: table-cell;
         text-align: center;
         position: relative;
      }

      .btn-circle {
         width: 30px;
         height: 30px;
         text-align: center;
         padding: 6px 0;
         font-size: 12px;
         line-height: 1.428571429;
         border-radius: 15px;
      }
   </style>
@endsection
@section('content')
   @include('layout.errors.notifications')
   <div class="stepwizard">
      <div class="stepwizard-row setup-panel">
         <div class="stepwizard-step col-xs-3">
            <a href="#step-1" type="button" class="btn btn-success btn-circle" disabled="disabled">1</a>
            <p>
               <small>Shipper</small>
            </p>
         </div>
         <div class="stepwizard-step col-xs-3">
            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
            <p>
               <small>Destination</small>
            </p>
         </div>
         <div class="stepwizard-step col-xs-3">
            <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
            <p>
               <small>Review</small>
            </p>
         </div>
         <div class="stepwizard-step col-xs-3">
            <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
            <p>
               <small>Payment</small>
            </p>
         </div>
      </div>
   </div>

   <div role="form">
      <!-- STEP1 -->
      <form id="form_step1">
         <!-- SET THIS EMPTY INPUT FORM MORE SECURITY  -->
         <input type="hidden" id="input1" name="input" value="">
         <div class=" setup-content" id="step-1">
            <div class="panel-heading">
               <h2 class="panel-title">Shipper</h2>
            </div>

            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group required">
                     <label for="client_name" class="control-label">Your Name: <span>*</span></label>
                     <input type="text" name="client_name" class="form-control"
                            id="client_name" placeholder="Shipper Name" maxlength="15" minlength="3"
                            value="{{ auth()->check() ? auth()->user()->name : '' }}"
                            required>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group required">
                     <label for="inputStreet" class=" control-label">Phone Number: <span>*</span>
                        <small>Like +905534676564</small>
                     </label>
                     <input type="text" name="client_phone" class="form-control" id="clientPhoneNumber"
                            required value="{{ isset($address) ? $address->phone_number : '' }}">
                  </div>
               </div>
               <div class="col-sm-5">
                  <div class="form-group required">
                     <label for="email" class="control-label">Email: <span>*</span></label>
                     <input type="email" name="client_email" class="form-control" id="clientEmail"
                            required value="{{ auth()->check() ? auth()->user()->email : '' }}">
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label for="inputStreet" class=" control-label">Details:</label>
                     <textarea name="details" class="form-control" id="details"></textarea>
                  </div>
                  <div class="form-group">
                     @auth()
                        <div id="off_div" class="form-group">
                           <label for="giftCode" class="control-label ">Gift Code: <span>*</span></label>
                           <input type="text" name="giftCode" class="form-control" id="giftCode">
                           <button class="btn btn-border color-default" data-loading-text="loading ..."
                                   id="apply_gift">APPLY DISCOUNT
                           </button>
                           <span id="error-gift" class="invalid-feedback font-weight-bolder" role="alert"></span>
                        </div>
                     @else()
                        <h5>for using Gift card, please <a href="{{ route('login') }}">login</a></h5>
                     @endauth
                  </div>
                  @if (\Cart::count() > 0)
                     <button class="btn btn-primary nextBtn pull-right" id="first_step" type="button">Next</button>
                  @else
                     <h4>YOUR CART IS EMPTY</h4>
                  @endif
               </div>

            </div>
         </div>
      </form>

      <!-- STEP2 -->
      <form id="form_step2">
         <!-- SET THIS EMPTY INPUT FORM MORE SECURITY  -->
         <input type="hidden" id="input2" name="input" value="">
         <div class="setup-content" id="step-2">
            <div class="panel-heading">
               <h3 class="panel-title">Destination</h3>
            </div>
            <section>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group required">
                        <label for="name" class=" control-label">First Name: <span>*</span></label>
                        <input type="text" value="{{ isset($address) ? $address->name : '' }}" name="name"
                               class="form-control" id="name" required>
                     </div>
                     <div class="form-group required">
                        <label for="number" class="control-label">Number: <span>*</span></label>
                        <input type="number" value="{{ isset($address) ? $address->number : '' }}" name="number"
                               class="form-control" id="number" required>
                     </div>
                     <div class="form-group required">
                        <label for="area" class=" control-label">Area: </label>
                        <input type="text" name="area" value="{{ isset($address) ? $address->area : '' }}"
                               class="form-control" id="area" maxlength="15">
                     </div>
                     <div class="form-group required">
                        <label for="city" class=" control-label">City: <span>*</span></label>
                        <input type="text" name="city" value="{{ isset($address) ? $address->city : '' }}"
                               class="form-control" id="city" required>
                     </div>
                     <div class="form-group required">
                        <label for="postal_code" class=" control-label">Zip/Postal Code: <span>*</span></label>
                        <input type="text" class="form-control" value="{{ isset($address) ? $address->postal_code : '' }}"
                               name="postal_code" id="postal_code" required>
                     </div>
                     @if (!isset($address))
                        @auth()
                           <div class="checkbox-group ">
                              <input type="checkbox" id="def_addr" name="def_addr">
                              <label for="def_addr">
                                 <span class="check"></span>
                                 <span class="box"></span>
                                 save this address as my address
                              </label>
                           </div>
                        @endauth
                     @endif
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group required">
                        <label for="surname" class=" control-label">Last Name: <span>*</span></label>
                        <div class="">
                           <input type="text" name="surname" value="{{ isset($address) ? $address->surname : '' }}"
                                  class="form-control" id="surname" required>
                        </div>
                     </div>
                     <div class="form-group required">
                        <label for="street" class=" control-label">Street: <span>*</span></label>
                        <input type="text" name="street" value="{{ isset($address) ? $address->street : '' }}"
                               class="form-control" id="street" maxlength="15">
                     </div>
                     <div class="form-group required">
                        <label for="avenue" class=" control-label">Avenue:</label>
                        <input type="text" name="avenue" value="{{ isset($address) ? $address->avenue : '' }}"
                               class="form-control" id="avenue" maxlength="20">
                     </div>
                     <div class="form-group required">
                        <label for="state" class=" control-label">State/Province: <span>*</span></label>
                        <input type="text" name="state" value="{{ isset($address) ? $address->state : '' }}"
                               class="form-control" id="state" required>
                     </div>
                     <div class="form-group required">
                        <label for="phone_number" class=" control-label">Phone Number: <span>*</span>
                           <small>Like +905534676564</small>
                        </label>
                        <input type="text" name="phone_number" value="{{ isset($address) ? $address->phone_number : '' }}"
                               class="form-control" id="phone_number" required>
                     </div>

                     <button class="btn btn-primary nextBtn pull-right" id="second_step" type="button">Next</button>
                  </div>

               </div>
            </section>

         </div>
      </form>

      <!-- STEP 3 -->
      <div class="setup-content" id="step-3">
         <div class="">
            <input type="hidden" id="input3" name="input" value="">
            <h3>Review</h3>
            <table class="table table-hover table-bordered">
               <thead>
               <tr>
                  <td class="center">Photo</td>
                  <td class="center">Product Name</td>
                  <td class="center">Price</td>
                  <td class="center">qty</td>
               </tr>
               </thead>
               <tbody>
               @forelse (Cart::content() as $cart)
                  <tr>
                     <td class="center">
                        <center>
                           <img class="thumbnail" width="150" height="180" src="{{$cart->options->src}}"
                                alt="product photo">
                        </center>
                     </td>
                     <td class="center"><a href="{{ route('front.show', $cart->options->slug) }}">{{ $cart->name }}</a>
                     </td>
                     <td class="center">{{ $cart->price }}</td>
                     <td class="center">{{ $cart->qty }}</td>
                  </tr>
               @empty
                  <h4>your cart is empty</h4>
               @endforelse

               </tbody>

            </table>

         </div>
         <!-- SET THIS EMPTY INPUT FORM MORE SECURITY  -->

         <div class="container-fluid">
            <div class="pull-left">
               <h4>Total Price:</h4>
               <h4>Discount:</h4>
               <h4>Total price after Discount:</h4>
            </div>
            <div class="pull-right">
               <h5>{{ Cart::subTotal() }}</h5>
               @if (session('gift_price'))
                  <h5>-{{session('gift_price')}}</h5>
                  <h5>=
                      <?php
                      $subTotal = (substr(str_replace(',', '', Cart::subtotal()), 0, -3));
                      $giftAmount = session('gift_price');
                      echo number_format($subTotal - $giftAmount); ?>
                  </h5>
               @else
                  <h5>0</h5>
                  <h5>={{ Cart::subTotal() }}</h5>
               @endif

            </div>

         </div>

         <div class="container-fluid">
            <div class="checkout-box">
               <h3>SHIP TO:</h3>
               <div class="checkout-box-content">
                  <p id="ship_addr"></p>
               </div>
            </div>
         </div>

         <button class="btn btn-primary nextBtn pull-right" id="third_step" type="button">Payment</button>
      </div>

      <!-- STEP 4  -->
      <div id="step_4">
         <!-- SET THIS EMPTY INPUT FORM MORE SECURITY  -->
{{--         <input type="hidden" name="input" value="">--}}
         <div class="panel panel-primary setup-content" id="step-4">
            <div class="panel-heading">
               <h3 class="panel-title">Payment</h3>
            </div>
            <div class="panel-body">
               <div class="form-group">
                  <h4>With PayPal<i class="fa fa-paypal"></i></h4>
               </div>
               <div class="form-group">
                  <h6 class="control-label">Redirect to Payment Page</h6>
                  <a href="{{ route('payment') }}" class="btn pull-left" id="payment">Payment</a>
               </div>

            </div>
         </div>
      </div>
   </div>


@endsection
@section('extra_js')
   <script type="text/javascript" src="{{ asset('front-assets/external/jquery/jquery-validation.js') }}"></script>
   <script type="text/javascript" src="{{ asset('front-assets/js/checkOut.js') }}"></script>
   <script type="text/javascript">
       $(document).ready(function () {
           var navListItems = $('div.setup-panel div a'),
               allWells = $('.setup-content');

           allWells.hide();

           navListItems.click(function (e) {
               e.preventDefault();
               var $target = $($(this).attr('href')),
                   $item = $(this);

               if (!$item.hasClass('disabled')) {
                   navListItems.removeClass('btn-success').addClass('btn-default');
                   $item.addClass('btn-success');
                   allWells.hide();
                   $target.show();
                   $target.find('input:eq(0)').focus();
               }
           });
           $('div.setup-panel div a.btn-success').trigger('click');
       });
   </script>
   <!-- CHECK OUT VALIDATIONS AND SEND -->
   <script type="text/javascript">
       $(document).ready(function () {
           //IF FORM IS VALID IT RUNS
           $("#first_step").click(function (e) {
               //save ORDER
               var data = {
                       client_name: $("#client_name").val(),
                       client_phone: $("#clientPhoneNumber").val(),
                       client_email: $("#clientEmail").val(),
                       details: $("#details").val(),
                       input : $('#input1').val()
                   },
                   rules = {
                       client_name: {
                           required: true,
                           lettersonly: true,
                           maxlength: 25

                       },
                       client_phone: {
                           required: true,
                           phone: true
                       },
                       client_email: {
                           required: true,
                           email: true
                       }
                   };
               var dataDone = upload_ajax("{{ route('front.checkout.store')}}", data, "form_step1", rules);
               if (dataDone) {
                   var curStep = $(this).closest(".setup-content"),
                       curStepBtn = curStep.attr("id"),
                       nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");

                   nextStepWizard.removeAttr('disabled').trigger('click');
               }
           });
           //Second step
           $("#second_step").click(function () {
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
                       input : $('#input2').val()

                   },

                   rules = {
                       name: {
                           required: true,
                           lettersonly: true,
                           maxlength: 15, minlength: 3

                       },
                       surname: {
                           required: true,
                           lettersonly: true,
                           maxlength: 20, minlength: 3

                       },
                       number: "required",
                       city: {
                           required: true,
                           lettersonly: true
                           , maxlength: 15, minlength: 3
                       },
                       postal_code: {
                           required: true,
                           post_code: true
                       },
                       state: {
                           required: true,
                           lettersonly: true
                           , maxlength: 15, minlength: 3
                       },
                       phone_number: {
                           required: true,
                           phone: true
                       },
                   },
                   blkstr = [];
               // put array into str to show in next page
               $.each(data, function (idx2, val2) {
                   // var str = idx2 + ':' + val2;
                   var str = val2;
                   blkstr.push(str);

               });
               $('#ship_addr').text(blkstr.join(", "));
               var dataDone = upload_ajax("{{ route('front.address.store')}}", data, "form_step2", rules);
               if (dataDone) {
                   var curStep = $(this).closest(".setup-content"),
                       curStepBtn = curStep.attr("id"),
                       nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");

                   nextStepWizard.removeAttr('disabled').trigger('click');
               }
           });
           //STEP 3
           $("#third_step").click(function () {
               //save address

               var dataDone = upload_ajax("{{ route('front.order.saveStatus')}}",);
               if (dataDone) {
                   var curStep = $(this).closest(".setup-content"),
                       curStepBtn = curStep.attr("id"),
                       nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                       curInputs = curStep.find("input[type='text'],input[type='url']");

                   nextStepWizard.removeAttr('disabled').trigger('click');

               }

           });


       });
   </script>
   <!-- CHECK DISCOUNT CODE -->
   <script type="text/javascript">
       $(document).ready(function () {
           $("#apply_gift").click(function (e) {
               e.preventDefault();
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: "{{ route('front.checkout.checkDiscount') }}",
                   method: "post",
                   data: {giftCode: $("#giftCode").val()},
                   beforeSend: function () {
                       $("#apply_gift").text('loading...');
                   },
               })
                   .done(function (result) {
                       $("#apply_gift").text('APPLY DISCOUNT');
                       if (result.success == 'empty') {
                           jQuery('#error-gift').empty().html('the filed is empty ').addClass('alert-danger');
                           jQuery('#off_div').removeClass('has-success').addClass('has-error');
                       }
                       if (result.success == 'true') {
                           jQuery('#error-gift').empty().html('the code has added ').removeClass().addClass('alert-success');
                           jQuery('#off_div').removeClass('has-error').addClass('has-success');

                       }
                       if (result.success == 'false') {
                           jQuery('#error-gift').empty().html('the code is not true').removeClass().addClass('alert-danger');
                           jQuery('#off_div').removeClass('has-success').addClass('has-error');
                       }
                       if (result.success == 'repeat') {
                           jQuery('#error-gift').empty().html('u can use this code only one time').removeClass().addClass('alert-danger');
                           jQuery('#off_div').removeClass('has-success').addClass('has-error');

                       }
                       // $('.ajax-load').hide();
                   }).error(function (result) {
                   jQuery('#error-gift').empty().html(result.error).removeClass().addClass('alert-danger');
                   jQuery('#off_div').removeClass('has-success').addClass('has-error');
                   alert('error');
               })
           });


       });

   </script>
@endsection