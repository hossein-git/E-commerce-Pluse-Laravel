@extends('layout.front.index')
@section('title')
   Check Out
@endsection
@section('extra_css')
@endsection
@section('content')

   <div class="row">
      <div class="col-md-8">
         <!-- Nav tabs -->
         <ul class="nav nav-tabs checkout-tab">
            <li class="active" style="margin-left: -0.5rem">
               <a href="#Shipping" data-toggle="tab">
                  <div class="numeral-box">
                     <span class="numeral">1</span>
                     <span class="icon icon-check"></span>
                  </div>
                  <div class="title">
                     Shipping Address
                  </div>
               </a>
            </li>
            <li style="margin-left: -2rem">
               <a href="#Review" data-toggle="tab" >
                  <div class="numeral-box">
                     <span class="numeral">2</span>
                  </div>
                  <div class="title">
                     Gift Card
                  </div>
               </a>
            </li>
            <li style="margin-left: -2rem">
               <a href="#payment" data-toggle="tab">
                  <div class="numeral-box">
                     <span class="numeral">3</span>
                  </div>
                  <div class="title">
                     Review & Payments
                  </div>
               </a>
            </li>
         </ul>
         <!-- Tab panes -->
         <div class="tab-content checkout-tab-content">
            <div class="tab-pane active" id="Shipping">
               <form class="form-horizontal">
                  <div class="row">
                     <div class="col-sm-5">
                        <div class="form-group">
                           <label for="inputFirstName" class=" control-label">First Name: <span>*</span></label>
                           <input type="text" name="name" class="form-control" id="inputFirstName" required>
                        </div>
                        <div class="form-group">
                           <label for="inputStreet" class=" control-label">Number: <span>*</span></label>
                           <div class="">
                              <input type="text" name="number" class="form-control" id="inputNumber" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputCity" class=" control-label">Area: <span>*</span></label>
                           <div class="">
                              <input type="text" name="area" class="form-control" id="inputCity" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputCity" class=" control-label">City: <span>*</span></label>
                           <div class="">
                              <input type="text" name="city" class="form-control" id="inputCity" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputZip" class=" control-label">Zip/Postal Code: <span>*</span></label>
                           <div class="">
                              <input type="text" class="form-control" id="inputZip" required>
                           </div>
                        </div>

                     </div>
                     <div class="col-sm-1"></div>
                     <div class="col-sm-5">
                        <div class="form-group">
                           <label for="inputLastName" class=" control-label">Last Name: <span>*</span></label>
                           <div class="">
                              <input type="text" name="surename" class="form-control" id="inputLastName" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputStreet" class=" control-label">Street: <span>*</span></label>
                           <div class="">
                              <input type="text" name="street" class="form-control" id="inputStreet" >
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputCity" class=" control-label">Avenue: <span>*</span></label>
                           <div class="">
                              <input type="text" name="avenue" class="form-control" id="inputAvenue" >
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputState" class=" control-label">State/Province: <span>*</span></label>
                           <div class="">
                              <input type="text" name="state" class="form-control" id="inputState">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="inputPhone" class=" control-label">Phone Number: <span>*</span></label>
                           <div class="">
                              <input type="text" class="form-control" id="inputPhone" required>
                           </div>
                        </div>
                     </div>
                  </div>
                  <button class="btn icon-btn-right" href="#">NEXT<span class="icon icon-chevron_right"></span></button>
               </form>
            </div>
            <div class="tab-pane checkout-tab-content" id="Review">
               <form action="">
                  <div class="form-group">
                     <label for="giftCode" class=" control-label">Gift Code: <span>*</span></label>
                     <div class="form-group">
                     <input type="text" name="giftCode" class="form-control" id="giftCode">
                        <button class="btn">Check</button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="tab-pane" id="payment">
               payment
            </div>
         </div>
      </div>
      <!-- CART -->
      <div class="col-md-4 checkout-box-aside ">
         <div class="checkout-box">
            <div class="checkout-table-02">
               <table>
                  <thead>
                  <tr>
                     <td colspan="2">Order Summary</td>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                     <td>SUBTOTAL:</td>
                     <td>$45</td>
                  </tr>
                  <tr>
                     <td>SHIPPING(FLAT RATE - FIXED):</td>
                     <td>$15</td>
                  </tr>
                  <tr>
                     <td>ORDER TOTAL:</td>
                     <td><strong class="color-base">$457</strong></td>
                  </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="checkout-box">
            <h3>2 ITEM IN CART</h3>
            <div class="checkout-box-03">
               <div class="item">
                  <div class="img">
                     <a href="#"><img src="images/product/product-80x100-1.jpg" alt=""></a>
                  </div>
                  <div class="description">
                     <a href="#" class="title">Daisy Street 3/4 Sleeve Pane</a>
                     <p>
                        Black, Xl
                     </p>
                     <div class="price">$45</div>
                     <p>
                        QTY:1
                     </p>
                  </div>
               </div>
               <div class="item">
                  <div class="img">
                     <a href="#"><img src="images/product/product-80x100-2.jpg" alt=""></a>
                  </div>
                  <div class="description">
                     <a href="#" class="title">Daisy Street 3/4 Sleeve Pane</a>
                     <p>
                        Black, Xl
                     </p>
                     <div class="price">$45</div>
                     <p>
                        QTY:1
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /CART -->
   </div>

@endsection
@section('extra_js')
@endsection