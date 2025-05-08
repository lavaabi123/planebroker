<?php echo $this->include('email/email_header') ?>       
	<!-- START CENTERED WHITE CONTAINER -->
	<table role="presentation" class="main">
		<!-- START MAIN CONTENT AREA -->
		<tr>
			<td class="wrapper">
				<table role="presentation" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold">You have received a message from a customer.</h1>
							<div class="mailcontent" style="line-height: 26px;font-size: 14px;">
								<p style='text-align: center'>
									<?php echo trans("name"); ?>:&nbsp;<?php echo html_escape($message_name); ?><br>
									<?php echo trans("email"); ?>:&nbsp;<?php echo html_escape($message_email); ?><br><br>
									<?php echo html_escape($message_text); ?>
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