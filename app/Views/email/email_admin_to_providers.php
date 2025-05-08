<?php echo $this->include('email/email_header') ?>
    <!-- START CENTERED WHITE CONTAINER -->
	<table role="presentation" class="main">
		<!-- START MAIN CONTENT AREA -->
		<tr>
			<td class="wrapper">
				<table role="presentation" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<div class="mailcontent" style="line-height: 26px;font-size: 14px;">
								<?php echo $user_message; ?>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- END MAIN CONTENT AREA -->
	</table>
<?php echo $this->include('email/email_footer') ?>