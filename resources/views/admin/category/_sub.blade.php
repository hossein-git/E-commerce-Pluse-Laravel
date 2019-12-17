<ul class="dropdown-menu dropdown-danger">
   @foreach($subs as $sub)
      <li>
         <a class="click_me" tabindex="-1" href="">{{ "-".$category->category_name }}</a>
      </li>

      @if($sub->children->count())
         @include('admin.category._sub', ['subs' => $category->children])
      @endif
   @endforeach
</ul>



