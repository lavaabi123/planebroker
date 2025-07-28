<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- reCAPTCHA JS-->
<script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>"></script>

<!-- Include script -->
<script type="text/javascript">
	grecaptcha.ready(function() {
		 grecaptcha.execute("<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>", {action: 'validate'}).then(function(token) {
			 console.log(token);
			  // Store recaptcha response
			  $("#g-recaptcha-response").val(token);

		 });
	});
</script>
<style>
input.is-invalid, select.is-invalid, textarea.is-invalid {
    border: 1px solid red !important;
}
</style>
    <div class="front-login-box login-sec">
        <?php echo $this->include('Common/_messages') ?>
        <!-- /.login-logo -->
		
        <div class="row mx-0 align-items-stretch min-vh-100">
				<div class="col-md-6 leftSec p-5">
					<div class="mx-auto py-md-5">
					<h3 class="fw-bolder">New. Better. Modern.</h4>
					<hr/>
					<h3 class="fw-bolder">A Market Place<br/>
					for all things aviation.</h4>
					<p class="mt-3 mt-md-4 mb-3">Full dashboard for a seamless selling experience.</p>
					<img src="<?php echo base_url('assets/frontend/images/tab.png'); ?>" />
					</div>
				</div>
			
				<div class="col-md-6 rightSec p-5 py-md-2 align-self-center">
				
                <form id="example-advanced-form" method="post" action="<?php echo base_url(); ?>/user-signup-post">
                    <?php echo csrf_field() ?>
					<div class="form-section">
						<a href="<?= base_url(); ?>"><img src="<?php echo base_url('assets/img/logo.png'); ?>" /></a>
						<h5 class="text-black mt-4 mb-2 fw-bolder">Welcome! <span class="text-primary">Sign up</span></h5>
                   <fieldset class="form-input">
												
								<div class="form-section">
									<div class="form-group">
										<input class="form-control required" type="text" id="first_name" name="first_name" placeholder="<?php echo trans('form_firstname').'*'; ?>" value="<?php echo old('first_name') ?>">
									</div>
									<div class="form-group">
										<input class="form-control required" type="text" id="last_name" name="last_name" placeholder="<?php echo trans('form_lastname').'*'; ?>" value="<?php echo old('last_name') ?>">
									</div>
									<div class="form-group">
										<input class="form-control required email" type="email" id="email" name="email" placeholder="E-mail*" value="<?php echo old('email') ?>">
									</div>								
									<div class="form-group">
										<input class="form-control required" type="text" id="mobile_no" name="mobile_no" placeholder="<?php echo trans('Phone Number*') ?>" value="<?php echo old('mobile_no') ?>">
									</div>
									
									<div class="form-group">
										<input class="form-control required" type="password" id="password" name="password" placeholder="<?php echo trans('form_password').'*'; ?>">
									</div>
									<div class="form-group">
										<input type="password" name="confirm_password" class="form-control required" placeholder="<?php echo trans("form_confirm_password").'*'; ?>" data-parsley-equalto="#password">
									</div>
									
									<input type="hidden" name="role" value="3">
									
								</div>	
								<input type="hidden" id="g-recaptcha-response"  class="form-control required" name="check_bot" value="" >
								<input type="hidden" name="register_plan" value="<?php echo !empty(session()->get('selected_plan_id')) ? session()->get('selected_plan_id') : 1; ?>" >					
							</fieldset>

						<button type="submit" class="btn py-3 col-12 my-4"><?php echo trans("Sign up"); ?></button>
						<p class="text-muted fs-6 mb-0">Already have an account? <a href="<?php echo base_url(); ?>/login" class="text-decoration-underline fs-6 text-primary"><?php echo trans("Sign in now"); ?></a></p>
					</div>
                </form>
				</div>


                

            
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
<?= $this->endSection() ?>