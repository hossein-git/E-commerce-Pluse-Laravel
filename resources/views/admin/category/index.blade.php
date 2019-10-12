@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty')
@section('content')
   <div class="col-xs-6 col-lg-6">
      <form action="">
         <ul>
            @foreach($categories as $category)
               <li class="bolder bigger-120">
                  <i class="menu-icon fa fa-square"></i>
                  {{ $category->category_name }}
                  <b class="arrow"></b>
                  <button class="delete_it btn btn-danger btn-xs" data-id="{{ $category->category_id }}">
                     <i class="ace-icon fa fa-trash-o bigger-140"></i>
                  </button>
                  @if($category->children()->count())
                     @include('admin.category._indexSub', ['subs' => $category->children])
                  @endif
               </li>
               -------------------------------
            @endforeach
         </ul>
      </form>
   </div>
   {{ $categories->links() }}
   <!-- DELETE WITH AJAX -->
   <script>
       $(document).ready(function () {
           $(".delete_it").click(function (e) {
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
                   url: "/admin/category/" + id,
                   method: "DELETE",
                   dataType: "Json",
                   data: {"id": id},
                   success: function ($results) {
                       alert('category has been successfully deleted');
                       $(obj).parent().remove(); //delete row
                       console.log($results);
                   },
                   error: function (xhr) {
                       alert('error, category not deleted');
                       console.log(xhr.responseText);
                   }
               });
           });
       });
   </script>
@endsection()
