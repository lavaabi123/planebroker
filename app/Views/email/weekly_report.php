<?php echo $this->include('email/email_header') ?>           
<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main" border="0" cellpadding="0" cellspacing="0">
	<!-- START MAIN CONTENT AREA -->
	<tr>
		<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
				<tr>					
					<td><img src="<?php echo base_url()."/assets/img/welcome.jpg"; ?>" alt="" width="100%" style="display: block;" /></td>
				</tr>
				<tr>
					<td style="padding: 20px 0px;">
					<?php echo $menu; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END MAIN CONTENT AREA -->
</table>
<?php echo $this->include('email/email_footer') ?>
