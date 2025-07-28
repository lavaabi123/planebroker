<?php echo $this->include('email/email_header') ?>           
<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main" border="0" cellpadding="0" cellspacing="0">
	<!-- START MAIN CONTENT AREA -->
	<tr>
		<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 20px 0px;">
						<p style="color: #000000;font-size:11px; margin-bottom: 5px;">Welcome to <a href="<?php echo base_url(); ?>">planebroker.com</a> the premier platform for showcasing Aircraft excellence!</p>
						<p style="color: #555555;font-size:11px; margin-bottom: 5px;">We're delighted to welcome you to our team who are committed to delivering exceptional services for our clients. To begin, kindly log in to your dashboard and add listing. If you have any inquiries or concerns, please reach out to our support team for assistance.</p>
						<p style=" text-align: center; margin: 20px 0px;">							<a href="<?php echo base_url(); ?>/login" style='display: inline-block; line-height: 14px; font-size: 12px;font-weight: 700;text-decoration: none;padding: 12px 50px;background-color: #ff6c00; color: #ffffff !important;border-radius: 25px; letter-spacing: 1px;'>LOG IN NOW</a>						</p>
						
						<p style="color: #000000; font-size:11px; margin-bottom: 5px;">Best regards, </p>
						<p style="color: #000000; font-size:11px; margin-bottom: 0px;"><strong>The Plane Broker Team</strong></p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END MAIN CONTENT AREA -->
</table>
<?php echo $this->include('email/email_footer') ?>
