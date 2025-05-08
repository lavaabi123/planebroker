/**
 * Theme: Reactmore Admin
 * Author: More
 */

$(document).ready(function () {
    $("#messageProviderForm").validate({
        rules: {
			check_bot:{required: true},
            name: { required: true, maxlength:255},
            email: { required: true, email: true, maxlength:255}, 
            phone: { required: true, maxlength:20},           
            best_way: { required: true},                       
            message: { required: true},           
        },
        messages: {
			check_bot:{
				required: "You are not a human!"
			}
        },
        submitHandler: function (form) {
            send_message_to_provider(form);
            return false; // Prevent form submission
        }
    });
});


//delete item
function delete_item(url, id, message) {
    Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: sweetalert_ok,
        cancelButtonText: sweetalert_cancel,
    }).then(function (willDelete) {
        if (willDelete.value) {
            var data = {
                'id': id,
            };
            data[csrfName] = $.cookie(csrfCookie);
            $.ajax({
                type: "POST",
                url: baseUrl + url,
                data: data,
                beforeSend: function () {
                    $("#wait").show();
                },
                complete: function () {
                    $("#wait").hide();

                },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

function send_message_to_provider(val) {        
     var formData = $('#messageProviderForm').serialize();        
    //var csrfName = $.cookie(csrfCookie);
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/send_message_to_provider",
        data: formData,
        success: function (response) {
            $('.loader').hide();
            if (!response.success) {
                console.log(response.error);
                Swal.fire(response.message, '', 'error');
            }else if(response.success){ 
                Swal.fire('Successfully delivered your message. Thank you!', '', 'success')
                //$('#contact-provider').html('<div class="success-msg">Thank you for your message!</div>');
				$('#messageProviderForm')[0].reset();
            }
            return false;
        }
    });
    return false;
}

function get_provider_messages(message_id) {
    var data = {
        "message_id": message_id
    };
    //data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/get_provider_messages",
        data: data,
        success: function (data) {
            $('#provider-message-content').html(data);
            $('#modal-provider-message').modal('show');
        }
    });
}

function delete_provider_messages(message_id) {
    var data = {
        "message_id": message_id
    };
	Swal.fire({
        text: 'Do you want to delete this message?',
        icon: "info",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then(function (willDelete) {
        if (willDelete.value) {            
			//data[csrfName] = $.cookie(csrfCookie);
			$.ajax({
				type: "POST",
				url: baseUrl + "/common/delete_provider_messages",
				data: data,
				success: function (data) {
					$('#provider-message-content').html(data);
					$('#pm'+message_id).hide();
				}
			});
        }
    });
}
