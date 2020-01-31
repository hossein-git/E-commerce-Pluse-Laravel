@extends('layout.admin.index')
@section('title')
   Role List
@endsection
@section('extra_css')
@endsection
@section('content')

   <div class="row">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left">
            <h2>Role Management</h2>
         </div>
      </div>
   </div>

   <table class="table table-hover table-bordered">
      <thead>
         <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($roles as $key => $role)
         <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->description }}</td>
            <td class="center">
               <div class="btn-group">
                  <a class="btn btn-info click_me" href="{{ route('roles.show',$role->id) }}">Show</a>
                  @can('role-edit')
                     <a class="btn btn-primary click_me" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                  @endcan
                  @can('role-delete')
                     <button class="btn  btn-danger delete_role" title="Delete" data-id="{{ $role->id }}">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                     </button>
                  @endcan
               </div>
            </td>
         </tr>
      @endforeach
      </tbody>

   </table>

   {!! $roles->render() !!}





@endsection
@section('extra_js')
   @can('role-delete')
      <script type="text/javascript">
         deleteAjax("/admin/roles/",'delete_role','role');
      </script>
   @endcan
@endsection