<?php echo $this->include('email/email_header') ?>           
<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main" border="0" cellpadding="0" cellspacing="0">
	<!-- START MAIN CONTENT AREA -->
	<tr>
		<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>					
					<td><img src="<?php echo base_url()."/assets/img/confrimmail.jpg"; ?>" alt="" width="100%" style="display: block;" /></td>
				</tr>
				<tr>
					<td style="padding: 20px 0px;">
						<p style="color: #000000;font-size:11px; margin-bottom: 5px;">To enjoy our services, please click the link below to confirm your email:</p>
						<p style=" text-align: center; margin: 20px 0px;">
							<a href="<?php echo base_url(); ?>/providerauth/confirm?token=<?php echo $token; ?>" style='display: inline-block;font-size: 12px;font-weight: 700;text-decoration: none;padding: 12px 50px;background-color: #ff6c00; color: #ffffff !important;border-radius: 25px; letter-spacing: 1px;'>CONFIRM MY E-MAIL</a>
						</p>
						<p style="color: #000000; font-size:11px; margin-bottom: 5px;">Once confirmed, you'll have full access to our platform and be connected with pet owners in your area.</p>
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
