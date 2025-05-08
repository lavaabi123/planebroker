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
						<h2 style="font-size: 36px;line-height: 36px;font-weight: bold;margin-bottom:25px;text-align:center"><?php echo "Payment Confirmation"; ?></h2>
						<div class="mailcontent" style="line-height: 26px;font-size: 14px;">
							<p style='text-align: center'>
								Payment has been successfully made and Your plan has been upgraded, unlocking new features and benefits! <br>
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
