@foreach($subs as $sub)
   <ul>
      <li class="font-weight-bold">
         -- <b>{{$sub->category_name }}</b>
         @can('product-delete')
            <button class="delete_it btn btn-danger btn-xs" data-id="{{ $sub->category_id }}">
               -
               <i class="ace-icon fa fa-trash-o bigger-140"></i>
            </button>
         @endcan
         
         @if($sub->children->count())
            @include('admin.category._indexSub', ['subs' => $sub->children])
         @endif
      </li>
   </ul>

@endforeach

