<footer id="footer">
   <div class="footer-content-col">
      <div class="container">
         <div class="row">
            <div class="col-sm-6 col-md-3">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title visible-xs">FREE SHIPPING</h4>
                  <div class="mobile-collapse_content">
                     <a href="#" class="services-block">
                        <span class="icon icon-airplanemode_active"></span>
                        <div class="title">Free Shipping</div>
                        <p>Free on all products</p>
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-sm-6 col-md-3">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title visible-xs">SECURED SHOPPING</h4>
                  <div class="mobile-collapse_content">
                     <a href="#" class="services-block">
                        <span class="icon icon-security"></span>
                        <div class="title">Secured Shopping</div>
                        <p>We use the best security features</p>
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-sm-6 col-md-3">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title visible-xs">FREE RETURNS</h4>
                  <div class="mobile-collapse_content">
                     <a href="#" class="services-block">
                        <span class="icon icon-assignment_return"></span>
                        <div class="title">Free Returns</div>
                        <p>Return for free within 30 days</p>
                     </a>
                  </div>
               </div>
            </div>
            <div class="col-sm-6 col-md-3">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title visible-xs">SUPPORT</h4>
                  <div class="mobile-collapse_content">
                     <a href="#" class="services-block">
                        <span class="icon icon-headset_mic"></span>
                        <div class="title">Support</div>
                        <p>Effectiveand Friendly Support</p>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div class="col-md-3 col-sm-12 hidden-xs">
               <div class="row">
                  <div class="col-sm-4 col-md-12">
                     <div class="footer-logo">
                        <a href="{{ route('home') }}"><img src="{{ $setting->src }}" alt="logo"></a>
                     </div>
                  </div>
                  <div class="col-sm-8 col-md-12">
                     <div class="social-icon-round">
                        <ul>
                           <li><a class="icon fa fa-github" href="https://github.com/hossein-git"></a></li>
                           <li><a class="icon fa fa-linkedin" href="https://www.linkedin.com/in/hossein-haghparast-88b230b4"></a></li>
                           <li><a class="icon fa fa-instagram" href="https://www.instagram.com/hossein_hagh_parast/"></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-6 col-md-2">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title">INFORMATION</h4>
                  <div class="mobile-collapse_content">
                     <div class="v-links-list">
                        <ul>
                           <li><a href="#">About Us</a></li>
                           <li><a href="#">Customer Service</a></li>
                           <li><a href="#">Privacy Policy</a></li>
                           <li><a href="#">Site Map</a></li>
                           <li><a href="#">Search Terms</a></li>
                           <li><a href="#">Advanced Search</a></li>
                           <li><a href="#">Orders and Returns</a></li>
                           <li><a href="#">Contact Us</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-6 col-md-2">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title">WHY BUY FROM US</h4>
                  <div class="mobile-collapse_content">
                     <div class="v-links-list ">
                        <ul>
                           <li><a href="#">Shipping & Returns</a></li>
                           <li><a href="#">Secure Shopping</a></li>
                           <li><a href="#">International Shipping</a></li>
                           <li><a href="#">Affiliates</a></li>
                           <li><a href="#">Group Sales</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="clearfix divider visible-sm"></div>
            <div class="col-sm-6 col-md-2">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title">MY ACCOUNT</h4>
                  <div class="mobile-collapse_content">
                     <div class="v-links-list ">
                        <ul>
                           <li><a href="#" data-toggle="modal" data-target="#modalTrackOrder"><span class="icon icon-lock_outline"></span>Track My Order</a></li>
                           <li><a href="#">View Cart</a></li>
                           @auth()
                              <li><a href="#">My Wishlist</a></li>
                              <li><a href="{{ route('front.profile') }}">Profile</a></li>
                           @else
                           <li><a href="{{ route('login') }}">Sign In</a></li>
                           <li><a href="{{ route('register') }}">Register</a></li>
                           @endauth
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-6 col-md-3">
               <div class="mobile-collapse">
                  <h4 class="mobile-collapse_title">CONTACTS</h4>
                  <div class="mobile-collapse_content">
                     <div class="list-info">
                        <ul>
                           <li>Address: {{ $setting->site_address }}</li>
                           <li>Phone: {{ $setting->site_phone }}</li>
                           <li>Fax: {{ $setting->site_fax }}</li>
                           <li>E-mail: <a href="mailto:{{ $setting->site_email }}">{{ $setting->site_email }}</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="copyright">
      <div class="container visible-xs">
         <div class="social-icon-round">
            <ul>
               <li><a class="icon fa fa-github" href="https://github.com/hossein-git"></a></li>
               <li><a class="icon fa fa-linkedin" href="https://www.linkedin.com/in/hossein-haghparast-88b230b4"></a></li>
               <li><a class="icon fa fa-instagram" href="https://www.instagram.com/hossein_hagh_parast/"></a></li>
            </ul>
         </div>
      </div>
      <div class="container text-center">
         <div class="box-copyright">
            <a href="http://www.findhossein.ir/">{{ $setting->site_title }} &copy; 2019. <span>By Hossein Haghparast.</span></a>
         </div>
      </div>
   </div>
   <a href="#" class="back-to-top">
      <span class="icon icon-keyboard_arrow_up"></span>
      <span class="text">BACK TO TOP</span>
   </a>
</footer>