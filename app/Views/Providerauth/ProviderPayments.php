
<?php echo !empty($user_detail->user_level) ? '<a href="'.base_url('/add-listing').'" class="btn my-2">Add Listing</a>' : '' ; ?>
			<div class="table-responsive proMsg sPayments mb-5">
				<table class="table datatable substable table-bordered table-striped">
					<thead>
						<tr role="row">
							<th><?php echo trans('Subscription'); ?></th>
							<th><?php echo trans('Listing Name'); ?></th>
							<th><?php echo trans('Start Date'); ?></th>
							<th><?php echo trans('End Date'); ?></th>
							<th><?php echo trans('Status'); ?></th>
							<th><?php echo trans('Action'); ?></th>
							<th class="max-width-120" style="padding-left: 0;"></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$pp = 0;
						if(!empty($payments_all)){
							foreach ($payments_all as $p => $payment) :
							//if(empty($payment->is_cancel)){							?>
							<tr>
								<td><?php echo $payment->plan_name; ?></td>
								<td><?php echo !empty($payment->display_name) ? (!empty(trim($payment->display_name)) ? $payment->display_name : '-') : (($payment->stripe_subscription_end_date != NULL && strtotime($payment->stripe_subscription_end_date) < time()) ? '':'<a href="'.base_url('/add-listing?sale_id='.$payment->id.'&payment_type='.strtolower($payment->payment_type).'').'" class="btn btn-sm mob-w-100">Add Listing</a>'); ?></td>
								<td><?php echo ($payment->stripe_subscription_start_date != NULL) ? date("m/d/Y",strtotime($payment->stripe_subscription_start_date)):'-'; ?></td>
								<td><?php echo ($payment->stripe_subscription_end_date != NULL) ? date("m/d/Y",strtotime($payment->stripe_subscription_end_date)) : '-'; ?></td>
								<td><?php echo !empty($payment->is_cancel) ? '<span class="text-danger d-inline-block mb-0" title="Canceled">Canceled</span>' :(($payment->stripe_subscription_end_date != NULL && strtotime($payment->stripe_subscription_end_date) < time()) ? '<span class="text-danger d-inline-block mb-0" title="Expired">Expired</span>' : (!empty($payment->product_status) ? '<span class="text-success d-inline-block mb-0" title="Active">Active</span>' :'<span class="text-warning d-inline-block mb-0" title="Inactive">Inactive</span>')); ?></td>     
								<td>
								<?php echo !empty($payment->display_name) ? '
								<a target="_blank" href="'.base_url().'/listings/'.$payment->permalink.'/'.$payment->product_id.'/'.(!empty($payment->display_name)?str_replace(' ','-',strtolower($payment->display_name)):'').'" class="me-2"><i class="far fa-eye me-1"></i>View</a>' : ''; ?>
								<?php if(empty($payment->is_cancel)){ ?>
								<a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $payment->id;?>','<?php echo $payment->payment_type;?>')" class="cancel me-2"><i class="far fa-circle-xmark me-1"></i>Cancel</a>
								<?php 
								}
								?>
								</td>
								
								<?php
								
								 echo '<td style="padding-left: 0;">'.(($user_detail->user_level == 0) ? ((!empty($payment->is_cancel))?'<a href="'.base_url('/renew_plan?sale_id='.$payment->id.'&payment_type='.strtolower($payment->payment_type)).'" class="btn btn-sm w-100">RENEW</a>' : ((!empty($highest_plan) && $highest_plan[0]->id == $payment->plan_id)?'':'<a href="'.base_url('/plan?sale_id='.$payment->id.'&payment_type='.strtolower($payment->payment_type).'&plan_id='.$payment->plan_id).'" class="btn btn-sm w-100">UPGRADE</a>')) : ((!empty($payment->is_cancel))?'<a href="javascript:void(0);" onclick="change_subs_status('.$payment->id.','.$payment->product_id.')" class="btn btn-sm w-100">Activate</a>':'')); 
								?>
								</td>
							</tr>
						<?php //} 
						endforeach;
						}?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-12 float-right mb-5">
                                    <?php //echo $paginations; ?>
                                </div>
            
					<?php echo $this->include('Providerauth/_modal_provider_messages') ?>

				<?php if(!empty($payments_all)){ ?>
				<ul class="nav nav-tabs gap-0 col-sm-9 col-lg-6 row row-cols-3" id="myTab1" role="tablist">
					<li class="nav-item" role="presentation">
					  <button class="nav-link active btn w-100 min-w-auto activelist" id="filter-active" data-bs-toggle="tab" data-bs-target="#catactive" type="button" role="tab">ACTIVE<i class="fa fa-info-circle px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="This subscription is currently active. Your listing is live and visible to buyers."></i></button>
					</li>
					<li class="nav-item" role="presentation">
					  <button class="nav-link btn w-100 min-w-auto inactivelist" id="filter-inactive" data-bs-toggle="tab" data-bs-target="#catinactive" type="button" role="tab">INACTIVE<i class="fa fa-info-circle px-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="This subscription is paid but not yet active. Publish your listing to activate it."></i></button>
					</li>
					<li class="nav-item" role="presentation">
					  <button class="nav-link btn w-100 min-w-auto expiredlist" id="filter-expired" data-bs-toggle="tab" data-bs-target="#catexpired" type="button" role="tab">EXPIRED<i class="fa fa-info-circle px-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="This subscription has expired. Your listing is no longer visible to buyers."></i></button>
					</li>
				</ul>
				
				<div class="row mt-3 mt-3 row-gap-3 row-gap-sm-4">
				<?php foreach($payments_all as $payment){ 
					$db = \Config\Database::connect();
					$pic = base_url().'/assets/frontend/images/user.png';
					if($payment->product_id > 0){
					$pics = $db->query("SELECT file_name FROM user_images WHERE product_id='".$payment->product_id."' ORDER BY `order` ASC LIMIT 1", 'a')->getRowArray();
				 
					if(empty($pics)){ 
						$pic = base_url().'/assets/frontend/images/user.png';
					}else{
						$pic = base_url().'/uploads/userimages/'.$payment->user_id.'/'.$pics['file_name'];
					}
					}
					
					?>
					<div class="col-md-6 subscription-card <?php echo !empty($payment->is_cancel) ? 'expired':(($payment->stripe_subscription_end_date != NULL && strtotime($payment->stripe_subscription_end_date) < time()) ? 'expired' : (!empty($payment->product_status) ? 'active' : 'inactive')); ?>">
						<div class="sb-details bg-grey rounded-5">
							<div class="row p-4">
								<div class="col-6">
									<img class="proPic" src="<?= $pic; ?>" width="100%">	
									<p class="mb-0"><?= $payment->plan_name; ?></p>
									<h5 class="">$<?= $payment->plan_price; ?></h5>
								</div>
								<div class="col-6 text-end">
									<?php 
									echo !empty($payment->is_cancel) ? '<span class="text-danger d-inline-block mb-0" title="Canceled">Canceled</span>' :(($payment->stripe_subscription_end_date != NULL && strtotime($payment->stripe_subscription_end_date) < time()) ? '<span class="text-danger d-inline-block mb-0" title="Expired">Expired</span>' : (!empty($payment->product_status) ? '<span class="text-success d-inline-block mb-0" title="Active">Active</span>' :'<span class="text-warning d-inline-block mb-0" title="Inactive">Inactive</span>')); 
									if($payment->product_id > 0){ ?>
									<a href="<?php echo base_url('/add-listing?category='.$payment->category_id.'&id='.$payment->product_id); ?>" class="btn py-3 blue-btn">EDIT MY LISTING</a> 
									<a target="_blank" href="<?php echo base_url().'/listings/'.$payment->permalink.'/'.$payment->product_id.'/'.(!empty($payment->display_name)?str_replace(' ','-',strtolower($payment->display_name)):''); ?>" class="btn py-3">VIEW LISTING</a>
									<?php 
									}else{ if($payment->stripe_subscription_end_date != NULL && strtotime($payment->stripe_subscription_end_date) > time()){ ?>
										<a href="<?php echo base_url('/add-listing?sale_id='.$payment->id.'&payment_type='.$payment->payment_type); ?>" class="btn py-3 blue-btn">ADD LISTING</a> 
									<?php }else{
										echo '<br/>';
									}}
									if(empty($payment->is_cancel)){ ?>
									<a href="javascript:void(0);" onclick="confirm_cancel('<?php echo $payment->id;?>','<?php echo $payment->payment_type;?>')" class="text-primary mt-3 d-inline-block">Cancel Subscription</a>
									<?php } ?>
								</div>
							</div>
							<div class="row px-3 py-2 mx-0 bg-gray align-items-center">
								<div class="col-6">
									Start Date: <?php echo ($payment->stripe_subscription_start_date != NULL) ? date("m/d/Y",strtotime($payment->stripe_subscription_start_date)) : '-'; ?>  
								</div>
								<div class="col-6 text-end">									
									<?php if(empty($payment->is_cancel)){ 
									if(!empty($highest_plan) && $highest_plan[0]->id == $payment->plan_id){
										echo ''; 
									}else{ ?>
									<a href="<?php echo base_url('/plan?sale_id='.$payment->id.'&payment_type='.$payment->payment_type.'&plan_id='.$payment->plan_id); ?>" class="btn min-w-auto">UPGRADE SUBSCRIPTION</a> 
									<?php }
									}else{
										 ?>
									<a href="<?php echo base_url('/plan?sale_id='.$payment->id.'&payment_type='.$payment->payment_type.'&plan_id='.$payment->plan_id); ?>" class="btn min-w-auto">RENEW SUBSCRIPTION</a> 
									<?php
									} ?>
								</div>
							</div>
							<div class="row p-4">
							<?php if(empty($payment->is_cancel) && ($payment->stripe_subscription_end_date != NULL && strtotime($payment->stripe_subscription_end_date) > time())){ ?>
								<div class="col-12 d-flex align-items-center">
								 <img class="icons" src="<?= base_url('assets/frontend/images/calender.png') ?>">	
									<p>Next Payment on <?php echo ($payment->stripe_subscription_end_date != NULL) ? date("F d, Y",strtotime($payment->stripe_subscription_end_date)):'-'; ?></p>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php  } ?>
				</div>
				<?php } ?>
<style>
.dbContent ul.nav-tabs .nav-link.active.activelist, .dbContent ul.nav-tabs .nav-link.activelist:hover{
	background: rgb(var(--bs-success-rgb)) !important;
}
.dbContent ul.nav-tabs .nav-link.active.inactivelist, .dbContent ul.nav-tabs .nav-link.inactivelist:hover{
	background:rgb(var(--bs-warning-rgb)) !important;
}
.dbContent ul.nav-tabs .nav-link.active.expiredlist, .dbContent ul.nav-tabs .nav-link.expiredlist:hover{
	background:var(--red) !important;
}
span.text-warning {
    text-align: center;
    font-size: 11px;
    font-weight: 500;
    background: rgb(var(--bs-warning-rgb));
    color: var(--white) !important;
    width: initial;
    margin: 0 auto 10px;
    border-radius: 20px;
    padding: 1px 20px;
	text-transform: uppercase;
}
.page-link:hover,.page-link:focus{
	color:#fff !important;
}
</style>