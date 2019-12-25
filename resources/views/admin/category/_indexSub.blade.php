<ul>
   @foreach($subs as $sub)
      <li data-id="{{ $sub->category_id }}" data-jstree='{"icon":"ace-icon fa fa-trash-o"}'>{{$sub->category_name }}
         @if($sub->children->count())
            @include('admin.category._indexSub', ['subs' => $sub->children])
         @endif
      </li>
   @endforeach
</ul>


