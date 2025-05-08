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
						<h6 style="font-size: 16px;line-height: 36px;font-weight: bold;margin-top:25px;text-align:center;margin-bottom: 20px ">Email Address Validation Reminder</h6>
						<div class="mailcontent" style="line-height: 20px;font-size: 14px;">
							<p style='text-align: center'>Last Chance to Confirm Your Email</p>
							<p style='text-align: center'>
								<?php echo trans("msg_confirmation_email"); ?><br>
							</p>
							<p style='text-align: center;margin-top: 30px;margin-bottom: 20px '>
								<a href="<?php echo base_url(); ?>/providerauth/confirm?token=<?php echo $token; ?>" style='font-size: 16px;font-weight: 700;text-decoration: none;padding: 14px 40px;background-color: #000;color: #ffffff !important; border-radius: 25px;'>
									<?php echo trans("confirm_your_email"); ?>
								</a>
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
