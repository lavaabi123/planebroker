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
			<div class='row'>
			
		
		<div class="titleSec mb-3 mb-xl-4">
			<h3 class="title-md dblue mb-0 mb-sm-2">My Plan
			<?php
				if($user_detail->plan_id ==3){
					echo '<a href="'.base_url('/plan').'" class="btn bg-orange" style="
    float: right;">Change Plan</a>';
				}else{
					echo '<a href="'.base_url('/plan').'" class="btn bg-orange" style="
    float: right;">Upgrade Plan</a>';
				}
			?>
			</h3>
		</div>
				<div class='' style="margin: 0 auto;">
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
						<p>No data found</p>
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
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $subscription->id;?>')" class="cancel btn">Cancel Subscription</a>

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
							
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $subscription->id;?>')" class="cancel btn">Cancel Subscription</a>

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
                            <br><br><strong class="dblue">Last Payment:</strong> <?php echo date("m/d/Y", strtotime($user_detail->stripe_subscription_start_date));?>
                            <br><strong class="dblue">Next Payment:</strong> <?php echo date("m/d/Y", strtotime($user_detail->stripe_subscription_end_date));?>
                            <br><br>
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $subscriptions->id;?>')" class="cancel btn">Cancel Subscription</a>

                            <br></p>
						<?php }else{ ?>
							 <p><?php echo $subscriptions->plan->name." ($" . moneyFormat($subscriptions->plan->billing_cycles[1]->pricing_scheme->fixed_price->value) . "/mo)";?>
							<p>You are in 30 days Trial Period</p>
							<strong class="dblue">Trial Start:</strong> <?php echo date("m/d/Y", strtotime($user_detail->stripe_subscription_start_date));?>
                            <br><strong class="dblue">Trial End:</strong> <?php echo date("m/d/Y", strtotime($user_detail->stripe_subscription_end_date));?>
                            <br>
							<strong class="dblue">Next Payment:</strong> <?php echo date("m/d/Y", strtotime($subscriptions->billing_info->next_billing_time));?>
                            <br><br>
							
                            <a href="javascript:void(0)" onclick="confirm_cancel('<?php echo $subscriptions->id;?>')" class="cancel btn">Cancel Subscription</a>

                            <br></p>
						<?php } ?>	
					<?php } }else{
						echo '<p>No data found</p>';
					} 
					
					?>
					
					
				</div>
				
				
				
		<div class="titleSec mb-3 mb-xl-4">
			<h3 class="title-md dblue mb-0 mb-sm-2">Payment History</h3>
		</div>
		<?php echo $payment_history; ?>		
		
		<div class="titleSec mb-3 mb-xl-4">
			<h3 class="title-md dblue mb-0 mb-sm-2">Payment Methods</h3>
		</div>
		<?php echo $payment_methods; ?>
			</div>
			  
				</div>
			</div>
		</div>
		
		
		</div>		
<script>
function confirm_cancel(subscription_id) {
    Swal.fire({
        text: "Are your sure to cancel the subscription?",
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "<?php echo trans("ok"); ?>",
        cancelButtonText: "<?php echo trans("cancel"); ?>",

    }).then(function (response) {
        if (response.value) {
        	window.location = '<?php echo base_url(); ?>/providerauth/billing-cancel/'+subscription_id; 
        }
    });
}
</script>		
<?= $this->endSection() ?>