@extends('layout.admin.index')
@section('title')
   Brands
@stop
@section('content')

   <form id="brand_form"
         action="{{ isset($brand) ? route('brand.update',$brand->brand_id) : route('brand.store') }}"
         method="post" enctype="multipart/form-data"
   >
      {{ isset($brand) ? method_field('PUT') : '' }}
      {{ csrf_field() }}
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

      @if (isset($brand) && $brand->brand_image != null)
         <input type="hidden" name="brand_image" value="{{ $brand->brand_image }}">
      @endif
      <img id="show_image" src="{{ isset($brand) ? $brand->src : '' }}" alt="" width="200" height="100" class="img-responsive img-thumbnail">
      <div class="form-group {{ $errors->has('brand_image') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="brand_image">Brand Image</label>
         <input type="file" name="brand_image" id="brand_image">
         <span class="text-danger">{{ $errors->first('brand_image') }}</span>
      </div>

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
   </form>

@endsection
@section('extra_js')
   <script>
       $(document).ready(function () {

           function readURL(input) {
               if (input.files && input.files[0]) {
                   var reader = new FileReader();

                   reader.onload = function (e) {
                       $('#show_image').attr('src', e.target.result);
                   }

                   reader.readAsDataURL(input.files[0]);
               }
           }

           $("#brand_image").change(function () {
               readURL(this);
           });
          @if(env('APP_AJAX'))
          $("#brand_form").submit(function (e) {
              e.preventDefault();
              //var form = $(this);
              var form_data = new FormData(this);
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
              $.ajax({
                  url: "{{ isset($brand) ? route('brand.update',$brand->brand_id) : route('brand.store') }}",
                  method: "post",
                  data: form_data,
                  enctype: 'multipart/form-data',
                  contentType: false,
                  cache: false,
                  processData: false,
                  beforeSend: function () {
                      $(".preview").toggle();
                  },
                  success: function ($results) {
                      //show loading image ,reset forms ,clear gallery
                      $(".preview").toggle();
                     @if(!isset($brand)) $("#brand_form")[0].reset(); @endif
                     alert('{{ !isset($brand) ? 'new brand has created successfully' : "brand has updated successfully" }}');
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
          @endif
       });
   </script>

@stop