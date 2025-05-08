<?= $this->extend('layouts/main') ?>



<?= $this->section('content') ?>
<style>
.stepsguide{
	height: 100%;
    border-radius: 8px 8px 8px 8px;
    padding: 0px;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 1px 4px 12px -2px rgb(47 46 45 / 48%);
}
</style>
<?php
$img = '';
if(!empty($user_detail->avatar)){
	$img = base_url()."/uploads/userimages/".$user_detail->id."/".$user_detail->avatar;
}else{ 
	$img =  base_url()."/assets/img/user.png";				
}

?>
<main class="pt-4 pt-sm-5">

	<div class="container">
		<div class="row">
			<div class="col-sm-12 pe-xl-5">
				<h4 class="title-md text-center">Thank you for signing up to Plane Broker!</h4>
				<p class="text-center mb-3 mb-md-4">View your dashboard and start finalizing your profile! If you have any inquiries or concerns, please reach out to our support team for assistance.</p>
						<h3 class="text-center" style="font-size:20px; font-weight: 900;margin-bottom: 0;">Important Steps to Get Started!</h3>
				<div class="row mt-3 mb-5">
					<div class="col-md-4 mt-3">
					<div class="stepsguide px-3 py-5">
						<div style="min-height: 120px;"><img src="<?php echo base_url()."/assets/img/photo.png"; ?>" alt="" style="display: block;"/></div>
						<p class="mt-3" style="font-size: 14px;line-height: 20px;text-align: center;min-height: 120px;">It’s important for potential customers to see a complete profile! Make sure to add your profile photo and additional photos of your work. You can add Tags to your photos so that customers can filter your gallery with ease.</p>
						<a href="<?php echo base_url(); ?>/providerauth/photos" style='display: inline-block; line-height: 14px; font-size: 12px;font-weight: 400;text-decoration: none;padding: 12px 50px;background-color: #000000; color: #ffffff;border-radius: 15px;'>Edit My Photos</a>
					</div>
					</div>
					<div class="col-md-4 mt-3">
					<div class="stepsguide px-3 py-5">
						<div style="min-height: 120px;"><img src="<?php echo base_url()."/assets/img/useredit.png"; ?>" alt="" style="display: block;"/></div>
						<p class="mt-3" style="font-size: 14px;line-height: 20px;text-align: center;min-height: 120px;">Finalize your profile by adding your hours of operations and rates. Make sure to review all your details to make sure your potential customers are viewing the correct information from your profile.</p>
						<?php $busine_name = !empty($user_detail->business_name) ? $user_detail->business_name : $user_detail->fullname ; ?>
						<a href="<?php echo base_url(); ?>/providerauth/edit-profile" style='display: inline-block; line-height: 14px; font-size: 12px;font-weight: 400;text-decoration: none;padding: 12px 50px;background-color: #000000; color: #ffffff;border-radius: 15px;'>Edit My Profile</a>
					</div>
					</div>
					<div class="col-md-4 mt-3">
					<div class="stepsguide px-3 py-5">
						<div style="min-height: 120px;"><img src="<?php echo base_url()."/assets/img/upload.png"; ?>" alt="" style="display: block;"/></div>
						<p class="mt-3" style="font-size: 14px;line-height: 20px;text-align: center;min-height: 120px;">Share your profile! <a href="<?php echo base_url(); ?>">planebroker.com</a> provides you with a unique profile that allows you to share with your current and potential customers. This serves as your own personal web page and one you should be product to share!</p>
						<a href="javascript:void(0)" onclick="open_social_share()" style='display: inline-block; line-height: 14px; font-size: 12px;font-weight: 400;text-decoration: none;padding: 12px 50px;background-color: #000000; color: #ffffff;border-radius: 15px;'>Share Profile</a>	
					</div>
					</div>
				</div>			
			</div>
		</div>
	</div>

</main>
	
<div id="social-share" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header bg-solid-warning justify-content-start p-4">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5"><i class="fa-solid fa-xmark"></i></a>
			<h6 class="ms-2 mb-0">Share Business</h6>
			</div>
			<div class="modal-body p-4">
			<img src="<?php echo $img; ?>" width="100%" class="rounded-4" />
			<h6 class="mb-0 text-black"><?php echo !empty($user_detail->business_name) ? $user_detail->business_name : $user_detail->fullname; ?></h6>						
			<p class="fs-7"><?php echo $user_detail->city.', '.$user_detail->state_code.' '.$user_detail->zipcode; ?></p>
			<!-- AddToAny BEGIN -->
			<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
			<a class="a2a_button_facebook w-100">Facebook</a>
			<a class="a2a_button_x w-100">Twitter</a>
			<a onclick="copyURI(event)" data-link="<?php echo base_url('/provider/'.$user_detail->clean_url); ?>" class="w-100" target="_top" rel="nofollow noopener" ><span class="a2a_svg a2a_s__default a2a_s_link a2a_img_text" style="background-color: rgb(136, 137, 144);"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="#fff" d="M7.591 21.177c0-.36.126-.665.377-.917l2.804-2.804a1.235 1.235 0 0 1 .913-.378c.377 0 .7.144.97.43-.026.028-.11.11-.255.25-.144.14-.24.236-.29.29a2.82 2.82 0 0 0-.2.256 1.056 1.056 0 0 0-.177.344 1.43 1.43 0 0 0-.046.37c0 .36.126.666.377.918a1.25 1.25 0 0 0 .918.377c.126.001.251-.015.373-.047.125-.037.242-.096.345-.175.09-.06.176-.127.256-.2.1-.094.196-.19.29-.29.14-.142.223-.23.25-.254.297.28.445.607.445.984 0 .36-.126.664-.377.916l-2.778 2.79a1.242 1.242 0 0 1-.917.364c-.36 0-.665-.118-.917-.35l-1.982-1.97a1.223 1.223 0 0 1-.378-.9l-.001-.004Zm9.477-9.504c0-.36.126-.665.377-.917l2.777-2.79a1.235 1.235 0 0 1 .913-.378c.35 0 .656.12.917.364l1.984 1.968c.254.252.38.553.38.903 0 .36-.126.665-.38.917l-2.802 2.804a1.238 1.238 0 0 1-.916.364c-.377 0-.7-.14-.97-.418.026-.027.11-.11.255-.25a7.5 7.5 0 0 0 .29-.29c.072-.08.139-.166.2-.255.08-.103.14-.22.176-.344.032-.12.048-.245.047-.37 0-.36-.126-.662-.377-.914a1.247 1.247 0 0 0-.917-.377c-.136 0-.26.015-.37.046-.114.03-.23.09-.346.175a3.868 3.868 0 0 0-.256.2c-.054.05-.15.148-.29.29-.14.146-.222.23-.25.258-.294-.278-.442-.606-.442-.983v-.003ZM5.003 21.177c0 1.078.382 1.99 1.146 2.736l1.982 1.968c.745.75 1.658 1.12 2.736 1.12 1.087 0 2.004-.38 2.75-1.143l2.777-2.79c.75-.747 1.12-1.66 1.12-2.737 0-1.106-.392-2.046-1.183-2.818l1.186-1.185c.774.79 1.708 1.186 2.805 1.186 1.078 0 1.995-.376 2.75-1.13l2.803-2.81c.751-.754 1.128-1.671 1.128-2.748 0-1.08-.382-1.993-1.146-2.738L23.875 6.12C23.13 5.372 22.218 5 21.139 5c-1.087 0-2.004.382-2.75 1.146l-2.777 2.79c-.75.747-1.12 1.66-1.12 2.737 0 1.105.392 2.045 1.183 2.817l-1.186 1.186c-.774-.79-1.708-1.186-2.805-1.186-1.078 0-1.995.377-2.75 1.132L6.13 18.426c-.754.755-1.13 1.672-1.13 2.75l.003.001Z"></path></svg></span>Copy Link</a>
			</div>
			<!-- AddToAny END -->
			</div>
			<!--<div class="modal-footer p-4">
				<button type="button" data-bs-dismiss="modal" class="btn btn-secondary m-0">Close</button>
				
			</div>-->
		</div>
	</div>
</div>	
<div class="alert text-white bg-success sticky-top alert alert-dismissible alert-dismissible" id="suc-alert" style="top: 10px;
    position: fixed;
    right: 20px;
    display: none;
    z-index: 9999;">
	<i class="icon fas fa-check me-2"></i> Copied to Clipboard !
</div>
<div class="loader"></div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

			<script>
			var a2a_config = a2a_config || {};
			a2a_config.onclick = 1;
			</script>
			<script async src="https://static.addtoany.com/menu/page.js"></script>	
<script>
function open_social_share(){
	$("#social-share").modal('show');
}
function copyURI(evt) {
    evt.preventDefault();
    navigator.clipboard.writeText(evt.target.getAttribute('data-link')).then(() => {
      /* clipboard successfully set */
	  $("#social-share").modal('hide');
	  $("#suc-alert").fadeIn().delay(2000).fadeOut();
    }, () => {
      /* clipboard write failed */
    });
}
</script>
<?= $this->endSection() ?>