<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>listings/sales"><?php echo trans('Sales') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
		<div class="container-fluid">
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3 g-3 text-center package">
			<?php if(!empty($plans)){
				foreach($plans as $plan){  
				
					$query = !empty($_GET['sale_id']) ? '&sale_id='.$_GET['sale_id'] : '' ;
					$query .= !empty($_GET['payment_type']) ? '&payment_type='.$_GET['payment_type'] : '' ;
					$query .= !empty($_GET['user_id']) ? '&user_id='.$_GET['user_id'] : '' ;
				?>	
			  <div class="col <?php echo !empty($plan->is_recommended) ? 'plan-2' : '';  ?>">
				<div class="card p-3 border rounded-5 shadow-sm h-100">
				  <div class="card-header pb-3 pb-xl-4">
					<h5 class="my-0"><?= $plan->name ?></h5>
				  </div>
				  <div class="card-body p-3 pb-xl-4">
					<h3 class="fs-3 text-black py-2">$<?= $plan->price ?></h3>
					
					<?php if(!empty($plan_id) && $plan_id == $plan->id){  ?>					
					<a href="javascript:void(0);" class="btn min-w-auto w-100 py-3">Current Plan</a>
					<a></a>
					<?php }else{ ?>					
					<?php 
					if((empty($user_trial_detail) || !in_array($plan->id,explode(',',$user_trial_detail->plan_ids)))){ ?>
						
						<a href="<?php echo admin_url().'listings/change_plan?type=trial&new_plan_id='.$plan->id.''.$query; ?>" class="btn min-w-auto w-100 py-3">Start Free Trial</a>
						<!--<a onclick="change_plan('<?php echo $_GET['sale_id']; ?>','<?php echo $plan->id; ?>','trial','<?php echo $_GET['user_id']; ?>')" href="javascript:void(0)" class="btn min-w-auto w-100 py-3">Start Free Trial</a>-->
					<?php }else{ ?>
						<a href="<?php echo admin_url().'listings/change_plan?new_plan_id='.$plan->id.''.$query; ?>" class="btn min-w-auto w-100 py-3"><?php echo 'Select';  ?></a>
						<!--<a onclick="change_plan('<?php echo $_GET['sale_id']; ?>','<?php echo $plan->id; ?>','','<?php echo $_GET['user_id']; ?>')" href="javascript:void(0)" class="btn min-w-auto w-100 py-3"><?php echo 'Select';  ?></a>-->
					<?php } 
					} ?>
					
					<ul class="list-unstyled my-4">
					  <li><?= $plan->no_of_weeks ?> week listing on PlaneBroker.com</li>
					  <li><?= $plan->no_of_photos ?> photos / docs</li>
					  <li class="<?php echo !empty($plan->no_of_videos) ? '' : 'd-close';  ?>"><?php echo !empty($plan->no_of_videos) ? $plan->no_of_videos.' Videos' : 'No Video';  ?></li>
					  <li class="<?php echo !empty($plan->is_featured_listing) ? '' : 'd-close';  ?>"><?php echo !empty($plan->is_featured_listing) ? 'Featured Listing on Homepage' : 'Not a featured listing';  ?></li>
					  <li class="<?php echo !empty($plan->is_premium_listing) ? '' : 'd-close';  ?>"><?php echo !empty($plan->is_premium_listing) ? 'Premium listing' : 'Not a Premium listing';  ?></li>
					</ul>
					
				  </div>
				</div>
			  </div>
			  <?php } 
					} ?>
					
					
			  <div class="col">
				<div class="card p-3 border rounded-5 shadow-sm h-100">
				  <div class="card-header pb-3 pb-xl-4">
					<h5 class="my-0">Captain’s Club</h5>
				  </div>
				  <div class="card-body px-3 pb-xl-4">
					<!--<h5 class="card-title title-sm text-black py-2 py-xl-4" style="font-size:13px">DEALER MONTHLY PACKAGE(S) ONLY</h5>-->
											
					
					
					<ul class="list-unstyled my-4">
					  <li>Unlimited Photos</li>
					  <li>Unlimited Videos</li>
					  <li>Unlimited Documents/Logbooks</li>
					  <li>Featured Listing on Homepage</li>
					  <li>Premium Listing</li>
					</ul>
					<a href="<?php echo base_url('/contact'); ?>" class="btn min-w-auto w-100 py-3">Select</a>		
											
					
				  </div>
				</div>
			  </div>
			</div>
		</div>
		</div>
<?= $this->endSection() ?>