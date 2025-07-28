<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="bg-grey d-flex flex-column flex-lg-row">
        <?php echo $this->include('Common/_messages') ?>
		<div class="leftsidecontent" id="stickySection">
			<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3 mb-5">
			<div class="container-fluid">
				<div class="titleSec">
					<h3 class="title-lg fw-bolder my-4"><?php echo $title; ?></h3>
				</div>
				<div class="row row-gap-3">
					<div class="col-md-4 pe-md-0">
						<div class="dbContent h-100">
						<div class="text-center mb-4">

								<div class="proPic" id="upload-icon" style="cursor: pointer;">

									<img class="uimg" src="<?php echo ($user_detail->avatar) ? base_url().'/uploads/userimages/'.$user_detail->id.'/'.$user_detail->avatar : base_url('assets/frontend/images/user-pic.png'); ?>" alt="user pic"/>

									<a href="javascript:void(0);"><img src="<?php echo base_url('assets/frontend/images/addpic.png'); ?>" alt="Add Icon"/></a>

								</div>

								<p class="TwCenMT fw-bold fs-6 mt-3">Upload Profile Photo / Logo</p>

							</div>
							<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								<button class="nav-link active" id="account-details-tab" data-bs-toggle="pill" data-bs-target="#account-details" type="button" role="tab" aria-controls="account-details" aria-selected="true">Account Details</button>
								<button class="nav-link" id="update-password-tab" data-bs-toggle="pill" data-bs-target="#update-password" type="button" role="tab" aria-controls="update-password" aria-selected="false">Update Password</button>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="dbContent h-100">
							<div class="container">
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" id="account-details" role="tabpanel" aria-labelledby="account-details-tab">
										<form id="edit-account-form" method="post" action="<?php echo base_url(); ?>/providerauth/edit-account-post">
										<?php echo csrf_field() ?>
										<input type="hidden" name="id" value="<?php echo $user_detail->id ?>">
										<fieldset class="form-input">				
											<h4 class="title-sm text-center mb-4 mb-md-5 fw-bolder">Basic Info</h4>
											<div class="form-section d-sm-flex row-cols-1 row-cols-sm-2 gap-2">
											<div class="p-0">
												<div class="form-section d-flex gap-2">
													<div class="form-group">
														<input class="form-control required" type="text" id="first_name" name="first_name" placeholder="<?php echo trans('form_firstname') ?>" value="<?php echo $user_detail->first_name ?>">
													</div>
													<div class="form-group">
														<input class="form-control required" type="text" id="last_name" name="last_name" placeholder="<?php echo trans('form_lastname') ?>" value="<?php echo $user_detail->last_name ?>">
													</div>
												</div>
												<div class="form-group">
													<input class="form-control required" type="text" id="mobile_no" name="mobile_no" placeholder="<?php echo trans('Telephone Number') ?>" value="<?php echo $user_detail->mobile_no ?>">
												</div>
												<div class="form-group">
													<input class="form-control required email" type="email" id="email" name="email" placeholder="<?php echo trans('form_email') ?>" value="<?php echo $user_detail->email ?>">
												</div>
												<div class="form-group">
													<input type="file" id="profile-pic-input" name="profile_picture" accept="image/*">													
															<!-- Custom File Trigger -->
													<label for="profile-pic-input" class="choose-file-button">Choose Profile Image</label>
												</div>
												<div class="form-section d-flex gap-2">
													<div class="form-group">
														<input class="form-control required" type="text" id="city" name="city" placeholder="<?php echo trans('City') ?>" value="<?php echo $user_detail->city ?>">
													</div>
													<div class="form-group">
														<input class="form-control required" type="text" id="state" name="state" placeholder="<?php echo trans('State') ?>" value="<?php echo $user_detail->state ?>">
													</div>
												</div>
											</div>
												<div class="p-0">
													<div class="form-group">
														<input class="form-control" type="text" id="business_name" name="business_name" placeholder="Company Name (optional)" value="<?php echo $user_detail->business_name ?>">
													</div>
													<div class="form-group">
														<input class="form-control" type="text" id="website" name="website" placeholder="Website (optional)" value="<?php echo $user_detail->website ?>">
													</div>
													<div class="form-group">
														<input class="form-control" type="text" id="facebook" name="facebook_link" placeholder="Facebook (optional)" value="<?php echo $user_detail->facebook_link ?>">
													</div>
													<div class="form-group">
														<input class="form-control" type="text" id="linkedin" name="linkedin_link" placeholder="LinkedIn (optional)" value="<?php echo $user_detail->linkedin_link ?>">
													</div>
													<div class="form-group">
														<input class="form-control" type="text" id="instagram" name="insta_link" placeholder="Instagram (optional)" value="<?php echo $user_detail->insta_link ?>">
													</div>
													
												</div>
												
											</div>	
											<div class="form-group w-100">
													<textarea class="w-100" name="about_me" placeholder="About Seller (optional)"><?php echo $user_detail->about_me ?></textarea>
												</div>
											<input type="submit" class="btn" value="Save Details" />				
										</fieldset>
										</form>
									</div>
									<div class="tab-pane fade" id="update-password" role="tabpanel" aria-labelledby="update-password-tab">
										<form id="edit-password-form" method="post" action="<?php echo base_url(); ?>/providerauth/edit-password-post">
											<input type="hidden" name="id" value="<?php echo $user_detail->id ?>">
											<fieldset class="form-input">					
												<h4 class="title-sm text-center mb-4 mb-md-5 fw-bolder">Update Password</h4>
												<div class="form-section row row-cols-1">						
													<div class="form-group">
														<input class="form-control required" type="password" id="current_password" name="current_password" placeholder="<?php echo trans('Current Password') ?>">
													</div>					
													<div class="form-group">
														<input class="form-control required" type="password" id="new_password" name="new_password" placeholder="<?php echo trans('New Password') ?>">
													</div>
													<div class="form-group">
														<input type="password" name="confirm_new_password" class="form-control required" placeholder="<?php echo trans("Confirm New Password"); ?>" data-parsley-equalto="#new_password">
													</div>
												</div>	
												<input type="submit" class="btn" value="Change" />					
											</fieldset>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		</div>
		

<script>
$(document).ready(function () {
	var activeTab = "<?= session()->getFlashdata('activeTab') ?>";

	if (activeTab === "update-password") {
		// Remove existing active classes
		$('#v-pills-tab .nav-link').removeClass('active').attr('aria-selected', 'false');
		$('.tab-pane').removeClass('show active');

		// Activate the "Update Password" tab
		$('#update-password-tab').addClass('active').attr('aria-selected', 'true');
		$('#update-password').addClass('show active');
	}
});
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

</script>
<?= $this->endSection() ?>