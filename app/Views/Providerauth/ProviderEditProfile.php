<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
.form-section.row.row-cols-1.row-cols-md-2.dd label::after {
    content: "*";
    color: red;
    font-size: 25px;
}
</style><?php
if(!empty($user_detail->avatar)){ 
	$pic['file_name'] = base_url().'/uploads/userimages/'.$user_detail->id.'/'.$user_detail->avatar;
}else{
	$pic['file_name'] = base_url().'/assets/frontend/images/user.png';
}						
						?>
						<?php $percent = ($user_detail->miles - 0)/ (50 - 0)*100; ?>
						<style>
						.loader1 {
    width: 48px;
    height: 48px;
    border: 5px solid #FFF;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    top: 37%;
    position: absolute;
    left: 38%;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 

.image-wrapper {
	background: rgb(0 0 0 / 63%);
	bottom: 0px;
	height: 50px;
	left: 0;
	position: absolute;
	transition: bottom 0.15s linear;
	width: 100%;
}

.edit {
	.h-align;
	color: white;
	cursor: pointer;
	font-size: 25px !important;
	top: 10px;position:absolute;left:48%;text-align:center;
}

.profile-pic {
	.h-align(absolute);
	border-radius: 5%;
	border: 4px solid white;
	height: 160px;
	overflow: hidden;
	transform: translateX(0%) translateY(-7%);
	width: 210px;
	top: 0;
	img {
		box-sizing: border-box;
		height: 100%;
		left: 50%;
		max-height: 100%;
		position: absolute;
		transform: translateX(-50%);
		transition: all 0.15s ease-out;
		width: auto;object-fit: scale-down;
	}
	
}
.user-info {
	.clear;
	padding: 8px;
	position: relative;
}
.hidden-input {
	left: -999px;
	position: absolute;
}
.slider-container {
    text-align: center;
    margin-bottom: 25px;
    padding: 10px;
  }

  .slider-container label {
    display: block;
  }

  .slider-container input[type="range"] {
    width: 100%;
    margin: 0 auto;
    display: block;
  }
  
  
  /* Styles for the range slider */
  input[type="range"] {
    -webkit-appearance: none;
    width: 100%;
    height: 10px;
    background: linear-gradient(to right, #ff6c00 0%, #ff6c00 <?php echo $percent; ?>%, #e0dcd7 <?php echo $percent; ?>%, #e0dcd7 100%);
    outline: none;
    opacity: 1;
    -webkit-transition: .2s;
    transition: opacity .2s;
    border-radius: 5px;
    margin: 10px 0;
  }

  /* Style for the thumb of the slider */
  input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: #ff6c00;
    border-radius: 50%;
    cursor: pointer;
  }

  /* Style for the thumb of the slider in Firefox */
  input[type="range"]::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background: #ff6c00;
    border-radius: 50%;
    border: 2px solid #ccc;
    cursor: pointer;
  }
  @media (min-width:768px){
  .pr-md-0{
	padding-right:0px;  
  }
  .pl-md-0{
	padding-left:0px;  
  }
  }
  .pac-container:after {
    /* Disclaimer: not needed to show 'powered by Google' if also a Google Map is shown */

    background-image: none !important;
    height: 0px;
}
label#postcode-error, label#locality-error {
    opacity: 0;
}label#location_id-error {
    display: none !important;
}
</style>
    <div class="plan bg-gray pt-2 pb-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-3 mb-xl-4">
			<h3 class="title-lg text-black mb-0 mb-sm-5"><?php echo $title; ?></h3>
		</div>
		<div class="container">
			<div class="row">
			<div class="leftsidecontent col-12 col-sm-4 col-lg-3">
				<?php echo $this->include('Common/_sidemenu') ?>
			</div>
			<div class="col-12 col-sm-8 col-lg-9">
			<form id="edit-form" method="post" action="<?php echo base_url(); ?>/providerauth/edit-profile-post">
			<?php echo csrf_field() ?>
				<input type="hidden" name="id" value="<?php echo $user_detail->id ?>">
				<input type="hidden" name="email" value="<?php echo $user_detail->email ?>">
				<fieldset class="form-input">	
						<h4 class="title-sm dblue mt-3 mt-lg-5 border-bottom"><?php echo trans('Profile Picture') ?>:</h4>
					<div class="form-section row row-cols-1 row-cols-md-3">
						<div class="form-group">				
						<div class="user-info">
						  <div class="profile-pic"><img class="proPic1" src="<?php echo $pic['file_name']; ?>"/>
							<div class="layer">
							  <div class="loader1" style="display:none;"></div>
							</div><a class="image-wrapper" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#imageUploadModal">
								<!--<input class="hidden-input" name="user-pic" id="changePicture" type="file"/>
								<label class="edit fa fa-edit" for="changePicture" type="file" title="Change picture"></label>--><label class="edit fa fa-edit" for="changePicture" title="Change picture"></label></a>
						  </div>
						</div>
						</div>
						</div>					
					<h4 class="title-sm dblue mt-3 mt-lg-5 border-bottom">Basic Info:</h4>
					<div class="form-section row row-cols-1 row-cols-md-3">
						
						<div class="form-group">
							<input class="form-control" type="text" id="business_name" name="business_name" placeholder="<?php echo trans('Business Name(if applicable)') ?>" value="<?php echo $user_detail->business_name ?>">
						</div>
						<!--<div class="form-group">
							<select name='location_id' class='location required'>
								<option value='<?php echo $user_detail->location_id ?>'><?php echo $user_detail->city.', '.$user_detail->state_code.' '.$user_detail->zipcode ?></option>
							</select>
						
						</div>-->
						<div class="form-group">
							<input class="form-control required" type="text" id="mobile_no" name="mobile_no" placeholder="<?php echo trans('Telephone Number') ?>" value="<?php echo $user_detail->mobile_no ?>">
						</div>
						<div class="form-group">
							<input class="form-control" type="text" id="referredby" name="referredby" placeholder="<?php echo trans('Referred By') ?>" value="<?php echo $user_detail->referredby ?>">
						</div>
						<input type="hidden" name="gender" value="Male" />
						<!--<div class="form-group">
                                <select name="gender" class="form-control required">
                                    <option><?php echo trans('Gender') ?></option>
                                    <option value="Male" <?php echo ($user_detail->gender == 'Male') ? 'selected':''; ?>>Male</option>
                                    <option value="Female" <?php echo ($user_detail->gender == 'Female') ? 'selected':''; ?>>Female</option>
                                </select>
						</div>-->
						<input type="hidden" name="licensenumber" value="123" />
						<!--<div class="form-group">
							<input class="form-control" type="text" id="licensenumber" name="licensenumber" placeholder="<?php echo trans('License #') ?>" value="<?php echo $user_detail->licensenumber ?>">
						</div> -->
						<div class="form-group">
							<input class="form-control required" type="text" id="experience" name="experience" placeholder="<?php echo trans('Years of Experience') ?>" value="<?php echo $user_detail->experience ?>">
						</div>
						<div class="form-group">
							<input class="form-control" type="text" id="website" name="website" placeholder="<?php echo trans('Website') ?>" value="<?php echo $user_detail->website ?>">
						</div>
						<div class="form-group yelp">
							<input class="form-control" type="text" id="yelp_name" name="yelp_name" placeholder="<?php echo trans('Yelp Business Name') ?>" value="<?php echo $user_detail->yelp_name ?>">
							<i class="toolTipinfo" data-toggle="popover">i</i>
						</div>						
						<!--<div class="form-group">
							<img src="<?php //echo base_url('assets/frontend/images/yelp.png'); ?>" width="100%" />
						</div>-->
						</div>			
						
						<p class="fw-bold dblue mb-0">Google My Business:</p>					
						<div class="form-section row row-cols-2 row-cols-md-2">
						<div class="form-group">
							<input class="form-control" name="google_location" id="pac-input" type="text" placeholder="Select Location from Google" value="<?php echo $user_detail->google_location ?>" />
						</div>	
							<input name="place_id" placeholder="Google Place ID" type="hidden"  id="place_id" value="<?php echo $user_detail->place_id ?>"/>
							
						<div class="form-group">
							<input class="form-control" name="google_rating" placeholder="Google Rating" type="text" readOnly id="google_rating" value="<?php echo $user_detail->google_rating ?>"/>
						</div>						
						</div>
						
						
						<h4 class="title-sm dblue mt-3 mt-lg-5 border-bottom"><?php echo trans('Type of Business') ?>:</h4>
						<div class="form-section row row-cols-1 row-cols-md-3">
						
											
						<div class="form-group">
							<input class="form-control required" type="text" id="address" name="address" placeholder="<?php echo trans('Address') ?>" autocomplete="off" value="<?php echo $user_detail->address ?>" >
						</div>	  
						<div class="form-group">
							<input class="form-control" type="text" id="address2" name="suite" placeholder="<?php echo trans('Suite, Apartment, etc') ?>" value="<?php echo $user_detail->suite ?>" >
						</div>
						<input type="hidden" id="cityLat" name="city_lat" value="<?php echo $user_detail->city_lat ?>" />
						<input type="hidden" id="cityLng" name="city_lng" value="<?php echo $user_detail->city_lng ?>" />
						<input type="hidden" id="location_id" name="location_id" value="<?php echo $user_detail->location_id ?>" />
						<div class="form-group">							
							<input type="text" value="<?php echo $user_detail->city ?>" placeholder="City" name='locality' id="locality" class='form-control required' />
						</div>
						<div class="form-group">							
							<input type="text" value="<?php echo $user_detail->state ?>" placeholder="State" name='state' id="state" class='form-control required' />
						</div>
						<div class="form-group">							
							<input type="text" value="<?php echo $user_detail->zipcode ?>" placeholder="Zip Code" name='postcode' id="postcode" class='form-control required' />
						</div>
							
						</div>
						<div class="form-section">						
						
						<h4 class="title-sm dblue mt-3 mt-lg-5 border-bottom"><?php echo trans('Social Profile') ?>:</h4>
						<div class="form-section row row-cols-1 row-cols-md-3">
						<div class="form-group">
							<input class="form-control" type="text" id="facebook_link" name="facebook_link" placeholder="<?php echo trans('Facebook Link') ?>" value="<?php echo $user_detail->facebook_link ?>">
						</div>
						<div class="form-group">
							<input class="form-control" type="text" id="insta_link" name="insta_link" placeholder="<?php echo trans('Instagram Link') ?>" value="<?php echo $user_detail->insta_link ?>">
						</div>
						<div class="form-group">
							<input class="form-control" type="text" id="twitter_link" name="twitter_link" placeholder="<?php echo trans('Twitter Link') ?>" value="<?php echo $user_detail->twitter_link ?>">
						</div>
						</div>
						
						
						
						
						
									<?php
									if(!empty($dynamic_fields)){
										$dynamic_fields_values = json_decode($user_detail->dynamic_fields,true);
										
										echo '<div class="row  mt-3">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                            <h4 class="border-bottom pb-2 mb-3">Dynamic Fields</h4>
											<div class="form-section row row-cols-1 row-cols-md-2">';
										foreach($dynamic_fields as $field){
											echo '<div class="form-group mb-3 pr-2 d_fields" data-category="'.$field->category_ids.'" data-subcategory="'.$field->subcategory_ids.'">
													<label>'.$field->name.'</label>';
													if($field->field_type == 'Text'){
														echo '<input type="text" name="dynamic_fields['.$field->name.']" class="form-control" placeholder="'.$field->name.'" value="'. (!empty($dynamic_fields_values[$field->name]) ? $dynamic_fields_values[$field->name] : '').'">';
													}else if($field->field_type == 'Textarea'){
														echo '<textarea name="dynamic_fields['.$field->name.']" class="form-control" placeholder="'.$field->name.'">'. (!empty($dynamic_fields_values[$field->name]) ? $dynamic_fields_values[$field->name] : '').'</textarea>';
													}else if($field->field_type == 'Checkbox'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<div class="row">';
															foreach($decoded_option as $oi => $option){
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex"><input type="checkbox" name="dynamic_fields['.$field->name.'][]" id="status_'.$oi.'" class="" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && in_array($option, $dynamic_fields_values[$field->name]) ) ? 'checked' : '').'><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
															}	
															echo '</div>';															
														}else{
															echo 'Options not available';
														}
													}else if($field->field_type == 'Radio'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<div class="row">';
															foreach($decoded_option as $oi => $option){
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex"><input type="radio" name="dynamic_fields['.$field->name.']" id="status_'.$oi.'" class="" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && $option== $dynamic_fields_values[$field->name]) ? 'checked' : '').'><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
															}	
															echo '</div>';															
														}else{
															echo 'Options not available';
														}
													}else if($field->field_type == 'Dropdown'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														$option_html = '';
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<select class="form-control" name="dynamic_fields['.$field->name.']"><option value="">--Select--</option>';
															foreach($decoded_option as $oi => $option){
																echo '<option value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && ($option == $dynamic_fields_values[$field->name]) ) ? 'selected' : '').'>'.$option.'</option>';
															}
															echo '</select>';															
														}else{
															echo 'Options not available';
														}
													}
												echo '</div>';
										}
										echo '</div>						
                                            </div>
                                        </div>                                    
                                    </div>';
									}									
									?>
						
						<input type="submit" class="btn yellowbtn fs-5 mt-5" value="Save my Profile" />
					</div>
				</fieldset>
			</form>
			</div>
			</div>
			
		</div>
	</div>
<!-- Modal -->
<div class="modal fade" id="imageUploadModal" tabindex="-1" role="dialog" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageUploadModalLabel">Upload Image</h5>
        <a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5"><i class="fa-solid fa-xmark"></i></a>
      </div>
      <div class="modal-body mb-3">
        <input type="file" id="upload" style="display: flex;
    margin: 0 auto 25px auto;
    border: 1px solid #eee;" />
        <div id="imageDemo"></div>
        <button class="btn btn-success d-flex m-auto" id="crop">Crop & Upload</button>
      </div>
    </div>
  </div>
</div>
	<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbBKfGnxtUfSe3EpjdIbaiafOMTvk1rg8&callback=initAutocomplete&libraries=places&v=weekly"
      defer
    ></script>
<script type="text/javascript">
$(document).ready(function(){
			
		// On change, load subcategories
    $('#category_id').on('change', function() {
        let selected = $(this).val();
		var field_id = $(this).attr('data-field-id');
        if (selected && selected.length > 0) {
            $.ajax({
                url: baseUrl + "/common/get_sub_category_by_ids",
                method: 'POST',
				dataType:'json',
                data: { category_ids: selected, field_id:field_id },
                success: function(response) {
                    $('#sub_category_id').html(response.text);
                }
            });
        } else {
            $('#sub_category_id').html('');
        }
    });
	
	$('#category_id, #sub_category_id').on('change', function () {
		const selectedCategory = $('#category_id').val();
		const selectedSubcategory = $('#sub_category_id').val();

		$('.d_fields').each(function () {
			const catList = $(this).data('category').toString().split(',');
			const subcatList = $(this).data('subcategory').toString().split(',');

			const matchCategory = selectedCategory === '' || catList.includes(selectedCategory);
			const matchSubcategory = selectedSubcategory === '' || subcatList.includes(selectedSubcategory);

			if (matchCategory && matchSubcategory) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	});
	
	$('select[name="category_id"]').trigger('change');	
			
			
    var $uploadCrop;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                });
            }

            reader.readAsDataURL(input.files[0]);
        }
        else {
            alert("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#imageDemo').croppie({
        enableExif: true,
		viewport: {
			width: 200,
			height: 150,	
			type: 'rectangle',				
			enableResize: true,
			enableOrientation: true,
		},
		boundary: {
			width: 400,
			height: 300
		}
    });

    $('#upload').on('change', function () { readFile(this); });

    $('#crop').on('click', function () {
        $uploadCrop.croppie('result', {
            type: 'blob',
			size: 'original',
			quality: 1
        }).then(function (resp) {
            $('#imageUploadModal').modal('hide');
            // You can send the cropped image data (resp) to the server here
            $('.loader1').show();
			//console.log($('#changePicture').files);
			//var file  = $('#changePicture')[0].files[0];
			var form_data = new FormData();
			form_data.append("upload", resp);
			$.ajax({
				url: '<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/'+'<?php echo session()->get('vr_sess_user_id'); ?>',
				data: form_data,
				type: 'POST',
				dataType: 'JSON',
				processData: false,
				contentType: false,
				cache: false,
				enctype: 'multipart/form-data',
				beforeSend: function(){
					$('.loader1').show();
				},
				success: function(response){
					$('.loader1').hide();
					if(response.uploaded == 1){
						$("#changePicture").val(null);
						$('.proPic1').attr('src',response.url);
						$('.proPic').find('img').attr('src',response.url);	
						
						$.ajax({
							url: '<?php echo base_url(); ?>/providerauth/photos_post',
							data: {check:'5',image:response.fileName},
							type: 'POST',
							dataType: 'HTML',
							success: function(response){
								if(response != ''){
									$(".load-images").html(response);
								}
								$("#imageListId").sortable({
									update: function(event, ui) {
											getIdsOfImages();
										} //end update	
								});	
								$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));										
							}
						})						
						
						$(".upload-loading-success").html('Updated Successfully!');
						$(".upload-loading-success").show().delay(5000).fadeOut();
					}else{
						$(".upload-loading-error").html(response.error);
						$(".upload-loading-error").show().delay(5000).fadeOut();
					}
				}
			}) 
        });
    });
});
        function initMap() {
			const input = document.getElementById("pac-input");
			const options = {
				fields: ["place_id", "rating"],
				strictBounds: false,
			};
			const autocomplete = new google.maps.places.Autocomplete(input, options);
			autocomplete.addListener("place_changed", () => {			
				const place = autocomplete.getPlace();
				console.log(place);
				$('#place_id').val(place.place_id);
				$('#google_rating').val(place.rating);
			});
		}
		window.initMap = initMap;
       </script>
<script>
	$(document).ready(function() {
		$("#pac-input").on("keydown keyup keypress blur change", function(){
			$('#google_rating').val("");
			$('#place_id').val("");
		});
		toggleAllDay();
		attachLocation();
		attachTime();
		
		var simg = '<?php echo base_url().'/assets/frontend/images/yelp.png'; ?>';
		$('[data-toggle="popover"]').popover({
        placement : 'right',
		trigger : 'hover',
        html : true,
        content : '<div class="tooltip-inner text-start"><img width="270" src="'+simg+'"></div>'
    });
		const milesRangeInput = document.getElementById('miles');
		const selectedMilesSpan = document.getElementById('selectedMiles');
			
		// Update the selected miles value when the slider value changes
		milesRangeInput.addEventListener('input', function() {
			selectedMilesSpan.value = milesRangeInput.value;
			const value = (milesRangeInput.value - milesRangeInput.min) / (milesRangeInput.max - milesRangeInput.min) * 100;
			console.log(value);
			milesRangeInput.style.background = 'linear-gradient(to right, #ff6c00 0%, #ff6c00 '+value+'%, #e0dcd7 '+value+'%, #e0dcd7 100%)';
		});
	});

		
	function toggleAllDay(){
		$('.allDay').each(function(){
			var thisCheck = $(this);
			var row = thisCheck.parents('.hoo').find('.row');
			if(thisCheck.is(":checked")){
				row.hide();
			}else{
				row.show();
			}
		});
	}
	$('body').on('click', '.allDay', function(){
		toggleAllDay();
	});	
	function attachLocation(){
		$('select.location').selectize({
			valueField: 'id',
			labelField: 'location',
			searchField: 'location',
			preload: true,
			create: false,
			render: {
				option: function(item, escape) {
					return '<div>'+escape(item.location)+'</div>';
				}
			},
			load: function(query, callback) {
				$.ajax({
					url: '<?php echo base_url(); ?>/providerauth/get-locations?q=' + encodeURIComponent(query),
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
	function change_categories_skills(_this,user_id){
		$(".load_categories_skills").html('');
		$(".load_category_offering").html('');
		var category_id = $(_this).val()
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>/providerauth/get-categories-skills',
			data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',category_id:category_id,user_id:user_id},   
			dataType: 'HTML',			
			success: function (data) {	
				$(".load_categories_skills").html(data);       
			}
		});	
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>/providerauth/get-category-offering',
			data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',category_id:category_id,user_id:user_id},   
			dataType: 'HTML',			
			success: function (data) {  	
				$(".load_category_offering").html(data);       
			}
		});		
	}
	function getComboA(selectObject) {
	  var value = $(selectObject).val(); 
		if(value == 2){
			$('#address').removeClass('required');
			$('#address').val('');
			$('#address').hide();
			$('#load_location_field').hide();
		}else{
			$('#address').addClass('required');
			$('#address').val('');
			$('#address').show();
			$('#load_location_field').show();
		}
	}
	function getComboB(selectObject) {
	  var value = $(selectObject).val(); 
		if(value == 1){
			$('.slider-container').hide();
		}else{
			$('.slider-container').show();
		}
	}
	let autocomplete;
let address1Field;
let address2Field;
let postalField;

function initAutocomplete() {
	const input = document.getElementById("pac-input");
	const options = {
		fields: ["place_id", "rating"],
		strictBounds: false,
	};
	const autocomplete1 = new google.maps.places.Autocomplete(input, options);
	autocomplete1.addListener("place_changed", () => {			
		const place = autocomplete1.getPlace();
		console.log(place);
		$('#place_id').val(place.place_id);
		$('#google_rating').val(place.rating);
	});
  address1Field = document.querySelector("#address");
  address2Field = document.querySelector("#address2");
  postalField = document.querySelector("#postcode");
  // Create the autocomplete object, restricting the search predictions to
  // addresses in the US and Canada.
  autocomplete = new google.maps.places.Autocomplete(address1Field, {
    componentRestrictions: { country: ["us", "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });
  address1Field.focus();
  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  const place = autocomplete.getPlace();
  let address1 = "";
  let postcode = "";
	document.getElementById('cityLat').value = place.geometry.location.lat();
	document.getElementById('cityLng').value = place.geometry.location.lng();

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
    // @ts-ignore remove once typings fixed
    const componentType = component.types[0];
console.log(component);
    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      case "postal_code": {
        postcode = `${component.long_name}${postcode}`;
        break;
      }

      case "postal_code_suffix": {
        //postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#locality").value = component.long_name;
        break;
      case "administrative_area_level_1": {
        document.querySelector("#state").value = component.long_name;
        break;
      }
      case "country":
        //document.querySelector("#country").value = component.long_name;
        break;
    }
  }

  address1Field.value = address1;
  postalField.value = postcode;
  
  //document.querySelector("#full_location").value = document.querySelector("#locality").value+', '+document.querySelector("#state").value+' '+postcode;
  
  //get location id
  $.ajax({
		type: "POST",
		url: '<?php echo base_url(); ?>/providerauth/get-location-id',
		data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',zipcode:postcode},   
		dataType: 'HTML',			
		success: function (data) { 
			if(data != ''){
				document.querySelector("#location_id").value = data;
			}	      
		}
	});	
	
	
  // After filling the form with address components from the Autocomplete
  // prediction, set cursor focus on the second address line to encourage
  // entry of subpremise information such as apartment, unit, or floor number.
  address2Field.focus();
}

window.initAutocomplete = initAutocomplete;
</script><script type="text/javascript">
$(document).ready(function () {
    //If image edit link is clicked
    $(".edit").on('click', function(e){
        e.preventDefault();
        $("#changePicture").trigger('click');
    });

    //On select file to upload
    $("#changePicture").on('change', function(){
        var image = $('#changePicture').val();
        var img_ex = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        
        //validate file type
        if(!img_ex.exec(image)){
            alert('Please upload only .jpg/.jpeg/.png/.gif file.');
            $('#changePicture').val('');
            return false;
        }else{
            $('.loader1').show();
			console.log($('#changePicture').files);
				var file  = $('#changePicture')[0].files[0];
				var form_data = new FormData();
				form_data.append("upload", file);
				$.ajax({
					url: '<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/'+'<?php echo session()->get('vr_sess_user_id'); ?>',
					data: form_data,
					type: 'POST',
					dataType: 'JSON',
					processData: false,
					contentType: false,
					cache: false,
					enctype: 'multipart/form-data',
					beforeSend: function(){
						$('.loader1').show();
					},
					success: function(response){
						$('.loader1').hide();
						if(response.uploaded == 1){
							$("#changePicture").val(null);
							$('.proPic1').attr('src',response.url);
							$('.proPic').find('img').attr('src',response.url);	
							
							$.ajax({
								url: '<?php echo base_url(); ?>/providerauth/photos_post',
								data: {check:'5',image:response.fileName},
								type: 'POST',
								dataType: 'HTML',
								success: function(response){
									if(response != ''){
										$(".load-images").html(response);
									}
									$("#imageListId").sortable({
										update: function(event, ui) {
												getIdsOfImages();
											} //end update	
									});	
									$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));										
								}
							})						
							
							$(".upload-loading-success").html('Updated Successfully!');
							$(".upload-loading-success").show().delay(5000).fadeOut();
						}else{
							$(".upload-loading-error").html(response.error);
							$(".upload-loading-error").show().delay(5000).fadeOut();
						}
					}
				}) 
			
        }
    });
});

</script>
<?= $this->endSection() ?>