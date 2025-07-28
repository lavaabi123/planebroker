<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="bg-grey py-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		
		<div class="container">
			<div class="titleSec">
				<h3 class="title-lg fw-bolder my-4"><?php echo $title; ?></h3>
			</div>
		<div class='row'>
			<div class='col-12 col-md-10'>
			<h6 class='text-lg'><b><i class='fa fa-trophy'></i> Purchase our <?php echo $plan_detail[0]->name; ?> Plan for $<?php echo str_replace('.00', '', $plan_detail[0]->price); ?></b></h6>
			<?php if($plan_detail[0]->id == 3){ ?>
			<div class='text-sm'>You are on our highest plan! It can't get any better than this! </div>
			<?php }else{ ?>
			<div class='text-sm'>Upgrading means <b>increased exposure</b>, additional photos, features, and more flexibility.</div>
			<?php } ?>
			</div>
			<div class='col-6 col-md-2'>
			<a class="btn my-4 my-md-0 min-w-auto w-100" href="<?php echo base_url('plan'); ?>">CHANGE PLAN</a>
			</div>
		</div>
			<hr>
			<div class='row'>
				<div class='col-12 col-sm-6'>
					
					<form id="payment-form" action='<?php echo base_url(); ?>/checkout-post' method='post' class="mb-4">
						<?php 
						if(!empty($cards)){ ?>
					<div class="carddetail">
						<p class="text-primary fw-medium">Use your saved cards</p>
						<?php 
						if(!empty($cards)){
							foreach ( $cards->data as $s => $source ) { ?>
								<div class="card mb-2 rounded-5">
								<div class="d-flex justify-content-between align-items-center p-3">
								<div class="d-flex justify-content-between align-items-center">
								<div class="me-3 form-section"><label class="form-group d-flex justify-content-between align-items-center"><input onclick="show_hide_card(this)" type="radio" name="card_id" value="<?php echo $source->id; ?>" class="" /></label></div>
								<div class="me-3">
								<?php if( $source->brand=='Visa'){ ?>
								<svg class="SVGInline-svg SVGInline--cleaned-svg SVG-svg BrandIcon-svg BrandIcon--size--32-svg" height="32" width="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h32v32H0z" fill="#00579f"></path><g fill="#fff" fill-rule="nonzero"><path d="M13.823 19.876H11.8l1.265-7.736h2.023zm7.334-7.546a5.036 5.036 0 0 0-1.814-.33c-1.998 0-3.405 1.053-3.414 2.56-.016 1.11 1.007 1.728 1.773 2.098.783.379 1.05.626 1.05.963-.009.518-.633.757-1.216.757-.808 0-1.24-.123-1.898-.411l-.267-.124-.283 1.737c.475.213 1.349.403 2.257.411 2.123 0 3.505-1.037 3.521-2.641.008-.881-.532-1.556-1.698-2.107-.708-.354-1.141-.593-1.141-.955.008-.33.366-.667 1.165-.667a3.471 3.471 0 0 1 1.507.297l.183.082zm2.69 4.806.807-2.165c-.008.017.167-.452.266-.74l.142.666s.383 1.852.466 2.239h-1.682zm2.497-4.996h-1.565c-.483 0-.85.14-1.058.642l-3.005 7.094h2.123l.425-1.16h2.597c.059.271.242 1.16.242 1.16h1.873zm-16.234 0-1.982 5.275-.216-1.07c-.366-1.234-1.515-2.575-2.797-3.242l1.815 6.765h2.14l3.18-7.728z"></path><path d="M6.289 12.14H3.033L3 12.297c2.54.641 4.221 2.189 4.912 4.049l-.708-3.556c-.116-.494-.474-.633-.915-.65z"></path></g></g></svg>
								<?php }else if( $source->brand=='American Express'){ ?>
								<svg class="SVGInline-svg SVGInline--cleaned-svg SVG-svg BrandIcon-svg BrandIcon--size--32-svg" height="32" width="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><g fill="none" fill-rule="evenodd"><path fill="#0193CE" d="M0 0h32v32H0z"></path><path d="M17.79 18.183h4.29l1.31-1.51 1.44 1.51h1.52l-2.2-2.1 2.21-2.27h-1.52l-1.44 1.51-1.26-1.5H17.8v-.85h4.68l.92 1.18 1.09-1.18h4.05l-3.04 3.11 3.04 2.94h-4.05l-1.1-1.17-.92 1.17h-4.68v-.84zm3.67-.84h-2.53v-.84h2.36v-.83h-2.36v-.84h2.7l1.01 1.26-1.18 1.25zm-14.5 1.68h-3.5l2.97-6.05h2.8l.35.67v-.67h3.5l.7 1.68.7-1.68h3.31v6.05h-2.63v-.84l-.34.84h-2.1l-.35-.84v.84H8.53l-.35-1h-.87l-.35 1zm9.96-.84v-4.37h-1.74l-1.4 3.03-1.41-3.03h-1.74v4.04l-2.1-4.04h-1.4l-2.1 4.37h1.23l.35-1h2.27l.35 1h2.43v-3.36l1.6 3.36h1.05l1.57-3.36v3.36h1.04zm-8.39-1.85-.7-1.85-.87 1.85h1.57z" fill="#FFF"></path></g></svg>
								<?php }else if( $source->brand=='MasterCard'){ ?>
								<svg class="SVGInline-svg SVGInline--cleaned-svg SVG-svg BrandIcon-svg BrandIcon--size--32-svg" height="32" width="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h32v32H0z" fill="#000"></path><g fill-rule="nonzero"><path d="M13.02 10.505h5.923v10.857H13.02z" fill="#ff5f00"></path><path d="M13.396 15.935a6.944 6.944 0 0 1 2.585-5.43c-2.775-2.224-6.76-1.9-9.156.745s-2.395 6.723 0 9.368 6.38 2.969 9.156.744a6.944 6.944 0 0 1-2.585-5.427z" fill="#eb001b"></path><path d="M26.934 15.935c0 2.643-1.48 5.054-3.81 6.21s-5.105.851-7.143-.783a6.955 6.955 0 0 0 2.587-5.428c0-2.118-.954-4.12-2.587-5.429 2.038-1.633 4.81-1.937 7.142-.782s3.811 3.566 3.811 6.21z" fill="#f79e1b"></path></g></g></svg>
								<?php }else if( $source->brand=='Discover'){ ?>								
								<img height="32" width="32" src="<?php echo base_url('assets/img/discover.png'); ?>" />
								<?php }else if( $source->brand=='Diners Club'){ ?>								
								<img height="32" width="32" src="<?php echo base_url('assets/img/dinners.png'); ?>" />
								<?php }else{ ?>									
								<img height="32" width="32" src="<?php echo base_url('assets/img/dummy.png'); ?>" />
								<?php } ?>
								</div>
								<div class="">
								<p class="mb-0"><strong><?php echo $source->brand;?> •••• <?php echo $source->last4;?></strong>
								<?php if($customer->default_source == $source->id){ ?>
								<span class="badge bg-primary">Default</span>
								<?php } ?>
								</p>
								<p class="mb-0">Expires <?php echo date('M',strtotime($source->exp_month)).' '.$source->exp_year; ?></p>
								</div>
								</div>
								</div>
								</div>
							<?php }
						}
						?>	
					</div>
					<p> (or) </p>
					<div class="card mb-2 rounded-5">
						<div class="d-flex justify-content-between align-items-center p-3">
						<div class="d-flex justify-content-between align-items-center">
						<div class="me-3 form-section"><label class="form-group d-flex justify-content-between align-items-center"><input onclick="show_hide_card(this)" type="radio" name="card_id" value="new" class="" /></label></div>
						
						<div class="">
						<p class="mb-0"><strong>New Card</strong>
						</p>
						</div>
						</div>
						</div>
					</div>	
						<input type="hidden" name="customer_id" value="<?php echo $customer->id; ?>" />	
						<?php } ?>
						<input type="hidden" name="plan_id" value="<?php echo $plan_detail[0]->id; ?>" />
						<input type="hidden" name="type" value="<?php echo $type; ?>" />
						<input type="hidden" name="sale_id" value="<?php echo !empty($_GET['sale_id']) ? $_GET['sale_id']:''; ?>" />
						<input type="hidden" name="payment_type" value="<?php echo !empty($_GET['payment_type'])?$_GET['payment_type']:''; ?>" />
					<div class="s-hide" style="display:<?php echo !empty($cards) ? 'none' : ''; ?>">
					<?php if(!empty($cards)){ ?>					
					<p>Please enter your new credit card information below</p>
					<?php }else{ ?>	
					<p>Please enter your credit card information below</p>
					<?php } ?>	
						  <div class="form-row">
							<label for="card-element">Credit or debit card</label>
							<div id="card-element">
							  <!-- a Stripe Element will be inserted here. -->
							</div>
							<!-- Used to display form errors -->
							<div id="card-errors"></div>
						  </div>
					</div>
			  <br>
			  <?php if(!empty($type) && $type=='trial'){ ?>
			  <div class='text-sm'><i>Your first charge will take place on <?php echo date('F jS, Y', strtotime("+1 month")); ?>. You will be billed every <?= $plan_detail[0]->no_of_weeks ?> weeks. Cancel anytime by going to the billing page on your dashboard.</i></div>
			  <?php }else{ ?>
			  <div class='text-sm'><i>You will be billed every <?= $plan_detail[0]->no_of_weeks ?> weeks. Cancel anytime by going to the billing page on your dashboard.</i></div>
			  <?php } ?>
			  
						  <br>
						  <div class='text-lg'>Total: <span class="fs-3 fw-bolder">$<?php echo str_replace('.00', '', $plan_detail[0]->price); ?></span></div>
						  <br>
						  <input type="hidden" name="plan_amount" value="<?php echo str_replace('.00', '', $plan_detail[0]->price); ?>" />
						  
						  <input type='submit' value='<?php echo (!empty($type) && $type=='trial') ? 'Start Free Trial' : 'Pay Now'; ?>' class='btn card-submit-btn' style="display: <?php echo !empty($cards) ? 'none' : 'block' ; ?>	">
					</form>
					<!--
					<p class="text-center">(or)<p>
					
					<?php
					$paypalPriceId = '';
					$clientId = env('paypal.sdk.client');
					if($type == 'trial'){
						$paypalPriceId = $plan_detail[0]->paypal_plan_id_with_trial;
					}else{
						$paypalPriceId = $plan_detail[0]->paypal_plan_id_without_trial;
					}					
					?>					
					<div id="paypal-button-container-<?php echo $paypalPriceId; ?>"></div>
					<script src="https://www.sandbox.paypal.com/sdk/js?client-id=<?php echo $clientId; ?>&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
					<script>
					  paypal.Buttons({
						  style: {
							  shape: 'pill',
							  color: 'gold',
							  layout: 'horizontal',
							  label: 'paypal'
						  },
						  createSubscription: function(data, actions) {
							return actions.subscription.create({
							  /* Creates the subscription */
							  plan_id: '<?php echo $paypalPriceId; ?>'
							});
						  },
						  onApprove: function(data, actions) {
							//alert(data.subscriptionID); // You can add optional success message for the subscriber here
							$.ajax({
								url: '<?php echo base_url(); ?>/providerauth/paypal-success',
								type: 'POST',
								dataType: 'JSON',
								data: {response:data,type:'<?php echo $type; ?>',plan_id:'<?php echo $plan_detail[0]->id; ?>',payment_type:'<?php echo !empty($_GET['payment_type'])?$_GET['payment_type']:''; ?>',sale_id:'<?php echo !empty($_GET['sale_id'])?$_GET['sale_id']:''; ?>',user_id:'<?php echo !empty(session()->get('vr_sess_user_id')) ? session()->get('vr_sess_user_id'):''; ?>'},
								error: function() {
									Swal.fire({
										text: "Something is wrong. Please try again!",
										icon: "error",
										confirmButtonColor: "#34c38f",
										confirmButtonText: "<?php echo trans("ok"); ?>",
									})
								},
								success: function(res) {
									if(res.type == 'success'){
										Swal.fire({
											text: res.message,
											icon: "success",
											confirmButtonColor: "#34c38f",
											confirmButtonText: "<?php echo trans("ok"); ?>",
										}).then(function() {
											window.location.href = "<?php echo base_url(); ?>/add-listing?sale_id="+res.sale_id+"&payment_type=paypal";
										})
									}else{
										Swal.fire({
											text: res.message,
											icon: "error",
											confirmButtonColor: "#34c38f",
											confirmButtonText: "<?php echo trans("ok"); ?>",
										})
									}
								}
							});
						  }
					  }).render('#paypal-button-container-<?php echo $paypalPriceId; ?>'); // Renders the PayPal button
					</script>
					-->
				</div>
				<div class='col-12 col-sm-6'>
					<table class="table table-striped include-plan" width="100%">
						<thead>
							<tr><th>What's Included with this Plan</th><th></th></tr>
						</thead>
						<tbody>
							<tr style="display :<?php echo ($plan_detail[0]->id == 2) ? 'none' : ''; ?>"><td><div><?= $plan_detail[0]->no_of_weeks ?> week listing on PlaneBroker.com</div></td><td class="text-center"><i class="fa fa-check"></i></td></tr>
							<tr><td><div><?= $plan_detail[0]->no_of_photos ?> photos / docs</div></td><td class="text-center"><i class="fa fa-check"></i></td></tr>
							<tr><td><div><?php echo !empty($plan_detail[0]->no_of_videos) ? $plan_detail[0]->no_of_videos.' Videos' : 'No Video';  ?></div></td><td class="text-center"><i class="fa fa-<?php echo !empty($plan_detail[0]->no_of_videos) ? 'check' : 'close';  ?>"></i></td></tr>
							<tr><td><div><?php echo !empty($plan_detail[0]->is_featured_listing) ? 'Featured Listing on Homepage' : 'Not a featured listing';  ?></div></td><td class="text-center"><i class="fa fa-<?php echo !empty($plan_detail[0]->is_featured_listing) ? 'check' : 'close';  ?>"></i></td></tr>
							<tr><td><div><?php echo !empty($plan_detail[0]->is_premium_listing) ? 'Premium listing' : 'Not a premium listing';  ?></div></td><td class="text-center"><i class="fa fa-<?php echo !empty($plan_detail[0]->is_premium_listing) ? 'check' : 'close';  ?>"></i></td></tr>
							
							
							
						</tbody>
					</table>						
				</div>
			</div>
		</div>
		</div>
<div class="loader"></div>
<script>
$(function(){
  $('#card-form').submit(function() {
    $('.loader').show(); 
    return true;
  });
});
function show_hide_card(_this){
	var card_id = $(_this).val();
	if(card_id == 'new'){
		$('.s-hide').show();
	}else{
		$('.s-hide').hide();
	}
	$('.card-submit-btn').show();
}
</script>		
<?= $this->endSection() ?>
<style>
.StripeElement {
    background-color: white;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
}
.StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
}
.StripeElement--invalid {
    border-color: #fa755a;
}
.StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
}
</style>