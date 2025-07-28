
	$(document).ready(function() {
		
        $(".toast").toast('show');
			var addRate = $('.addRate');
			var rateType = addRate.data('rate-type');
			addRate.on('click', function(e){
				e.preventDefault();
				$(this).before('<div class="d-flex rate gap-2 gap-sm-4"><div class="col"><input type="number" class="form-control" data-a-sign="$" data-v-max="99999999" data-v-min="0" data-m-dec="2" name="price[]" placeholder="59.99 per"></div><div class="col"><input type="text" class="onlyNum form-control" placerholder="60" value="60" name="duration_amount[]"></div><div class="col"><select name="duration[]" class="form-control"><option value="m" selected="selected">Minute '+rateType+'</option><option value="h">Hour '+rateType+'</option></select></div><a href="#" class="button tiny alert removeRate p-2"><i class="fa fa-trash-o"></i></a></div>');
			});
		});
		/* Only Number in input */
	$('body').on('keydown', '.onlyNum', function (evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if(charCode >= 65 && charCode <= 93 || charCode >= 106 && charCode <= 111 || charCode >= 186){
		 evt.preventDefault();
		}
	});
	$('body').on('click', '.removeRate', function(e){
		e.preventDefault();
		$(this).parents('.rate').remove();
	});
	
	
	/* --------------------------------------------------------------
   1.  Grab the form and start jQuery‑Validate
-------------------------------------------------------------- */
const $form = $('#aircraft-add-form-1');

$form.validate({
    /* keep your existing options ---------------------------- */
    ignore         : ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
    errorElement   : 'label',
    errorClass     : 'error text-danger',
    errorPlacement : placeDynamicError,
    highlight      : highlightDynamicGroup,
    unhighlight    : unhighlightDynamicGroup,

    rules:  {
        /* keep your old rules */
        password : { minlength: 4 },
        mobile_no: { phoneUS:true, minlength:10, maxlength:10 }
        /* we will inject the dynamic “checkbox‑group” rules below */
    },
    messages: {}
});

/* --------------------------------------------------------------
   2.  Loop over every checkbox array called dynamic_fields[ID][]
       ‑ If any one of the checkboxes in that array has the
         HTML5  required  attribute, we treat the whole array
         as “at least one required”.
-------------------------------------------------------------- */
const added = new Set();                     // avoid duplicates

$('input[type="checkbox"][name^="dynamic_fields["]').each(function () {

    const name = this.name;                  //  e.g.  dynamic_fields[61][]
    if (added.has(name)) return;             // already processed

    if ($(this).prop('required')) {          // server decided it's required
        /* 2a) Tell jQuery‑Validate this *group* is required */
        $form.validate().settings.rules[name] = { required: true };

        /* 2b) Provide a message */
        $form.validate().settings.messages[name] = {
            required: 'Please choose at least one option.'
        };
    }

    added.add(name);
});

/* --------------------------------------------------------------
   3.  Helper functions
-------------------------------------------------------------- */

/* Put the error under the legend that sits in the same .services-group
   (works for every dynamic group, so long as you follow the markup below)
-----------------------------------------------------------------*/
function placeDynamicError(error, element) {
    if (element.attr('name').startsWith('dynamic_fields[')) {
        const $group = element.closest('.services-group');
        $group.find('.dyn-error-holder').first()
              .html(error)                   // replace old error if any
              .removeClass('d-none');
    } else {
        element.before(error);               // your original behaviour
    }
}

/* Add red border to the whole group */
function highlightDynamicGroup(element) {
    if (element.name.startsWith('dynamic_fields[')) {
        $(element).closest('.services-group').addClass('error-border');
    } else {
        $(element).addClass('error');
    }
}

/* Remove border/message once *any* box is checked */
function unhighlightDynamicGroup(element) {
    if (element.name.startsWith('dynamic_fields[')) {
        const $group   = $(element).closest('.services-group');
        const groupName = element.name;
        if ($group.find('input[name="'+groupName+'"]:checked').length) {
            $group.removeClass('error-border')
                  .find('.dyn-error-holder').addClass('d-none');
        }
    } else {
        $(element).removeClass('error');
    }
}

	var form = $("#example-advanced-form").show();

form.validate({
    errorPlacement: function (error, element) {
    const name = element.attr("name");
    const msg = error.text();

    // Only place error if there is an actual message
    if (msg && (
        (name === "email" && msg === "Email already in use!") ||
		(name === "mobile_no" && msg !== "") ||
		(name === "first_name" && msg !== "") ||
		(name === "last_name" && msg !== "") ||
        (name === "confirm_password" && msg !== "") ||
        (name === "check_bot")
    )) {
        element.before(error);
    }
},
    highlight: function (element) {
        $(element).addClass("is-invalid");
    },
    unhighlight: function (element) {
        $(element).removeClass("is-invalid");
    },
    ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
    rules: {
        check_bot: { required: true },
        email: {
            required: true,
            email: true,
            remote: {
                url: "check-email",
                type: "post"
            }
        },
        confirm_password: {
            equalTo: "#password"
        },
        password: { required: true, minlength: 4 },
        mobile_no: {
            required: true,
            phoneUS: true,
            minlength: 10,
            maxlength: 10
        },
        first_name: { required: true, lettersonly: true },
        last_name: { required: true, lettersonly: true }
    },
    messages: {
        email: {
            required: "",         // suppress required message
            email: "Please enter a valid email",            // suppress invalid email message
            remote: "Email already in use!"
        },
        password: {
            required: "",         // suppress required message
            minlength: ""         // suppress minlength message
        },
        mobile_no: {
            required: "",
            phoneUS: "Please enter a valid 10 digit phone number",
            minlength: "Please enter a valid 10 digit phone number",
            maxlength: "Please enter a valid 10 digit phone number"
        },
        first_name: { required: "", lettersonly: "Only alphabetical characters" },
        last_name: { required: "", lettersonly: "Only alphabetical characters" },
        check_bot: {
            required: "You are not a human!"
        },
        confirm_password: {
			required: "",
            equalTo: "Password does not match."
        }
    }
});

	jQuery.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z\s]+$/i.test(value);
	}, "Only alphabetical characters");
	jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
		phone_number = phone_number.replace(/\s+/g, "");
		return this.optional(element) || phone_number.length > 9 && 
		phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
	}, "Please enter a valid 10 digit phone number");
	$("#edit-form").validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        rules: {
            accounttype:{
                required: true
            },
			location_id:{
                required: true
            },
			mobile_no: { 
				required: true, 
				phoneUS: true,
				minlength:10,
				maxlength:10
			},
			gender:{
                required: true
            },
			referredby: { lettersonly: true},
            "offering[]": { 
                    required: true, 
                    minlength: 1 
            },
            "clientele[]": { 
                    required: true, 
                    minlength: 1 
            }
        }
    });
	$("#edit-account-form").validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        rules: {
            first_name: { required: true, lettersonly: true},
			last_name: { required: true, lettersonly: true},
			mobile_no: { 
				required: true, 
				phoneUS: true,
				minlength:10,
				maxlength:10
			},
			email: { required: true, email: true},
        }
    });
	$("#edit-password-form").validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        rules: {
            new_password: { required: true, minlength: 4 },
			confirm_new_password: {
				minlength: 4,
				equalTo: "#new_password"
			}
        }
    });
	$("#card-form").validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        rules: {
            cc_type: { required: true},
			cc_number: { required: true},
        }
    });
	
	$("#search-form").validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',            
        rules: {
            //location_id: { required: true}
        },
		submitHandler: function(form) { 
			if($('#search-form').find('.locationhome').val() == ''){
				var city_state1 = 'all';
			}else{
				console.log($('#search-form').find('.locationhome').val());	
				var location = $('#search-form').find('.locationhome').val();
				var city_state = location.split('||')[0]+', '+location.split('||')[1];
				var city_state1 = location.split('||')[4];//city_state.replace(', ', '-').replace(' ', '-').toLowerCase();
			}	
			var cat = '';
			if($('select[name="category_id"]').val() != undefined){
				if($('#search-form').find('select[name="category_id"]').val() != ''){
					var cat = '?category='+$('select[name="category_id"]').val();
				}
			}
			if($('#search-form').find('.locationhome').val() == '' && $('#search-form').find('#text-input').val() != ''){
				city_state1 = $('#search-form').find('#text-input').val();				
			}
			window.location = baseUrl+'/providers/'+city_state1+cat;		
	   }
    });	