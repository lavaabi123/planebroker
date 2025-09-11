<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/selectize/css/selectize.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/pickadate/themes/pickadate.min.css" /> 
<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/selectize/js/standalone/selectize.min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.time.js'></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/provider.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?>                        
                         <a class="btn btn-primary" href="<?php echo admin_url() . 'users?page='.$page; ?>"><?php echo trans('Back'); ?></a>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>users"><?php echo trans('users') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->            
            <?php echo $this->include('admin/includes/_messages') ?>

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-body px-0">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <?php echo form_open_multipart('admin/edit_user_post', ['id' => 'provider-form-edit', 'class' => 'custom-validation needs-validation']); ?>
                                    <input type="hidden" name="id" value="<?php echo html_escape($user_detail->id); ?>">
                                    <input type="hidden" id="crsf">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("First Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="first_name" id="first_name" class="form-control auth-form-input required" placeholder="<?php echo trans("First Name"); ?>" value="<?php echo html_escape($user_detail->first_name); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Last Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="last_name" id="last_name" class="form-control auth-form-input" placeholder="<?php echo trans("Last Name"); ?>" value="<?php echo html_escape($user_detail->last_name); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Company Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="business_name" id="business_name" class="form-control auth-form-input" placeholder="<?php echo trans("Company Name"); ?>" value="<?php echo html_escape($user_detail->business_name); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("email"); ?><span class="required"> *</span></label>
                                                <input type="email" name="email" id="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo html_escape($user_detail->email); ?>" parsley-type="email" required>
                                            </div>
                                        </div>

                                         <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Phone Number"); ?><span class="required"> *</span></label>
                                                <input type="text" name="mobile_no" id="mobile_no" class="form-control auth-form-input" placeholder="<?php echo trans("Phone Number"); ?>" value="<?php echo html_escape($user_detail->mobile_no); ?>" required>
                                            </div>
                                        </div>  
                                         <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("User Level"); ?><span class="required"> *</span></label>
												<select onchange="confirm_once(this)" name="user_level" class="form-control">
												<?php if($user_detail->user_level == 0 || $product_count == 0){ ?>
													<option value="0" <?php echo ($user_detail->user_level == 0) ? 'selected' : '' ; ?>>Standard User</option>
													<?php } ?>
													<option value="1" <?php echo !empty($user_detail->user_level) ? 'selected' : '' ; ?>>Captain User</option>
												</select>
                                            </div>
                                        </div> 
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_password"); ?> (Leave Blank to Keep the Same)</label>
                                                <input type="password" name="password" id="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                        </div> 
                                        <div class="col-6">
                                             <div class="form-group mb-3">
                                                <label><?php echo trans("form_confirm_password"); ?></label>
                                                <input type="password" name="password_confirm" id="password_confirm" class="form-control form-input" value="" placeholder="<?php echo trans("form_confirm_password"); ?>" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                        </div>
										<div class="col-6">
											<input class="form-control" type="text" id="city" name="city" placeholder="<?php echo trans('City') ?>" value="<?php echo $user_detail->city ?>">
										</div>
										<div class="col-6">
											<input class="form-control" type="text" id="state" name="state" placeholder="<?php echo trans('State') ?>" value="<?php echo $user_detail->state ?>">
										</div>
										<div class="col-6">
											<input class="form-control" type="text" id="website" name="website" placeholder="Website" value="<?php echo $user_detail->website ?>">
										</div>
										<div class="col-6">
											<input class="form-control" type="text" id="facebook" name="facebook_link" placeholder="Facebook" value="<?php echo $user_detail->facebook_link ?>">
										</div>
										<div class="col-6">
											<input class="form-control" type="text" id="linkedin" name="linkedin_link" placeholder="LinkedIn" value="<?php echo $user_detail->linkedin_link ?>">
										</div>
										<div class="col-6">
											<input class="form-control" type="text" id="instagram" name="insta_link" placeholder="Instagram" value="<?php echo $user_detail->insta_link ?>">
										</div>													
										
										<div class="col-6">
											<input class="form-control" type="text" id="tiktok_link" name="tiktok_link" placeholder="<?php echo trans('TikTok Link') ?>" value="<?php echo $user_detail->tiktok_link ?>">
										</div>
										<div class="col-6">
											<input class="form-control" type="text" id="youtube_link" name="youtube_link" placeholder="<?php echo trans('YouTube Link') ?>" value="<?php echo $user_detail->youtube_link ?>">
										</div>
										<div class="col-6">
											<div class="file-upload">
											<label class="dz-wrap" style="display:block !important;margin-left:0 !important;">
												<span>Upload Profile Photo</span><br />
												<span>(.png,.jpeg,.jpg)</span>
												<input type='file' id="profile-pic-input" name='profile_picture' class="choose-file-button w-100" accept=".jpg,.jpeg,.png">
											</label>
											</div>
											</label>
										</div>
										<div class="col-6">
											<div class="proPic" id="upload-icon" style="cursor: pointer;">
												<img class="uimg" width="100px" src="<?php echo ($user_detail->avatar) ? base_url().'/uploads/userimages/'.$user_detail->id.'/'.$user_detail->avatar : base_url('assets/frontend/images/user-pic.png'); ?>" alt="user pic"/>
											</div>
										</div>
										<div class="col-12 mt-3">
											<textarea class="form-control" name="about_me" placeholder="About Seller"><?php echo $user_detail->about_me ?></textarea>
										</div>
                                    </div>									
									
                                    <div class="form-group mb-3 float-right">
                                        <button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                                    </div>

                               <!-- </div> -->
                                <?php echo form_close(); ?>
                                
                                

                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <small><strong><span class="required"> *</span> Must be filled</strong></small>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div> <!-- end col -->

        </div>

        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript">
$(document).ready(function () {
    // Trigger input when "+" icon clicked
    $('#upload-icon').on('click', function () {
        $('#profile-pic-input').click();
    });

    // Handle file input change
    $('#profile-pic-input').on('change', function () {
        const fileInput = this;
        const fileName = fileInput.files[0]?.name || "No file chosen";
        $('#file-name').text(fileName);

        // Create FormData object
        const formData = new FormData();
        formData.append('upload', fileInput.files[0]);

        // Send via AJAX
        $.ajax({
            url: '<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/'+'<?php echo session()->get('vr_sess_user_id'); ?>', // Change to your upload route
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.uploaded == 1){
					$.ajax({
						url: '<?php echo base_url(); ?>/providerauth/upload_profile_photo',
						data: {image:response.fileName},
						type: 'POST',
						dataType: 'HTML',
						success: function(respdonse){
							$('#upload-icon').find('.uimg').attr('src',response.url);							
						}
					})
				}
            },
            error: function (xhr) {
                alert('Upload failed. Please try again.');
            }
        });
    });
});
function confirm_once(_this){
	var user_level = $(_this).val();
	if(user_level == 1){
		$.confirm({
			title: 'Selecting Captain User will move all existing listings under Captain Club',
			content: 'Do you want to proceed?',
			type: 'blue',
			buttons: {
				cancel: {
					text: 'Ok',
					btnClass: 'btn-default',
					action: function () {
					}
				}
			}
		});
	}
}
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
	
	
    $(".photoupload").on("click", function(){
        var data = {
            "check": '1',
            "id": <?php echo $user_detail->id;?>
        };
        data[csrfName] = $.cookie(csrfCookie);
        $.ajax({
            url: baseUrl +'/admin/providers/photos_post',
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function(response){
                if(response == '2'){
                    $(".upload-loading-error").html('Please Upgrade your plan to upload more photos.');
                    $(".upload-loading-error").show().delay(5000).fadeOut();
                }else{
                var dataf = new FormData($("#photoupload")[0]);
                dataf[csrfName] = $.cookie(csrfCookie);
                $.ajax({
                    url: baseUrl +'/fileupload.php?uploadpath=userimages/'+<?php echo $user_detail->id;?>,
                    data: dataf,
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
                             var data = {
                                "check": '2',
                                image:response.fileName,
                                "id": <?php echo $user_detail->id;?>
                            };
                            data[csrfName] = $.cookie(csrfCookie);
                            $.ajax({
                                url: baseUrl +'/admin/providers/photos_post',
                                data: data,
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
                                }
                            })                      
                            $(".upload-loading-success").html('Uploaded Successfully!');
                            $(".upload-loading-success").show().delay(5000).fadeOut();
                        }else{
                            $(".upload-loading-error").html(response.error);
                            $(".upload-loading-error").show().delay(5000).fadeOut();
                        }
                    }
                })
            }                   
            }
        })
        
    });    
});

function deletephotos(photo_id){    
    Swal.fire({
        text: "Are you sure you want to delete this photo?",
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: sweetalert_ok,
        cancelButtonText: sweetalert_cancel,

    }).then(function (response) {
        if (response.value) {
            var data = {
                "photo_id": photo_id,
                "id": <?php echo $user_detail->id;?>
            };
            data[csrfName] = $.cookie(csrfCookie);
            $.ajax({
                url: baseUrl +'/admin/providers/photos_delete',
                data: data,
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
                }
            })
        }else{
                $('#emailtemplate_id option[value=""]').prop('selected', true);
            }
        });
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

    var data = {
       "check": "3",
       ids:values,
       "id": <?php echo $user_detail->id;?>
    };
    data[csrfName] = $.cookie(csrfCookie);

    $.ajax({
        url: baseUrl +'/admin/providers/photos_post',
        data: data,
        type: 'POST',
        dataType: 'HTML',
        success: function(response){
                                                    
        }
    })
}

$(function() {
  $('input[name="admin_plan_end_date"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
	minDate:new Date(),
    minYear: parseInt(moment().subtract(1, 'years').format('YYYY'),10),
    maxYear: parseInt(moment().add(10, 'years').format('YYYY'), 10),
	autoUpdateInput: false,
  }).on("apply.daterangepicker", function (e, picker) {
        picker.element.val(picker.startDate.format(picker.locale.format));
    });
  // 1) Wire all existing
  document.querySelectorAll('.dz-wrap').forEach(wireDropZone);

  // 2) Wire dynamically added ones
  const observer = new MutationObserver(muts => {
    muts.forEach(m => {
      m.addedNodes.forEach(node => {
        if (node.nodeType !== 1) return;
        if (node.matches('.dz-wrap')) wireDropZone(node);
        node.querySelectorAll?.('.dz-wrap').forEach(wireDropZone);
      });
    });
  });
  observer.observe(document.body, { childList: true, subtree: true });

});
</script>

<style>
  .dz-wrap {
    border: 2px dashed #ccc;
    padding: 2rem;
    text-align: center;
    position: relative;
    border-radius: 20px;
    cursor: pointer;
  }

  .dz-wrap.over {
    background-color: #f0faff;
  }

  .dz-wrap input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
  }
</style>
<?php echo $this->endSection() ?>