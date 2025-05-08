<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- reCAPTCHA JS-->
<script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>"></script>
<!-- Include script -->
<script type="text/javascript">
	grecaptcha.ready(function() {
		 grecaptcha.execute("<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>", {action: 'validate'}).then(function(token) {
			  // Store recaptcha response
			  $("#g-recaptcha-response").val(token);

		 });
	});
</script>

    <div class="plan bg-gray pt-2 pb-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-3 mb-xl-4">
			<h3 class="title-lg dblue mb-0 mb-sm-5"><?php echo $title; ?></h3>
		</div>
		<div class="container">
			<div class="row">
			<div class="leftsidecontent col-12 col-sm-4 col-lg-3">
			<?php echo $this->include('Common/_sidemenu') ?>
			</div>
			<div class="col-12 col-sm-8 col-lg-9">
			<form id="aircraft-add-form" method="post" action="<?php echo base_url(); ?>/add-listing-post" style="display: none;">
					<?php echo csrf_field() ?>
					<input type="hidden" name="category_id" value="<?php echo $_GET['type']; ?>">
                        <h3></h3>
                        <fieldset class="form-input">
						
							<div class="form-section">
								<div class="form-group">
									<select name="sub_category_id" class="form-control required my-4" required>
										<option value=""><?php echo trans('Select Category') ?></option>
										<?php
										if(!empty($sub_categories)){
											foreach($sub_categories as $category){ ?>
												<option value="<?php echo $category->id; ?>" <?php echo (old('category_id') == $category->id) ? 'selected':''; ?>><?php echo $category->name; ?></option>
										<?php }
										}
										?>
									</select>
									<?php 
									if(!empty($dynamic_fields)){
										foreach ($dynamic_fields as $groupName => $dynamic_field): ?>
										<h5><?= esc($groupName) ?></h5>
										<?php $dynamic_fields_values = json_decode($user_detail->dynamic_fields,true);
										
										echo '<div class="row  mt-3">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
											<div class="form-section row row-cols-1 row-cols-md-2">';
										foreach($dynamic_field as $field){
											$req_op = ($field->field_condition) ? '*' : '(optional)';
											$req_op_text = ($field->field_condition) ? 'required' : '';
											echo '<div class="form-group pr-2 d_fields" data-category="'.$field->category_ids.'" data-subcategory="'.$field->subcategory_ids.'">
													<label class="mb-0">'.$field->name.' '.$req_op.'</label>';
													if($field->field_type == 'Text'){
														echo '<input type="text" name="dynamic_fields['.$field->id.']" class="form-control" placeholder="'.$field->name.'" value="'. (!empty($dynamic_fields_values[$field->name]) ? $dynamic_fields_values[$field->name] : '').'" '.$req_op_text.'>';
													}else if($field->field_type == 'Textarea'){
														echo '<textarea name="dynamic_fields['.$field->id.']" class="form-control" placeholder="'.$field->name.'" '.$req_op_text.'>'. (!empty($dynamic_fields_values[$field->name]) ? $dynamic_fields_values[$field->name] : '').'</textarea>';
													}else if($field->field_type == 'Checkbox'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<div class="row">';
															foreach($decoded_option as $oi => $option){
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex"><input type="checkbox" name="dynamic_fields['.$field->id.'][]" id="status_'.$oi.'" class="" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && in_array($option, $dynamic_fields_values[$field->name]) ) ? 'checked' : '').'  '.$req_op_text.'><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
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
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex"><input type="radio" name="dynamic_fields['.$field->id.']" id="status_'.$oi.'" class="" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && $option== $dynamic_fields_values[$field->name]) ? 'checked' : '').'  '.$req_op_text.'><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
															}	
															echo '</div>';															
														}else{
															echo 'Options not available';
														}
													}else if($field->field_type == 'Dropdown'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														$option_html = '';
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<select class="form-control" name="dynamic_fields['.$field->id.']"  '.$req_op_text.'><option value="">--Select--</option>';
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
									endforeach; 
									}									
									?>
								</div>
							</div>
                        </fieldset>

                        <h3></h3>
                        <fieldset class="form-input">
                            <h3 class="title-xl black my-3"><?php echo trans('Photos and Videos') ?></h3>
							<div class="form-section">
								<div class="form-group">
							<div class='row'>
					
					
						<div class='col-12 <?php if(!empty($user_photos)){ ?>col-sm-6<?php }else{ ?>col-sm-6<?php } ?>'>
							<h3 class="title-sm dblue border-bottom change-title">Add Photo</h3>
							
								<input type="text" data-role="tagsinput" class="form-control mb-2" value="" id="image_tag" name="image_tag" placeholder="Enter Tag" class="image_tag" />
								<div class="mt-0">
									<input type='file' id="userphoto" name='uploads[]' <?php echo ($user_detail->plan_id == '3' ? 'multiple' : '') ?> class="cropimage w-100 <?php echo ($user_detail->plan_id == '3' ? 'cmul' : '') ?>" >
									<img class="change-button load-edit-image" width="20%" src="" style="display:none"/>
									<input type='button' value='Upload' class='btn photoupload'>
								</div>
								<div class="d-flex justify-content-between align-items-center mt-3">
									<input type='button' value='Cancel' onclick="cancel_edit()" class='btn bg-orange change-button' style="display:none">
									<input type='button' value='Update' data-id="" class='btn change-button  photouploadupdate' style="display:none">
								</div>
								<p class="upload-loading" style="display:none">Uploading...</p>
								<p class="upload-loading-success text-success" style="display:none"></p>
								<p class="upload-loading-error text-danger" style="display:none"></p>
				<div class="final-result-container">
					<div class="col-md-12 load-images-final d-flex flex-wrap">
					</div>
					<div class="col-md-12 load-images1 d-flex" style="opacity:0">
						
					</div>	

				<div class="csimage cropped_image_save" data-id=""></div>					
				</div>
						</div>
					
						<div class='col-12 <?php if(!empty($user_photos)){ ?>col-sm-6<?php }else{ ?>col-sm-6<?php } ?>'>
							<h3 class="title-sm dblue border-bottom">Current Photo<?php if(!empty($user_photos)){ echo 's'; } ?></h3>
							<div class='load-images'>
								<?php if(!empty($user_photos)){ ?>
								<?php if(count($user_photos) > 1){ ?>
								<p>(<?php echo trans('Drag and drop to organize your photos'); ?>)</p>
								<?php } ?>
								<ul class="row" id="imageListId">
								<?php
									foreach($user_photos as $r => $row){
										echo "<li class='col-6 col-md-3 listitemClass' id='imageNo".$row['id']."'><div class='pic'>";
										echo "<img width='100%' height='150px' src='".base_url()."/uploads/userimages/".session()->get('vr_sess_user_id')."/".$row['file_name']."'></div><div class=' d-flex  justify-content-between bg-orange'><div class='trash' onclick='editphotos(".$row['id'].",this)' data-id='".$row['id']."' data-tags='".$row['image_tag']."' style='cursor:pointer'><i class='fa fa-pen'></i></div><div class='trash' onclick='deletephotos(".$row['id'].")' data-id='".$row['id']."' style='cursor:pointer'><i class='fa fa-trash-o'></i></div></div></li>";
									}
								?>
								</ul>
								<?php 
								}else{
									echo 'please upload.';
								} ?>
							</div>
						</div>
							</div>
						</div>
					</div>
                        </fieldset>

                        <h3></h3>
                        <fieldset class="form-input">
						<div class="titleSec">
                            <h3 class="title-xl black mb-0"><?php echo trans('Seller Information') ?></h3>
							</div>
							<div class="form-section">
                            <div class="form-group">
                                <input class="form-control" type="text" id="business_name" name="business_name" placeholder="<?php echo trans('Business Name(if applicable)') ?>" value="<?php echo old('business_name') ?>">
                            </div>													
                            <div class="form-group">
                                <input class="form-control required" type="text" id="phone" name="phone" placeholder="<?php echo trans('Phone') ?>" autocomplete="off" value="<?php echo old('phone') ?>" >
                            </div>													
                            <div class="form-group">
                                <input class="form-control required" type="text" id="address" name="address" placeholder="<?php echo trans('Address') ?>" autocomplete="off" value="<?php echo old('address') ?>" >
                            </div>	  
                            <div class="form-group">
                                <input class="form-control" type="text" id="address2" name="suite" placeholder="<?php echo trans('Suite, Apartment, etc') ?>" value="<?php echo old('suite') ?>" >
                            </div>
							<div class="form-group row">
                            <div class="col-12 col-md-5 pr-md-0">							
								<input type="text" value="" placeholder="City" name='locality' id="locality" class='form-control required' />
                            </div>
                            <div class="col-12 col-md-4 px-md-1">							
								<input type="text" value="" placeholder="State" name='state' id="state" class='form-control required' />
                            </div>
                            <div class="col-12 col-md-3 pl-md-0">							
								<input type="text" value="" placeholder="Zip Code" name='postcode' id="postcode" class='form-control required' />
                            </div>
							</div>
							
							
							<input type="hidden" id="g-recaptcha-response"  class="form-control required" name="check_bot" value="" >
							
							<input type="hidden" name="register_plan" value="<?php echo !empty(session()->get('selected_plan_id')) ? session()->get('selected_plan_id') : 1; ?>" >

                            </div>
                        </fieldset>
                    </form> 
			</div>
			</div>
		</div>
		</div>
<script>
	$(document).ready(function(){
	});
	function deletephotos(photo_id){
		$.confirm({
			title: 'Confirm Deletion',
			content: 'Are you sure you want to delete this photo?',
			buttons: {
				confirm: function () {
					$.ajax({
						url: '<?php echo base_url(); ?>/providerauth/photos_delete',
						data: {photo_id:photo_id},
						type: 'POST',
						dataType: 'HTML',
						success: function(response){
							if(response != ''){
								$(".load-images").html(response);
								$(".upload-loading-success").html('Deleted Successfully!');
								$(".upload-loading-success").show().delay(5000).fadeOut();
							}	
							$("#imageListId").sortable({
								update: function(event, ui) {
										getIdsOfImages();
									} //end update	
							});	
							if($('.listitemClass:first-child').find('img').attr('src') === undefined){
								//$('.proPic').find('img').attr('src','<?php echo base_url().'/assets/frontend/images/user.png'; ?>');
							}else{
								//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));
							}
								
														
						}
					})
				},
				cancel: function(){
					
				}
			}
		});
	}
	function editphotos(photo_id,_this){
		$('.final-result-container').hide();
		$("#userphoto").val(null);		
		$("#image_tag").tagsinput('removeAll');
		$('#image_tag').tagsinput('add', $(_this).attr('data-tags'));
		$('#image_tag').tagsinput('refresh');
		$('.change-button').show();
		$('.photoupload').hide();
		$('.change-title').html('Edit Photo');
		$('.photouploadupdate').attr('data-id',photo_id);
		$('.load-edit-image').attr('src',$(_this).closest('li').find('img').attr('src'));
		$('.csimage').removeClass('cropped_image_save');
		$('.csimage').addClass('cropped_image_save_edit');
		$('#userphoto').removeAttr('multiple');
	}
	function cancel_edit(){		
		$("#image_tag").tagsinput('removeAll');
		$('.change-button').hide();
		$('.photoupload').show();
		$('.change-title').html('Add Photo');
		$('.photouploadupdate').attr('data-id','');
		$('.load-edit-image').attr('src','');
		$('.csimage').addClass('cropped_image_save');
		$('.csimage').removeClass('cropped_image_save_edit');
		$("#userphoto").val(null);	
		if ($("#userphoto").hasClass("cmul")) {
			$('#userphoto').attr('multiple',true);
		}
	}
	function editphotospost(_this){
		var p_id = $(_this).attr('data-id');
		console.log(p_id);
		console.log($('#userphoto').get(0).files.length);
		if ($('#userphoto').get(0).files.length === 0) {
			console.log("No files selected.");
			$.ajax({
				url: '<?php echo base_url(); ?>/providerauth/photosedit_post',
				data: {p_id:p_id,image_tag:$("#image_tag").val()},
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
					//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));					
					$("#image_tag").tagsinput('removeAll');						
					$(".upload-loading-success").html('Updated Successfully!');
					$(".upload-loading-success").show().delay(5000).fadeOut();	
					$('.final-result-container').hide();									
				}
			})
		}else{
			var form_data = new FormData();
			form_data.append("upload", $('#userphoto').get(0).files);
							   
			var dataf = new FormData($("#photoupload")[0]);
			var imgt = $("#image_tag").val();
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
					$('.upload-loading').show();
				},
				success: function(response){
					$('.upload-loading').hide();
					if(response.uploaded == 1){
						$("#userphoto").val(null);
						$.ajax({
							url: '<?php echo base_url(); ?>/providerauth/photosedit_post',
							data: {p_id:p_id,image:response.fileName,image_tag:imgt},
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
								//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));								
							}
						})
						$("#image_tag").tagsinput('removeAll');
						
						$(".upload-loading-success").html('Updated Successfully!');
						$(".upload-loading-success").show().delay(5000).fadeOut();
						$('.final-result-container').hide();
					}else{
						$(".upload-loading-error").html(response.error);
						$(".upload-loading-error").show().delay(5000).fadeOut();
					}
				}
			}) 
		}	
			
		$("#image_tag").tagsinput('removeAll');
		$('.change-button').hide();
		$('.photoupload').show();
		$('.change-title').html('Add Photo');
		$('.photouploadupdate').attr('data-id','');
		$('.load-edit-image').attr('src','');
		$('.csimage').addClass('cropped_image_save');
		$('.csimage').removeClass('cropped_image_save_edit');
		if ($("#userphoto").hasClass("cmul")) {
			$('#userphoto').attr('multiple',true);
		}
		
	}
	$(function() {
		$("#imageListId").sortable({
			update: function(event, ui) {
					getIdsOfImages();
				} //end update	
		});
	});
	function getIdsOfImages() {
		var values = [];
		$('.listitemClass').each(function(index) {
			values.push($(this).attr("id")
						.replace("imageNo", ""));
		});
		$('#outputvalues').val(values);
		$.ajax({
			url: '<?php echo base_url(); ?>/providerauth/photos_post',
			data: {check:'3',ids:values},
			type: 'POST',
			dataType: 'HTML',
			success: function(response){		
				//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));
			}
		})
	}
	function load_croppie(_this) {		
		$('#upload-image').attr('data-id',$(_this).find('img').attr('data-id'));
		$('#upload-image').croppie('bind', {
			url: $(_this).find('img').attr('src')
		}).then(function(){
			console.log('jQuery bind complete');
		});
		$('#crop-image').modal('show');
	}
	$(document).ready(function(){ 
	var myCroppie = $('#upload-image').croppie({
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
	$('#crop-image').on('shown.bs.modal', function(){	
		//$('#upload-image').attr('data-id',$('#upload-image').attr('data-id'));			
		myCroppie.croppie('bind',{
			url: $(".test"+$('#upload-image').attr('data-id')).find('img').attr('src')
		});
	});
	$('#crop-image').on('hide.bs.modal', function(){ 
		//$("#image_tag").tagsinput('removeAll');
		//$("#userphoto").val(null);
		myCroppie.croppie('bind',{
			url: ''
		});
	});

	/*$('.cropimage').on('change', function () { 
		$('#crop-image').modal('show'); 
		$('.cropped_image').attr('data-id',$(this).attr('data-id'));
		$('.cropped_image').attr('data-url',$(this).attr('data-url'));
	});*/
	var fileList = [];
	$('.cropimage').on('click', function (event) {
		fileList = [];
		$('.load-images1').html('');
		$('.load-images-final').html('');
		$('.final-result-container').hide();
		console.log(fileList);
		/*if($("#image_tag").val() == ''){
			$(".upload-loading-error").html('Please add tags to your photo.');
			$(".upload-loading-error").show().delay(5000).fadeOut();$('#crop-image').modal('hide');
			event.preventDefault();
		}else{
			
		}*/
						
	})					
	$('.cropimage').on('change', function (event) {
		//$('#crop-image').modal('show'); 
		if (event.target.files.length) {
			var i = 0;
			var index = 0;
			for (let singleFile of event.target.files) {
				
				var reader = new FileReader();
				reader.onload = function (e) {
					$('.load-images1').append('<div class="p-2 test'+i+'"><a onclick="load_croppie(this)" href="javascript:void(0);"><img data-id="'+i+'" width="150px" height="150px" style="object-fit:scale-down" src="'+e.target.result+'" /></a></div>');
					$('.load-images-final').append('<div class="" style="padding: 2px !important;"><a onclick="load_croppie(this)" href="javascript:void(0);" class="fid-'+i+' image-container"><img width="150px" height="113px" style="object-fit:scale-down;border-radius: 25px;border: 1px solid #eee;"  data-id="'+i+'" src="'+e.target.result+'" /> <div class="icon-container"><i class="fa fa-crop"></i></div></a></div>');
					
					$('.final-result-container').show();
		
					i++;
				}
				fileList.push(singleFile);
				reader.readAsDataURL(singleFile);
			}
		}
		$('.cropped_image').attr('data-id',$(this).attr('data-id'));
		$('.cropped_image').attr('data-url',$(this).attr('data-url'));
	});
	
	$('.cropped_image').on('click', function (ev) {
		
		myCroppie.croppie('result', {
			type: 'blob',
			size: 'original',
			quality: 1
		}).then(function (response) {
			fileList[$('#upload-image').attr('data-id')] = response;
			console.log(fileList);
			var image = new Image();
			image.src = URL.createObjectURL(response);
			image.style.width = '150px';
			image.style.height = '113px';
			image.style.border = '1px solid #eee';
			image.style.borderRadius = '25px';
			image.style.objectFit ="scale-down";
			$('.fid-'+$('#upload-image').attr('data-id')).html(image);
			$('.fid-'+$('#upload-image').attr('data-id')).append('<div class="icon-container"><i class="fa fa-crop"></i></div>');
			
		});
	});	
	
	$(".cropped_image_save").on("click", function(){
		$('#crop-image').modal('hide'); 
	})
	$(".cropped_image").on("click", function(){
		$('#crop-image').modal('hide'); 
	})
	$(".open-image-modal").on("click", function(){
		$('#crop-image').modal('show'); 
	})
		$(".photoupload,.photouploadupdate").on("click", function(){
			console.log('1');
			if($("#image_tag").val() == ''){
				$(".upload-loading-error").html('Please add tags to your photo.');
				$(".upload-loading-error").show().delay(5000).fadeOut();$('#crop-image').modal('hide');
			}else{
			if ($(".csimage").hasClass("cropped_image_save")) {
			console.log('1');
			$.ajax({
				url: '<?php echo base_url(); ?>/providerauth/photos_post',
				data: {check:'1'},
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function(){
					$('.loader').show();
				},
				success: async function(response){
					if(response == '2'){
						$(".upload-loading-error").html('Please Upgrade your plan to upload more photos.');
						$(".upload-loading-error").show().delay(5000).fadeOut();$('#crop-image').modal('hide');
						$("#image_tag").tagsinput('removeAll');$("#userphoto").val("");
					}else{
						var imtg = $("#image_tag").val();
						// Read selected files
						 var form_data = new FormData();
						  var totalfiles = fileList.length;
						  console.log(totalfiles);
						  for (var index = 0; index < totalfiles; index++) {
							  console.log(fileList[index]);
							  form_data.delete("upload");
							   form_data.append("upload", fileList[index]);
						  
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
										$('.upload-loading').show();
									},
									success: function(response){
										$('.upload-loading').hide();
										if(response.uploaded == 1){
											$("#userphoto").val(null);
											$.ajax({
												url: '<?php echo base_url(); ?>/providerauth/photos_post',
												data: {check:'2',image:response.fileName,image_tag:imtg},
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
													//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));										
												}
											})
											
											$(".upload-loading-success").html('Uploaded Successfully!');
											$(".upload-loading-success").show().delay(5000).fadeOut();
										}else{
											$(".upload-loading-error").html(response.error);
											$(".upload-loading-error").show().delay(5000).fadeOut();
										}
										$('.loader').hide();
									}
								})
							
							
										if((index+1) == totalfiles){
											$("#image_tag").tagsinput('removeAll');
										}
						}
					}	
					$('.loader').hide();	$('#crop-image').modal('hide');
		$('.final-result-container').hide(); 	fileList = [];			
				}
				
			})	
			}else{
			console.log('2');
		var p_id = $('.photouploadupdate').attr('data-id');	

	 var form_data = new FormData();
	  var totalfiles = fileList.length;
	  for (var index = 0; index < totalfiles; index++) {
		  console.log(fileList[index]);
		  form_data.delete("upload");
		  form_data.append("upload", fileList[index]);
			var imtg = $("#image_tag").val();
		
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
				$('.upload-loading').show();$('.loader').show();
			},
			success: function(response){
				$('.upload-loading').hide();$('.loader').hide();
				if(response.uploaded == 1){
					$("#userphoto").val(null);
					$.ajax({
						url: '<?php echo base_url(); ?>/providerauth/photosedit_post',
						data: {p_id:p_id,image:response.fileName,image_tag:imtg},
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
							//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));											
						}
					})
					$('#crop-image').modal('hide'); 
		$('.final-result-container').hide();
					Swal.fire({
						text: "Updated Successfully!",
						icon: "success",
						confirmButtonColor: "#34c38f",
						confirmButtonText: "<?php echo trans("ok"); ?>",
					})
					//$(".upload-loading-success").html('Updated Successfully!');
					$(".upload-loading-success").show().delay(5000).fadeOut();
				}else{
					$('#crop-image').modal('hide'); 
					Swal.fire({
						text: response.error,
						icon: "error",
						confirmButtonColor: "#34c38f",
						confirmButtonText: "<?php echo trans("ok"); ?>",
					})
					//$(".upload-loading-error").html(response.error);
					$(".upload-loading-error").show().delay(5000).fadeOut();
				}
			}
		})
		
		$("#image_tag").tagsinput('removeAll');
		$('.change-button').hide();
		$('.photoupload').show();
		$('.change-title').html('Add Photo');
		$('.photouploadupdate').attr('data-id','');
		$('.load-edit-image').attr('src','');
		$('.csimage').addClass('cropped_image_save');
		$('.csimage').removeClass('cropped_image_save_edit');fileList = [];
		if ($("#userphoto").hasClass("cmul")) {
			$('#userphoto').attr('multiple',true);
		}
	  }
			}
		}
	});
});
</script>
<?= $this->endSection() ?>