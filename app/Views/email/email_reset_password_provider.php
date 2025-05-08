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
							<h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("reset_password"); ?></h1>
							<div class="mailcontent" style="line-height: 26px;font-size: 14px;">
								<p style='text-align: center'>
									<?php echo trans("email_reset_password"); ?><br>
								</p>
								<p style='text-align: center;margin-top: 30px;'>
									<a href="<?php echo base_url('providerauth/reset-password'); ?>?token=<?php echo $token; ?>" style='display: inline-block;font-size: 12px;font-weight: 700;text-decoration: none;padding: 12px 50px;background-color: #ff6c00; color: #ffffff !important;border-radius: 25px; letter-spacing: 1px;'>
										<?php echo trans("RESET PASSWORD"); ?>
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