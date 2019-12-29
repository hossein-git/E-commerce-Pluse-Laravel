<nav class="header-menu">
   <ul>
      <li class="dropdown">
         <a href="{{ route('front.productsList') }}" class="load_page">PRODUCTS</a>
         <div class="dropdown-menu">
            {{--            <h2 class="title-submenu">LAYOUT</h2>--}}
            <div class="row custom-layout-02 menu-list-col">
               <div class="col-sm-4">
                  <div class="row" style="margin-top: -3rem ">
                     <div class="col-sm-6 justify-content-around">
                        <ul class="megamenu-submenu">
                           @foreach($categories as $key=> $category)
                              <li>
                                 <b><a class="cat-main" data-id="{{$key}}"
                                       onmouseover="nav_over(this)"
                                       href="{{ route('front.lists',['list' => 'categories','slug' => "$category->category_slug"]) }}"
                                       class="load_page">
                                       {{ $category->category_name }}
                                    </a></b>
                              </li>
                              <div id="nav_info{{$key}}" style="display: none">
                                 @if( $category->children->count())
                                    @foreach($category->children as $child)
                                       <li><b>
                                             <a href="{{ route('front.lists',['list' => 'categories','slug' => "$child->category_slug"]) }}"
                                                class="load_page">
                                                {{ $child->category_name }}</a>
                                          </b>
                                       </li>
                                    @endforeach
                                 @endif
                              </div>
                           @endforeach
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4">
                  {{--                  <a class="title-underline" href="listing-left-column.html">--}}
                  {{--                     <span>SHOPPING PAGES</span>--}}
                  {{--                  </a>--}}
                  <div class="row" style="margin-top: -3rem ">
                     <div class="col-sm-pull-4 ">
                        <div>
                           <ul id="category-chiled" class="megamenu-submenu bolder">

                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </li>
      <li class="dropdown">
         <a href="{{ route('front.productsList') }}">SPECIAL OFFERS</a>
         <div class="dropdown-menu">
            <div class="row custom-layout-02">
               <div class="col-sm-12">
                  <div class="header-menu-product slick-arrow-top row">
                     @forelse($special_offers as $product)
                        <div class="col-sm-2">
                           <div class="product">
                              <div class="product_inside">
                                 <a href="{{ route('front.show',$product->product_slug) }}">
                                    <div class="image-box">
                                       <img src="{{ $product->thumbnail }}" class="img-thumbnail" alt="photo">
                                       <div class="label-sale ">Sale<br>{{ $product->off }}% Off</div>
                                    </div>
                                    <h2 class="title">
                                       {{ $product->product_name }}
                                    </h2>
                                    <div class="price">
                                       <span class="new-price">{{ $product->price }}</span>
                                       <span class="old-price">{{ $product->sale_price }}</span>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>

                     @empty
                     @endforelse
                  </div>
               </div>
            </div>
         </div>
      </li>
      <li class="dropdown">
         <a>POPULER PRODUCTS</a>
         <div class="dropdown-menu">
            <div class="row custom-layout-02">
               <div class="col-sm-12">
                  <div class="header-menu-product  slick-arrow-top">
                     <div class="row">
                        @forelse($popular_products as $product)
                           <div class="col-sm-2">
                              <div class="product">
                                 <div class="product_inside">
                                    <a href="{{ route('front.show',$product->product_slug) }}">
                                       <div class="image-box">
                                          <img src="{{ $product->thumbnail }}" class="img-thumbnail" alt="photo">
                                          <div class="label-sale left">Sale</div>
                                       </div>
                                       <h2 class="title">
                                          {{ $product->product_name }}
                                       </h2>
                                       <div class="price">
                                          <span class="new-price">{{ $product->price }}</span>
                                          <span class="old-price">{{ $product->sale_price }}</span>
                                       </div>
                                    </a>
                                 </div>
                              </div>
                           </div>

                        @empty
                        @endforelse

                     </div>

                  </div>
               </div>
            </div>
         </div>
      </li>

      <li class="dropdown">
         <a>BRANDS</a>
         <div class="dropdown-menu">
            <div class="row custom-layout-02">
               <div class="col-sm-12">
                  <div class=" header-menu-product">
                     @forelse($brands as $brand)
                        <div class="col-sm-3">
                           <a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $brand->brand_slug ]) }}"
                              class="load_page">
                              <div class="image-box">
                                 <img src="{{ $brand->src }}" class="img" width="100" height="200" alt="{{ $brand->brand_name }}">
                              </div>
                           </a>
                        </div>

                     @empty
                        NO BRANDS
                     @endforelse
                  </div>

               </div>
            </div>
         </div>
      </li>
   </ul>
</nav>