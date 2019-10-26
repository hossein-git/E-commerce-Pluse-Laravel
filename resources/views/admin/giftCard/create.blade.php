@extends('layout.admin.index' )
@section('title')
   Gift Cards Create
@stop
@section('extra_css')
@stop
@section('content')
   @include('layout.errors.notifications')
   <form id="gift_form" action="{{ route('giftCard.store') }}" method="post">
      {{ csrf_field() }}
      <div class="form-group {{ $errors->has('gift_name') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="gift_name">Gift Card Name</label>
         <input type="text" name="gift_name" maxlength="21" id="gift_name" placeholder="gift Card Name"
                value="{{ old('gift_name')}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('gift_name') }}</span>
      </div>

      <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="status">Gift Card Status:</label><br>
         <input type="checkbox" name="status" id="status" class="ace ace-switch ace-switch-3" checked>
         <span class="lbl"></span>
         <span class="text-danger">{{ $errors->first('status') }}</span>
      </div>

      <div class="form-group {{ $errors->has('gift_code') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="gift_code">Gift Card Code</label>
         <input type="text" name="gift_code" maxlength="21" id="gift_code" placeholder="gift Card Code"
                value="{{old('gift_code')}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('gift_code') }}</span>
      </div>

      <div class="form-group {{ $errors->has('gift_amount') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="gift_amount">Gift Card Amount</label>
         <input type="number" name="gift_amount" maxlength="21" id="gift_amount" placeholder="gift Card Amount"
                value="{{old('gift_amount')}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('gift_amount') }}</span>
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


@endsection
@section('extra_js')
   @if(env('APP_AJAX'))
      <script>
          $(document).ready(function () {
              $("#gift_form").submit(function (e) {
                  e.preventDefault();
                  var form_data = new FormData(this);
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url: "{{ route('giftCard.store') }}",
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
                          $("#gift_form")[0].reset();
                          alert('new Gift card has created successfully');
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