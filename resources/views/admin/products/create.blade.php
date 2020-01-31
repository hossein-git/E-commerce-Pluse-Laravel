@extends('layout.admin.index' )
@section('title')
   Create new Product
@stop
@section('extra_css')
@stop
@section('content')

   <form method="post" action="{{ route('product.store') }}" id="product_form"
         enctype="multipart/form-data">
      <div class="row">
         @csrf
         <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="form-group col-md-6 col-lg-6 col-xs-12">
               <label class="control-label no-padding-right" for="product_name"> Product Name </label>
               <div class="clearfix">
                  <input placeholder="Product Name" name="product_name" value="{{ old('product_name') }}"
                         id="product_name" class="form-control" type="text">
               </div>
            </div>
            <div class="form-group col-md-6 col-lg-6 col-xs-12">
               <label class="control-label no-padding-right" for="made_in"> Made IN: </label>
               <div class="clearfix">
                  <input placeholder="Made IN" name="made_in" value="{{ old('made_in') }}" id="made_in"
                         class="form-control" type="text">
               </div>
            </div>
            <div class="form-group col-md-6 col-lg-6 col-xs-12">
               <label class=" control-label no-padding-right" for="brand_id">Choose your brands</label>
               <div class="clearfix">
                  <select name="brand_id" id="brand_id" class="form-control">
                     <option value="" disabled selected>Choose your brands</option>
                     @foreach($brands as $brand)
                        <option {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }} value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="form-group col-md-6 col-lg-6  col-xs-12">
               <label class=" control-label no-padding-right" for="product_slug"> Product Slug </label>
               <div class="clearfix">
                  <input placeholder="Product Slug" id="product_slug" name="product_slug"
                         value="{{ old('product_slug') }}" class="form-control" type="text">
               </div>
            </div>
         </div>

         <div class="form-group col-xs-12 col-md-12 col-lg-12">
            <div class="form-group col-xs-6 col-md-6 col-lg-3">
               <label class=" control-label no-padding-right" for="sale_price"> Sell Price </label>
               <div class="clearfix">
                  <input placeholder="Sell Price" name="sale_price" value="{{ old('sale_price') }}" id="sale_price"
                         class="form-control" min="0" type="number">
               </div>
            </div>
            <div class="form-group col-xs-6 col-md-6 col-lg-3">
               <label class=" control-label no-padding-right" for="buy_price"> Buy Price </label>
               <div class="clearfix">
                  <input placeholder="Buy Price" name="buy_price" value="{{ old('buy_price') }}" id="buy_price"
                         class="form-control" min="0" type="number">
               </div>
            </div>
            <div class="form-group col-xs-6 col-md-6 col-lg-3">
               <label class=" control-label no-padding-right" for="quantity">Quantity</label>
               <div class="clearfix">
                  <input placeholder="Quantity" type="number" value="{{ old("quantity") }}" min="0" name="quantity"
                         class="form-control" id="quantity">
               </div>
            </div>
            <div class="form-group col-xs-6 col-md-6 col-lg-3">
               <label for="weight">Weight</label>
               <div class="clearfix">
                  <input placeholder="weight" type="number" value="{{ old("weight") }}" min="0" name="weight"
                         class="form-control" id="weight">
               </div>
            </div>
         </div>
         <div class="col-xs-12 form-group col-md-12 col-lg-12">
            <label for="description">Description</label>
            <div class="clearfix">
                  <textarea id="description" rows="6" class="form-control"
                            name="description">{{ old('description') }}</textarea>
            </div>
         </div>
         <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">

               <label><h4>Available ? </h4>
                  <input type="checkbox" name="status" id="status" onclick="showMe()"
                         class="ace ace-switch ace-switch-5"
                         {{ old('status') == 'on' ? 'checked': '' }} checked>
                  <span class="lbl"></span>
               </label>
               <br>
               <label><h4>Discount ?</h4>
                  <input type="checkbox" name="is_off" id="is_off" onclick="showDiscount()"
                         class="ace ace-switch ace-switch-5" {{ old('is_off') == 'on' ? 'checked' :'' }}>
                  <span class="lbl"></span>
               </label>
               <div class="form-group">
                  <label class="" for="has_size">
                     <h4>Has Size ? </h4>
                     <input type="checkbox" name="has_size" id="has_size"
                            class="ace ace-switch ace-switch-5 form-control"
                             {{ old('has_size') == 'on' ? 'checked': '' }}>
                     <span class="lbl"></span>
                  </label>
               </div>
            </div>

            <div class="col-sm-6 col-lg-6 col-md-6 col-xs-12">
               <div class="available0" style="display:none ">
                  <label for="data_available"><b>Available Date</b></label>
                  <input id="data_available" name="data_available" class="form-control"
                         value="{{ old('data_available') }}"
                         type="date"/>
               </div>

               <div class="div-discount" style="display:none ">
                  <label for="off_price"><b>Amount of Discount:</b></label>
                  <input id="off_price" name="off_price" class="form-control" min="0" value="{{ old('off_price',0) }}"
                         type="number">
               </div>
            </div>

         </div>

         <div class="center col-xs-6 col-sm-6 col-lg-6 col-md-6">

            <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
               <label class="bolder bigger-110 " for="brand_image">Cover</label>

               <input type="file" name="cover" class="form-control" id="cover">

               <span class="text-danger">{{ $errors->first('cover') }}</span>
            </div>
            <img id="show_image" src="" alt="" width="200" height="100" class="img-responsive img-thumbnail">
         </div>
         <hr>
         <div class="form-group">
            <div class="btn-group btn-group-justified">
               <div class="btn-group">
                  <input type="submit" class="btn btn-info " value="SAVE">
               </div>
               <div class="btn-group">
                  <a class="btn btn-danger" onclick="history.back()">BACK</a>
               </div>
            </div>
         </div>

      </div>
   </form>
   <input type="hidden" value="{{ route('product.create2') }}" id="redirect-route">
@endsection()
@section('extra_js')
   <script type="text/javascript">
       // show items
       function showMe() {
           jQuery(".available0").toggle();
       }

       function showDiscount() {
           jQuery(".div-discount").toggle();
       }

       // <!-- add site map of the page -->
       jQuery(document).one('load', function (e) {
           jQuery("#site_map").append("<i class='ace-icon fa '></i><a href='{{ route('product.create') }}' class='click_me'>Create Product</a>");
           // e.isImmediatePropagationStopped()
       });
   </script>

   <!-- load cover image -->
   <script type="text/javascript">
       function readURL(input) {
           if (input.files && input.files[0]) {
               var reader = new FileReader();

               reader.onload = function (e) {
                   $('#show_image').attr('src', e.target.result);
               }

               reader.readAsDataURL(input.files[0]);
           }
       }

       $("#cover").change(function () {
           readURL(this);
       });
   </script>

   <!--FRONT VALIDATION -->
   <script type="text/javascript">
       jQuery(document).ready(function () {
           jQuery(function ($) {
               $("#product_form").validate({
                   errorElement: 'div',
                   errorClass: 'help-block',
                   focusInvalid: false,
                   ignore: "",
                   rules: {
                       product_name: "required",
                       product_slug: "required",
                       buy_price: {required: true},
                       sale_price: {required: true},
                       quantity: {required: true},
                       made_in: "required",
                       description: "required",
                       colors: "required",
                       brand_id: "required",
                       categories: "required",
                   },
                   messages: {},


                   highlight: function (e) {
                       $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                   },

                   success: function (e) {
                       $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                       $(e).remove();
                   },

                   errorPlacement: function (error, element) {
                       if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                           var controls = element.closest('div[class*="col-"]');
                           if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                           else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                       } else if (element.is('.select2')) {
                           error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                       } else if (element.is('.chosen-select')) {
                           error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                       } else error.insertAfter(element.parent());
                   },

                   submitHandler: function (form) {
                   },
                   invalidHandler: function (form) {
                   }
               });

               $('#modal-wizard-container').ace_wizard();
               $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

               $(document).one('ajaxloadstart.page', function (e) {
                   //in ajax mode, remove remaining elements before leaving page
                   $('[class*=select2]').remove();
               });
           })
       })
   </script>

   {{--send date with AJAX--}}
   @if(env('APP_AJAX'))
      <script type="text/javascript">
          $(document).ready(function () {
              $("#product_form").submit(function (e) {
                  e.preventDefault();
                  var form = $(this);
                  var form_data = new FormData(this);
                  // check if the input is valid
                  // if (!form.valid()) return false;
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url: "{{ route('product.store') }}",
                      method: "post",
                      enctype: 'multipart/form-data',
                      data: form_data,
                      contentType: false,
                      cache: false,
                      processData: false,
                      beforeSend: function () {
                          $(".preview").toggle();
                      },
                      success: function (data) {
                          if (data.success === true) {
                              //show loading image ,reset forms ,clear gallery
                              $(".preview").hide();
                              $("#product_form")[0].reset();
                              $(".gallery").empty();
                              alert(data.message);
                              window.location.replace($('#redirect-route').val());
                          }
                      },
                      error: function (request, status, error) {
                          json = $.parseJSON(request.responseText);
                          if (json.success === false) {
                              alert(json.message);
                              $(".preview").hide();
                              return;
                          }
                          $(".preview").hide();
                          $("#error_result").empty();
                          $.each(json.errors, function (key, value) {
                              $('.alert-danger').show().append('<p>' + value + '</p>');
                          });
                          $('html, body').animate(
                              {
                                  scrollTop: $("#error_result").offset().top,
                              },
                              500,
                          )
                          // $("#result").html('');
                      }
                  });
              });
          });
      </script>
   @endif
   <!-- show selected images -->



@stop
