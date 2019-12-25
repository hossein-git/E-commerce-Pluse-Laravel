<!-- FOR CATEGORY IN MOBILE NAV -->
<ul>
   @foreach ($children as $child)
      <li>
         <a href="{{ route('front.lists',['list' => 'categories','slug' => "$child->category_slug", ]) }}">{{ $child->category_name }}</a>
         @if ($child->children->count() > 0)
            @include('layout.front.partials.categoryPartials._child2', ['children' => $child->children])
         @endif
      </li>
   @endforeach
</ul>