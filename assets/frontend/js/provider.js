
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
	
	
	 var form1 = $("#aircraft-add-form").show();

    form1.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {
			// Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex)
            {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age").val()) < 18)
            {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                form1.find(".body:eq(" + newIndex + ") label.error").remove();
                form1.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form1.validate().settings.ignore = ":disabled,:hidden";
            return form1.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
			console.log(currentIndex);console.log(priorIndex);
            // Used to skip the "Warning" step if the user is old enough.
            if (currentIndex === 2 && Number($("#age").val()) >= 18)
            {
                form1.steps("next");
            }
            // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3)
            {
                form1.steps("previous");
            }
			if(currentIndex === 1){
				$("#slide1").fadeOut();
				$("#slide2").fadeIn("slow");
				$("#slide3").fadeOut();
				$(".stepnumber").text('2');
			}else if(currentIndex === 2){
				$("#slide1").fadeOut("slow");
				$("#slide2").fadeOut("slow");
				$("#slide3").fadeIn("slow");
				$(".stepnumber").text('3');
			}else{
				$("#slide1").fadeIn("slow");
				$("#slide2").fadeOut("slow");
				$("#slide3").fadeOut("slow");
				$(".stepnumber").text('1');
			}
        },
        onFinishing: function (event, currentIndex)
        {
            form1.validate().settings.ignore = ":disabled";
            return form1.valid();
        },
        onFinished: function (event, currentIndex)
        {
            $("#aircraft-add-form").submit();
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        rules: {
			check_bot:{required: true},
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
            accounttype:{
                required: true
            },
            "offering[]": { 
                    required: true, 
                    minlength: 1 
            },
            "clientele[]": { 
                    required: true, 
                    minlength: 1 
            },
			password: { required: true, minlength: 4 },
			mobile_no: { 
				required: true, 
				phoneUS: true,
				minlength:10,
				maxlength:10
			},
			first_name: { required: true, lettersonly: true},
			last_name: { required: true, lettersonly: true},
			referredby: { lettersonly: true},
			location_id: {required: true}
        },
        messages: {
            email: {
                remote: "Email already in use!"
            },
			check_bot:{
				required: "You are not a human!"
			},
			confirm_password:{
				equalTo: "Password does not match."
			}
        },
    });
    var form = $("#example-advanced-form").show();

    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        rules: {
			check_bot:{required: true},
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
				minlength:10,
				maxlength:10
			},
			first_name: { required: true, lettersonly: true},
			last_name: { required: true, lettersonly: true}
        },
        messages: {
            email: {
                remote: "Email already in use!"
            },
			check_bot:{
				required: "You are not a human!"
			},
			confirm_password:{
				equalTo: "Password does not match."
			}
        },
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
	/*
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
    });	*/