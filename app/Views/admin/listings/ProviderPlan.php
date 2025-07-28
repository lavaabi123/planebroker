<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?>
					<a class="btn btn-primary" href="<?php echo admin_url() . 'listings/add'; ?>"><?php echo trans('Back'); ?></a>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>listings"><?php echo trans('Listings') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
		<div class="titleSec text-center mb-4">
			<h5>Select Package for the Listing </h5>
		</div>
		<div class="container-fluid">
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3 g-3 text-center package">
			<?php if(!empty($plans)){
				foreach($plans as $plan){  
				
					$query = !empty($_GET['sale_id']) ? '&sale_id='.$_GET['sale_id'] : '' ;
					$query .= !empty($_GET['payment_type']) ? '&payment_type='.$_GET['payment_type'] : '' ;
					$query .= !empty($_GET['user_id']) ? '&user_id='.$_GET['user_id'] : '' ;
					$query .= !empty($_GET['user_id']) ? '&user_id='.$_GET['user_id'] : '' ;
				?>	
			  <div class="col <?php echo !empty($plan->is_recommended) ? 'plan-2' : '';  ?>">
				<div class="card p-3 border rounded-5 shadow-sm h-100">
				  <div class="card-header pb-3 pb-xl-4">
					<h5 class="my-0"><?= $plan->name ?></h5>
				  </div>
				  <div class="card-body p-3 pb-xl-4">
					<!--<h3 class="fs-3 text-black py-2">$<?= $plan->price ?></h3>-->
					
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
					<?php 
					if((empty($user_trial_detail) || !in_array($plan->id,explode(',',$user_trial_detail->plan_ids))) && empty($_GET['sale_id'])){ ?>
						<?php //echo admin_url().'listings/add?plan_id='.$plan->id.'&type=trial'.$query; ?>
						<a onclick="select_plan('<?php echo $plan->id; ?>','<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] : ''; ?>','trial')" href="javascript:void(0);" class="btn min-w-auto w-100 py-3">Start Free Trial</a>
					<?php }else{ ?>
						<?php //echo admin_url().'listings/add?plan_id='.$plan->id.''.$query; ?>
						<a onclick="select_plan('<?php echo $plan->id; ?>','<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] : ''; ?>','')" href="javascript:void(0);" class="btn min-w-auto w-100 py-3"><?php echo 'Select';  ?></a>
					<?php } 
					} ?>
					
					
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
					<!--<h5 class="fs-6 text-black py-2" style="font-size:13px">DEALER MONTHLY PACKAGE(S) ONLY</h5>	-->			
					
					
					<ul class="list-unstyled my-4">
					  <li>Unlimited Photos</li>
					  <li>Unlimited Videos</li>
					  <li>Unlimited Documents/Logbooks</li>
					  <li>Featured Listing on Homepage</li>
					  <li>Premium Listing</li>
					</ul>	
									
					<a onclick="select_plan('999','<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] : ''; ?>','')" href="javascript:void(0);" class="btn min-w-auto w-100 py-3">Select</a>	
					
				  </div>
				</div>
			  </div>
			</div>
		</div>
		</div>
<script>
function select_plan(plan_id,user_id,ptype){
	var query = '?plan_id='+plan_id+'&user_id='+user_id;
	if(ptype != ''){
		query += '&ptype='+ptype;
	}
	$.confirm({
		title: 'What would you like to do?',
		content: 'Do you want to proceed to add a listing or just select a plan and exit?',
		type: 'blue',
		buttons: {
			proceed: {
				text: 'Proceed to Add Listing',
				btnClass: 'btn-green',
				action: function () {
					$.confirm({
						title: 'Proceeding will move all existing listings under this Captain\'s Club',
						content: 'Do you want to proceed?',
						type: 'blue',
						buttons: {
							proceed: {
								text: 'Proceed to Add Listing',
								btnClass: 'btn-green',
								action: function () {
									query += '&proceed=listing';
									window.location.href = '<?php echo admin_url().'listings/add'; ?>'+query;
								}
							},
							cancel: {
								text: 'Cancel',
								btnClass: 'btn-default',
								action: function () {
								}
							}
						}
					});
				}
			},
			exit: {
				text: 'Select only Plan and Exit',
				btnClass: 'btn-red',
				action: function () {
					$.confirm({
						title: 'Proceeding will move all existing listings under this Captain\'s Club',
						content: 'Do you want to proceed?',
						type: 'blue',
						buttons: {
							proceed: {
								text: 'Proceed to Select Plan and Exit',
								btnClass: 'btn-green',
								action: function () {
									query += '&proceed=plan';
									window.location.href = '<?php echo admin_url().'listings/add'; ?>'+query;
								}
							},
							cancel: {
								text: 'Cancel',
								btnClass: 'btn-default',
								action: function () {
								}
							}
						}
					});
				}
			},
			cancel: {
				text: 'Cancel',
				btnClass: 'btn-default',
				action: function () {
				}
			}
		}
	});
}
</script>
<?= $this->endSection() ?>