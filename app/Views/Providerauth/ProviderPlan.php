<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="plan pt-5 pb-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-5">
			<h4 class="fw-bolder mb-2"><?php echo $title; ?></h4>
			<p class="text-grey">Now it’s time to select the plan that’s right for you.</p>
		</div>
		<div class="container">
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3 g-3 text-center package">
			<?php if(!empty($plans)){
				foreach($plans as $plan){  
				
					$query = !empty($_GET['sale_id']) ? '&sale_id='.$_GET['sale_id'] : '' ;
					$query .= !empty($_GET['payment_type']) ? '&payment_type='.$_GET['payment_type'] : '' ;
				?>	
			  <div class="col <?php echo !empty($plan->is_recommended) ? 'plan-2' : '';  ?>">
			  <?php echo !empty($plan->is_recommended) ? '<span class="m-popular">Most Popular!</span>' : '';  ?>
				<div class="card rounded-5 shadow-sm">
				  <div class="card-header py-3 py-xl-4">
					<h5 class="my-0"><?= $plan->name ?></h5>
				  </div>
				  <div class="card-body px-3 pb-xl-5">
					<h3 class="card-title title-xl text-black py-2 py-xl-4">$<?= $plan->price ?></h3>
					
					<?php if(!empty($plan_id) && $plan_id == $plan->id){  ?>					
					<a href="javascript:void(0);" class="btn min-w-auto w-100 py-3">CURRENT PLAN</a>
					<a></a>
					<?php }else{ ?>					
					<?php 
					if((empty($user_trial_detail) || !in_array($plan->id,explode(',',$user_trial_detail->plan_ids))) && empty($_GET['sale_id'])){ ?>
					<a href="<?php echo base_url('/select-plan?id='.$plan->id.'&type=trial'.$query); ?>" class="btn min-w-auto w-100 py-3">Start Free Trial</a>
					<?php }else{ ?>
						<a href="<?php echo base_url('/select-plan?id='.$plan->id.''.$query); ?>" class="btn min-w-auto w-100 py-3"><?php echo 'Select';  ?></a>
					<?php } 
					} ?>
					
					<ul class="list-unstyled my-4">
					  <li><?= $plan->no_of_weeks ?> week listing on PlaneBroker.com</li>
					  <li><?= $plan->no_of_photos ?> photos / docs</li>
					  <li class="<?php echo !empty($plan->no_of_videos) ? '' : 'd-close';  ?>"><?php echo !empty($plan->no_of_videos) ? $plan->no_of_videos.' Videos' : 'No Video';  ?></li>
					  <li class="<?php echo !empty($plan->is_featured_listing) ? '' : 'd-close';  ?>"><?php echo !empty($plan->is_featured_listing) ? 'Featured Listing on Homepage' : 'Not a featured listing';  ?></li>
					  <li class="<?php echo !empty($plan->is_premium_listing) ? '' : 'd-close';  ?>"><?php echo !empty($plan->is_premium_listing) ? 'Premium listing' : 'Not a Premium listing';  ?></li>
					</ul>
					
					<?php if(!empty($plan_id) && $plan_id == $plan->id){  ?>					
					<a href="javascript:void(0);" class="btn min-w-auto w-100 py-3">CURRENT PLAN</a>
					<a></a>
					<?php }else{ ?>					
					<?php if((empty($user_trial_detail) || !in_array($plan->id,explode(',',$user_trial_detail->plan_ids))) && empty($_GET['sale_id'])){  ?>
					<a href="<?php echo base_url('/select-plan?id='.$plan->id.'&type=trial'.$query); ?>" class="btn min-w-auto w-100 py-3">Start Free Trial</a>
					<p class="fw-bold mt-4 text-orange">30 Day Free Trial</p>
					<?php }else{ ?>
						<a href="<?php echo base_url('/select-plan?id='.$plan->id.''.$query); ?>" class="btn min-w-auto w-100 py-3"><?php echo 'Select';  ?></a>
					<?php } 
					} ?>
				  </div>
				</div>
			  </div>
			  <?php } 
					} ?>
					
					
			  <div class="col">
				<div class="card rounded-5 shadow-sm">
				  <div class="card-header py-3 py-xl-4">
					<h5 class="my-0">Captain’s Club</h5>
				  </div>
				  <div class="card-body px-3 pb-xl-5">
					<h5 class="card-title title-sm text-black py-2 py-xl-4" style="font-size:13px">DEALER MONTHLY PACKAGE(S) ONLY</h5>
									
					<a href="<?php echo base_url('/captains-club-request'); ?>" class="btn min-w-auto w-100 py-3">Contact Us</a>				
					
					
					<ul class="list-unstyled my-4">
					  <li>Unlimited Photos</li>
					  <li>Unlimited Videos</li>
					  <li>Unlimited Documents/Logbooks</li>
					  <li>Featured Listing on Homepage</li>
					  <li>Premium Listing</li>
					</ul>
									
					<a href="<?php echo base_url('/captains-club-request'); ?>" class="btn min-w-auto w-100 py-3">Contact Us</a>			
					
				  </div>
				</div>
			  </div>
			</div>
			<p class="text-grey text-center mt-5 mb-md-5 px-md-5">Whether you're listing a single aircraft or managing multiple sales, Plane Broker offers flexible options to match your goals. Each plan is built to give you the tools you need to showcase your aircraft clearly and connect with serious buyers.</p>
		</div>
		</div>
<?= $this->endSection() ?>