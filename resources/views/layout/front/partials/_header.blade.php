<header class="no-shadow">
   <!-- mobile-header -->
   <div class="mobile-header">
      <div class="container-fluid">
         {{--<div class="pull-left">
            <!-- language -->
            <div class="mobile-parent-language"></div>
            <!-- /language -->
            <!-- currency -->
            <div class="mobile-parent-currency"></div>
            <!-- /currency -->
            <div class="mini-menu-dropdown dropdown">
               <a class="dropdown-toggle" data-toggle="dropdown">
                  <span class="icon icon-more_horiz"></span>
               </a>
               <div class="dropdown-menu">
                  <div class="mini-menu">
                     <ul>
                        <li class="active"><a href="index.html">Home</a></li>
                        <li><a href="faqs.html">Delivery</a></li>
                        <li><a href="blog_listing.html">Blog</a></li>
                        <li><a href="contact.html">Contacts</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>--}}
         <div class="pull-right">
            <!-- account -->
            <div class="account dropdown">
               <a class="dropdown-toggle" data-toggle="dropdown"><span class="icon icon-person "></span></a>
               <div class="dropdown-label hidden-sm hidden-xs">My Account</div>
               <ul class="dropdown-menu">
                  <li><a href="login-form.html"><span class="icon icon-person"></span>My Account</a></li>
                  <li><a href="wishlist.html"><span class="icon icon-favorite_border"></span>My Wishlist</a></li>
                  <li><a href="compare.html"><span class="fa fa-balance-scale"></span>Compare</a></li>
                  <li><a href="checkout.html"><span class="icon icon-check"></span>Checkout</a></li>
                  <li><a href="#" data-toggle="modal" data-target="#modalLoginForm"><span class="icon icon-lock_outline"></span>Log In</a></li>
                  <li><a href="login-form.html"><span class="icon icon-person_add"></span>Create an account</a></li>
               </ul>
            </div>
            <!-- /account -->
            <!-- cart -->
            <div class="mobile-parent-cart"></div>
            <!-- /cart -->
         </div>
      </div>
      <div class="container-fluid text-center">
         <!-- logo -->
         <div class="logo">
            <a href="{{ route('home') }}"><img src="{{ asset('front-assets/images/logo-mobile.png') }}" alt=""/></a>
         </div>
         <!-- /logo -->
      </div>
      <div class="container-fluid top-line">
         <div class="pull-left">
            <div class="mobile-parent-menu">
               <div class="mobile-menu-toggle">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="menu-text">
								MENU
								</span>
               </div>
            </div>
         </div>
         <div class="pull-right">
            <!-- search -->
            <div class="search">
               <a href="#" class="search-open"><span class="icon icon-search"></span></a>
               <div class="search-dropdown">
                  <form action="#" method="get">
                     <div class="input-outer">
                        <input type="search" name="search" value="" maxlength="128" placeholder="Enter keyword">
                        <button type="submit" class="btn-search"><span>Search</span></button>
                     </div>
                     <a href="#" class="search-close"><span class="icon icon-close"></span></a>
                  </form>
               </div>
            </div>
            <!-- /search -->
         </div>
      </div>
   </div>
   <!-- /mobile-header -->
   <!-- desktop-header -->
   <div class="desktop-header header-01">
     {{-- <div class="container">
         <div class="pull-left">
            <!-- mini-menu -->
            <div class="mini-menu">
               <ul>
                  <li class="active"><a href="index.html">Home</a></li>
                  <li><a href="faqs.html">Delivery</a></li>
                  <li><a href="blog_listing.html">Blog</a></li>
                  <li><a href="contact.html">Contacts</a></li>
               </ul>
            </div>
            <!-- /mini-menu -->
         </div>
         <div class="pull-right text-right">
            <!-- box-info -->
            <div class="box-info">
               <div class="telephone">
                  <span class="icon icon-call"></span>+300-9876-2345
               </div>
               <div class="time">
                  7 Days a week from 9:00 am to 7:00 pm
               </div>
            </div>
            <!-- /box-info -->
            <!-- language -->
            <div class="main-parent-language">
               <div class="language dropdown select-change">
                  <a class="dropdown-toggle" data-toggle="dropdown">
                     <span class="dropdown-label hidden-sm hidden-xs">Language:</span>
                     <span class="title-value"></span>
                     <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                     <li class="active" data-top-value="En"><a href="#">En</a></li>
                     <li data-top-value="Ge"><a href="#">Fa</a></li>
                  </ul>
               </div>
            </div>
            <!-- /language -->
            <!-- currency -->
            <div class="main-parent-currency">
               <div class="currency dropdown select-change">
                  <a class="dropdown-toggle" data-toggle="dropdown">
                     <span class="dropdown-label hidden-sm hidden-xs">Currency:</span>
                     <span class="title-value"></span>
                     <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                     <li class="active" data-top-value="GBP"><a href="#">GBP - British Pound Sterling</a></li>
                     <li data-top-value="EUR"><a href="#">EUR - Euro</a></li>
                     <li data-top-value="USD"><a href="#">USD - US Dollar</a></li>
                  </ul>
               </div>
            </div>
            <!-- /currency -->
         </div>
      </div>--}}
      <div class="top-line" style="margin-top: -1rem">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <!-- logo -->
                  <div class="logo">
                     <a href="{{ route('home') }}"><img src="{{ asset('front-assets/images/logo-mobile.png') }}" alt=""/></a>
                  </div>
                  <!-- /logo -->
               </div>
               <!-- SEARCH -->
               <div class="col-md-4 text-center">
                  <div class="social-icon">
                     <form action="#" method="get">
                        <div class="input-group">
                           <input type="text" class="form-control search-query" placeholder="Type your query">
                           <span class="input-group-btn">
                              <button type="button" class="btn btn-purple">
                                 <span class="fa fa-search"></span>
                              </button>
                           </span>
                        </div>
                     </form>
                  </div>
               </div>
               <!-- /SEARCH -->

               <div class="col-md-4">
                  <!-- account -->
                  <div class="account dropdown">
                     <a class="dropdown-toggle" data-toggle="dropdown">
                        <span class="icon icon-person "></span>
                        <span class="dropdown-label hidden-sm hidden-xs">My Account</span>
                     </a>
                     <ul class="dropdown-menu">
                        <li><a href="login-form.html"><span class="icon icon-person"></span>My Account</a></li>
                        <li><a href="wishlist.html"><span class="icon icon-favorite_border"></span>My Wishlist</a></li>
                        <li><a href="compare.html"><span class="fa fa-balance-scale"></span>Compare</a></li>
                        <li><a href="checkout.html"><span class="icon icon-check"></span>Checkout</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#modalLoginForm"><span class="icon icon-lock_outline"></span>Log In</a></li>
                        <li><a href="login-form.html"><span class="icon icon-person_add"></span>Create an account</a></li>
                     </ul>
                  </div>
                  <!-- /account -->
                  <!-- cart -->
                  <div class="main-parent-cart">
                     <div class="cart">
                        <div class="dropdown">
                           <a class="dropdown-toggle">
                              <span class="icon icon-shopping_basket"></span>
                              <span class="badge badge-cart">2</span>
                              <div class="dropdown-label hidden-sm hidden-xs">YOUR BAG</div>
                           </a>
                           <div class="dropdown-menu slide-from-top">
                              <div class="container">
                                 <div class="top-title">RECENTLY ADDED ITEM(S)</div>
                                 <a href="#" class="icon icon-close cart-close"></a>
                                 <ul>

                                    <li class="item">
                                       <div class="img">
                                          <a href="#"><img src="images/product/product-01.jpg" alt=""/></a>
                                       </div>
                                       <div class="info">
                                          <div class="title-col">
                                             <h2 class="title">
                                                <a href="#">Daisy Street 3/4 Sleeve Panelled Casual Shirt</a>
                                             </h2>
                                             <div class="details">
                                                Black, XL
                                             </div>
                                          </div>
                                          <div class="price">
                                             $45
                                          </div>
                                          <div class="qty">
                                             <div class="qty-label">Qty:</div>
                                             <div class="style-2 input-counter">
                                                <span class="minus-btn"></span>
                                                <input type="text" value="1" size="5"/>
                                                <span class="plus-btn"></span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="item-control">
                                          <div class="delete"><a href="#" class="icon icon-delete" title="Delete"></a></div>
                                          <div class="edit"><a href="#" class="icon icon-edit" title="Edit"></a></div>
                                       </div>
                                    </li>

                                 </ul>
                                 <h4 class="empty-cart-js hide">Your Cart is Empty</h4>
                                 <div class="cart-bottom">
                                    <div class="pull-right">
                                       <div class="pull-left">
                                          <div class="cart-total">TOTAL:  <span> $135.00</span></div>
                                       </div>
                                       <a href="checkout.html" class="btn icon-btn-left"><span class="icon icon-check_circle"></span>CHECKOUT</a>
                                    </div>
                                    <div class="pull-left">
                                       <a href="shopping_cart_01.html" class="btn icon-btn-left"><span class="icon icon-shopping_basket"></span>VIEW CART</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /cart -->
               </div>

            </div>
         </div>
      </div>
      <div class="top-line" style="margin-bottom: -3rem">
         <div class="container">
            <div class=" fill-bg-base text-center">
               <div class="menu-parent-box">
                  <!-- header-menu -->
                  @include('layout.front.partials._nav')
                  <!-- /header-menu -->
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /desktop-header -->
   <!-- stuck nav -->
   <div class="stuck-nav">
      <div class="container">
         <div class="pull-left">
            <div class="stuck-menu-parent-box"></div>
         </div>
         <div class="pull-right">
            <div class="stuck-cart-parent-box"></div>
         </div>
      </div>
   </div>
   <!-- /stuck nav -->
</header>