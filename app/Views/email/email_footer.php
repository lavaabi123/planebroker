            <!-- END CENTERED WHITE CONTAINER -->
			</td>
        </tr>
		</tbody>
		<!-- START FOOTER -->
		<tfoot  style="background: #ededed; text-align: center;">
		<tr>
			<td>
				<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="padding: 0 10px;">
					<tr>
						<td style="padding: 40px 0px;">
							<p style="color: #7a7a7a; font-size:18px;margin-bottom: 0;">We make it Easy to make the Best decision.</p>
							<h3 style="color: #000000; font-size:21px;margin-bottom: 0;font-weight: 900;">Thank you for helping us in the process!</h3>
						</td>
					</tr>
					<tr>
						<td style="padding-bottom: 20px;">
							<a href="<?php echo base_url(); ?>">
								<img src="<?php echo get_logo_email(get_general_settings()); ?>" alt="" style="max-width: 240px;max-height: 70px;">
							</a>				
						</td>			
					</tr>			
					<tr>				
					<td class="content-block" style="text-align: center;width: 100%; padding: 0;">					
						<?php if (!empty(get_general_settings()->facebook_url)) : ?>						
						<a href="<?php echo html_escape(get_general_settings()->facebook_url); ?>" target="_blank" style="margin-right: 5px;">	
							<img src="<?php echo base_url('assets/img/fb.png'); ?>" />	
						</a>					
						<?php endif; ?>					
						<?php if (!empty(get_general_settings()->twitter_url)) : ?>						
						<a href="<?php echo html_escape(get_general_settings()->twitter_url); ?>" target="_blank" style="margin-right: 5px;">							
							<img src="<?php echo base_url('assets/img/twitter.png'); ?>" />	
						</a>
						<?php endif; ?>					
						<!--<?php if (!empty(get_general_settings()->pinterest_url)) : ?>						
						<a href="<?php echo html_escape(get_general_settings()->pinterest_url); ?>" target="_blank">
							<img src="<?php echo base_url(); ?>assets/images/social-icons/pinterest.png" alt="" style="width: 28px; height: 28px;" />
						</a>					
						<?php endif; ?>-->			
						<?php if (!empty(get_general_settings()->instagram_url)) : ?>
						<a href="<?php echo html_escape(get_general_settings()->instagram_url); ?>" target="_blank" style="margin-right: 5px;">
							<img src="<?php echo base_url('assets/img/instagram.png'); ?>" />	
						</a>					
						<?php endif; ?>					
						<!--<?php if (!empty(get_general_settings()->linkedin_url)) : ?>
						<a href="<?php echo html_escape(get_general_settings()->linkedin_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
							<img src="<?php echo base_url(); ?>assets/images/social-icons/linkedin.png" alt="" style="width: 28px; height: 28px;" />
						</a>
						<?php endif; ?>
						<?php if (!empty(get_general_settings()->vk_url)) : ?>
						<a href="<?php echo html_escape(get_general_settings()->vk_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
							<img src="<?php echo base_url(); ?>assets/images/social-icons/vk.png" alt="" style="width: 28px; height: 28px;" />
						</a>					
						<?php endif; ?>-->				
						<?php if (!empty(get_general_settings()->youtube_url)) : ?>						
						<a href="<?php echo html_escape(get_general_settings()->youtube_url); ?>" target="_blank">
							<img src="<?php echo base_url('assets/img/youtube.png'); ?>" />					
						</a>						
						<?php endif; ?>				
					</td>			
				</tr>
				<tr>
					<td class="content-block powered-by" style="text-align: center; padding-top:30px;">					
					<p style="font-size:11px;">If you need Customer Support please contact us <a href="<?php echo base_url('contact'); ?>" style="color:#d65b00; text-decoration: underline;">here for further assistance.</a></p>
						<!--<span class="apple-link" style="display: block;"><?php echo get_general_settings()->contact_address; ?></span>
						<span>Copyright &copy; <?php echo date("Y"); ?> <a style="color: #ffffff;" href="<?php echo base_url(); ?>">Plane Broker</a>. All rights reserved.</span>-->
					</td>
				</tr>			
			</table>			
			</td>			
			</tr>
		</tfoot>
		<!-- END FOOTER -->
    </table>
    <style>
        .wrapper table tr td img {
            height: auto !important;
        }
    </style>
</body>

</html>