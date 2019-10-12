@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty')
@section('content')
   @include('layout.errors.notifications')

   <div class="btn-group">
      <button data-toggle="dropdown" class="btn btn-primary btn-white dropdown-toggle" aria-expanded="false">
         SORT BY CATEGORY
         <i class="ace-icon fa fa-angle-down icon-on-right"></i>
      </button>
      <ul class="dropdown-menu">
         @foreach($categories as $category)
            <li class="dropdown-hover">
               @if($category->children->count())
                  <a class="click_me clearfix" tabindex="-1"
                     href="{{ route('product.index.sortCat',$category->category_id) }}">
                     <span class="pull-left">{{ $category->category_name }}</span>
                     <i class="ace-icon fa fa-caret-right pull-right"></i>
                  </a>
                  @include('admin.category._sub', ['subs' => $category->children])
               @else
                  <a class="click_me" tabindex="-1"
                     href="{{ route('product.index.sortCat',$category->category_id) }}">
                     {{ $category->category_name }}
                  </a>
               @endif
            </li>
         @endforeach
      </ul>
   </div>
   <div class="btn-group">
      <button data-toggle="dropdown" class="btn btn-primary btn-white dropdown-toggle" aria-expanded="false">
         SORT BY
         <i class="ace-icon fa fa-angle-down icon-on-right"></i>
      </button>
      <ul class="dropdown-menu">
         <li>
            <a class="click_me" href="{{ route('product.index.sort','created_at') }}">Created Data</a>
         </li>
         <li>
            <a class="click_me" href="{{ route('product.index.sort','buy_price') }}">Buy Price</a>
         </li>
         <li>
            <a class="click_me" href="{{ route('product.index.sort','sale_price') }}">Sell Price</a>
         </li>
         <li>
            <a class="click_me" href="{{ route('product.index.sort','product_id') }}"> By Id</a>
         </li>
      </ul>
   </div>
   <a class="click_me btn btn-info2 btn-sm" href="{{ route('product.index.trash') }}">
      <i class="ace-icon fa fa-trash-o "></i>
      Trash
   </a>

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
      <tbody id="table_body">
      @forelse($products as $key => $product)
         <tr>
            <td class="center">
               <label class="pos-rel">{{$key+ 1}}
                  <input type="checkbox" class="ace" id="check">
                  <span class="lbl"></span>
               </label>
            </td>
            <td><a class="click_me bolder" data-path="/product/show" title="show product"
                   href="{{ route('product.show',$product->product_id) }}">{{ $product->product_name }}</a>
            </td>
            <td>{{ $product->sku }}</td>
            <td>{{ $product->buy_price }}</td>
            <td>{{ $product->is_off == 1 ? number_format($product->sale_price - $product->off_price ) : number_format($product->sale_price) }}</td>
            <td class="center">
               @if($product->status == 1)
                  <a href="#" class="green bigger-140 show-details-btn" title="Active" disabled="">
                     <i class="ace-icon fa fa-angle-double-up"></i>
                     <span class="sr-only">Active</span>
                  </a>
               @else
                  <a href="#" class="red bigger-140 show-details-btn" title="De Active" disabled="">
                     <i class="ace-icon fa fa-angle-double-down"></i>
                     <span class="sr-only">De Active</span>
                     <small>{{ $product->data_available }}</small>
                  </a>
               @endif
            </td>
            {{--            <td class="center">--}}
            {{--               @if($product->status == 0)--}}
            {{--                  <b>{{ $product->data_available }}</b>--}}
            {{--               @else--}}
            {{--                  <i class="glyphicon green glyphicon-ok bigger-130"></i>--}}
            {{--            @endif--}}
            {{--            <td>--}}
            <td class="center">
               @if($product->is_off == 1)
                  <span class='label label-warning smaller-80'>HAS-OFF</span>
                  <b>{{ number_format($product->off_price) }}</b>
               @else
                  <span class="label label-info smaller-80">NOT OFF</span>
               @endif
            </td>
            {{--            <td class="smaller-80">{{ $product->is_off == 1 ? $product->off_price : '' }}</td>--}}
            <td class="smaller-80">
               @foreach($product->categories as $category)
                  <span class='label label-default smaller-90'>{{ $category->category_name }}</span>
               @endforeach
            </td>
            <td class="smaller-80">
               @foreach($product->colors as $color)
                  <span style=" background: {{ $color->color_code }} "
                        class="label label-sm">{{ $color->color_name }}</span>
               @endforeach
            </td>
            {{--            <td class="smaller-80">{{ $product->made_in }}</td>--}}
            <td>{{ str_limit($product->description,50,'...')  }}</td>
            <td>
               <img src="{{ asset($product->thumbnail) }}" alt="cover photo" width="80" height="100">
            </td>
            <td class="smaller-80">{{ $product->created_at }}</td>
            <td>
               <div class="hidden-sm hidden-xs btn-group">
                  <form>
                     <button class="btn btn-xs btn-danger delete_me" data-id="{{ $product->product_id }}">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                     </button>
                     @if(Request::route()->getName() == 'product.index')
                        <a class="btn btn-warning btn-xs edit_me" title="Edit"
                           href="{{route('product.edit',$product->product_id)}}" data-id="{{ $product->product_id }}">
                           <i class="ace-icon fa fa-pencil bigger-120"></i></a>
                     @else
                        <button class="btn btn-success btn-xs restore_me" title="Restore"
                                data-id="{{route('product.restore',$product->product_id)}}"><i
                                   class="ace-icon fa fa-check bigger-120"></i>
                        </button>
                     @endif
                  </form>
                  <a class=" btn btn-xs btn-info click_me bolder" data-path="/admin/product/{{$product->product_id}}"
                     title="show product"
                     href="{{ route('product.show',$product->product_id) }}"><i
                             class="ace-icon fa fa-eye bigger-120"></i>
                  </a>
               </div>
            </td>
            <td>


            </td>
         </tr>
      @empty
         <tr>
            <td colspan="16" class="text-capitalize">There are no date</td>
         </tr>
      @endforelse
      </tbody>
   </table>

   <div class="">
      {{ $products->links() }}
   </div>

   <script>
       $(document).ready(function () {
           $(".delete_me").click(function (e) {
               e.preventDefault();
               if (!confirm('Are you Sure?')){
                   return false;
               }
               var obj = $(this); // first store $(this) in obj
               var id = $(this).data("id");
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: "/admin/product/" + id,
                   method: "DELETE",
                   dataType: "Json",
                   data: {"id": id},
                   success: function ($results) {
                       alert('product has been successfully deleted');
                       $(obj).closest("tr").remove(); //delete row
                       console.log($results);
                   },
                   error: function (xhr) {
                       alert('error, product not deleted');
                       console.log(xhr.responseText);
                   }
               });
           });
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
           <!-- LOAD THE EDIT PAGE-->
           jQuery(".edit_me").bind('click', function () {
               var route = $(this).attr('href');
               var id = $(this).data('id');
               window.history.replaceState("", "", "product/" + id + "/edit");
               $("#content-load").load(route);
               return false;
           });
       });
   </script>
@endsection()
