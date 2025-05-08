<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

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
			<form id="edit-account-form" method="post" action="<?php echo base_url(); ?>/providerauth/edit-account-post">
			<?php echo csrf_field() ?>
				<input type="hidden" name="id" value="<?php echo $user_detail->id ?>">
				<fieldset class="form-input">				
					<h4 class="title-sm dblue border-bottom">Basic Info</h4>
					<div class="form-section row row-cols-1 row-cols-md-3">
						<div class="form-group">
							<input class="form-control required" type="text" id="first_name" name="first_name" placeholder="<?php echo trans('form_firstname') ?>" value="<?php echo $user_detail->first_name ?>">
						</div>
						<div class="form-group">
							<input class="form-control required" type="text" id="last_name" name="last_name" placeholder="<?php echo trans('form_lastname') ?>" value="<?php echo $user_detail->last_name ?>">
						</div>
						<div class="form-group">
							<input class="form-control required email" type="email" id="email" name="email" placeholder="<?php echo trans('form_email') ?>" value="<?php echo $user_detail->email ?>">
						</div>
						<div class="form-group">
							<input class="form-control required" type="text" id="mobile_no" name="mobile_no" placeholder="<?php echo trans('Telephone Number') ?>" value="<?php echo $user_detail->mobile_no ?>">
						</div>	
					</div>	
					<input type="submit" class="btn" value="Save Details" />				
				</fieldset>
				</form>
				<form id="edit-password-form" method="post" action="<?php echo base_url(); ?>/providerauth/edit-password-post">
				<input type="hidden" name="id" value="<?php echo $user_detail->id ?>">
				<fieldset class="form-input">					
					<h4 class="title-sm dblue mt-3 mt-lg-5 border-bottom">Change Password</h4>
					<div class="form-section row row-cols-1 row-cols-md-3">						
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
<?= $this->endSection() ?>