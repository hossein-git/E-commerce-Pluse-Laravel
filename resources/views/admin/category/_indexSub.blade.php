@foreach($subs as $sub)
   <ul >
      <div class="space-2"></div>
      <li class="font-weight-bold">
         -- <b>{{$sub->category_name }}</b>
         <button class="delete_it btn btn-danger btn-xs" data-id="{{ $sub->category_id }}">
            -
            <i class="ace-icon fa fa-trash-o bigger-140"></i>
         </button>
      </li>
   </ul>

@endforeach

