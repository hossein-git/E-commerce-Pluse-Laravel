<nav class="header-menu">
   <ul>
      <li class="dropdown">
         <a href="{{ route('front.productsList') }}" class="load_page">PRODUCTS</a>
         <div class="dropdown-menu">
            {{--            <h2 class="title-submenu">LAYOUT</h2>--}}
            <div class="row custom-layout-02 menu-list-col">
               <div class="col-sm-4">
                  {{--                  <a class="title-underline" href="listing-left-column.html">--}}
                  {{--                     <span>STORE INFO PAGES</span>--}}
                  {{--                  </a>--}}
                  <div class="row" style="margin-top: -3rem ">
                     <div class="col-sm-6 justify-content-around">
                        <ul class="megamenu-submenu">
                           @foreach($categories as $key=> $category)
                              <li>
                                 <b><a class="cat-main" data-id="{{$key}}"
                                       onmouseover="nav_over(this)"
                                       href="{{ route('front.lists',['list' => 'categories','slug' => "$category->category_slug"]) }}" class="load_page">
                                       {{ $category->category_name }}
                                    </a></b>
                              </li>
                              <div id="nav_info{{$key}}" style="display: none">
                                 @if( $category->children->count())
                                    @foreach($category->children as $child)
                                       <li><b>
                                             <a href="{{ route('front.lists',['list' => 'categories','slug' => "$child->category_slug"]) }}" class="load_page">
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
         <a href="listing-left-column.html">SPECIAL OFFERS</a>
         {{--<div class="dropdown-menu">
            <h2 class="title-submenu">LISTING</h2>
            <ul class="image-links-layout">
               <li>
                  <a href="listing-left-column.html">
                     <span class="figure"><img src="images/custom/listing-img-01.png" alt=""></span>
                     <span class="figcaption">Left Column</span>
                  </a>
               </li>
            </ul>
         </div>--}}
      </li>
      <li class="dropdown">
         <a href="product.html">MOST SOLD</a>
         <div class="dropdown-menu">
            <h2 class="title-submenu">PRODUCT</h2>
            <ul class="image-links-layout">
               <li>
                  <a href="product.html">
                     <span class="figure"><img src="images/custom/product-img-01.png" alt=""></span>
                     <span class="figcaption">Image Size - Small</span>
                  </a>
               </li>
            </ul>
         </div>
      </li>
      <li class="dropdown">
         <a>BRANDS</a>
         <div class="dropdown-menu">
            <div class="row">
               <div class="carousel-brands">
                  @forelse($brands as $brand)
                     <div>
                        <a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $brand->brand_slug ]) }}" class="load_page">
                           <img src="{{ $brand->src }}" alt="{{ $brand->brand_name }}">
                        </a>
                     </div>
                  @empty
                     NO BRANDS
                  @endforelse
               </div>
            </div>
         </div>
      </li>
      <li class="dropdown">
         <a href="gallery_masonry_col_3.html">QUESTIONS</a>
         {{-- <div class="dropdown-menu">
             <h2 class="title-submenu">GALLERY</h2>
             <ul class="image-links-layout">
                <li>
                   <a href="gallery_grid_col_2.html">
                      <span class="figure"><img src="images/custom/gallery-img-01.png" alt=""></span>
                      <span class="figcaption">Grid Layout 2 cols</span>
                   </a>
                </li>
             </ul>
          </div>--}}
      </li>
      <li class="dropdown megamenu">
         <a href="about.html">PAGES</a>
         <div class="dropdown-menu">
            <div class="row custom-layout-02 menu-list-col">
               <div class="col-sm-5">
                  <a class="title-underline" href="listing-left-column.html">
                     <span>STORE INFO PAGES</span>
                  </a>
                  <div class="row">
                     <div class="col-sm-6">
                        <ul class="megamenu-submenu">
                           <li><a href="about.html">About</a></li>
                           <li><a href="about_01.html">About 2</a></li>
                           <li><a href="contact.html">Contacts</a></li>
                           <li><a href="contact_01.html">Contacts 2</a></li>
                           <li><a href="faqs.html">FAQs</a></li>
                           <li><a href="look-book.html">Lookbook</a></li>
                        </ul>
                     </div>
                     <div class="col-sm-5">
                        <ul class="megamenu-submenu">
                           <li><a href="collections.html">Collections</a></li>
                           <li><a href="faqs.html">Delivery Page</a></li>
                           <li><a href="faqs.html">Payment page</a></li>
                           <li><a href="faqs.html">Support page</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-sm-5">
                  <a class="title-underline" href="listing-left-column.html">
                     <span>SHOPPING PAGES</span>
                  </a>
                  <div class="row">
                     <div class="col-sm-6">
                        <ul class="megamenu-submenu">
                           <li><a href="login-form.html">Login form</a></li>
                           <li><a href="shopping_cart_01.html">Shopping cart 01</a></li>
                           <li><a href="shopping_cart_02.html">Shopping cart 02</a></li>
                           <li><a href="checkout.html">Checkout</a></li>
                           <li><a href="wishlist.html">Wishlist</a></li>
                           <li><a href="compare.html">Compare</a></li>
                        </ul>
                     </div>
                     <div class="col-sm-5">
                        <ul class="megamenu-submenu">
                           <li><a href="account.html">Page Account</a></li>
                           <li><a href="account-address.html">Page Account address</a></li>
                           <li><a href="account-order.html">Page Account order</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-sm-2">
                  <a class="title-underline" href="listing-left-column.html">
                     <span>OTHER PAGES</span>
                  </a>
                  <ul class="megamenu-submenu">
                     <li><a href="typography.html">Typography</a></li>
                     <li><a href="infographic.html">Infographic</a></li>
                     <li><a href="comming-soon.html">Under Construction</a></li>
                     <li><a href="page-404.html">Page 404</a></li>
                     <li><a href="page-empty-category.html">Page Empty Category</a></li>
                     <li><a href="page-empty-search.html">Page Empty Search</a></li>
                     <li><a href="page-empty-shopping-cart.html">Page Empty shopping Cart</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </li>
   </ul>
</nav>