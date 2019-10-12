@extends(!Request::ajax() ? 'layout.admin.index' : 'layout.empty' )
@section('content')
   @include('layout.errors.notifications')
   <table id="simple-table" class="table  table-bordered table-hover">
      <thead>
      <tr>
         <th class="center">
            #
         </th>
         <th class="center">Name</th>
         <th class="center">Status</th>
         <th class="center">Amount</th>
         <th class="center">Code</th>
         <th class="hidden-480">operations</th>
         <th></th>
      </tr>
      </thead>
      <tbody>
      @forelse($gifts as $key=> $gift)
         <tr>
            <td class="center">
               <label class="pos-rel">
                  {{ $key+1 }}
                  <input type="checkbox" class="ace">
                  <span class="lbl"></span>
               </label>
            </td>
            <td class="">{{ $gift->gift_name }}</td>
            <td class="center">
               <div class="action-buttons">
                  @if($gift->status == 1)
                     <a href="#" class="green bigger-140 show-details-btn" title="Active" disabled="">
                        <i class="ace-icon fa fa-angle-double-up"></i>
                        <span class="sr-only">Active</span>
                     </a>
                  @else
                     <a href="#" class="red bigger-140 show-details-btn" title="De Active" disabled="">
                        <i class="ace-icon fa fa-angle-double-down"></i>
                        <span class="sr-only">De Active</span>
                     </a>
                  @endif
               </div>
            </td>
            <td class="">{{ number_format($gift->gift_amount) }}</td>
            <td class="bolder">{{ $gift->gift_code }}</td>
            <td class="center">
               <div class="hidden-sm hidden-xs btn-group">
                  <form>
                     <button class="btn btn-xs btn-danger delete_me" data-id="{{ $gift->gift_id }}">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                     </button>
                     <a class="btn btn-warning btn-xs edit_me" title="Edit"
                        href="{{ route('giftCard.edit',$gift->gift_id) }}" data-id="{{ $gift->gift_id }}">
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

   {{ $gifts->links() }}

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
                url: "/admin/giftCard/" + id,
                method: "DELETE",
                dataType: "Json",
                data: {"id": id},
                success: function ($results) {
                    alert('Gift Card Has Been successfully Deleted');
                    $(obj).closest("tr").remove(); //delete row
                    console.log($results);
                },
                error: function (xhr) {
                    alert('error, gift Card not deleted');
                    console.log(xhr.responseText);
                }
            });
        });
        <!-- LOAD THE EDIT PAGE-->
        jQuery(".edit_me").bind('click', function () {
            var route = $(this).attr('href');
            var id = $(this).data('id');
            window.history.replaceState("", "", "giftCard/"+id+"/edit");
            $("#content-load").load(route);
            return false;
        });
    });
</script>






@endsection