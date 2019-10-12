@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty')
@section('content')
   @include('layout.errors.notifications')
   <form id="ssss"
         action="{{ isset($brand) ? route('brand.update',$brand->brand_id) : route('brand.store') }}"
         method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      @if(!env('APP_AJAX'))
      {{ isset($brand) ? method_field('PUT') : '' }}
      @endif
      <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="brand_name">Brand Name</label>
         <input type="text" name="brand_name" maxlength="21" id="brand_name" placeholder="Brand Name"
                value="{{ isset($brand) ? $brand->brand_name : old('brand_name')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('brand_name') }}</span>
      </div>
      <div class="form-group {{ $errors->has('brand_slug') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="brand_slug">Brand Slug</label>
         <input type="text" name="brand_slug" maxlength="21" id="brand_slug" placeholder="Brand Slug"
                value="{{isset($brand) ? $brand->brand_slug :old('brand_slug')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('brand_slug') }}</span>
      </div>

      <div class="form-group {{ $errors->has('brand_description') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="brand_description">Description</label>
         <textarea type="text" name="brand_description" id="brand_description" placeholder="Brand Slug" required
                   class="form-control">{{isset($brand) ? $brand->brand_description :old('brand_description')}}</textarea>
         <span class="text-danger">{{ $errors->first('brand_description') }}</span>
      </div>

      <div class="form-group {{ $errors->has('brand_image') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="brand_image">Brand Image</label>

            <input type="file" name="brand_image" id="brand_image" required>
{{--            <span class="ace-file-container" data-title="Choose"><span class="ace-file-name" data-title="select photo"><i class=" ace-icon fa fa-upload"></i></span></span>--}}

         <span class="text-danger">{{ $errors->first('brand_image') }}</span>
      </div>

      <div class="form-group">
         <div class="btn-group btn-group-justified">
            <div class="btn-group">
               <button type="submit" class="btn btn-info ">SAVE</button>
            </div>
            <div class="btn-group">
               <a class="btn btn-danger" onclick="history.back()">BACK</a>
            </div>
         </div>
      </div>
   </form>
   @if(env('APP_AJAX') == true)
      <script>
          $(document).ready(function () {
              $("#ssss").submit(function (e) {
                  e.preventDefault();
                  var form = $(this);
                  var form_data = new FormData(this);
                  {{ isset($brand) ? "data_form.append('_method', 'PATCH');" : ''}}
                  console.log(form_data);
                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                     }
                 });
                  $.ajax({
                      url: "{{ isset($brand) ? route('brand.update',$brand->brand_id) : route('brand.store') }}",
                      method: "post",
                      data: form_data,
                      contentType: false,
                      cache: false,
                      processData: false,
                      beforeSend: function () {
                          $(".preview").toggle();
                      },
                      success: function ($results) {
                          //show loading image ,reset forms ,clear gallery
                          $(".preview").toggle();
                          {{ isset($brand) ? "" : '$("#brand_form")[0].reset()' }}
                          alert({{ !isset($brand) ? 'new brand has created successfully' : "brand has updated successfully" }});
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
                      }
                  });
              });
          });
      </script>
   @endif



@endsection