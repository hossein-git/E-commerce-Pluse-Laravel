@extends('layout.admin.index' )
@section('title')
   Edit Products
@stop
@section('extra_css')
   <!-- the script in this page wont work with pjax so i hava to reload it  -->
   @if (env('APP_AJAX'))
      <script type="text/javascript">
          document.on('pjax:complete', function () {
              pjax.reload();
          })
      </script>
   @endif
@stop

@section('content')

   <div class="row" style="">
      <form method="post" action="{{ route('product.update',$product->product_id) }}" enctype="multipart/form-data"
            id="Uproduct_form">
         @csrf
         @if( ! env("APP_AJAX") )
            @method("PUT")
         @endif
         <div class="col-xs-12">
            <div class="form-group col-xs-3">
               <label class="control-label no-padding-right" for="product_name"> Product Name </label>
               <input placeholder="Product Name" name="product_name"
                      value="{{ old('product_name',$product->product_name) }}" id="product_name" class="form-control"
                      type="text">
            </div>
            <div class="form-group col-xs-3">
               <label class="control-label no-padding-right" for="made_in"> Made IN: </label>
               <input placeholder="Made IN" name="made_in" value="{{ old('made_in',$product->made_in) }}" id="made_in"
                      class="form-control" type="text">
            </div>
            <div class="form-group col-xs-3">
               <label for="brand_id">Choose your brands</label>
               <select name="brand_id" id="brand_id" class="form-control">
                  @foreach($brands as $brand)
                     <option {{ $product->brand_id == $brand->brand_id ? "selected" : '' }} value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group  col-xs-3">
               <label class=" control-label no-padding-right" for="product_slug"> Product Slug </label>
               <input placeholder="Product Slug" id="product_slug" name="product_slug"
                      value="{{ old('product_slug',$product->product_slug) }}" class="form-control" type="text">
            </div>
         </div>

         <div class="form-group col-xs-12">
            <div class="col-xs-3">
               <label class=" control-label no-padding-right" for="sale_price"> Sale Price </label>
               <input placeholder="Sale Price" name="sale_price" value="{{ old('sale_price',$product->sale_price) }}"
                      id="sale_price" class="form-control" min="0" type="number">
            </div>
            <div class="col-xs-3">
               <label class=" control-label no-padding-right" for="buy_price"> Buy Price </label>
               <input placeholder="Buy Price" name="buy_price" value="{{ old('buy_price',$product->buy_price) }}"
                      id="buy_price" class="form-control" min="0" type="number">
            </div>
            <div class="col-xs-3">
               <label for="quantity">Quantity</label>
               <input placeholder="Quantity" type="number" value="{{ old("quantity",$product->quantity) }}" min="0"
                      name="quantity" class="form-control" id="quantity">
            </div>
            <div class="col-xs-3">
               <label for="weight">Weight</label>
               <input placeholder="weight" type="number" value="{{ old("weight",$product->weight) }}" min="0"
                      name="weight" class="form-control" id="weight">
            </div>
         </div>
         <div class="col-xs-12 form-group">
            <label for="description">Description</label>
            <textarea id="description" rows="6" class="form-control"
                      name="description">{{ old('description',$product->description) }}</textarea>
         </div>
         <div class="form-group col-xs-6">
            <div class="col-sm-4">

               <label><h4>Available ? </h4>
                  <input type="checkbox" name="status" id="status" onclick=''
                         class="ace ace-switch ace-switch-5" {{ $product->status == 1 ? 'checked': '' }} >
                  <span class="lbl"></span>
               </label>

               <label><h4>Discount ?</h4>
                  <input type="checkbox" name="is_off" id="is_off" onclick=""
                         class="ace ace-switch ace-switch-5" {{ $product->is_off == 1 ? 'checked' :'' }}>
                  <span class="lbl"></span>
               </label>
            </div>
            <div class="col-sm-8">
               <div class="available0">
                  <label for="data_available"><b>Available Date</b></label>
                  <input id="data_available" name="data_available" class="form-control"
                         value="{{ old('data_available',$product->data_available) }}" type="date"/>
               </div>
               <div class="div-discount">
                  <label for="off_price"><b>Amount of Discount:</b></label>
                  <input id="off_price" name="off_price" class="form-control" min="0"
                         value="{{ old('off_price',$product->off_price) }}" type="number">
               </div>
            </div>
         </div>
         <div class="form-group col-xs-6">
            <div class="form-group">
               <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tag input</label>
               <div class="col-sm-9">
                  <div class="inline">
                     <input type="text" name="tags" id="form-field-tags" placeholder="Enter tags ..."
                            value="<?php foreach ($product->tags as $tag) {
                                echo $tag->tag_name . ',';
                            } ?>"/>
                     <span class="help-button" title="Type your tag and press enter">?</span>
                  </div>
                  <label>
                     <h4>Has Size ? </h4>
                     <input type="checkbox" name="has_size" id="has_size" class="ace ace-switch ace-switch-5"
                             {{ $product->has_size == 1 ? 'checked' :'' }}>
                     <span class="lbl"></span>
                  </label>
               </div>
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
            <div class="col-xs-6">
               <!-- to show selected images -->
               <div class="gallery"></div>
               @foreach($product->photos as $photo)
                  <div class="fileuploader-items div-show image-show">
                     <ul class="fileuploader-items-list">
                        <li class="fileuploader-item file-has-popup file-type-image file-ext-png">
                           <div class="columns">
                              <a href="{{ $photo->src }}" target="_blank">
                                 <div class="column-thumbnail">
                                    <div class="fileuploader-item-image fileuploader-no-thumbnail">
                                       <div style="background-color: #1B6AAA " class="fileuploader-item-icon">
                                          <img src="{{ $photo->thumbnail }}" alt="{{ $photo->photo_title }}">
                                       </div>
                                    </div>
                                    <span class="fileuploader-action-popup">
                                 </span>
                                 </div>
                              </a>
                              <div class="column-title">
                                 <div title="innostudio.de__setting-icnload.png">{{ $photo->photo_title }}</div>
                                 <span>{{ $photo->photo_size }} KB </span>
                              </div>
                              <div class="column-actions">
                                 <input type="radio" name="cover" value="{{ $photo->addr }}"
                                        {{ $photo->addr == substr(strchr($product->cover,'\\'),1) ? 'checked' : '' }}  class="cover_cb fileuploader-action radio"
                                        id="cover" title="Cover Photo">
                                 <i class="icon ui-icon-asc"></i><a
                                         class="fileuploader-action fileuploader-action-remove" title="remove"><i
                                            data-id="{{ $photo->photo_id }}" class="destroy_image"></i></a></div>
                           </div>
                           <div class="progress-bar2">
                              <div class="fileuploader-progressbar">
                                 <div class="bar"></div>
                              </div>
                              <span></span>
                           </div>
                        </li>
                     </ul>
                  </div>
               @endforeach
            </div>
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
                              <option {{ in_array($category->category_id,$p_categories) ? 'selected': '' }} value="{{ $category->category_id }}">{{ $category->category_name }}</option>
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
                                 <option {{  in_array($color->color_id,$p_colors) ? 'selected' : '' }} value="{{ $color->color_id}}">{{ $color->color_name }}</option>
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
         <div class="col-xs-12">
            <div class="col-xs-6">
               <input type="submit" class="btn btn-success btn-block" id="submit" value="SAVE">
            </div>
            <div class="col-xs-6">
               <a class="btn btn-danger btn-block" onclick="history.back()">Cancel</a>
            </div>
         </div>
      </form>
   </div>

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
   {{--send date with AJAX--}}
   @if(env('APP_AJAX') )
      <script type="text/javascript">
          $(document).ready(function () {
              //get value of radio buttons
              var radio_val = $("input[name='cover']").val();
              $(".radio").click(function () {
                  radio_val = $(this).val();
              });
              $("#Uproduct_form").submit(function (e) {
                  e.preventDefault();
                  var form = $(this);
                  var data_form = new FormData(this);
                  data_form.append('_method', 'PUT');
                  /*var data = {
                      product_name: $("#product_name").val(),
                      made_in: $("#made_in").val(),
                      brand_id: $("#brand_id").val(),
                      product_slug: $("#product_slug").val(),
                      sale_price: $("#sale_price").val(),
                      buy_price: $("#buy_price").val(),
                      quantity: $("#quantity").val(),
                      weight: $("#weight").val(),
                      description: $("#description").val(),
                      data_available: $("#data_available").val(),
                      off_price: $("#off_price").val(),
                      categories: $("#duallist0").val(),
                      colors: $("#duallist").val(),
                      photos: $("#gallery-photo-add").val(),
                      cover: radio_val,
                  };*/
                  // check if the input is valid
                  // if (!form.valid()) return false;
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                      }
                  });
                  $.ajax({
                      url: "{{ route('product.update',$product->product_id) }}",
                      method: "POST",
                      enctype: 'multipart/form-data',
                      dataType: 'json',
                      data: data_form,
                      contentType: false,
                      cache: false,
                      processData: false,
                      beforeSend: function () {
                          $(".preview").toggle();
                      },
                      success: function (data) {
                          console.log(data.message);
                          if (data.success === true) {
                              alert(data.message);
                              $("#error_result").empty();
                          }
                          //show loading image ,
                          $(".preview").hide();
                      },
                      error: function (request, status, error) {
                          console.log(request.responseText);
                          var json = $.parseJSON(request.responseText);
                          if (json.success === false) {
                              alert(json.message);
                              $(".preview").hide();
                              return
                          }
                          $("#error_result").empty();
                          $(".preview").hide();
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

   <script type="text/javascript">
       <!-- show selected images -->
       $(document).ready(function () {
           $(function () {
               // Multiple images preview in browser
               var imagesPreview = function (input, placeToInsertImagePreview) {
                   // $(".gallery").empty();
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

       //REMOVE IMAGES WHICH SELECTED FRIM INPUT
       function removeImage(e) {
           $(e).parents(":eq(4)").remove()
       }

       //REMOVE IMAGES FROM DATA BASE with ajax
       $(".destroy_image").click(function () {
           var obj = $(this);
           var photo_id = $(this).data("id");
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
               }
           });
           $.ajax({
               url: " /admin/photo/" + photo_id,
               method: "DELETE",
               datatype: "json",
               data: {id: photo_id},
               success: function (data) {
                   if ( data.success === true) {

                       alert(data.message);
                       obj.parents(":eq(5)").remove();
                   }
               },
               error: function (request, status, error) {
                   console.log(request);
                   var json = $.parseJSON(request.responseText);
                   if (json.success === false) {
                       alert(json.message);
                   }
                   console.log(json,error);
               }
           });
       });
   </script>
   <script src="{{ asset('admin-assets/js/bootstrap-tag.min.js') }}"></script>
   <!-- FOR TAG INPUT -->
   <script type="text/javascript">
       var tag_input = $('#form-field-tags');
       try {
           tag_input.tag(
               {
                   source: function (query, process) {
                       $.ajax({
                           url: '/admin/product/tags/' + query,
                           type: 'get'
                       }).done(function (result_items) {
                           process(result_items);
                       });
                   }
               }
           )
       } catch (e) {
           tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
       }
   </script>
@stop