@extends('layout.admin.index')
@section('title')
   Add new User
@endsection
@section('extra_css')
@endsection
@section('content')
   <form id="user_form" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" >
      {{ csrf_field() }}

      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="name">Name</label>
         <input type="text" name="name" maxlength="21" id="name" placeholder="Name"
                value="{{ old('name')}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('name') }}</span>
      </div>

      <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="email">Email:</label>
         <input type="email" name="email" maxlength="21" id="email" placeholder="Email"
                value="{{old('email')}}" required class="form-control">
         <span class="text-danger">{{ $errors->first('email') }}</span>
      </div>

      <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
         <label class="bolder bigger-110" for="role">Role:</label>
         <select class="form-control select2" name="role_id" id="role">
            <option value="" selected>NORMAL USER</option>
            @forelse($roles as $role)
               <option value="{{ $role->role_id }}" {{ $role->role_id == old('role') ? 'selected' : '' }}>{{ $role->name }}</option>
               @empty
            @endforelse
         </select>
         <span class="text-danger">{{ $errors->first('role') }}</span>
      </div>

{{--      <div class="form-group {{ $errors->has('brand_image') ? 'has-error' : '' }}">--}}
{{--         <label class="bolder bigger-110" for="brand_image">Brand Image</label>--}}

{{--         <input type="file" name="brand_image" id="brand_image" required>--}}

{{--         <span class="text-danger">{{ $errors->first('brand_image') }}</span>--}}
{{--      </div>--}}

      <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
         <label for="password" class="bolder bigger-110">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
            <span class="invalid-feedback text-danger" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
      </div>

      <div class="form-group ">
         <label for="password-confirm" class="bolder bigger-110">{{ __('Confirm Password') }}</label>
         <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
@endsection