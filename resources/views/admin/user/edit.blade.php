@extends('layout.admin.index')
@section('title')
Edit User
@endsection
@section('extra_css')
@endsection
@section('content')
   <form id="user_edit_form" action="{{ route('user.update',$user->user_id) }}" method="post" >
      {{ csrf_field() }}
      {{ method_field('put') }}

      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="name">Name</label>
         <input type="text" name="name" maxlength="21" id="name" placeholder="Name"
                value="{{isset($user->name) ? $user->name : old('name')}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('name') }}</span>
      </div>

      <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="email">Email:</label>
         <input type="email" name="email" maxlength="21" id="email" placeholder="Email"
                value="{{isset($user->email) ? $user->email : old('email')}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('email') }}</span>
      </div>
      @can('role-create','role-edit')
         <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
            <label class="bolder bigger-110" for="role">Role:</label>
            <select class="form-control" name="roles[]" id="role" multiple>
               <option value="" {{ $user->getRoleNames()->count() == 0 ? 'selected' : '' }}>NORMAL USER</option>
               @forelse($roles as $key=> $role)
                  <option value="{{ $role->id }}" {{ in_array($role->id,$userRole) ? 'selected' : ''}} >
                     {{ $role->name }}</option>
               @empty

               @endforelse
            </select>
            <span class="text-danger">{{ $errors->first('role') }}</span>
         </div>
      @endcan
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
      @if ($user->address)
         <div class="form-group">
            <a href="{{ route('admin.address.edit',$user->user_id) }}" class="btn btn-lg btn-success">Edit Address</a>
         </div>
      @endif

   </form>

@endsection
@section('extra_js')
   @if (env('APP_AJAX'))
      <script type="text/javascript">
          $(document).ready(function ()
          {
              $("#user_edit_form").submit(function (e) {
                  e.preventDefault();
                  var data ={
                      name : $('#name').val(),
                      email : $('#email').val(),
                      roles : $('#role').val(),
                      _method : "PUT"

                  };
                  if (upload_ajax("{{ route('user.update',$user->user_id) }}",data))
                  {
                      return window.location.replace("{{ route('user.index') }}");
                  }
              });
          });
      </script>

   @endif

@endsection