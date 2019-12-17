//uses for delete row

/**
 *
 * @param  url  string = URL OF ROUTE LIKE : /admin/xxx/
 * @param cls string = THE CLASS NAME OF INPUT
 * @param msg  string = show msg after success.ONLY RELATED WORD
 * @returns {boolean}
 */

function deleteAjax(url,cls,msg) {
    $("."+ cls).click(function (e) {
        e.preventDefault();
        if (!confirm('ARE YOU SURE TO DELETE IT?')) {
            return false
        }
        var obj = $(this); // first store $(this) in obj
        var id = $(this).data("id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url + id,
            method: "DELETE",
            dataType: "Json",
            data: {"id": id},
            success: function ($results) {
                alert(msg + ' has been successfully deleted');
                $(obj).closest("tr").remove(); //delete row
            },
            error: function (xhr) {
                alert('error, '+ msg +' not deleted');
                console.log(xhr.responseText);
            }
        });
    });
}
