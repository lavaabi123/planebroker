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
	<style>
	.form-input .form-section .form-group select.form-control {
		background: #fff url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'><path fill='%23989393' d='M2 0L0 2h4zm0 5L0 3h4z'/></svg>") right .75rem center/8px 10px no-repeat!important;
	}
	</style>
<main class="pt-4 pt-sm-5">
<?php echo $this->include('Common/_messages') ?>
<div class="pageTitle py-2 text-center text-white">
	<h2 class="title-xl fw-900 mb-0">Contact Us</h2>
</div>
<div class="bg-white py-4 py-sm-5 mb-4 mb-sm-5">
	<div class="container">
		<div class="row">
			<!-- MESSAGE ME - START -->
			<div class="col-8">
				<div id="contact-provider" class="rounded-5 p-4 py-sm-5 mb-5" style="background: #dbd6d6;">
					<p class="text-dark">Thank you for your interest in Plane Broker. Feel free to contact us with any questions or suggestions you may have. Just complete the form and we will respond to your email as promptly as possible.</p>
					<form action="<?php echo base_url('/submit-contact'); ?>" method="post" id="contactForm1" class="form-input">
					<?php $validation = \Config\Services::validation(); ?>
					<!-- Recaptcha Error -->
				 <?php if( $validation->getError('recaptcha_response') ) {?>

					  <div class="alert alert-danger">
							<?= $validation->getError('recaptcha_response'); ?>
					  </div>
				 <?php }?>
						<div class="row form-section">
							<div class="form-group">
								<input type="text" name="name" id="name" class="ucwords form-control" placeholder="Your Name *">
							</div>
							<div class="form-group">
								<input type="text" name="email" id="email" placeholder="Your Email *" class="form-control">
							</div>
							<div class="form-group">
								<input type="text" name="phone" id="phone" data-max="10" class="onlyNum form-control" placeholder="Your Phone *">
							</div>
							<div class="form-group">
								<select name="subject" id="subject" class="form-control" style="color: #989393;">
									<option value="General">General</option>
									<option value="Billing">Billing</option>
									<option value="Media/Business Inquiries">Media/Business Inquiries</option>
									<option value="Tech Support">Tech Support</option>
									<option value="Report User">Report User</option>
								</select>
							</div>
							<div class="form-group">
								<textarea name="message" id="message" class="form-control" placeholder="Message *"></textarea>
							</div>
							<div id="html_element"></div>
							<div class="gap-3">
								<input type="hidden" id="g-recaptcha-response" name="recaptcha_response" value="">                                
								<input type="submit" value="Send Message" class="button btn small success noMarg col yellowbtn">	
							</div>
						</div>
						
					</form>
										
				</div>
			</div><!-- MESSAGE ME - END -->
			<div class="col-4">
				<h3 class="title-sm dblue mt-3 mb-0">DID YOU KNOW?</h3>
				<p>Most questions can be answered in our <a href="<?php echo base_url(); ?>/faq">FAQ</a></p>
				<!--<hr>
				<h3 class="title-sm dblue mt-3 mb-0">Plane Broker Corporate</h3>
				<p>Monday-Friday 9:00am-5:00pm<br>
					<small>Pacific Standard Time</small></p>-->
				</div>
			</div>
		</div>
	</div>
</div>
</main>
<script>
$(document).ready(function () {
    $("#contactForm1").validate({
        rules: {
            name: { required: true, maxlength:255},
            email: { required: true, email: true, maxlength:255},          
            subject: { required: true},                     
            message: { required: true},                     
            recaptcha_response: { required: true},           
        },
        messages: {
			recaptcha_response:{
				required: "You are not a human!"
			}
        },
        submitHandler: function (form) {
            document.getElementById("contactForm1").submit();
        }
    });
});
</script>
<?= $this->endSection() ?>