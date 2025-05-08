<?php echo $this->include('email/email_header') ?>
    <!-- START CENTERED WHITE CONTAINER -->
	<table role="presentation" class="main">
		<!-- START MAIN CONTENT AREA -->
		<tr>
			<td class="wrapper">
				<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>					
					<td><img src="<?php echo base_url()."/assets/img/welcome.jpg"; ?>" alt="" width="100%" style="display: block;" /></td>
				</tr>
					<tr>
						<td>
							<h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold;margin-top:25px;"><?php echo trans("Subscription Payment Failed"); ?></h1>
							<div class="mailcontent" style="line-height: 26px;font-size: 14px;">
								<!--<p>
									Hi <?php //echo $to_name; ?>,<br>
								</p>-->
								<p>Your subscription payment was unsuccessful, which puts your account at risk of being downgraded to a free account. Please log into your account and update your payment information.</p>
								<p style='text-align: center;margin-top: 30px;'>
									<a href="<?php echo base_url('providerauth/login'); ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #000;color: #ffffff !important; border-radius: 3px;'>Login</a>
								</p>
								<?php /*if(count($subscriptions) < 1){?>
										 <p><strong>Subscription payment failed for:</strong> <?php echo date("m/d/Y", strtotime($enddate));?><br></p>
								<?php }else{ ?>

								<?php if(isset($cards->card->brand)){ ?>
									<p>Your credit card on file is a <strong><?php echo $cards->card->brand;?></strong> ending in <strong><?php echo $cards->card->last4;?></strong><br>
									 <h3><strong>Subscription details:</strong></h3>
									</p>
								<?php } ?>                                  
								<?php
								foreach ($subscriptions->data as $subscription) {
								?>
									<p><?php echo $subscription->metadata->title . " ($" . moneyFormat($subscription->plan->amount / 100) . "/mo)";?>
									<br><strong>Last Payment:</strong> <?php echo date("m/d/Y", $subscription->current_period_start);?>
									<br><strong>Subscription payment failed for:</strong> <?php echo date("m/d/Y", $subscription->current_period_end);?>
									<br></p>
								<?php }
								?>                  
						<?php } */ ?>
							<p> Due to subscription payment failure, your plan has been changed to <strong>Free</strong>.
							 <br><a href="<?php echo base_url('contact'); ?>">Click here</a> to contact Plane Broker Administrator.
							</p>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- END MAIN CONTENT AREA -->
	</table>
<?php echo $this->include('email/email_footer') ?>