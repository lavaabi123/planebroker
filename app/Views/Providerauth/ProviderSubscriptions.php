<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
   
			
	<div class="bg-grey d-flex flex-column flex-lg-row">
        <?php echo $this->include('Common/_messages') ?>
		<div class="leftsidecontent" id="stickySection">
			<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3 mb-5">
			<div class="container-fluid">
				<div class="titleSec">
					<h3 class="title-lg fw-bolder my-4">Subscriptions<?php //echo $title; ?></h3>
				</div>
				<div class="dbContent">
					<div class="container px-0">
					<div class="filter_Sec">
						<?php echo $this->include('Providerauth/_filter_provider_subs') ?>
					</div>
				<div class='d-none' style="margin: 0 auto;">
					<?php 
					if($user_detail->plan_id > 1){
					if($user_detail->payment_type == 'Stripe'){ 
						if(count($subscriptions) < 1){
						if($user_detail->admin_plan_update == 1){
							$plan = ($user_detail->plan_id == 2 ) ? 'Standard' : 'Premium';
							echo '<h6 class="text-dark">You are on '.$plan.' Plan, Upgraded by site admin.</h6>';
							if($user_detail->admin_plan_end_date != NULL){
							echo '<strong class="dblue">Expires on:</strong> '.date("m/d/Y", strtotime($user_detail->admin_plan_end_date)).'';
							}
						}else{	
						?>
						<p class="text-center p-4">No data found</p>
					<?php 
						}
					}else{ ?>

						<?php if(isset($cards->card->brand)){ ?>
							<p>Your credit card on file is a <strong><?php echo $cards->card->brand;?></strong> ending in <strong><?php echo $cards->card->last4;?></strong></p>
							<hr>
							<h6 class="dblue mb-0">Subscription:</h6>
							
							
						<?php }	?>									
						<input type="hidden" name="plan_id" value="<?php echo $user_detail->stripe_subscription_customer_id; ?>" />
						<?php
						//echo '<pre>';
						//print_r($subscriptions->data);
						if(!empty($subscriptions->data)){
						foreach ($subscriptions->data as $subscription) {
						    if ($subscription->status == 'active') {
						?>
                            <p><?php echo $subscription->metadata->title . " ($" . moneyFormat($subscription->plan->amount / 100) . "/mo)";?>
                            <br><strong class="dblue">Last Payment:</strong> <?php echo date("m/d/Y", $subscription->current_period_start);?>
                            <br><strong class="dblue">Next Payment:</strong> <?php echo date("m/d/Y", $subscription->current_period_end);?>
                            <br><br>
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $user_detail->id;?>')" class="cancel btn">Cancel Subscription</a>

                            <!--<a href="<?php echo base_url().'/providerauth/update-card/';?>" class="cancel btn">Payment Methods</a>-->
                            <br></p>
                        <?php }elseif ($subscription->status == 'trialing') {
							?>
                            <p><?php echo $subscription->metadata->title . " ($" . moneyFormat($subscription->plan->amount / 100) . "/mo)";?>
							<p>You are in 30 days Trial Period</p>
							<strong class="dblue">Trial Start:</strong> <?php echo date("m/d/Y", $subscription->trial_start);?>
                            <br><strong class="dblue">Trial End:</strong> <?php echo date("m/d/Y", $subscription->trial_end);?>
                            <br>
							<strong class="dblue">Next Payment:</strong> <?php echo date("m/d/Y", $subscription->current_period_end);?>
                            <br><br>
							
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $user_detail->id;?>')" class="cancel btn">Cancel Subscription</a>

                            <!--<a href="<?php echo base_url().'/providerauth/update-card/';?>" class="cancel btn">Payment Methods</a>-->
                            <br></p>
                        <?php
							}
						}
						}else{ ?>
							<p>You are in Trial period</p>
						<?php } ?>					
					<?php } }else{ ?>
						<h3 class="title-sm dblue mb-0">Subscription:</h3>
						<?php 
						if($user_detail->is_trial != 1){ ?>
							<p><?php echo $subscriptions->plan->name." ($" . moneyFormat($subscriptions->plan->billing_cycles[0]->pricing_scheme->fixed_price->value) . "/mo)";?>
                            <br><br><strong class="dblue">Last Payment:</strong> <?php echo ($user_detail->stripe_subscription_start_date != NULL) ? date("m/d/Y", strtotime($user_detail->stripe_subscription_start_date)):'-';?>
                            <br><strong class="dblue">Next Payment:</strong> <?php echo ($user_detail->stripe_subscription_end_date != NULL) ? date("m/d/Y", strtotime($user_detail->stripe_subscription_end_date)):'-';?>
                            <br><br>
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $user_detail->id;?>')" class="cancel btn">Cancel Subscription</a>

                            <br></p>
						<?php }else{ ?>
							 <p><?php echo $subscriptions->plan->name." ($" . moneyFormat($subscriptions->plan->billing_cycles[1]->pricing_scheme->fixed_price->value) . "/mo)";?>
							<p>You are in 30 days Trial Period</p>
							<strong class="dblue">Trial Start:</strong> <?php echo ($user_detail->stripe_subscription_start_date != NULL) ? date("m/d/Y", strtotime($user_detail->stripe_subscription_start_date)):'-';?>
                            <br><strong class="dblue">Trial End:</strong> <?php echo ($user_detail->stripe_subscription_end_date != NULL) ? date("m/d/Y", strtotime($user_detail->stripe_subscription_end_date)):'-';?>
                            <br>
							<strong class="dblue">Next Payment:</strong> <?php echo date("m/d/Y", strtotime($subscriptions->billing_info->next_billing_time));?>
                            <br><br>
							
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $user_detail->id;?>')" class="cancel btn">Cancel Subscription</a>

                            <br></p>
						<?php } ?>	
					<?php } }else{
						echo '<p class="text-center py-4">No data found</p>';
					} 
					
					?>
					
					
				</div>
				<?php echo $payment_history; ?>	
					</div>
				</div>
			</div>
		</div>
	</div>		
<script>
function confirm_cancel(subscription_id,payment_type) {
    Swal.fire({
        text: "ARE YOU SURE YOU WANT TO CANCEL?",
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "<?php echo trans("YES, CANCEL MY SUBSCRIPTION"); ?>",
        cancelButtonText: "<?php echo trans("NO, KEEP MY SUBSCRIPTION"); ?>",

    }).then(function (response) {
        if (response.value) {
        	window.location = '<?php echo base_url(); ?>/providerauth/billing-cancel/'+subscription_id+'/'+payment_type; 
        }
    });
}
function change_subs_status(sale_id,product_id){
	$.confirm({
		title: 'Confirm Activating Plan',
		content: 'Are you sure you want to change to this plan status?',
		buttons: {
			confirm: function () {
				$.ajax({
					url: '<?php echo base_url(); ?>/change_plan_status',
					data: {sale_id:sale_id,product_id:product_id},
					type: 'POST',
					dataType: 'HTML',
					success: function(response){
						window.location = '<?php echo base_url(); ?>/subscriptions';
					}
				})
			},
			cancel: function(){
				
			}
		}
	});
}
$(document).ready(function () {
    // Show only active by default
    $('.subscription-card').hide();
    $('.subscription-card.active').show();

    $('#filter-active').on('click', function () {
        $('.subscription-card').hide();
        $('.subscription-card.active').show();
        $('#filter-active').addClass('active-tab');
        $('#filter-inactive').removeClass('active-tab');
        $('#filter-expired').removeClass('active-tab');
    });

    $('#filter-inactive').on('click', function () {
        $('.subscription-card').hide();
        $('.subscription-card.inactive').show();
        $('#filter-inactive').addClass('active-tab');
        $('#filter-active').removeClass('active-tab');
        $('#filter-expired').removeClass('active-tab');
    });
	
    $('#filter-expired').on('click', function () {
        $('.subscription-card').hide();
        $('.subscription-card.expired').show();
        $('#filter-expired').addClass('active-tab');
        $('#filter-active').removeClass('active-tab');
        $('#filter-inactive').removeClass('active-tab');
    });
	
	$('.applyBtn').on('click', function () {
		setTimeout(function () {
			$('.fb-filter form').submit();
		}, 50); // 50ms delay ensures date value is written first
	});
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?= $this->endSection() ?>