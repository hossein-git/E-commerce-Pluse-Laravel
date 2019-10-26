<nav class="panel-menu mm-right">
   <ul>
      <li><a href="{{ route('home') }}" class="load_page">Home</a></li>
      <li>
         <a href="{{ route('front.productsList') }}" class="load_page">Products</a>
         <ul>
            @forelse($categories as $category)
            <li><a href="{{ route('front.lists',['list' => 'categories','slug' => "$category->category_slug", ]) }}" class="load_page">{{ $category->category_name }}</a></li>
               @empty
                  <li>NOTHING YET</li>
            @endforelse
         </ul>
      </li>
      <li>
         <a href="product.html">SPECIAL OFFERS</a>
         <ul>
            <li><a href="product.html">Image Size - Small</a></li>
         </ul>
      </li>
      <li>
         <a href="product.html">MOST SOLD</a>
         <ul>
            <li><a href="product.html">Image Size - Small</a></li>
         </ul>
      </li>
      <li>
         <a >BRANDS</a>
         <ul>
            @forelse($brands as $brand)
            <li><a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $brand->brand_slug ]) }}" class="load_page">{{ $brand->brand_name }}</a></li>
            @empty
               <b>NO DATA</b>
            @endforelse
         </ul>
      </li>
      <li><a href="#">QUESTIONS</a></li>
      <li>
         <a href="about.html">PAGES</a>
         <ul>
            <li><a href="about.html">About</a></li>
            <li><a href="about_01.html">About 2</a></li>
            <li><a href="contact.html">Contacts</a></li>
            <li><a href="contact_01.html">Contacts 2</a></li>
            <li><a href="comming-soon.html">Under Construction</a></li>
            <li><a href="look-book.html">Lookbook</a></li>
            <li><a href="collections.html">Collections</a></li>
            <li><a href="typography.html">Typography</a></li>
            <li><a href="infographic.html">Infographic</a></li>
            <li><a href="faqs.html">Delivery Page</a></li>
            <li><a href="faqs.html">Payment page</a></li>
            <li><a href="checkout.html">Checkout</a></li>
            <li><a href="compare.html">Compare</a></li>
            <li><a href="wishlist.html">Wishlist</a></li>
            <li><a href="shopping_cart_01.html">Shopping cart 01</a></li>
            <li><a href="shopping_cart_02.html">Shopping cart 02</a></li>
            <li><a href="account.html">Page Account</a></li>
            <li><a href="account-address.html">Page Account address</a></li>
            <li><a href="account-order.html">Page Account order</a></li>
            <li><a href="login-form.html">Login form</a></li>
            <li><a href="faqs.html">Support page</a></li>
            <li><a href="faqs.html">FAQs</a></li>
            <li><a href="page-404.html">Page 404</a></li>
            <li><a href="page-empty-category.html">Page Empty Category</a></li>
            <li><a href="page-empty-search.html">Page Empty Search</a></li>
            <li><a href="page-empty-shopping-cart.html">Page Empty shopping Cart</a></li>
         </ul>
      </li>
   </ul>
   <div class="mm-navbtn-names" style="display:none">
      <div class="mm-closebtn">CLOSE</div>
      <div class="mm-backbtn">BACK</div>
   </div>
</nav>

