<?php echo $this->include('email/email_header') ?>           
<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main">
	<!-- START MAIN CONTENT AREA -->
	<tr>
		<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>					
					<td><img src="<?php echo base_url()."/assets/img/subs_cancellation.jpg"; ?>" alt="" width="100%" style="display: block;" /></td>
				</tr>
				<tr>
					<td>
						<div class="mailcontent" style="margin-top: 30px;line-height: 20px;font-size: 14px;">
						
						
						<p>Dear <?php echo $to_name; ?>,</p>

<p>We hope this email finds you well. We regret to inform you that your subscription to Planebroker.com has been canceled as per your recent request.</p>

<p>Here are some important details regarding the cancellation:<br />
<strong>1. Profile Visibility:</strong> Your profile will no longer be visible on Planebroker.com. Customers and potential clients will not be able to access your information on our platform.<br />
<strong>2. Loss of Analytics and Data:</strong> Unfortunately, with the cancellation of your subscription, access to your analytics and data insights has been discontinued. Any historical data or analytics will no longer be accessible.<br />
<strong>3. Customer Data and Messages:</strong> Please be aware that upon cancellation, your customer data and messages from clients will be deleted. This includes any correspondence and valuable insights you may have gained from interactions with your customers.</p>

<p>However, please be informed that we value your presence on Planebroker.com, and your profile information will be securely stored in our system. In the event that you decide to return, your profile can be reactivated, and you can resume enjoying the benefits of our platform.</p>

<p>We understand that circumstances change, and we want to assure you that you are welcome back anytime. If you ever wish to renew your subscription, simply log in to your account and follow the renewal process. Your existing profile will be reinstated, and you can continue connecting with clients in no time.</p>

<p>If you have any questions or concerns regarding the cancellation or if there's anything we can assist you with, please feel free to reach out to our <a href="<?php echo base_url('/contact'); ?>" target="_blank">customer support team</a> at [support@planebroker.com].</p>

<p>We appreciate the time you spent with us on Planebroker.com and hope to welcome you back in the future.</p>

<p style='margin-top: 30px;margin-bottom: 20px '>Best regards,<br />
Customer Support Team <br />
Planebroker.com</p>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END MAIN CONTENT AREA -->
</table>
<?php echo $this->include('email/email_footer') ?>
