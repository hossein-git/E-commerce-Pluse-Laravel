<nav class="panel-menu mm-right">
   <ul>
      <li><a href="{{ route('home') }}" class="load_page">Home</a></li>
      <li>
         <a href="{{ route('front.productsList') }}" class="load_page">Products</a>
         <ul>
            @forelse($categories as $category)
               <li><a href="{{ route('front.lists',['list' => 'categories','slug' => "$category->category_slug", ]) }}"
                      class="load_page">{{ $category->category_name }}</a>
                  @if ($category->children->count() > 0)
                     @include('layout.front.partials.categoryPartials._child', ['children' => $category->children])
                  @endif
               </li>
            @empty
               <li>NOTHING YET</li>
            @endforelse
         </ul>
      </li>
      <li>
         <a>SPECIAL OFFERS</a>
         <ul>
            @forelse($special_offers as $product)
               <li><a href="{{ route('front.show',$product->product_slug) }}">{{ $product->product_name }}</a></li>
            @empty
            @endforelse

         </ul>
      </li>
      <li>
         <a>MOST SOLD</a>
         <ul>
            @forelse($popular_products as $product)
               <li><a href="{{ route('front.show',$product->product_slug) }}">{{ $product->product_name }}</a></li>
            @empty
            @endforelse
         </ul>


      <li>
         <a>BRANDS</a>
         <ul>
            @forelse($brands as $brand)
               <li><a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $brand->brand_slug ]) }}"
                      class="load_page">{{ $brand->brand_name }}</a></li>
            @empty
               <b>NO DATA</b>
            @endforelse
         </ul>
      </li>
   </ul>
   <div class="mm-navbtn-names" style="display:none">
      <div class="mm-closebtn">CLOSE</div>
      <div class="mm-backbtn">BACK</div>
   </div>
</nav>

