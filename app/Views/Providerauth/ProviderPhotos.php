<?= $this->section('content') ?>
    <div class="proPhotos bg-gray pt-2 pb-4 pb-xl-5">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.css">
	<style>
	.bootstrap-tagsinput .badge {
		color: #797979;
	}	
/*	ul#imageListId li:first-child:after {
    content: "Profile Picture";
    background-color: #ffffffe0;
    top: 27%;
    position: absolute;
    display: inline-block;
	right: calc(var(--bs-gutter-x) * .5);
    left: calc(var(--bs-gutter-x) * .5);
	color: #000;
	transform: rotate(317deg);
    font-size: 0.7rem;
    text-align: center;
} */
.bootstrap-tagsinput{
border-color: #b3b3b3;
    border-radius: 50px !important;
    box-shadow: none;
    font-size: 14px;
    padding: 15px 30px 15px 20px;
	}
	#upload-image-i {
	background:#e1e1e1;
	width:300px;
	padding:30px;
	height:300px;
}
.image-container {
  position: relative;
  display: inline-block; /* Ensure container fits the size of the image */
}

.icon-container {
  position: absolute;
  top: 33%; /* Adjust the positioning as needed */
  left: 39%; /* Adjust the positioning as needed */
  color: white; /* Color of the icon */
  background-color: rgba(0, 0, 0, 0.5); /* Background color for icon container */
  padding: 5px;
  border-radius: 6px; /* To make it a circle, adjust size if needed */
}

.icon-container i {
  font-size: 24px; /* Adjust the size of the icon */
}
	</style>
	<?= $this->extend('layouts/main') ?>
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-3 mb-xl-4">
			<h3 class="title-lg text-black mb-0 mb-sm-5">My <?php echo $title; ?></h3>
		</div>
		<div class="container">
			<div class="row">
				<div class="leftsidecontent col-12 col-sm-4 col-lg-3">
				<?php echo $this->include('Common/_sidemenu') ?>
				</div>
				<div class="col-12 col-sm-8 col-lg-9">
					<div class='row'>
					
       <!-- <link href="http://localhost/pando/inc/themes/backend/Stackmin/Assets/plugins/fancybox/jquery.fancybox.min.css" rel="stylesheet" type="text/css"></link>
        <script src="http://localhost/pando/inc/themes/backend/Stackmin/Assets/plugins/fancybox/jquery.fancybox.min.js"></script>
					<button type="button" href="javascript:void(0)" class="fm-edit p-l-5 image-editor-btn" data-fancybox data-src="http://localhost/pando/file_manager/editor/6597b689ad077/compose" data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"height" : "100%"}}}'><i class="fad fa-pencil-alt"></i></button>	-->
					
						<div class='col-12 <?php if(!empty($user_photos)){ ?>col-sm-6<?php }else{ ?>col-sm-6<?php } ?>'>
							<h3 class="title-sm dblue border-bottom change-title">Add Photo</h3>
							<form action='<?php echo base_url(); ?>/providerauth/photos' class='panel mb-4' id="photoupload" method='post' enctype='multipart/form-data'>
								<input type="text" data-role="tagsinput" class="form-control mb-2" value="" id="image_tag" name="image_tag" placeholder="Enter Tag" class="image_tag" />
								<div class="d-flex justify-content-space align-items-center mt-3">
									<input type='file' id="userphoto" name='uploads[]' <?php echo ($user_detail->plan_id == '3' ? 'multiple' : '') ?> class="cropimage <?php echo ($user_detail->plan_id == '3' ? 'cmul' : '') ?>" >
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
							</form>
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
						<!--<a href='<?php echo base_url(); ?>/providerauth/dashboard' class='btn mt-5 w-auto m-auto'>I'm Done, Go to my Dashboard</a>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	
		
<div id="crop-image" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-solid-warning justify-content-start p-4">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5"><i class="fa-solid fa-xmark"></i></a>
			<h6 class="ms-2 mb-0">Crop Image</h6>
			</div>
			<div class="modal-body p-4">
			<div class="row">
						
					<div class="col-md-12 load-images1 d-none">
						
					</div>	
				<div class="col-md-12 text-center">
					<div id="upload-image"></div>
				</div>
				<div class="col-md-12 mb-2 text-center">					
				<button class="btn bg-orange cropped_image" style="font-size: 13px;" data-id="">Crop</button>
				</div>	
				<!--<div class="final-result-container">	
				<h5>Final Result:</h5>
				<div class="col-md-12 load-images-final d-flex">
				</div>
				</div>-->
			</div>	
			</div>
			<!--<div class="modal-footer p-4" style="flex-wrap: nowrap;">
				<button type="button" data-bs-dismiss="modal" style="font-size: 13px;" class="btn btn-secondary m-0">Cancel</button>
				<button class="btn bg-orange csimage cropped_image_save" style="font-size: 13px;" data-id="">Ok</button>				
			</div>-->
		</div>
	</div>
</div>

<div class="loader"></div>
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