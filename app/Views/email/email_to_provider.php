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
						<div class="mailcontent" style="line-height: 26px;font-size: 14px;">
						   <div style="padding: 20px; padding-bottom: 40px;">
								<?php echo $message_text; ?>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END MAIN CONTENT AREA -->
</table>
<?php echo $this->include('email/email_footer') ?>