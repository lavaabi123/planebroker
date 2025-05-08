
<style>
.dropdown-toggle::after{
	display:none;
}
</style>
						<?php if(!empty($cards)){ ?>
						
			<div class='row'>
				<div class="col-sm-6">
					<div class="carddetail">
						<?php 
						if($cards->data){
							foreach ( $cards->data as $s => $source ) { ?>
								<div class="card mb-2">
								<div class="d-flex justify-content-between align-items-center p-3">
								<div class="d-flex justify-content-between align-items-center">
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
								<div class="">
                                <div class="dropdown">
								  <span class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									•••
								  </span>
								  <ul class="dropdown-menu">
									<?php if($customer->default_source == $source->id){ ?>
									<li><a class="dropdown-item" style="<?php echo ($customer->default_source == $source->id)? 'color: gray;cursor: no-drop;' : '' ?>" href="javascript:void(0);">Set as default</a></li>
									<?php }else{ ?>
									<li><a class="dropdown-item" onclick="set_default('<?php echo $source->id; ?>','<?php echo $source->customer; ?>')" href="javascript:void(0);">Set as default</a></li>
									<?php } ?>
									
									<!--<li><a class="dropdown-item" onclick="edit_card('<?php echo $source->id; ?>','<?php echo $source->customer; ?>)" href="javascript:void(0);">Edit</a></li>-->
									
									<?php if($customer->default_source == $source->id){ ?>
									<li><a class="dropdown-item" style="<?php echo ($customer->default_source == $source->id)? 'color: gray;cursor: no-drop;' : '' ?>" href="javascript:void(0);">Delete</a></li>
									<?php }else{ ?>
									<li><a class="dropdown-item" onclick="delete_card('<?php echo $source->id; ?>','<?php echo $source->customer; ?>')" href="javascript:void(0);">Delete</a></li>
									<?php } ?>
								  </ul>
								</div>
								</div>
								</div>
								</div>
							<?php }
						}
						?>	
					</div>
					<hr>
					<!--<div class="carddetail">
						<h3 class="title-sm dblue mb-0">Subscription:</h3>
						<?php
						foreach ($subscriptions->data as $subscription) {
						    if ($subscription->status == 'active') {
						?>
                            <p><?php echo $subscription->metadata->title . " ($" . moneyFormat($subscription->plan->amount / 100) . "/mo)";?>
                            <br><strong class="dblue">Last Payment:</strong> <?php echo date("m/d/Y", $subscription->current_period_start);?>
                            <br><strong class="dblue">Next Payment:</strong> <?php echo date("m/d/Y", $subscription->current_period_end);?>
                            <br>
                            </p>
                        <?php }
						}
						?>

					</div>-->
				</div>
				<div class='col-sm-6 '>
					<form id="payment-form" action='<?php echo base_url(); ?>/providerauth/update-card-post' method='post'>	
							<!--<div class="credit-card-input no-js form-group" id="skeuocard">
							<label for="cc_type">Card Type</label>
							<select name="cc_type" class="form-control">
							  <option value="">...</option>
							  <option value="visa">Visa</option>
							  <option value="discover">Discover</option>
							  <option value="mastercard">MasterCard</option>
							  <option value="maestro">Maestro</option>
							  <option value="jcb">JCB</option>
							  <option value="unionpay">China UnionPay</option>
							  <option value="amex">American Express</option>
							  <option value="dinersclubintl">Diners Club</option>
							</select>
							<label for="cc_number">Card Number</label>
							<input type="text" class="form-control" name="cc_number" id="cc_number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" size="19">
							<label for="cc_exp_month">Expiration Month</label>
							<input type="text" class="form-control" name="cc_exp_month" id="cc_exp_month" placeholder="00">
							<label for="cc_exp_year">Expiration Year</label>
							<input type="text" class="form-control" name="cc_exp_year" id="cc_exp_year" placeholder="00">
							<label for="cc_name">Cardholder's Name</label>
							<input type="text" class="form-control" name="cc_name" id="cc_name" placeholder="John Doe">
							<label for="cc_cvc">Card Validation Code</label>
							<input type="text" class="form-control" name="cc_cvc" id="cc_cvc" placeholder="123" maxlength="3" size="3">
						  </div>-->
						  <div class="form-row">
							<label for="card-element"><h5>Add card</h5></label>
							<div id="card-element">
							  <!-- a Stripe Element will be inserted here. -->
							</div>
							<!-- Used to display form errors -->
							<div id="card-errors"></div>
						  </div>
						  <br>						  
						  <input type="hidden" name="customerId" value="<?php echo $customerId; ?>" />
						  <input type='submit' value='Save' class='btn'>
						  <!--<a href="<?php echo base_url().'/providerauth/update-card/';?>" class="cancel btn">Cancel</a>-->
					</form>
				</div>
				</div><?php }else{
					echo '<p>No Records Found.</p>';
				} ?>
<div class="loader"></div>
<script>
$(function(){
  $('#card-form').submit(function() {
    $('.loader').show(); 
    return true;
  });
});
function set_default(source_id,customer_id){
    $('.loader').show(); 
	$.ajax({
		url: '<?php echo base_url(); ?>/providerauth/stripe_set_default',
		type: 'POST',
		data: {source_id:source_id,customer_id:customer_id},
		success: function(res) {
			$('.loader').hide(); 
			Swal.fire({
				text: "Changed Successfully!",
				icon: "success",
				confirmButtonColor: "#34c38f",
				confirmButtonText: "<?php echo trans("ok"); ?>",
			}).then((result) => {
			   if(result){
				 // Do Stuff here for success
				 location.reload();
			   }else{
				// something other stuff
			   }
			})
			
		}
	});
}

function delete_card(source_id,customer_id){
    $('.loader').show(); 
	$.ajax({
		url: '<?php echo base_url(); ?>/providerauth/stripe_delete_card',
		type: 'POST',
		data: {source_id:source_id,customer_id:customer_id},
		success: function(res) {
			$('.loader').hide(); 
			Swal.fire({
				text: "Deleted Successfully!",
				icon: "success",
				confirmButtonColor: "#34c38f",
				confirmButtonText: "<?php echo trans("ok"); ?>",
			}).then((result) => {
			   if(result){
				 // Do Stuff here for success
				 location.reload();
			   }else{
				// something other stuff
			   }
			})
			
		}
	});
}
</script>	