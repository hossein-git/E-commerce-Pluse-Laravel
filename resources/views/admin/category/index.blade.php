@extends('layout.admin.index' )
@section('title')
   Category List
@stop
@section('extra_css')
   <link rel="stylesheet" href="{{ asset('admin-assets/css/treeview/style.min.css') }}"/>
   @if (env('APP_AJAX'))
      <script type="text/javascript">
          $(document).on('pjax:complete', function() {
              pjax.reload();
          })
      </script>
   @endif
@stop
@section('content')

   <div class="space-20"></div>
   <div class="container-fluid">
      <div class="jstree" id="html1">
         <ul>
            @foreach($main_categories as $category)
               <li data-id="{{ $category->category_id }}"><b>{{ $category->category_name }}</b>
                  @if($category->children->count())
                     @include('admin.category._indexSub', ['subs' => $category->children])
                  @endif
               </li>
            @endforeach
         </ul>
      </div>
      {{ $main_categories->links() }}
   </div>
@endsection()
@section('extra_js')
   <!-- TREE VIEW -->
   <script src="{{ asset('admin-assets/js/jstree.min.js') }}"></script>
   <!-- DELETE WITH AJAX -->
   @can('product-delete')
      <script type="text/javascript">
          $('.jstree').jstree({
              "core": {
                  "themes": {
                      "variant": "large",

                  },
                  "core": {
                      "multiple": false,
                      "animation": 1,
                  }
              },
          }).on('changed.jstree', function (e, data) {
              var i, j, r = [];
              for (i = 0, j = data.selected.length; i < j; i++) {
                  r.push(data.instance.get_node(data.selected[i]).li_attr['data-id']);
              }
              if (!confirm('Are you Sure?')) {
                  return false;
              }
              var id = r.join(', ');
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
                        location.reload();
                      // console.log($results);
                  },
                  error: function (xhr) {
                      alert('error, category not deleted');
                      console.log(xhr.responseText);
                  }
              });

          });
      </script>
   @endcan


@stop
