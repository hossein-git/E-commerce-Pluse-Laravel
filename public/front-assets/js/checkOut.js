//USE FOR SAVE REQUESTS WITH AJAX + validate it
/**
 *
 * @param url string = URL OF ROUTE
 * @param data array = DATA TO PASS
 * @param formId int = FROM ID FOR VALIDATION
 * @param rules  array = RULES FOR VALIDATION
 * @param msg  string = show msg after success
 * @returns {boolean}
 */


function upload_ajax(url, data, formId = null, rules = null, msg) {
    var bool = false;

    if (formId) {
        var $form = $('#' + formId);
        //add phone validation
        jQuery.validator.addMethod("phone", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 10 &&
                phone_number.match(/^\+[0-9]{12}$/);
        }, "Please specify a valid phone number");
        //add post code validation
        jQuery.validator.addMethod("post_code", function (value, element) {
            return this.optional(element) || /^\d{10}(?:-\d{4})?$/.test(value);
        }, "Please provide a valid postal Code.");
        //add text only
        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z," "]+$/i.test(value);
        }, "Letters and spaces only please");
        $form.validate({
            rules: rules,
            // message: msg,
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block`,"text-danger" class to the error element
                error.addClass("text-danger");
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else {
                    error.insertAfter(element);
                }

            },
            success: function (label, element) {
                // Add the span element, if doesn't exists, and apply the icon classes to it.
                 if ( !$( element ).next( "span" )[ 0 ] ) {
                     $( '<span class="form-control-feedback icon icon-check"></span>' ).insertAfter( $( element ) );
                 }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                $( element ).next( "span" ).addClass( "icon-clear" ).removeClass( "icon-check" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                $( element ).next( "span" ).addClass( "icon-check" ).removeClass( "icon-clear" );
            }
        });

        //check if the input is valid
        if (!$form.valid()) return false;

    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        async: false,
        url: url,
        method: "POST",
        data: data,
        cache: false,
        beforeSend: function () {
            $(".ajax-load").show();
        },
        success: function (result) {
            if (msg){
                 alert(result.success);
            }
            bool = true;
            $(".ajax-load").hide();
        },
        error: function (request, status, error) {
            alert('server not responding....' + error);
            console.log(error,request,status);
            $(".ajax-load").hide();
        }
    });

    return (bool);

}


