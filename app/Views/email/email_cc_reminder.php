<?php echo $this->include('email/email_header') ?>           
<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main">
	<!-- START MAIN CONTENT AREA -->
	<tr>
		<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>					
					<td><img src="<?php echo base_url()."/assets/img/cc_reminder.jpg"; ?>" alt="" width="100%" style="display: block;" /></td>
				</tr>
				<tr>
					<td>
						<div class="mailcontent" style="margin-top: 30px;line-height: 20px;font-size: 14px;">
							<p>Thank you for registering at Planebroker.com! You're almost there!
							<br />To fully activate your account and make your profile visible, please complete your registration by selecting a plan and entering your credit card information. Don't worry, you'll enjoy a 30-day free trial, and your card will not be charged until the trial period concludes.
							</p>
							<p style=" text-align: center; margin: 20px 0px;">
								<a href="<?php echo base_url(); ?>/providerauth/login" style='display: inline-block;font-size: 12px;font-weight: 700;text-decoration: none;padding: 12px 50px;background-color: #ff6c00; color: #ffffff !important;border-radius: 25px; letter-spacing: 1px;'>Login to your Account</a>
							</p>
							<p style='margin-top: 30px;margin-bottom: 20px '>
								Thank you, <br />
								The Plane Broker Team
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
