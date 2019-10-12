@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty')
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
      @forelse($brands as $key=> $brand)
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

   {{ $brands->links() }}

   <script>
      $(document).ready(function () {
          $(".delete_me").click(function (e) {
              e.preventDefault();
              var obj = $(this); // first store $(this) in obj
              var id = $(this).data("id");
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
              $.ajax({
                  url: "/admin/brand/" + id,
                  method: "DELETE",
                  dataType: "Json",
                  data: {"id": id},
                  success: function ($results) {
                      alert('brand has been successfully deleted');
                      $(obj).closest("tr").remove(); //delete row
                      console.log($results);
                  },
                  error: function (xhr) {
                      alert('error, brand not deleted');
                      console.log(xhr.responseText);
                  }
              });
          });
          <!-- LOAD THE EDIT PAGE-->
          jQuery(".edit_me").bind('click', function () {
              var route = $(this).attr('href');
              var id = $(this).data('id');
              window.history.replaceState("", "", "brand/"+id+"/edit");
              $("#content-load").load(route);
              return false;
          });
      });
   </script>
@endsection