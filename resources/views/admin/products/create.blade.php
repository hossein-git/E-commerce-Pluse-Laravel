@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty')
@section('content')
   @include('layout.errors.notifications')
   <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data"
         id="{{ env('APP_AJAX') ? 'product_form' : '' }}">
      <div class="row" style="">
         @csrf
         <div class="col-xs-12">
            <div class="form-group col-xs-3">
               <label class="control-label no-padding-right" for="product_name"> Product Name </label>
               <div class="clearfix">
                  <input placeholder="Product Name" name="product_name" value="{{ old('product_name') }}"
                         id="product_name" class="form-control" type="text">
               </div>
            </div>
            <div class="form-group col-xs-3">
               <label class="control-label no-padding-right" for="made_in"> Made IN: </label>
               <div class="clearfix">
                  <input placeholder="Made IN" name="made_in" value="{{ old('made_in') }}" id="made_in"
                         class="form-control" type="text">
               </div>
            </div>
            <div class="form-group col-xs-3">
               <label class=" control-label no-padding-right" for="brand_id">Choose your brands</label>
               <div class="clearfix">
                  <select name="brand_id" id="brand_id" class="form-control">
                     <option value="" disabled selected>Choose your brands</option>
                     @foreach($brands as $brand)
                        <option {{ old('brand_id') == $brand->brand_id ? 'checked' : '' }} value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="form-group  col-xs-3">
               <label class=" control-label no-padding-right" for="product_slug"> Product Slug </label>
               <div class="clearfix">
                  <input placeholder="Product Slug" id="product_slug" name="product_slug"
                         value="{{ old('product_slug') }}" class="form-control" type="text">
               </div>
            </div>
         </div>

         <div class="form-group col-xs-12">
            <div class="form-group col-xs-3">
               <label class=" control-label no-padding-right" for="sale_price"> Sale Price </label>
               <div class="clearfix">
                  <input placeholder="Sale Price" name="sale_price" value="{{ old('sale_price') }}" id="sale_price"
                         class="form-control" min="0" type="number">
               </div>
            </div>
            <div class="form-group col-xs-3">
               <label class=" control-label no-padding-right" for="buy_price"> Buy Price </label>
               <div class="clearfix">
                  <input placeholder="Buy Price" name="buy_price" value="{{ old('buy_price') }}" id="buy_price"
                         class="form-control" min="0" type="number">
               </div>
            </div>
            <div class="form-group col-xs-3">
               <label class=" control-label no-padding-right" for="quantity">Quantity</label>
               <div class="clearfix">
                  <input placeholder="Quantity" type="number" value="{{ old("quantity") }}" min="0" name="quantity"
                         class="form-control" id="quantity">
               </div>
            </div>
            <div class="form-group col-xs-3">
               <label for="weight">Weight</label>
               <div class="clearfix">
                  <input placeholder="weight" type="number" value="{{ old("weight") }}" min="0" name="weight"
                         class="form-control" id="weight">
               </div>
            </div>
         </div>
         <div class="col-xs-12 form-group">
            <label for="description">Description</label>
            <div class="clearfix">
                  <textarea id="description" rows="6" class="form-control"
                            name="description">{{ old('description') }}</textarea>
            </div>
         </div>
         <div class="form-group col-xs-5">
            <h4>Available ? </h4>
            <label>
               <input type="checkbox" name="status" id="status" onclick="showMe()" class="ace ace-switch ace-switch-6"
                      {{ old('status') == 1 ? 'checked': '' }} checked>
               <span class="lbl"></span>
            </label>
            <h4>Discount ?</h4>
            <label>
               <input type="checkbox" name="is_off" id="is_off" onclick="showDiscount()"
                      class="ace ace-switch ace-switch-6" {{ old('is_off') == 1 ? 'checked' :'' }}>
               <span class="lbl"></span>
            </label>
         </div>
         <div class="form-group col-xs-7">
            <div class="available0" style="display:none ">
               <label for="data_available"><b>Available Date</b></label>
               <input id="data_available" name="data_available" class="form-control" value="{{ old('data_available') }}"
                      type="date"/>
            </div>
            <div class="div-discount" style="display:none ">
               <label for="off_price"><b>Amount of Discount:</b></label>
               <input id="off_price" name="off_price" class="form-control" min="0" value="{{ old('off_price',0) }}"
                      type="number">
            </div>
         </div>
         <div class="form-group col-xs-12">
            <div class="col-xs-6">
               <!-- file input -->
               <label for="photos">Photos</label>
               <label class="ace-file-input">
                  <input type="file" name="photos[]" id="gallery-photo-add" multiple>
                  <span class="ace-file-container" data-title="Choose"><span class="ace-file-name"
                                                                             data-title="No Photos ..."><i
                                class=" ace-icon fa fa-upload"></i></span></span>
               </label>
            </div>
            <div class="col-xs-6 gallery"></div>
         </div>

         <div class="col-xs-12">
            <div class="col-xs-6">
               <div class="widget-box">
                  <div class="widget-header">
                     <h4 class="widget-title">Categories</h4>
                     <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                           <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                     </div>
                  </div>
                  <div class="widget-body">
                     <div class="widget-main">
                        <select multiple="multiple" size="10" name="categories[]" id="duallist0">
                           @foreach($categories as $category)
                              <option {{ old('categories') == $category->category_id ? 'selected' : '' }} value="{{$category->category_id}}">{{ $category->category_name }}</option>
                           @endforeach
                        </select>
                        <div class="hr hr-16 hr-dotted"></div>
                     </div>
                     <label></label>
                  </div>
               </div>
            </div>
            <div class="col-xs-6">
               <div class="widget-box">
                  <div class="widget-header">
                     <h4 class="widget-title">Colors of product</h4>
                     <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                           <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                     </div>
                  </div>
                  <div class="widget-body">
                     <div class="widget-main">
                        <div class="form-group">
                           <select multiple="multiple" size="10" name="colors[]" id="duallist">
                              @foreach($colors as $color)
                                 <option value="{{$color->color_id}}" {{ old('colors') == $color->color_id ? 'selected' :'' }}>{{ $color->color_name }}</option>
                              @endforeach
                           </select>
                           <div class="hr hr-16 hr-dotted"></div>
                        </div>
                     </div>
                     <label></label>
                  </div>
               </div>
            </div>
         </div>
         <input type="hidden" name="cover" id="cover_name" value="">
         <div class="col-xs-12">
            <div class="col-xs-6">
               <input type="submit" class="btn btn-success btn-block" id="" value="SAVE">
            </div>
            <div class="col-xs-6">
               <input type="reset" class="btn btn-warning btn-block" value="Reset!" onclick=" ">
            </div>
         </div>
      </div>
   </form>

   <script type="text/javascript">
      {{--let myelement = document.createElement("script");--}}
      {{--myelement.type = "text/javascript";--}}
      {{--myelement.src = "{{ asset('admin-assets/js/jquery.inputlimiter.min.js') }}";--}}
      {{--$("#extra_js").append(myelement);--}}

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
   <!-- inline scripts related to this page -->
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
           var demo1 = jQuery('select[name="categories[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
           var container1 = demo1.bootstrapDualListbox('getContainer');
           container1.find('.btn').addClass('btn-white btn-info btn-bold');
           //typeahead.js
           //example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
           var substringMatcher = function (strs) {
               return function findMatches(q, cb) {
                   var matches, substringRegex;
                   // an array that will be populated with substring matches
                   matches = [];
                   // regex used to determine if a string contains the substring `q`
                   substrRegex = new RegExp(q, 'i');
                   // iterate through the pool of strings and for any string that
                   // contains the substring `q`, add it to the `matches` array
                   jQuery.each(strs, function (i, str) {
                       if (substrRegex.test(str)) {
                           // the typeahead jQuery plugin expects suggestions to a
                           // JavaScript object, refer to typeahead docs for more info
                           matches.push({value: str});
                       }
                   });
                   cb(matches);
               }
           }
           jQuery('input.typeahead').typeahead({
               hint: true,
               highlight: true,
               minLength: 1
           }, {
               name: 'states',
               displayKey: 'value',
               source: substringMatcher(ace.vars['US_STATES']),
               limit: 10
           });
           //in ajax mode, remove remaining elements before leaving page
           jQuery(document).one('ajaxloadstart.page', function (e) {
               jQuery('[class*=select2]').remove();
               jQuery('select[name="categories[]"]').bootstrapDualListbox('destroy');
               jQuery('.rating').raty('destroy');
               jQuery('.multiselect').multiselect('destroy');
           });

           var demo1 = jQuery('select[name="colors[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
           var container1 = demo1.bootstrapDualListbox('getContainer');
           container1.find('.btn').addClass('btn-white btn-info btn-bold');
           //typeahead.js
           //example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
           var substringMatcher = function (strs) {
               return function findMatches(q, cb) {
                   var matches, substringRegex;
                   // an array that will be populated with substring matches
                   matches = [];
                   // regex used to determine if a string contains the substring `q`
                   substrRegex = new RegExp(q, 'i');
                   // iterate through the pool of strings and for any string that
                   // contains the substring `q`, add it to the `matches` array
                   jQuery.each(strs, function (i, str) {
                       if (substrRegex.test(str)) {
                           // the typeahead jQuery plugin expects suggestions to a
                           // JavaScript object, refer to typeahead docs for more info
                           matches.push({value: str});
                       }
                   });
                   cb(matches);
               }
           }
           jQuery('input.typeahead').typeahead({
               hint: true,
               highlight: true,
               minLength: 1
           }, {
               name: 'states',
               displayKey: 'value',
               source: substringMatcher(ace.vars['US_STATES']),
               limit: 10
           });
           //in ajax mode, remove remaining elements before leaving page
           jQuery(document).one('ajaxloadstart.page', function (e) {
               jQuery('[class*=select2]').remove();
               jQuery('select[name="categories[]"]').bootstrapDualListbox('destroy');
               jQuery('.rating').raty('destroy');
               jQuery('.multiselect').multiselect('destroy');
           });
       });
   </script>
   <!--FRONT VALIDATION -->
   <script type="text/javascript">
       jQuery(document).ready(function () {
           jQuery(function ($) {
               jQuery.validator.addMethod("phone", function (value, element) {
                   return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
               }, "Enter a valid phone number.");

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
   @if(env('APP_AJAX') === true)
      <script type="text/javascript">
          $(document).ready(function () {
              $("#product_form").submit(function (e) {
                  e.preventDefault();
                  var form = $(this);
                  var form_data = new FormData(this);
                  // check if the input is valid
                  if (!form.valid()) return false;
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
                      success: function ($results) {
                          if ((JSON.stringify($results)) == 1) {
                              //show loading image ,reset forms ,clear gallery
                              $(".preview").toggle();
                              $("#product_form")[0].reset();
                              $(".gallery").empty();
                              alert("new product has created successfully");
                          } else {
                              console.log($results);
                          }
                      },
                      error: function (request, status, error) {
                          $(".preview").toggle();
                          $("#error_result").empty();
                          json = $.parseJSON(request.responseText);
                          $.each(json.errors, function (key, value) {
                              $('.alert-danger').show();
                              $('.alert-danger').append('<p>' + value + '</p>');
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
   <script>
       $(document).ready(function () {
           $(function () {
               // Multiple images preview in browser
               var imagesPreview = function (input, placeToInsertImagePreview) {
                   $(".gallery").empty();
                   if (input.files) {
                       var filesAmount = input.files.length;
                       $(".ace-file-name").attr('data-title', 'now choose the cover');
                       var c = 0;
                       for (var i = 0; i < filesAmount; ++i) {
                           var reader = new FileReader();

                           reader.onload = function (event) {
                               var showImage = '<div class="fileuploader-items div-show">' +
                                   '<ul class="fileuploader-items-list">' +
                                   '<li class="fileuploader-item file-has-popup file-type-image file-ext-png">' +
                                   '<div class="columns"><div class="column-thumbnail"><div class="fileuploader-item-image fileuploader-no-thumbnail">' +
                                   '<div style="background-color: #298a22" class="fileuploader-item-icon">' +
                                   '<img src="' + event.target.result + '" alt="' + input.files[c].type + '"></div></div><span class="fileuploader-action-popup"></span></div>' +
                                   '<div class="column-title">' +
                                   '<div title="innostudio.de__setting-icnload.png">' + input.files[c].name + '</div>' +
                                   '<span>' + (input.files[c].size) + ' KB </span></div>' +
                                   '<div class="column-actions">' +
                                   '<input type="radio" name="cover" value="' + input.files[c].name + '" class="cover_cb fileuploader-action radio" id="cover" title="Cover Photo"><i class="icon ui-icon-asc"></i>' +
                                   '<a class="fileuploader-action fileuploader-action-remove" title="remove">' +
                                   '<i onclick="removeImage(this)"></i></a>' +
                                   '</div></div><div class="progress-bar2"><div class="fileuploader-progressbar"><div class="bar"></div></div><span></span>' +
                                   '</div></li></ul></div>\n';
                               $(".gallery").append(showImage);
                               c++;
                           }
                           reader.readAsDataURL(input.files[i]);
                       }
                   }
               };

               $('#gallery-photo-add').on('change', function () {
                   imagesPreview(this, 'div.gallery');
               });
           });
       });

       function removeImage(e) {
           $(e).parents(":eq(4)").remove()
       }
   </script>

@endsection()

