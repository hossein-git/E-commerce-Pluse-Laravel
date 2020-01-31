@extends('layout.admin.index')
@section('title')
   Edit Role
@endsection
@section('extra_css')
@endsection
@section('content')

   <div class="row">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>Edit Role</h2>
         </div>
      </div>
   </div>
   <form id="role_form" action="{{ route('roles.update', $role->id) }}" method="post">
      @csrf
      @method('put')

      <div class="row">
         <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
               <label for="name"><strong>Name:</strong></label>
               <input type="text" value="{{ $role->name }}" id="name" name="name" placeholder="name"
                      class="form-control">
            </div>
         </div>
         <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
               <label for="description"><strong>description:</strong></label>
               <input type="text" value="{{ $role->description }}" id="description" name="description"
                      placeholder="description" class="form-control">
            </div>
         </div>
         <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
               <strong>Permission:</strong>
               <br/>
               @foreach($permission as $value)
                  <label>
                     <input type="checkbox" class="checkbox"
                            {{in_array($value->id, $rolePermissions) ? 'checked' : ''}} name="permission[]"
                            value="{{$value->id}}">
                     {{ $value->name }}</label>
                  <br/>
               @endforeach

            </div>
         </div>
         <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <div class="form-group">
               <div class="btn-group btn-group-justified">
                  <div class="btn-group">
                     <button type="submit" id="role_submit" class="btn btn-info">SAVE</button>
                  </div>
                  <div class="btn-group">
                     <a class="btn btn-danger" onclick="history.back()">BACK</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>





@endsection
@section('extra_js')
   @if (env('APP_AJAX'))
      <script type="text/javascript">
          $(document).ready(function () {
              $('#role_form').submit(function (e) {
                  e.preventDefault();
                  var total = [];
                  $('.checkbox').each(function () {
                      if ($(this).prop("checked")) {
                          total.push($(this).val());
                      }
                  });
                  var data = {
                      _method : 'put',
                      name: $('#name').val(),
                      description: $('#description').val(),
                      permission: total,

                  };
                   if (upload_ajax("{{ route('roles.update', $role->id)  }}",data)){
                       window.history.back();
                   }
              });
          });
      </script>
   @endif
@endsection