@extends('layout.admin.index')
@section('title')
Show Role
@endsection
@section('extra_css')
@endsection
@section('content')
   <div class="row">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2> Show Role</h2>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6">
            <span class="bolder">Name:</span>
            {{ $role->name }}
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6">
            <span class="bolder">Description:</span>
            {{ $role->description }}

      </div>


      <div class="col-xs-12 col-sm-12 col-md-12">
         <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($rolePermissions))
               @foreach($rolePermissions as $v)
                  <label class="label label-success">{{ $v->name }},</label>
               @endforeach
            @endif
         </div>
      </div>
   </div>

@endsection
@section('extra_js')
@endsection