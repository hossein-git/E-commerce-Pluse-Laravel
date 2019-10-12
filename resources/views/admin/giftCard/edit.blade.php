@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty' )
@section('content')
   <form id="gift_form" action="{{ route('giftCard.update',$gift->gift_id) }}" method="post">
      {{ csrf_field() }}
      @if( ! env("APP_AJAX") )
         @method("PUT")
      @endif
      <div class="form-group {{ $errors->has('gift_name') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="gift_name">Gift Card Name</label>
         <input type="text" name="gift_name" maxlength="21" id="gift_name" placeholder="gift Card Name"
                value="{{ old('gift_name',$gift->gift_name)}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('gift_name') }}</span>
      </div>

      <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="status">Gift Card Status:</label><br>
         <input type="checkbox" name="status" id="status" class="ace ace-switch ace-switch-3" {{ $gift->status == 1 ? 'checked' : ''}}>
         <span class="lbl"></span>
         <span class="text-danger">{{ $errors->first('status') }}</span>
      </div>

      <input type="hidden" name="gift_code" value="{{($gift->gift_code)}}" >

      <div class="form-group {{ $errors->has('gift_amount') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="gift_amount">Gift Card Amount</label>
         <input type="number" name="gift_amount" maxlength="21" id="gift_amount" placeholder="gift Card Slug"
                value="{{old('gift_amount',$gift->gift_amount)}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('gift_amount') }}</span>
      </div>

      <div class="form-group">
         <div class="btn-group btn-group-justified">
            <div class="btn-group">
               <button type="submit" class="btn btn-info ">UPDATE</button>
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
              $("#gift_form").submit(function (e) {
                  e.preventDefault();
                  var form = $(this);
                  var form_data = new FormData(this);
                  form_data.append('_method', 'PATCH');
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url: "{{ route('giftCard.update',$gift->gift_id) }}",
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
                          alert('Gift has updated successfully' );
                          history.back();
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