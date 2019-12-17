@extends('layout.admin.index' )
@section('title')
   Category Create
@stop
@section('extra_css')
@stop
@section('content')
   @include('layout.errors.notifications')
   <form id="category_form" action="{{ route('category.store') }}" method="post">
      {{ csrf_field() }}
      <div class="form-group {{ $errors->has('category_name') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="title">Category Name</label>
         <input type="text" name="category_name" maxlength="21" id="title" placeholder="Category Name" value="{{old('category_name')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('category_name') }}</span>
      </div>
      <div class="form-group {{ $errors->has('category_slug') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="title">Category Slug</label>
         <input type="text" name="category_slug" maxlength="21" id="title" placeholder="Category Slug" value="{{old('category_slug')}}" required
                class="form-control">
         <span class="text-danger">{{ $errors->first('category_slug') }}</span>
      </div>
      <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="Category">Parent Category </label>
         <select name="parent_id" id="Category" class="form-control">
            @if(count($allCategories) == 0)
               <option disabled="">NO CATEGORIES</option>
            @else
               <option value="">Parent Category</option>
               @foreach($allCategories as $Category)
                  <option value="{{ old('category_id',$Category->category_id) }}">
                     {{ !$Category->parent_id ? '--'.$Category->category_name : $Category->category_name }}
                  </option>
               @endforeach
            @endif
         </select>
         <span class="text-danger">{{ $errors->first('parent_id') }}</span>
      </div>

      <div class="form-group">
         <div class="btn-group btn-group-justified">
            <div class="btn-group">
               <button type="submit" class="btn btn-info ">SAVE</button>
            </div>
            <div class="btn-group">
               <a class="btn btn-danger" onclick="window.history.back()">BACK</a>
            </div>
         </div>
      </div>
   </form>

@endsection
@section('extra_js')
   @if(env('APP_AJAX'))
      <script>
          $(document).ready(function () {
              $("#category_form").submit(function (e) {
                  e.preventDefault();
                  var form = $(this);
                  var form_data = new FormData(this);
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url: "{{ route('category.store') }}",
                      method: "post",
                      data:  form_data,
                      contentType: false,
                      cache: false,
                      processData:false,
                      beforeSend: function () {
                          $(".preview").toggle();
                      },
                      success: function ($results) {
                          //show loading image ,reset forms ,clear gallery
                          $(".preview").toggle();
                          $("#category_form")[0].reset();
                          alert("new category has created successfully");
                          //console.log($results);
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
@stop
