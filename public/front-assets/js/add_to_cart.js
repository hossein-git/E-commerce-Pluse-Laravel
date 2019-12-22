//------TO ADD NEW ITEM TO THE CART . USED IN SHOW PRODUCT----
$(document).on('click','.add_to_cart',function (e) {
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
    if ($('.select-inline').val()){
        var selects = $('.select-inline').map(function() {
            return { attr_name: this.value };
        }).get();
    }

    $("#p_error").hide();
    var slug = $("#p_slug").val(),
        id = $("#p_id").val(),
        name = $("#p_name").text(),
        price = $("#p_price").text(),
        qty = $('#p_qty').val(),
        src = $('#p_src').attr('src'),
        _token = $('#_token').val(),
        url = $('#_url').val();
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
            id: id,
            slug: slug,
            name: name,
            price: price,
            qty: qty,
            src: src,
            color: color,
            size: size,
            attr: selects,
        },
        beforeSend: function () {
            $('#add_to_cart').text('loading...')
        },

    })
        .done(function (data) {
            $("#cart_content").empty().append(data.html);
            $("#cart_div").load(location.href + " #cart_div");
            $('#add_to_cart').text('Added to Cart').css("background-color", "#1B6AAA");
        })
        .fail(function (jqXHR, ajaxOptions, error) {
            console.log(jqXHR, ajaxOptions, error);
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

function deleteCart(e) {
    // e.preventDefault();
    var id = $(e).data('id'),
        obj = $(e); // first store $(this) in obj
    // console.log(obj);
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
            // console.log($results);
            $(obj).closest("li").remove(); //delete row
            $(obj).closest("tr").remove(); //delete row
            $("#cart_div").load(location.href + " #cart_div");
        },
        error: function (xhr) {
            alert('error, server not respond...');
        }
    });
}

/*-----EDIT CART-----*/
function editCart(e){
    var rowId = $(e).data('id'),
        _token = $('#_token').val(),
        url = $(e).data('url'),
        qty = $(e).parent().find('input').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url:url,
        method: "post",
        dataType: "Json",
        data: {_token: _token,qty: qty, rowId: rowId},
    }).done(function ($results) {
        alert('updated');
        // console.log($results);
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        console.log(jqXHR);
        console.log(ajaxOptions);
        console.log(thrownError);
        alert('error, server not respond...');
    });
}


