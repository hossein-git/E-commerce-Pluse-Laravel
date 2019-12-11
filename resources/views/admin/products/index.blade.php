@extends('layout.admin.index' )
@section('title')
   Products List
@stop
@section('extra_css')
@stop
@section('content')
   @include('layout.errors.notifications')
   <!-- IF $index_categories IS SET, MEANS THIS IS WITHOUT TRASH ROUTE THEN WE SHOW SORTING -->
   @if(isset($index_categories))
      <div class="pull-left">
         <form id="sort_form" action="{{ route('product.index.sort') }}" method="post">
            @csrf
            <div class="btn-group">
               <select name="sort_category" id="sort_category" class="form-control">
                  <option value="" disabled="" selected="">ORDER BY CATEGORY:</option>
                  <option value="{{ null }}">ALL CATEGORIES:</option>
                  @foreach($index_categories as $category)
                     <option value="{{ $category->category_slug }}">{{ $category->category_name }}</option>
                  @endforeach
               </select>
            </div>

            <div class="btn-group">
               <select name="sort" id="sort" class="form-control">
                  {{--            <option value="product_id" disabled="" selected="">SORT BY:</option>--}}
                  <option value="product_id">Sort By Default</option>
                  <option value="created_at">New Products</option>
                  <option value="buy_price">Buy Price</option>
                  <option value="sale_price">Sale Price</option>
               </select>
            </div>

            <div class="btn-group">
               <select name="dcs" class="form-control">
                  <option value="desc">High to lower</option>
                  <option value="asc">Low to higher</option>
               </select>
            </div>

            <div class="btn-group">
               <label for="status">ONLY ACTIVE</label>
               <input type="checkbox" name="status" id="status">
            </div>

            <button class=" btn btn-success btn-sm" type="submit">
               FILTER
            </button>

         </form>
         <a class="click_me btn btn-info2 btn-sm" href="{{ route('product.index.trash') }}">
            <i class="ace-icon fa fa-trash-o "></i>
            Trash
         </a>
      </div>
      <div class="pull-right">

         <form method="post" action="{{ route('admin.search') }}" id="form-search">
            @csrf
            <span><i>search by <b>name</b> and exact <b>SKU</b></i></span>
            <input type="hidden" value="products" name="search_kind">
            <span class="input-icon">
         <input type="text" placeholder="Search ..." class="nav-search-input"
                 autocomplete="off" name="search"/>
         <i class="ace-icon fa fa-search nav-search-icon"></i>
         <button type="submit" class="btn btn-sm">
            <span class="fa fa-search"></span>
         </button>
      </span>
         </form>
      </div>
   @endif

   <table id="simple-table" class="table table-bordered table-hover responsive">
      <thead>
         <tr>
         <th>#</th>
         <th>Product Name</th>
         <th class="center">SKU</th>
         <th>Buy Price</th>
         <th>Sell Price (after OFF)</th>
         <th>Status</th>
         {{--         <th>Available Date</th>--}}
         <th class="center">Discount?</th>
         {{--         <th class="smaller-80">Price Of Off</th>--}}
         <th class="smaller-80">Category</th>
         <th class="smaller-80">Colors</th>
         {{--         <th class="smaller-80">Made In</th>--}}
         <th class="smaller-80">Description</th>
         <th>Cover Photo</th>
         <th class="smaller-80">Created Date</th>
         <th>Operations</th>
      </tr>
      </thead>
      <tbody id="table_body" class="table_data">
      @include('admin.products._data')
      </tbody>
   </table>

   <div class="">
      {{ $products->links() }}
   </div>

@endsection()
@section('extra_js')
   <script>
       $(document).ready(function () {
           deleteAjax("/admin/product/", "delete_me", "product");
           $(".restore_me").click(function (e) {
               e.preventDefault();
               var obj = $(this); // first store $(this) in obj
               var id = $(this).data("id");
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: id,
                   method: "GET",
                   dataType: "Json",
                   // data: {"id": id},
                   success: function ($results) {
                       alert('product has been successfully restored');
                       $(obj).closest("tr").remove(); //delete row
                       console.log($results);
                   },
                   error: function (xhr) {
                       alert('error, product not restored');
                       console.log(xhr.responseText);
                   }
               });
           });
           @if(env('APP_AJAX'))
           <!-- LOAD THE EDIT PAGE-->
           jQuery(".edit_me").bind('click', function (e) {
               e.preventDefault();
               var route = $(this).attr('href');
               var pjax = new Pjax({
                   selectors: ["title", "#extra_css", "#content-load", "#extra_js"]
               });
               pjax.loadUrl(route);
           });
           @endif
       });
   </script>
   <!-- TO SORT PRODUCTS -->
   <script type="text/javascript">
       $(document).ready(function () {
           $("#sort_form").submit(function (e) {
               e.preventDefault();
               var form = $(this);
               var form_data = new FormData(this);
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: "{{ route('product.index.sort') }}",
                   method: "post",
                   data: form_data,
                   contentType: false,
                   cache: false,
                   processData: false,
                   beforeSend: function () {
                       $(".preview").show();
                   },

               })
                   .done(function (data) {
                       if (data.html == " ") {
                           // $('.ajax-load').attr('src', '');
                           $('#preview').hide();
                           $('.table_body').html("No more records found");
                           return;
                       }
                       $("#table_body").empty().append(data.html);
                       $('.preview').hide();
                   }).fail(function () {
                   alert('error');
               })
           });
       });

   </script>
@stop