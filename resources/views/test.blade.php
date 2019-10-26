@extends('layout.front.index')
@section('title')
   check Out
@endsection
@section('extra_css')
   <style> body {
         margin-top: 30px;
      }

      .stepwizard-step p {
         margin-top: 0px;
         color: #666;
      }

      .stepwizard-row {
         display: table-row;
      }

      .stepwizard {
         display: table;
         width: 100%;
         position: relative;
      }

      .stepwizard-step button[disabled] {
         /*opacity: 1 !important;
         filter: alpha(opacity=100) !important;*/
      }

      .stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
         opacity: 1 !important;
         color: #bbb;
      }

      .stepwizard-row:before {
         top: 14px;
         bottom: 0;
         position: absolute;
         content: " ";
         width: 100%;
         height: 1px;
         background-color: #ccc;
         z-index: 0;
      }

      .stepwizard-step {
         display: table-cell;
         text-align: center;
         position: relative;
      }

      .btn-circle {
         width: 30px;
         height: 30px;
         text-align: center;
         padding: 6px 0;
         font-size: 12px;
         line-height: 1.428571429;
         border-radius: 15px;
      }
   </style>
@endsection

@section('content')
   @include('layout.errors.notifications')
   <form action="{{ route('front.address.store') }}" method="post">
      @csrf
      <div class="setup-content" id="step-2">
         <div class="panel-heading">
            <h3 class="panel-title">Destination</h3>
         </div>
         <div class="row">
            <div class="col-sm-6">
               <div class="form-group ">
                  <label for="name" class=" control-label">First Name: <span>*</span></label>
                  <input type="text" name="name" class="form-control" id="name" >
               </div>
               <div class="form-group ">
                  <label for="number" class="control-label">Number: <span>*</span></label>
                  <input type="number" name="number" class="form-control" id="number" >
               </div>
               <div class="form-group ">
                  <label for="area" class=" control-label">Area: </label>
                  <input type="text" name="area" class="form-control" id="area">
               </div>
               <div class="form-group ">
                  <label for="city" class=" control-label">City: <span>*</span></label>
                  <input type="text" name="city" class="form-control" id="city" >
               </div>
               <div class="form-group ">
                  <label for="postal_code" class=" control-label">Zip/Postal Code: <span>*</span></label>
                  <input type="text" class="form-control" name="postal_code" id="postal_code" >
               </div>
               @auth()
                  <div class="checkbox-group ">
                     <input type="checkbox" id="def_addr" name="def_addr">
                     <label for="def_addr">
                        <span class="check"></span>
                        <span class="box"></span>
                        save this address as my address
                     </label>
                  </div>
               @endauth

            </div>
            <div class="col-sm-6">
               <div class="form-group ">
                  <label for="surname" class=" control-label">Last Name: <span>*</span></label>
                  <div class="">
                     <input type="text" name="surname" class="form-control" id="surname" >
                  </div>
               </div>
               <div class="form-group ">
                  <label for="street" class=" control-label">Street: <span>*</span></label>
                  <input type="text" name="street" class="form-control" id="street">
               </div>
               <div class="form-group ">
                  <label for="avenue" class=" control-label">Avenue:</label>
                  <input type="text" name="avenue" class="form-control" id="avenue">
               </div>
               <div class="form-group ">
                  <label for="state" class=" control-label">State/Province: <span>*</span></label>
                  <input type="text" name="state" class="form-control" id="state" >
               </div>
               <div class="form-group ">
                  <label for="phone_number" class=" control-label">Phone Number: <span>*</span>
                     <small>Like +905534676564</small></label>
                  <input type="text" name="phone_number" class="form-control" id="phone_number" >
               </div>

               <button class="btn btn-primary nextBtn pull-right" id="second_step" type="submit">Next</button>
            </div>

         </div>
      </div>
   </form>



@endsection
@section('extra_js')

@endsection