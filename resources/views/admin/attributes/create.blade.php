@extends('layout.admin.index')
@section('title')
   Create New Attribute
@endsection
@section('extra_css')
   <link rel="stylesheet" href="{{ asset('admin-assets/css/chosen.min.css') }}"/>
@endsection
@section('content')
   <form id="attr_form_create" method="post" action="{{ route('attribute.store') }}">
   @csrf
   <!-- if isset $product it means it coming from route(attribute.createNew)  -->

      <div class="row">
         <div class="col-sm-6">
            @if (isset($product))
               <span class="h3">product Name:</span><span class="h2 bolder"><a
                          href="{{ route('product.show',$product->product_id) }}">{{ $product->product_name }}</a></span>
               <input class="product_id" type="hidden" value="{{$product->product_id}}" name="product_id">
            @else
               <div class="form-group">
                  <label for="form-field-select-3">Choose a Product:</label>
                  <br/>
                  <select class="chosen-select form-control product_id" name="product_id" id="form-field-select-3"
                          data-placeholder="Choose a Product">
                     <option value=""></option>
                     @forelse($products as $product)
                        <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                     @empty
                        <option disabled="">NO DATA</option>
                     @endforelse
                  </select>
               </div>
            @endif
         </div>
         <div class="col-sm-6">
            <div class="form-group">
               <label for="attr_name" class="">Attribute Name:</label>
               <input type="text" name="attr_name" id="attr_name" class="form-control"/>
            </div>
         </div>
      </div>
      <div class="center h3">Add Attribute Value:</div>
      <div class="row">

         <div class="col-sm-3">
            <button class="btn btn-info" id="add_val">Add Value</button>
            <input class="btn btn-success" type="submit" value="SAVE">
         </div>
         <div class="col-sm-6" id="div_value">

            <div id="widget_value" class="widget-box">
               <div class="widget-header">
                  <h4 class="widget-title">Value:</h4>
                  <span class="widget-toolbar">
                     <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                     </a>
                     <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                     </a>
                  </span>
               </div>
               <div class="widget-body">
                  <div class="widget-main center">
                     <div class="form-group">
                        <label for="value"></label>
                        <input type="text" id="value" name="value[]" class="input form-control valuesCreate"
                               placeholder="Value">
                     </div>
                  </div>
               </div>
            </div>

         </div>
         <div class="col-sm-3"></div>
      </div>
   </form>
@endsection
@section('extra_js')
   <script src="{{ asset('admin-assets/js/chosen.jquery.min.js') }}"></script>
   <script type="text/javascript">
       jQuery(document).ready(function () {
           var cunter =0;
           $('#add_val').click(function (e) {
               cunter += 1;
               e.preventDefault();
               var widget = '<div id="widget_value" class="widget-box"><div class="widget-header"><h5 class="widget-title">Value:</h5><span class="widget-toolbar"><a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a><a href="#" data-action="close"><i class="ace-icon fa fa-times"></i></a></span></div><div class="widget-body"><div class="widget-main center"><div class="form-group"><input type="text" id="value" name="value[]" class="input form-control valuesCreate" placeholder="Value"></div></div></div></div>';
               $('#div_value').append(widget)
           });
           $('.chosen-select').chosen({allow_single_deselect: true});
           //resize the chosen on window resize

           $(window)
               .off('resize.chosen')
               .on('resize.chosen', function () {
                   $('.chosen-select').each(function () {
                       var $this = $(this);
                       $this.next().css({'width': $this.parent().width()});
                   })
               }).trigger('resize.chosen');
           //resize chosen on sidebar collapse/expand
           $(document).on('settings.ace.chosen', function (e, event_name, event_val) {
               if (event_name != 'sidebar_collapsed') return;
               $('.chosen-select').each(function () {
                   var $this = $(this);
                   $this.next().css({'width': $this.parent().width()});
               })
           });
       });

   </script>
   <!-- upload with ajax -->
   @if(env('APP_AJAX'))
      <script type="text/javascript">
          jQuery(document).ready(function () {
              $('#attr_form_create').on('submit', (function (e) {
                  e.preventDefault();
                  var valuesArray = [];
                  $('.valuesCreate').map(function () {
                      valuesArray.push($(this).val());
                  });

                  var data = {
                      product_id: $('.product_id').val(),
                      attr_name: $('#attr_name').val(),
                      value: valuesArray
                  };


                  if (upload_ajax("{{ route('attribute.store') }}", data)) {
                      window.location.reload();
                  }
              }));
          });
      </script>
   @endif

@endsection