@extends('layout.admin.index' )
@section('title')
   Brands List
@stop
@section('extra_css')
@stop
@section('content')
   @include('layout.errors.notifications')
   <table id="simple-table" class="table  table-bordered table-hover">
      <thead>
      <tr>
         <th class="center">
            #
         </th>
         <th class="center">Name</th>
         <th class="center">Slug</th>
         <th class="center">Photo</th>
         <th class="center">Description</th>
         <th class="hidden-480">operations</th>
         <th></th>
      </tr>
      </thead>
      <tbody>
      @forelse($admin_brands as $key=> $brand)
         <tr>
            <td class="center">
               <label class="pos-rel">
                  {{ $key+1 }}
                  <input type="checkbox" class="ace">
                  <span class="lbl"></span>
               </label>
            </td>
            <td class="">{{ $brand->brand_name }}</td>
            <td class="">{{ $brand->brand_slug }}</td>
            <td class="center">
               <img src="{{ $brand->src }}" alt="brand image">
            </td>
            <td class="">{{ $brand->brand_description }}</td>
            <td class="center">
               <div class="hidden-sm hidden-xs btn-group">
                  <form>
                     <button class="btn btn-xs btn-danger delete_me" data-id="{{ $brand->brand_id }}">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                     </button>
                     <a class="btn btn-warning btn-xs edit_me" title="Edit"
                        href="{{ route('brand.edit',$brand->brand_id) }}" data-id="{{ $brand->brand_id }}">
                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                     </a>
                  </form>
               </div>
            </td>
         </tr>
      @empty
         <tr>
            <td colspan="3">No Data</td>
         </tr>
      @endforelse
      </tbody>
   </table>
      {{ $admin_brands->links() }}

@endsection
@section('extra_js')
   <script>
       $(document).ready(function () {
           //DELETE ROW
           deleteAjax("/admin/brand/","delete_me","brand");
           <!-- LOAD THE EDIT PAGE-->
           jQuery(".edit_me").bind('click', function () {
               var route = $(this).attr('href');
               var pjax = new Pjax({
                   selectors: ["title", "#extra_css", "#content-load", "#extra_js"]
               });
               pjax.loadUrl(route);

           });
       });
   </script>
@stop