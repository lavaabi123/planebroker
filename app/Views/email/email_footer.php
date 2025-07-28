</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td style="text-align:center;background: #e6eaee; padding: 30px 10px;">
				<img src="<?php echo base_url(); ?>/assets/img/email_images/tag.png">
				<table align="center" cellspacing="15" style="padding: 20px 10px;">
					<tr>
						<?php if (!empty(get_general_settings()->facebook_url)) : ?><td><a href="<?php echo html_escape(get_general_settings()->facebook_url); ?>" target="_blank"><img src="<?php echo base_url(); ?>/assets/img/email_images/facebook.png" /></a></td><?php endif; ?>	
						<?php if (!empty(get_general_settings()->instagram_url)) : ?><td><a href="<?php echo html_escape(get_general_settings()->pinterest_url); ?>" target="_blank"><img src="<?php echo base_url(); ?>/assets/img/email_images/instagram.png" /></a></td><?php endif; ?>	
						<?php if (!empty(get_general_settings()->twitter_url)) : ?><td><a href="<?php echo html_escape(get_general_settings()->twitter_url); ?>" target="_blank"><img src="<?php echo base_url(); ?>/assets/img/email_images/x.png" /></a></td><?php endif; ?>	
						<?php if (!empty(get_general_settings()->youtube_url)) : ?><td><a href="<?php echo html_escape(get_general_settings()->youtube_url); ?>" target="_blank"><img src="<?php echo base_url(); ?>/assets/img/email_images/youtube.png" /></a></td><?php endif; ?>	
						<?php if (!empty(get_general_settings()->pinterest_url)) : ?><td><a href="<?php echo html_escape(get_general_settings()->pinterest_url); ?>" target="_blank"><img src="<?php echo base_url(); ?>/assets/img/email_images/pinterest.png" /></a></td><?php endif; ?>	
					</tr>
				</table>
				<img src="<?php echo base_url(); ?>/assets/img/email_images/logo.png" width="320px">
				<p style="margin: 30px 0 0;">If you need Customer Support please contact us <a href="<?php echo base_url('contact'); ?>" target="_blank" style="color:#f89f1e;text-decoration: none;">here for further assistance.</a></p>
			</td>
		</tr>
	</tfoot>
</table>

</body>
</html>	