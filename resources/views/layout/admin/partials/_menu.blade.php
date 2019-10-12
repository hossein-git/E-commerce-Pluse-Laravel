<div class="dropdown-menu">
   <ul>
      @foreach($items as $item)
         <li>
            <a href="{{ route('web.category',$item->category_id) }}">{{ $item->category_name}}<span></span></a>
            {{--@if(isset($categories[$category->category_id]))
                @include('layouts.web._nav',['items' =>$categories[$category->category_id] ])
            @endif--}}
            {{--<div class="dropdown-menu">
                <ul>
                    <li><a href="category.html">کومیته </a></li>
                </ul>
            </div>--}}
         </li>
      @endforeach
   </ul>
</div>