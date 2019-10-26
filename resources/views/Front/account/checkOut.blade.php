@extends('layout.front.index')
@section('title')
   check Out
@endsection
@section('extra_css')
   <style> body {
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
                  <small>Rewiev</small>
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
            <div class=" setup-content" id="step-1">
               <div class="panel-heading">
                  <h2 class="panel-title">Shipper</h2>
               </div>

               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group required">
                        <label for="client_name" class="control-label">Your Name: <span>*</span></label>
                        <input type="text" name="client_name" class="form-control"
                               id="client_name" placeholder="Shipper Name"
                               value="{{ auth()->check() ? auth()->user()->name : '' }}"
                               required>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group required">
                        <label for="inputStreet" class=" control-label">Phone Number: <span>*</span>
                           <small>Like +905534676564</small></label>
                           <input type="text" name="client_phone" class="form-control" id="clientPhoneNumber"
                                  required>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        <label for="inputStreet" class=" control-label">Details: <span>*</span></label>
                           <textarea name="details" class="form-control" id="details"></textarea>
                     </div>
                     <div class="form-group">
                        @auth()
                           <label for="giftCode" class=" control-label">Gift Code: <span>*</span></label>
                           <div id="off_div" class="form-group">
                              <input type="text" name="giftCode" class="form-control" id="giftCode">
                              <button class="btn btn-border color-default" data-loading-text="loading ..."
                                      id="apply_gift">APPLY DISCOUNT
                              </button>
                              <span class="invalid-feedback" role="alert">
                              <strong id="answer" class="alert-success"
                                      style="display: none">
                              </strong>
                              <strong id="answerz" class="alert-danger"
                                      style="display: none">
                              </strong>
                           </span>
                           </div>
                        @else()
                           <h5>for using Gift card, please <a href="{{ route('login') }}">login</a></h5>
                        @endauth
                     </div>
                     @if (Cart::count() > 0)
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
            <div class="setup-content" id="step-2">
               <div class="panel-heading">
                  <h3 class="panel-title">Destination</h3>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group required">
                        <label for="name" class=" control-label">First Name: <span>*</span></label>
                        <input type="text" name="name" class="form-control" id="name" required>
                     </div>
                     <div class="form-group required">
                        <label for="number" class="control-label">Number: <span>*</span></label>
                        <input type="number" name="number" class="form-control" id="number" required>
                     </div>
                     <div class="form-group required">
                        <label for="area" class=" control-label">Area: </label>
                        <input type="text" name="area" class="form-control" id="area">
                     </div>
                     <div class="form-group required">
                        <label for="city" class=" control-label">City: <span>*</span></label>
                        <input type="text" name="city" class="form-control" id="city" required>
                     </div>
                     <div class="form-group required">
                        <label for="postal_code" class=" control-label">Zip/Postal Code: <span>*</span></label>
                        <input type="text" class="form-control" name="postal_code" id="postal_code" required>
                     </div>
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

                  </div>
                  <div class="col-sm-6">
                     <div class="form-group required">
                        <label for="surname" class=" control-label">Last Name: <span>*</span></label>
                        <div class="">
                           <input type="text" name="surname" class="form-control" id="surname" required>
                        </div>
                     </div>
                     <div class="form-group required">
                        <label for="street" class=" control-label">Street: <span>*</span></label>
                           <input type="text" name="street" class="form-control" id="street">
                     </div>
                     <div class="form-group required">
                        <label for="avenue" class=" control-label">Avenue:</label>
                           <input type="text" name="avenue" class="form-control" id="avenue">
                     </div>
                     <div class="form-group required">
                        <label for="state" class=" control-label">State/Province: <span>*</span></label>
                           <input type="text" name="state" class="form-control" id="state" required>
                     </div>
                     <div class="form-group required">
                        <label for="phone_number" class=" control-label">Phone Number: <span>*</span>
                           <small>Like +905534676564</small></label>
                        <input type="text" name="phone_number" class="form-control" id="phone_number" required>
                     </div>

                     <button class="btn btn-primary nextBtn pull-right" id="second_step" type="button">Next</button>
                  </div>

               </div>
            </div>
         </form>

         <!-- STEP 3 -->
         <div class="setup-content" id="step-3">
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
                           <img class="thumbnail" width="150" height="180" src="{{$cart->options->src}}" alt="product photo">
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

            <div class="container-fluid">
               <div class="pull-left">
                  <h4>Total Price:</h4>
                  <h4>Discount:</h4>
                  <h4>Total price after Discount:</h4>
               </div>
               <div class="pull-right">
                  <h5>{{ Cart::Total() }}</h5>
                  @if (session('gift_price'))
                     <h5>-{{session('gift_price')}}</h5>
                     <h5>-{{ (substr(str_replace(',','',Cart::total()),0,-3)) - session('gift_price')}}</h5>
                  @else
                     <h5>0</h5>
                     <h5>{{ Cart::Total() }}</h5>
                  @endif

               </div>
            </div>


            <button class="btn btn-primary nextBtn pull-right" id="third_step" type="button">Payment</button>
         </div>

         <!-- STEP 4  -->
         <div id="step_4">
            <div class="panel panel-primary setup-content" id="step-4">
               <div class="panel-heading">
                  <h3 class="panel-title">Payment</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="control-label">Company Name</label>
                     <input maxlength="200" type="text" required="required" class="form-control"
                            placeholder="Enter Company Name"/>
                  </div>
                  <div class="form-group">
                     <label class="control-label">Company Address</label>
                     <input maxlength="200" type="text" required="required" class="form-control"
                            placeholder="Enter Company Address"/>
                  </div>
                  <button class="btn btn-success pull-right" type="submit">Finish!</button>
               </div>
            </div>
         </div>
      </div>


@endsection
@section('extra_js')
   <script type="text/javascript"
           src="{{ asset('front-assets/external/jquery/jquery-validation.js') }}"></script>
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
                       details: $("#details").val()
                   },
                   rules = {
                       client_name: {
                           required: true,
                           lettersonly: true
                       },
                       client_phone: {
                           required: true,
                           phone: true
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

               },
                   rules = {
                       name   : {
                           required: true,
                           lettersonly: true
                       },
                       surname: {
                           required: true,
                           lettersonly: true
                       },
                       number : "required",
                       city: {
                           required: true,
                           lettersonly: true
                       },
                       postal_code: {
                           required: true,
                           post_code : true
                       },
                       state: {
                           required: true,
                           lettersonly: true
                       },
                       phone_number: {
                           required: true,
                           phone : true
                       },
                   };
               var dataDone = upload_ajax("{{ route('front.address.store')}}", data , "form_step2" , rules );
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

               var dataDone = upload_ajax("{{ route('front.order.saveStatus')}}");
               if (dataDone) {
                   alert('ok');
                   var curStep = $(this).closest(".setup-content"),
                       curStepBtn = curStep.attr("id"),
                       nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                       curInputs = curStep.find("input[type='text'],input[type='url']");

                   nextStepWizard.removeAttr('disabled').trigger('click');

               }

           });

           //USE FOR SAVE REQUESTS WITH AJAX + validate it
           function upload_ajax(url, data, formId, rules,msg) {
               var bool = false;

               if (formId){
                   var $form = $('#' + formId);
                   //add phone validation
                   jQuery.validator.addMethod("phone", function (phone_number, element) {
                       phone_number = phone_number.replace(/\s+/g, "");
                       return this.optional(element) || phone_number.length > 10 &&
                           phone_number.match(/^\+[0-9]{12}$/);
                   }, "Please specify a valid phone number");
                   //add post code validation
                   jQuery.validator.addMethod("post_code", function(value, element) {
                       return this.optional(element) || /^\d{10}(?:-\d{4})?$/.test(value);
                   }, "Please provide a valid postal Code.");
                   //add text only
                   jQuery.validator.addMethod("lettersonly", function(value, element) {
                       return this.optional(element) || /^[a-z," "]+$/i.test(value);
                   }, "Letters and spaces only please");
                   $form.validate({
                       rules: rules,
                       // message: msg,
                       errorElement: "em",
                       errorPlacement: function (error, element) {
                           // Add the `help-block`,"text-danger" class to the error element
                           error.addClass("text-danger");

                           if (element.prop("type") === "checkbox") {
                               error.insertAfter(element.parent("label"));
                           } else {
                               error.insertAfter(element);
                           }

                       },
                       success: function (label, element) {
                           // Add the span element, if doesn't exists, and apply the icon classes to it.
                           /* if ( !$( element ).next( "span" )[ 0 ] ) {
                                $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
                            }*/
                       },
                       highlight: function (element, errorClass, validClass) {
                           $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                           // $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
                       },
                       unhighlight: function (element, errorClass, validClass) {
                           $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                           // $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
                       }
                   });

                   //check if the input is valid
                   if (!$form.valid()) return false;

               }


               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });

               $.ajax({
                   async: false,
                   url: url,
                   method: "POST",
                   data: data,
                   cache: false,
                   beforeSend: function () {
                       $(".ajax-load").show();
                   },
                   success: function (result) {
                       // alert(result.success);
                       bool = true;
                       $(".ajax-load").hide();
                   },
                   error: function (request, status, error) {
                       alert('server not responding....');
                   }
               });

               return (bool);

           }
           // /function
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
               })
                   .done(function (result) {
                       if (result.success == 'empty') {
                           jQuery('#answerz').html('').show().html('the filed is empty ');
                           jQuery('#off_div').removeClass().addClass('has-error');
                       }
                       if (result.success == 'true') {
                           jQuery('#answerz').html('').show().html('okay ');
                           jQuery('#off_div').removeClass('has-error').addClass('has-success');
                           jQuery('#off_check').removeClass('btn-primary').addClass('btn-success');
                       }
                       if (result.success == 'false') {
                           jQuery('#answer').html('').show().html('the code is not true');
                           jQuery('#off_div').removeClass('has-success').addClass('has-error');
                           jQuery('#off_check').removeClass('btn-success').addClass('btn-primary');
                       }
                       if (result.success == 'repeat') {
                           jQuery('#answer').html('').show().html('u can use this code only one time');
                           jQuery('#off_div').removeClass('has-success').addClass('has-error');
                       }
                       // $('.ajax-load').hide();
                   }).fail(function (xhr) {
                   alert('error');
               })
           });


       });

   </script>
@endsection