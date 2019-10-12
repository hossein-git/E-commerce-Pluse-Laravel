@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty')
@section('content')
   <table class="table table-hover table-bordered">
      <thead>
      <tr class="center">
         <th class="center">COMMENTS</th>
         <th class="center">USER</th>
         <th class="center">PRODUCT</th>
{{--         <th class="center">STAR</th>--}}
         <th class="center">Created At</th>
         <th class="center">OPERATIONS</th>
      </tr>
      </thead>
      <tbody>
      @forelse($comments as $comment)
         @php($product = $comment->commentable->get(['product_name','product_id'])->first())
         <tr>
            <td class="center">{{ $comment->comment }}</td>
            <td class="center">
               @if($comment->commenter_id =! null)
                  <span class="tag blue"><b>{{ $comment->guest_name }}</b></span>
                  <small><a href="mailTo:{{ $comment->guest_email }}">{{ $comment->guest_email }}</a></small>
               @else
                  {{ $comment->commenter() }}
               @endif
            </td>
            <td class="center">
               <a href="">{{ $product->product_name }}</a>
            </td>
            {{--<td class="small">
               <!-- DISPLAY RATING -->
               @for( $i = 0 ; $i < round($product->averageRating) ; $i++)
                  <span class="fa fa-stack" style="color: gold">
                     <i class="fa fa-star fa-stack-2x"></i>
                     <i class="fa fa-star-o fa-stack-2x"></i>
                  </span>
               @endfor
               @for( $i = 5 ; $i > round($product->averageRating) ; $i--)
                  <span class="fa fa-stack">
                     <i class="fa fa-star-o fa-stack-2x"></i>
                  </span>
               @endfor
            <!-- /DISPLAY RATING -->
            </td>--}}
            <td class="center">{{ $comment->created_at }}</td>
            <td class="center">
               <div class="hidden-sm hidden-xs btn-group">
                  <form>
                     <button class="btn btn-xs btn-danger delete_me" data-id="{{ $comment->id }}">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                     </button>
                  </form>
                  @if($comment->approved == 0)
                     <form>
                        <button class="btn btn-success btn-xs approved_me" title="approved"
                                data-route="{{ route('comment.approve',$comment->id) }}">
                           <i class="ace-icon fa fa-thumbs-up bigger-120"></i>
                        </button>
                     </form>
                  @endif
               </div>
            </td>
         </tr>
      @empty
         <tr>
            <td class="center bolder red" colspan="6">No Comments</td>
         </tr>
      @endforelse
      </tbody>
   </table>
   {{ $comments->links() }}
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
                   url: "/admin/comments/" + id,
                   method: "DELETE",
                   dataType: "Json",
                   data: {"id": id},
                   success: function ($results) {
                       alert('Comment has been successfully deleted');
                       $(obj).closest("tr").remove(); //delete row
                       console.log($results);
                   },
                   error: function (xhr) {
                       alert('error, Comment not deleted');
                       console.log(xhr.responseText);
                   }
               });
           });

           <!-- APPROVE COMMENT-->
           jQuery(".approved_me").bind('click', function (e) {
               e.preventDefault();
               var obj = $(this);
               var route = $(this).data('route');
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   }
               });
               $.ajax({
                   url: route,
                   method: "get",
                   success: function ($results) {
                       alert('Comment has been successfully Approved');
                       $(obj).closest("button").remove(); //delete button
                       console.log($results);
                   },
                   error: function (xhr) {
                       alert('error, not approved ');
                       console.log(xhr.responseText);
                   }
               });
           });
       });
   </script>
@endsection

