<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="plan bg-gray pt-2 pb-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-5">
			<h3 class="title-lg text-black mb-2"><?php echo $title; ?></h3>
			<p class="text-grey">Now it’s time to select the plan that’s right for you.</p>
		</div>
		<div class="container">
			<div class="row row-cols-1 row-cols-md-4 mb-3 gx-md-5 text-center package">
			  <div class="col">
				<div class="card mb-4 rounded-5 shadow-sm">
				  <div class="card-header py-3 py-xl-4">
					<h4 class="my-0 fw-normal">Basic</h4>
				  </div>
				  <div class="card-body px-3 px-xl-5 pb-xl-5">
					<h3 class="card-title title-xl text-black py-2 py-xl-4">$19.99<small class="text-body-secondary fw-light">/mo</small></h3>
					
					
					<ul class="list-unstyled">
					  <li>4 week listing on Trade-A-Plane.com</li>
					  <li>10 photos / docs</li>
					  <li>No Video</li>
					  <li>Not featured on homepage</li>
					  <li>No Premium Listing Placement</li>
					</ul>
					
					<?php if(!empty($user_plan_details) && $user_plan_details->plan_id == 2){  ?>					
					<a href="javascript:void(0);" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto">Active</a>
					<a></a>
					<?php }else{ ?>					
					<?php if(empty($standard_trial) && empty($premium_trial)){ ?>
					<a href="<?php echo base_url('/providerauth/select-plan?id=2&type=trial'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto">Start Free Trial</a>
					<p class="fw-bold mt-4 text-orange">30 Day Free Trial</p>
					<?php }else{ ?>
						<a href="<?php echo base_url('/providerauth/select-plan?id=2'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto"><?php echo (!empty($user_plan_details) && $user_plan_details->plan_id == 3) ? 'Choose Basic' : 'Select';  ?></a>
					<?php } 
					} ?>
				  </div>
				</div>
			  </div>
			   <div class="col">
				<div class="card mb-4 rounded-5 shadow-sm">
				  <div class="card-header py-3 py-xl-4">
					<h4 class="my-0 fw-normal">Enhanced</h4>
				  </div>
				  <div class="card-body px-3 px-xl-5 pb-xl-5">
					<h3 class="card-title title-xl text-black py-2 py-xl-4">$65.99<small class="text-body-secondary fw-light">/mo</small></h3>
										
					<ul class="list-unstyled">
					  <li>4 week listing on Trade-A-Plane.com</li>
					  <li>10 photos / docs</li>
					  <li>No Video</li>
					  <li>Not featured on homepage</li>
					  <li>No Premium Listing Placement</li>
					</ul>
					
					<?php if(!empty($user_plan_details) && $user_plan_details->plan_id == 3){  ?>					
					<a href="javascript:void(0);" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto">Active</a>
					<a></a>
					<?php }else{ ?>					
					<?php if(empty($standard_trial) && empty($premium_trial)){ ?>
					<a href="<?php echo base_url('/providerauth/select-plan?id=3&type=trial'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto">Start Free Trial</a>
					<p class="fw-bold mt-4 text-orange">30 Day Free Trial</p>
					<?php }else{ ?>
						<a href="<?php echo base_url('/providerauth/select-plan?id=3'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto"><?php echo (!empty($user_plan_details) && $user_plan_details->plan_id == 3) ? 'Choose Enhanced' : 'Select';  ?></a>
					<?php } 
					} ?>
				  </div>
				</div>
			  </div>
			  <div class="col plan-2">
				<div class="card mb-4 rounded-5 shadow-sm">
				  <div class="card-header py-3 py-xl-4">
					<h4 class="my-0 fw-normal">Best</h4>
				  </div>
				  <div class="card-body px-3 px-xl-5 pb-xl-5">
					<h3 class="card-title title-xl text-black py-2 py-xl-4">$129.99<small class="text-body-secondary fw-light">/mo</small></h3>
					
					<ul class="list-unstyled">
					  <li>4 week listing on Trade-A-Plane.com</li>
					  <li>10 photos / docs</li>
					  <li>No Video</li>
					  <li>Not featured on homepage</li>
					  <li>No Premium Listing Placement</li>
					</ul>
					
					<?php if(!empty($user_plan_details) && $user_plan_details->plan_id == 4){  ?>					
					<a href="javascript:void(0);" class="w-100 btn btn-lg yellowbtn py-3 py-xl-4 mt-auto">Active</a>
					<a></a>
					<?php }else{ ?>					
					<?php if(empty($standard_trial) && empty($premium_trial)){ ?>
					<a href="<?php echo base_url('/providerauth/select-plan?id=4&type=trial'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto">Start Free Trial</a>
					<p class="fw-bold mt-4 text-orange">30 Day Free Trial</p>
					<?php }else{ ?>
						<a href="<?php echo base_url('/providerauth/select-plan?id=4'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto"><?php echo (!empty($user_plan_details) && $user_plan_details->plan_id == 2) ? 'Upgrade' : 'Select';  ?></a>
					<?php } 
					} ?>
				  </div>
				</div>
			  </div>
			  <div class="col">
				<div class="card mb-4 rounded-5 shadow-sm">
				  <div class="card-header py-3 py-xl-4">
					<h4 class="my-0 fw-normal">Premier Dealer</h4>
				  </div>
				  <div class="card-body px-3 px-xl-5 pb-xl-5">
					<h3 class="card-title title-xl text-black py-2 py-xl-4">$129.99<small class="text-body-secondary fw-light">/mo</small></h3>
										
					<ul class="list-unstyled">
					  <li>Unlimited Photos</li>
					  <li>Unlimited Specs</li>
					  <li>Unlimited Videos</li>
					  <li>Unlimited Documents/Logbooks</li>
					</ul>
					
					<?php if(!empty($user_plan_details) && $user_plan_details->plan_id == 5){  ?>					
					<a href="javascript:void(0);" class="w-100 btn btn-lg yellowbtn py-3 py-xl-4 mt-auto">Active</a>
					<a></a>
					<?php }else{ ?>					
					<?php if(empty($standard_trial) && empty($premium_trial)){ ?>
					<a href="<?php echo base_url('/providerauth/select-plan?id=5&type=trial'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto">Start Free Trial</a>
					<p class="fw-bold mt-4 text-orange">30 Day Free Trial</p>
					<?php }else{ ?>
						<a href="<?php echo base_url('/providerauth/select-plan?id=5'); ?>" class="w-100 btn btn-black btn-lg py-3 py-xl-4 mt-auto"><?php echo (!empty($user_plan_details) && $user_plan_details->plan_id == 2) ? 'Upgrade' : 'Select';  ?></a>
					<?php } 
					} ?>
				  </div>
				</div>
			  </div>
			</div>
		</div>
		</div>
<?= $this->endSection() ?>