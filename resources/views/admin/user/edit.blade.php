@extends('layout.admin.index')
@section('title')
Edit User
@endsection
@section('extra_css')
@endsection
@section('content')
   @include('layout.errors.notifications')
   <form  action="{{ route('user.update',$user->user_id) }}" method="post" >
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

      <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="role">Role:</label>
         <select class="form-control" name="role_id" id="role">
            <option value="" {{ $user->roles ? '' : 'selected' }}>NORMAL USER</option>
            @forelse($roles as $role)
               <option value="{{ $role->role_id }}" {{ isset($user->roles) && $user->roles->role_id == $role->role_id ? 'selected' : 'n'}} >
                  {{ $role->name }}</option>
            @empty
            @endforelse
         </select>
         <span class="text-danger">{{ $errors->first('role') }}</span>
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
      @if ($user->address)
         <div class="form-group">
            <a href="{{ route('admin.address.edit',$user->user_id) }}" class="btn btn-lg btn-success">Edit Address</a>
         </div>
      @endif

   </form>

@endsection
@section('extra_js')
@endsection