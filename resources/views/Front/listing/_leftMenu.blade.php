<div class="slide-column-close">
   <a href="#"><span class="icon icon-close"></span>CLOSE</a>
</div>
<div class="col-md-3 col-lg-2 col-xl-2 aside leftColumn">
   <div class="collapse-block open collapse-block-mobile">
      <h3 class="collapse-block_title hidden">Filter:</h3>
      <div class="collapse-block_content">
         <div class="filters-mobile">

         </div>
      </div>
   </div>
   <form id="order_form"
         action="{{ (\Request::route()->getName()) == 'front.productsList' ? route('front.productsList') : route('front.lists',[ 'list' => \Request::route('list'), 'slug' => \Request::route('slug') ])}}"
         method="post">
      <div class="collapse-block open">
         <h3 class="collapse-block_title ">Sorting</h3>
         <div class="collapse-block_content">
            @csrf
            <div class="filters-row_select ">
               <label for="sort">Sort by:</label>
               <select name="sort" id="sort" class="form-control sort-position">
                  <option value="product_id">Default</option>
                  <option value="created_at">New Products</option>
                  <option value="sale_price">Price</option>
               </select>
            </div>
            <div class="filters-row_select">
               <label ></label>
               <select name="dcs" class="form-control sort-position">
                  <option value="desc">High to lower</option>
                  <option value="asc">Low to higher</option>
               </select>
            </div>
            <div class="filters-row_select">
               <label for="paginate">Show:</label>
               <select name="paginate" id="paginate" class="form-control show-qty">
                  <option value="10">10</option>
                  <option value="30">30</option>
                  <option value="60">60</option>
               </select>
               <a href="#" class="icon icon-arrow-down active">
               </a><a href="#" class="icon icon-arrow-up"></a>
            </div>
            <button type="submit" class="btn">FILTER</button>
         </div>
      </div>
      <div class="collapse-block open">
         <h3 class="collapse-block_title ">PRICE</h3>
         <div class="collapse-block_content">
            {{--         <div class="price-slider">--}}
            {{--            <div class="priceSlider"></div>--}}
            {{--         </div>--}}
            <div class="price-input form-group">
               <label>From</label>
               <input type="number" class="form-control" id="" min="0" value="0" name="priceMin"/>
            </div>
            <div class="price-input form-group">
               <label>To</label>
               <input type="number" class="form-control" id="" min="0" max="9999999" name="priceMax"/>
            </div>
            <div class="price-input">
               <button type="submit" class="btn">FILTER</button>
            </div>
         </div>
      </div>
   </form>
   <div class="collapse-block open">
      <h3 class="collapse-block_title">Products:</h3>
      <div class="collapse-block_content">
         <ul class="list-simple">
            @forelse($categories as $category)
               <li>
                  <a href="{{ route('front.lists',['list' => 'categories','slug' => "$category->category_slug", ]) }}">{{ $category->category_name }}</a>
               </li>
            @empty
               <li>NOTHING YET</li>
            @endforelse
         </ul>
      </div>
   </div>
</div>