<?php echo $this->include('email/email_header') ?>           
<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main">
	<!-- START MAIN CONTENT AREA -->
	<tr>
		<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>					
					<td><img src="<?php echo base_url()."/assets/img/recovery.jpg"; ?>" alt="" width="100%" style="display: block;" /></td>
				</tr>
				<tr>
					<td>
						<div class="mailcontent" style="margin-top: 30px;line-height: 20px;font-size: 14px;">
							<p>We miss having you as an essential part of the Plane Broker community! 🐾
As a valued broker, we understand that circumstances change, and we appreciate the time you spent with us. We're reaching out to let you know that your profile has been missed by plane owners in your area.</p>
							<p>
<?php if($recent_searches > 0){ ?>
🔍 Recent Searches in Your Zip Code:<?php echo $recent_searches; ?><br/>
<?php } ?>
<?php if($recent_connections > 0){ ?>
🤝 Recent Connections with Brokers:<?php echo $recent_connections; ?>
<?php } ?>
</p>
<p>
Your expertise is in demand, and there are plane owners actively seeking services in your specific area. We believe your return will not only benefit you but also contribute to the satisfaction of plane owners searching for the perfect broker.</p>

<p>To reactivate your subscription and regain access to these potential clients, simply click on the button below:</p>

<a href="<?php echo base_url(); ?>/plan" style='display: inline-block;font-size: 12px;font-weight: 700;text-decoration: none;padding: 12px 50px;background-color: #ff6c00; color: #ffffff !important;border-radius: 25px; letter-spacing: 1px;'>Reactivate My Subscription</a><br/><br/>
						<p>
We understand that circumstances change, and we're here to support you in reconnecting with the Plane Broker community.

Thank you for considering coming back. We're excited to have you back on board!
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
