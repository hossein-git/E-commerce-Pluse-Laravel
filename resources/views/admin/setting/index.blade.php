@extends('layout.admin.index')
@section('title')
   Site Settings
@endsection
@section('extra_css')
@endsection
@section('content')

   <form id="setting_form"
         action="{{ isset($setting) ? route('settings.update',$setting->setting_id) : route('settings.store') }}"
         method="post" enctype="multipart/form-data"
   >
      {{ isset($setting) ? method_field('PUT') : '' }}
      {{ csrf_field() }}

      <div class="form-group {{ $errors->has('site_title') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="site_title">Site Title</label>
         <input type="text" name="site_title" maxlength="21" id="site_title" placeholder="Site Title"
                value="{{ isset($setting) ? $setting->site_title : old('site_title')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('site_title') }}</span>
      </div>

      <div class="form-group {{ $errors->has('site_phone') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="site_phone">Site Phone</label>
         <input type="text" name="site_phone" id="site_phone" placeholder="Site Phone"
                value="{{ isset($setting) ? $setting->site_phone : old('site_phone')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('site_phone') }}</span>
      </div>

      <div class="form-group {{ $errors->has('site_fax') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="site_fax">Site fax</label>
         <input type="text" name="site_fax" id="site_fax" placeholder="Site fax"
                value="{{ isset($setting) ? $setting->site_fax : old('site_fax')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('site_fax') }}</span>
      </div>

      <div class="form-group {{ $errors->has('site_email') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="site_email">Site Email</label>
         <input type="email" name="site_email" id="site_email" placeholder="Site Email"
                value="{{ isset($setting) ? $setting->site_email : old('site_email')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('site_email') }}</span>
      </div>

      <div class="form-group {{ $errors->has('site_address') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="site_address">Site address</label>
         <input type="text" name="site_address" id="site_address" placeholder="Site address"
                value="{{ isset($setting) ? $setting->site_address : old('site_address')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('site_address') }}</span>
      </div>

      <div class="form-group {{ $errors->has('site_description') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="site_description">Site Description</label>
         <textarea type="text" name="site_description" id="site_description" placeholder="site Description" required
                   class="form-control">{{isset($setting) ? $setting->site_description :old('site_description')}}</textarea>
         <span class="text-danger">{{ $errors->first('site_description') }}</span>
      </div>
      <div class="row">
         <div class="col-sm-5 col-xs-12">
            <div class="form-group" id="_logo">
               @if ($setting->site_logo)
                  <img src="{{ $setting->src  }}" alt="logo" class="img-thumbnail" width="100" height="200">
               @endif
            </div>
            <div class="form-group {{ $errors->has('site_logo') ? 'has-error' : '' }}">
               <label class="bolder bigger-110" for="site_logo">Site Logo</label>

               <input type="file" name="site_logo" id="site_logo" class="form-control">
               <span class="text-danger">{{ $errors->first('site_logo') }}</span>
            </div>
         </div>
         <div class="col-sm-2"></div>
         <div class="col-sm-5 col-xs-12">
            <div class="form-group" id="_icon">
               @if ($setting->site_icon)
                  <img src="{{ $setting->icon  }}" alt="icon" class="img-thumbnail" width="100" height="200">
               @endif
            </div>
            <div class="form-group {{ $errors->has('site_icon') ? 'has-error' : '' }}">
               <label class="bolder bigger-110" for="site_icon">Site icon</label>

               <input type="file" name="site_icon" id="site_icon" class="form-control">
               <span class="text-danger">{{ $errors->first('site_icon') }}</span>
            </div>
         </div>
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
   @if (env('APP_AJAX'))
      <script src="{{ asset('front-assets/js/checkOut.js') }}"></script>
      <script type="text/javascript">
          $(document).ready(function () {
              $("#setting_form").submit(function (e) {
                  e.preventDefault();
                  var form_data = new FormData(this);
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url: "{{ route('settings.update', $setting->setting_id) }}",
                      method: "post",
                      enctype: 'multipart/form-data',
                      data: form_data,
                      contentType: false,
                      cache: false,
                      processData: false,
                      beforeSend: function () {
                          $(".preview").show();
                      },
                      success: function ($results) {
                          if ($results.success === true) {
                              //show loading image ,reset forms ,clear gallery
                              $(".preview").hide();
                              location.reload();
                              alert($results.message);

                          }
                      },
                      error: function (request, status, error) {
                          var json = $.parseJSON(request.responseText);
                          if (json.success === false) {
                              alert(json.message);
                              $(".preview").hide();
                              return
                          }
                          $(".preview").hide();
                          $("#error_result").empty();
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