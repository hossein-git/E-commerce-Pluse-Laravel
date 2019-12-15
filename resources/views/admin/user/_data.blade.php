@forelse($users as $user)
   <tr>
      <td class="center">{{$user->user_id}}</td>
      <td class="center" >{{ $user->name }}</td>
      <td class="center">{{ $user->email }}</td>
      <td class="center">{{ $user->roles ? $user->roles->name : '-'  }}</td>
      <td class="center">{{ $user->created_at }}</td>
      <td class="center">
         <div class="hidden-sm hidden-xs btn-group">
            <form>
               <a class="btn btn-info2 btn-xs show_user" title="Show Profile"
                  href="{{ route('user.show',$user->user_id) }}" data-id="{{ $user->user_id }}">
                  <i class="ace-icon fa fa-eye bigger-120"></i>
               </a>
               <a class="btn btn-warning btn-xs edit_user" title="Edit"
                  href="{{ route('user.edit',$user->user_id ) }}" data-id="{{ $user->user_id  }}">
                  <i class="ace-icon fa fa-pencil bigger-120"></i>
               </a>
               <button class="btn btn-sm btn-danger delete_user" title="Delete" data-id="{{ $user->user_id  }}">
                  <i class="ace-icon fa fa-trash-o bigger-120"></i>
               </button>
            </form>
         </div>
      </td>
   </tr>
@empty
   <tr>
      <td colspan="6">No Data</td>
   </tr>
@endforelse