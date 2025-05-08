$(document).ready(function() {
    toggleAllDay();
    /* Tick picker */
    function attachTime(){
        $('.time').each(function(){
            var thisInput = $(this), min = false, max = false, interval = 5;
            if(thisInput.hasClass('past')){
                max = true
            }else if(thisInput.hasClass('future')){
                min = true
            }
            if(typeof thisInput.data('interval')){
                interval = thisInput.data('interval');
            }
            thisInput.pickatime({
                format: 'h:i a',
                formatSubmit: 'HH:i',
                interval: interval,
                hiddenName: true,
                readOnly: true,
                min: min,
                max: max
            });
        });
    }
    attachTime();
    /* Location Dropdown/Search */
    attachLocation();
    $(".toast").toast('show');
    var addRate = $('.addRate');
    var rateType = addRate.data('rate-type');
    addRate.on('click', function(e){
        e.preventDefault();
        $(this).before('<div class="d-flex rate gap-2 gap-sm-4"><div class="col"><input type="number" class="form-control" data-a-sign="$" data-v-max="99999999" data-v-min="0" data-m-dec="2" name="price[]" placeholder="59.99 per"></div><div class="col"><input type="text" class="onlyNum form-control" placerholder="60" value="60" name="duration_amount[]"></div><div class="col"><select name="duration[]" class="form-control"><option value="m" selected="selected">Minute '+rateType+'</option><option value="h">Hour '+rateType+'</option></select></div><a href="javascript:void(0)" class="button tiny alert removeRate p-2"><i class="fas fa-trash"></i></a></div>');
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

	$('body').on('click', '.allDay', function(){
	    toggleAllDay();
	});    

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Only alphabetical characters");
    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && 
        phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please enter a valid 10 digit phone number");

    $("#provider-form").validate({
        ignore: ":hidden:not(#location_id)",
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
			referredby: { lettersonly: true},
            gender:{
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
            password_confirm: {
                required: true,
                minlength: 4,
                equalTo: "#password"
            }
        }
    });

    $("#provider-form-edit").validate({
        ignore: ":hidden:not(#location_id)",
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
            },
            password: { minlength: 4 },
            password_confirm: {
               required: {
                    depends: function(element) {
                      return $("#password").val().length > 0;
                    }
                  },
                  minlength: 4,
                  equalTo: "#password"
            }
        }
    });

});

function change_categories_skills(_this,user_id){
    $(".load_categories_skills").html('');
	$(".load_category_offering").html('');
    var category_id = $(_this).val()
    $.ajax({
        type: "POST",
        url: baseUrl +'/providerauth/get-categories-skills',
        data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',category_id:category_id,user_id:user_id, edit_user_id:user_id},   
        dataType: 'HTML',           
        success: function (data) {  
            console.log(data);          
            $(".load_categories_skills").html(data);   

            if($('#hid_categories_skills').length){   
            	let hid_categories_skills = $('#hid_categories_skills').val();
            	// Parse the JSON string into an array
				let categoriesSkillsArray = JSON.parse(hid_categories_skills);
				if (Array.isArray(categoriesSkillsArray)) {
					// Iterate over the checkboxes
					$('input[name="categories_skills[]"]').each(function() {
					  let checkboxValue = $(this).val();
					  
					  // Check if the value exists in the array
					  if (categoriesSkillsArray.includes(checkboxValue)) {
					    // Set the checkbox as checked
					    $(this).prop('checked', true);
					  }
					});
			    }
        	}
        }
    });
	$.ajax({
        type: "POST",
        url: baseUrl +'/providerauth/get-category-offering',
        data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',category_id:category_id,user_id:user_id, edit_user_id:user_id,from:'admin'},   
        dataType: 'HTML',           
        success: function (data) {  
            console.log(data);          
            $(".load_category_offering").html(data);   

            if($('#hid_category_offering').length){   
            	let hid_category_offering = $('#hid_category_offering').val();
            	// Parse the JSON string into an array
				let categoriesSkillsArray = JSON.parse(hid_category_offering);
				if (Array.isArray(categoriesSkillsArray)) {
					// Iterate over the checkboxes
					$('input[name="offering[]"]').each(function() {
					  let checkboxValue = $(this).val();
					  
					  // Check if the value exists in the array
					  if (categoriesSkillsArray.includes(checkboxValue)) {
					    // Set the checkbox as checked
					    $(this).prop('checked', true);
					  }
					});
			    }
        	}
        }
    }); 	
}

function attachLocation(){
    $('select.location').selectize({
        valueField: 'id',
        labelField: 'location',
        searchField: 'location',
        create: false,
        render: {
            option: function(item, escape) {
                return '<div>'+escape(item.location)+'</div>';
            }
        },
        load: function(query, callback) {
        	$('.selectize-control').removeClass('loading');
            if (!query.length) return callback();
            
            $.ajax({
                url: baseUrl +'/providerauth/get-locations?q=' + encodeURIComponent(query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    res = $.parseJSON(res);
                    callback(res.locations);
                }
            });
        }
    });
}
function toggleAllDay(){
    $('.allDay').each(function(){
        var thisCheck = $(this);
        var row = thisCheck.parents('.hoo').find('.dayRow');
        if(thisCheck.is(":checked")){
            row.hide();
        }else{
            row.show();
        }
    });
}    
$(document).ready(function(){
 
    //Show carousel-control
    
    $("#myCarousel").mouseover(function(){
        $("#myCarousel .carousel-control").show();
    });

    $("#myCarousel").mouseleave(function(){
        $("#myCarousel .carousel-control").hide();
    });
    
    //Active thumbnail
    
    $("#thumbCarousel .thumb").on("click", function(){
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
    
    });
    
    //When the carousel slides, auto update
    
    $('#myCarousel').on('slid.bs.carousel', function(){
       var index = $('.carousel-inner .item.active').index();
       //console.log(index);
       var thumbnailActive = $('#thumbCarousel .thumb[data-slide-to="'+index+'"]');
       thumbnailActive.addClass('active');
       $(thumbnailActive).siblings().removeClass("active");
       //console.log($(thumbnailActive).siblings()); 
    });     
        
 });


  $(document).ready(function(){
    var isBrowserCompatible = 
      $('html').hasClass('ua-ie-10') ||
      $('html').hasClass('ua-webkit') ||
      $('html').hasClass('ua-firefox') ||
      $('html').hasClass('ua-opera') ||
      $('html').hasClass('ua-chrome');

    if(isBrowserCompatible){
      window.card = new Skeuocard($('#skeuocard'), {
        debug: false
      });
    }
  });

  function change_user_plan(selectObject){
  	let plan =  selectObject.value;
  	if(plan=='1'){
  		$(".premium-plan-block").hide();
  		$("#show_premiun_date").hide();       
  	}else if(plan>='2'){
  		$(".premium-plan-block").show();   
  		$("#show_premiun_date").show();       
  	}else{
  		$(".premium-plan-block").hide();
  		$("#show_premiun_date").hide();          
  	}
  }
