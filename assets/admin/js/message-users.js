$processing = false;
$(document).ready(function(){		
	attachLocation();
})
function updateTotal(){
	
	updateTo();

	$.post(baseUrl + "/admin/emails/send_email_post"+'?num=y', $messageForm.serialize(), function(data){
		$('.numRows').html(data);
	});

}

function updateTo(){

	var names = [];
	var emails = [];
	$('.to-email-div .selectize-input.items > div').each(function(index, div){
		names.push($(this).find('.name').text());
		emails.push($(this).find('.email').text());
	});
	
	$('#toEmails').val(emails);
	$('#toNames').val(names);
	
}

function showLoader(){
	$('.loader').show();
}
function hideLoader(){
	$('.loader').hide();
}

function busy(){
	if($processing){
		return false;
	}else{
		$processing = true;
		showLoader();
		return true;
	}
}
function unbusy(){
	$processing = false;
	hideLoader();
}

function attachLocation(){
    $('select.location').selectize({
        valueField: 'id',
        labelField: 'locationhome',
        searchField: 'locationhome',
        create: false,
        plugins: ["remove_button"],
		delimiter: ",",
		//persist: false,
		preload: true,
        render: {
            option: function(item, escape) {
                return '<div>'+escape(item.locationhome)+'</div>';
            }
        },
        load: function(query, callback) {
        	$('.selectize-control').removeClass('loading');
            //if (!query.length) return callback();
            
            $.ajax({
                url: baseUrl +'/providerauth/get-locations?from=home&q=' + encodeURIComponent(query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    res = $.parseJSON(res);
                    callback(res.locations);                                        
                }
            });
        },
        onChange: function(val) {
        	setTimeout(() => {
			  updateTotal();
			}, 500);
        }
    });
}

$(function(){

	$messageForm = $('#messageForm');
	
	$messageForm.on('submit', function(e){
		e.preventDefault();
		
		Swal.fire({
            text: "Are you sure you want to send now?",
            icon: "warning",
            showCancelButton: 1,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: sweetalert_ok,
            cancelButtonText: sweetalert_cancel,

        }).then(function (response) {
           if (response.value) {
        	if(busy()){
			
				var num = parseInt($('.numRows').text());
				if(num < 1){
					unbusy();
					custom_alert('error', 'Sorry, you need to select recipients in order to send a message', false);
					return false;
				}
				
				var editorData = yourEditor.getData();
				if (editorData.trim() === '') {
				  unbusy();
				  custom_alert('error', 'Please enter a message for your email', false);
				  return false;
				}
				
				
				if($('input[name="subject"]').val() == ''){
					unbusy();
					custom_alert('error', 'Please enter a subject for your email', false);
					return false;
				}
								
				updateTo();
				
				var formData = $messageForm.serialize();
  				formData += '&content=' + encodeURIComponent(editorData);				
				$.post(baseUrl + "/admin/emails/send_email_post", formData, function(response){
					unbusy();

					if (!response.success) {
					    var errorMessages = [];
					    $.each(response.errors, function(field, message) {
					        errorMessages.push(message);
					    });
					    let isNewline = false;
					    if(typeof(errorMessages) != 'undefined' && errorMessages.length > 1){
					    	isNewline = true;
					    }
					    errorMessages = isNewline ? errorMessages.join('\n') : errorMessages.join(' ');
					    custom_alert('error', errorMessages, false);
					    console.log(errorMessages);					    
					}else if(response.success){	
						//custom_alert('success', response.message, false);
						window.location.reload();
					}
				});
			
			}
		  }
        });
		
		return false;
		
	});

	updateTotal();
	
	$('.clickUpdate').on('click', updateTotal);
	
	$('.numRows').on('click', function(){

		updateTo();
	
		$.post(baseUrl + "/admin/emails/send_email_post"+'?show=y', $('#messageForm').serialize(), function(data){
			$('#emails-recipients').html(data);
			$('#modal-emails').modal('show');
		});	
			
	});

	
	$('.selectize-input').on('keypress', 'input', function(e){
	  if (e.which == 13) {
	    e.preventDefault();
	    return false;
	  }
	});
	
	var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
                  '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';
	
	/* Tokenize TO */
	$('select[name="to[]"]').selectize({
		plugins: ['remove_button', 'restore_on_backspace'],
		create: true,
	    persist: false,
	    valueField: 'email',
		labelField: 'name',
		searchField: ['name', 'email'],
		onChange: function(value){
			updateTotal();
		},
		render: {
	        item: function(item, escape) {
	            return '<div>' +
	                (item.name ? '<span class="name">' + escape(item.name) + '</span> ' : '') +
	                (item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
	            '</div>';
	        },
	        option: function(item, escape) {
	            var label = item.name || item.email;
	            var caption = item.name ? item.email : null;
	            return '<div style="line-height: 1rem;">' +
	                '<b>' + escape(label) + '</b>' +
	                (caption ? '<div class="caption">' + escape(caption) + '</div>' : '') +
	            '</div>';
	        }
	    },
	    createFilter: function(input) {
	        var match, regex;
	
	        // email@address.com
	        regex = new RegExp('^' + REGEX_EMAIL + '$', 'i');
	        match = input.match(regex);
	        if (match) return !this.options.hasOwnProperty(match[0]);
	        
	        // name <email@address.com>
	        regex = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
	        match = input.match(regex);
	        if (match) return !this.options.hasOwnProperty(match[2]);
	
	        // name name <email@address.com>
	        regex = new RegExp('^([^<]*) ([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
	        match = input.match(regex);
	        if (match) return !this.options.hasOwnProperty(match[2]);
	
	        return false;
	    },
	    create: function(input) {
	        if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
	            return {email: input};
	        }
	        var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
	        if (match) {
	            return {
	                email : match[2],
	                name  : $.trim(match[1])
	            };
	        }	        
	        custom_alert('error', 'Invalid email address.', false);
	        return false;
	    }
	    
	});
	
	
});