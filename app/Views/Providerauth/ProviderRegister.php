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
<div class="front-login-box">
	<?php echo $this->include('Common/_messages') ;?>               
	<div class="wizard-main">
		<div class="container-fluid">
			<div class="row align-items-start">
				<div class="col-md-5 banner-sec">
					<img class="img-fluid" id="slide1" src="<?php echo base_url(); ?>/assets/frontend/images/pbd.jpg" alt="First slide">
				</div>
				<div class="col-md-7 login-sec">
					<div class="login-sec-bg">
						<form id="example-advanced-form" method="post" action="<?php echo base_url(); ?>/user-signup-post">
						<?php echo csrf_field() ?>
							<input type="hidden" id="fullname" name="fullname" value="">
							<h3></h3>
							<fieldset class="form-input">
								<h3 class="title-md text-center black mb-4">Account Information</h3>							
								<div class="form-section">
									<div class="form-group">
										<input class="form-control required" type="text" id="first_name" name="first_name" placeholder="<?php echo trans('form_firstname').'*'; ?>" value="<?php echo old('first_name') ?>">
									</div>
									<div class="form-group">
										<input class="form-control required" type="text" id="last_name" name="last_name" placeholder="<?php echo trans('form_lastname').'*'; ?>" value="<?php echo old('last_name') ?>">
									</div>
									<div class="form-group">
									<div class="form-check form-switch mb-3 d-flex align-items-center">
										<input type="hidden" name="role" value="3">
										<input class="form-control form-check-input mb-0 me-2" name="role" value="2" type="checkbox" id="flexSwitchCheckDefault">
										<label class="form-check-label" for="flexSwitchCheckDefault">Buyer / Seller</label>
									</div>
									</div>
									<div class="form-group seller_field" style="display:none;">
										<input class="form-control" type="text" id="business_name" name="business_name" placeholder="<?php echo trans('Seller Name(if applicable)') ?>" value="<?php echo old('business_name') ?>">
									</div>														
									<div class="form-group">
										<input class="form-control required" type="text" id="address" name="address" placeholder="<?php echo trans('Address Line 1').'*'; ?>" autocomplete="off" value="<?php echo old('address') ?>" >
									</div>		  
									<div class="form-group">
										<input class="form-control" type="text" id="address2" name="suite" placeholder="<?php echo trans('Address Line 2') ?>" value="<?php echo old('suite') ?>" >
									</div>								
									<div class="form-group">	
										<select name="country" onchange="change_country(this)" class="form-control country_list required">
											<?php
											if(!empty($countries)){
												foreach($countries as $country){ ?>
													<option value="<?php echo $country->id; ?>" <?php echo (old('country') == $country->id) ? 'selected':''; ?>><?php echo $country->name; ?></option>
											<?php }
											}
											?>
										</select>
									</div>
									<div class="form-group">							
										<select name="state" class="form-control load_states required">
											<option value=""><?php echo trans('Select State') ?></option>
										</select>
									</div>
									<div class="form-group">							
										<input type="text" value="" placeholder="City*" name='locality' id="locality" class='form-control required' />
									</div>
									<div class="form-group">							
										<input type="text" value="" placeholder="Zip/Postal Code*" name='postcode' id="postcode" class='form-control required' />
									</div>									
									<div class="form-group">
										<input class="form-control required" type="text" id="mobile_no" name="mobile_no" placeholder="<?php echo trans('Phone*') ?>" value="<?php echo old('mobile_no') ?>">
									</div>
									<div class="form-group">
										<input class="form-control required email" type="email" id="email" name="email" placeholder="<?php echo trans('form_email').'*'; ?>" value="<?php echo old('email') ?>">
									</div>
									<div class="form-group">
										<input class="form-control required" type="password" id="password" name="password" placeholder="<?php echo trans('form_password').'*'; ?>">
									</div>
									<div class="form-group">
										<input type="password" name="confirm_password" class="form-control required" placeholder="<?php echo trans("form_confirm_password").'*'; ?>" data-parsley-equalto="#password">
									</div>
								</div>	
								<input type="hidden" id="g-recaptcha-response"  class="form-control required" name="check_bot" value="" >
								<input type="hidden" name="register_plan" value="<?php echo !empty(session()->get('selected_plan_id')) ? session()->get('selected_plan_id') : 1; ?>" >
								<div class="text-center">
									<input type="submit" class="btn bg-orange" value="Sign Up" />
								</div>						
							</fieldset>
						</form>         
					</div>
				</div>          
			</div>
		</div>
	</div>            
</div>
<script>
	$(document).ready(function() {	
		$('.country_list').trigger('change');
		$('#flexSwitchCheckDefault').trigger('change');
	});	  	
	function change_country(_this){
		$('.load_states').find('option:not(:first)').remove();
		var country_id = $(_this).val();
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>/providerauth/get-states',
			data:{csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',country_id:country_id},   
			dataType: 'HTML',			
			success: function (data) {  
				$('.load_states').find('option:not(:first)').remove();			
				$(".load_states").append(data);       
			}
		});		
	}	
	$('#flexSwitchCheckDefault').on('change', function () {
		if ($(this).is(':checked')) {
			$('.seller_field').show();
		} else {
			$('.seller_field').hide();
		}
	});
</script>
<?= $this->endSection() ?>