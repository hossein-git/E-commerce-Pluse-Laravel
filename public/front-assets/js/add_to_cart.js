//------TO ADD NEW ITEM TO THE CART . USED IN SHOW PRODUCT----
$('#add_to_cart').click(function (e) {
    e.preventDefault();
    var color = $('#p_color').val();
    if (!color) {
        $("#p_error").text('Please select Color').show();
        return
    }
    var size = $('#p_size').val();
    if (!size) {
        $("#p_error").text('Please select Size').show();
        return
    }
    $("#p_error").hide();
    var slug = $("#p_slug").val();
    var id = $("#p_id").val();
    var name = $("#p_name").text();
    var price = $("#p_price").text();
    var qty = $('#p_qty').val();
    var src = $('#p_src').attr('src');
    var _token = $('#_token').val();
    var url = $('#_url').val();
    var currentVal = $("#cart_count").data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: "post",
        data: {
            _token: _token,
            id : id,
            slug : slug,
            name: name,
            price: price,
            qty: qty,
            src: src,
            color: color,
            size: size,
        },
        beforeSend: function () {
            $('#add_to_cart').text('loading...')
        },

    })
        .done(function (data) {
            $("#cart_content").empty().append(data.html);
            $('#add_to_cart').text('Added to Cart');
            $('#add_to_cart').css("background-color", "#1B6AAA");
            $("#cart_count").text(currentVal + qty );

        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            // console.log(jqXHR);
            alert('error');
        })

});

$(".p_color").click(function (e) {
    e.preventDefault();
    var data = $(this).data('id');
    $('#p_color').empty().val(data);
    $(".options-swatch-color").find('li').removeClass("active");
    $(this).parents().addClass('active');
});

$(".tags-list").find('a').click(function (e) {
    e.preventDefault();
    var data = $(this).attr('size');
    $('#p_size').empty().val(data);
    $(".tags-list").find('li').removeClass("active");
    $(this).parents().addClass('active');

});
/*------/TO ADD NEW ITEM TO THE CART . USED IN SHOW PRODUCT----*/


    /*----- DELETE FROM CART ------*/
$(".cart_delete_").click(function (e) {
    // e.preventDefault();
    var id = $(this).data('id');
    var obj = $(this); // first store $(this) in obj
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/cart/" + id,
        method: "DELETE",
        dataType: "Json",
        data: {"id": id},
        success: function ($results) {
            console.log($results);
            $(obj).closest("li").remove(); //delete row
            $(obj).closest("tr").remove(); //delete row
            var currentVal = $("#cart_count").data('id');
            $("#cart_count").text(currentVal - 1);
        },
        error: function (xhr) {
            alert('error, server not respond...');
        }
    });
});


/*-----EDIT CART-----*/
$(".cart_edit_form").submit(function (e) {
    e.preventDefault();
    // var url = $(this).data('url');
    var rowId = $(this).data('id');
    var qty = $(this).find('input:text').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        url: '/cart/edit/' ,
        method: "post",
        data:  {  qty : qty, rowId : rowId},
        contentType: false,
        cache: false,
        processData:false,
        success: function ($results) {
            alert('updated');
            console.log($results);
        },
        error: function (xhr) {
            console.log(xhr)
            alert('error, server not respond...');
        }
    });
});

