$(function() {
    $('.submitCustomer').click(function() {
        if (isEmptyForm()) {
            return false;
        }

        if (isNotValidPhoneNumber()) {
            return false;
        }

        var data = getCustomerData();

        ajaxHttp(data);
    });

    $('.submitCall').click(function() {
        if (isEmptyForm()) {
            return false;
        }

        var data = getCallData();

        ajaxHttp(data);
    });
});

/**
 * @param {object} data
 */
function ajaxHttp(data)
{
    $.ajax({
        type:"POST",
        url:$('#inputAction').val(),
        data:data,
        success: function (response) {
            var message = $('.response-input');

            if (response.status) {
                clearForm();
                message.css({color:"green"});
                message.html(response.status);
            } else if(response.error) {
                message.css({color:"red"});
                message.html(response.error);
            }
        },
        failure: function(){
            $('.response-input').html('Some thing wrong, try again.');
        }
    });
}

/**
 * @returns {boolean}
 */
function isEmptyForm() {
    var result = false;

    $('.form-control').each(function() {
        if (!$.trim($(this).val())) {
            $(this).css({borderColor:"red"});

            result = true;
        } else {
            $(this).css({borderColor:""});
        }
    });

    return result;
}

/**
 * @returns {object}
 */
function getCustomerData() {
    return {
        manageCustomer: {
            firstName: $('#inputFirstName').val(),
            lastName:  $('#inputLastName').val(),
            phone:     $('#inputPhone').val(),
            address:   $('#inputAddress').val(),
            status:    $('#inputStatus').val(),
            id:        $('#inputId').val()
        }
    };
}

/**
 * @returns {object}
 */
function getCallData() {
    return {
        manageCall: {
            subject:    $('#inputSubject').val(),
            content:    $('#inputContent').val(),
            customerId: $('#inputCustomerId').val(),
            callId:     $('#inputCallId').val()
        }
    }
}

/**
 * @returns {boolean}
 */
function isNotValidPhoneNumber() {
    var result = false;

    var reg = /^\d[\d\(\)\ -]{4,16}\d$/;

    var myPhone = $('#inputPhone');

    var isValid = reg.test(myPhone.val());

    if (!isValid) {
        myPhone.css({borderColor:"red"});
        result = true;
    } else {
        myPhone.css({borderColor:""});
    }

    return result;
}

/**
 * @return {void}
 */
function clearForm()
{
    $('.form-control').each(function() {
        $(this).val('');
    });
}

