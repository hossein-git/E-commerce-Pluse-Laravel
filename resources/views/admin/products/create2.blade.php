@extends('layout.admin.index')
@section('title')
   cre
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="bolder center text-info">
      <h5>please choose photo and others options</h5>
   </div>
   <form action="{{ route('product.store2') }}" method="post" enctype="multipart/form-data" id="product-form2">
      @csrf
      <div class="row">
         <!-- colors and category -->
         <div class="col-xs-12 col-lg-12 col-md-12">
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
         <hr>
         <br>

         <!-- Tags -->
         <div class="form-group col-xs-12 col-lg-12 col-md-12">
            <div class="form-group">
               <label class=" control-label no-padding-right" for="form-field-tags">Tag input</label>

               <div class="inline">
                  <input type="text" name="tags" id="form-field-tags" placeholder="Enter tags ..."/>
                  <span class="help-button" title="Type your tag and press enter">?</span>
               </div>

            </div>
         </div>
         <hr>
         <!-- Images -->
         <div class="form-group col-xs-12 col-lg-12 col-md-12">
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
         <hr>

         <div class="col-xs-12 col-lg-12 col-md-12">
            <div class="col-xs-6">
               <input type="submit" class="btn btn-success btn-block" id="" value="SAVE">
            </div>
            <div class="col-xs-6">
               <input type="reset" class="btn btn-warning btn-block" value="Reset!">
            </div>
         </div>

      </div>


   </form>




@endsection
@section('extra_js')

   <!-- FOR TAG INPUT -->
   <script src="{{ asset('admin-assets/js/bootstrap-tag.min.js') }}"></script>
   <script type="text/javascript">
       var tag_input = $('#form-field-tags');
       try {
           tag_input.tag(
               {
                   // placeholder: tag_input.attr('placeholder'),
                   //or fetch data from database, fetch those that match "query"
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
           //programmatically add/remove a tag
           // var $tag_obj = $('#form-field-tags').data('tag');
           // $tag_obj.add('Programmatically Added');
           //
           // var index = $tag_obj.inValues('some tag');
           // $tag_obj.remove(index);
       } catch (e) {
           //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
           tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
           //autosize($('#form-field-tags'));
       }

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
   <script>
       $(document).ready(function () {
           $(function () {
               // Multiple images preview in browser
               var imagesPreview = function (input, placeToInsertImagePreview) {
                   $(".gallery").empty();
                   if (input.files) {
                       var filesAmount = input.files.length;
                       if (input.files.length >= 4) {
                           alert('maximum you can add 3 image');
                           return;
                       }
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
                                   // '<input type="radio" name="cover" value="' + input.files[c].name + '" class="cover_cb fileuploader-action radio" id="cover" title="Cover Photo"><i class="icon ui-icon-asc"></i>' +
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

   {{--send date with AJAX--}}
   @if(env('APP_AJAX'))
      <script type="text/javascript">
          $(document).ready(function () {
              $("#product-form2").submit(function (e) {
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
                      url: "{{ route('product.store2') }}",
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
                          }
                      },
                      error: function (request, status, error) {
                          json = $.parseJSON(request.responseText);
                          console.log(json, status, error);
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
@endsection