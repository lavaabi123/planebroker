<?php echo $this->include('email/email_header') ?>       
	<!-- START CENTERED WHITE CONTAINER -->
	<table role="presentation" class="main" style="width:100%;">
		<!-- START MAIN CONTENT AREA -->
		<tr>
			<td class="wrapper">
				<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width:100%;">
					<tr>
						<td>
							<p style="margin-bottom:5px;">Thank you for your interest in the:</p>
							<h3 style="font-weight: 900;font-size: 24px; text-decoration: underline; margin: 0 0 18px;color: #0c3389;"><?php echo !empty($product_detail['display_name']) ? $product_detail['display_name'] : 'Aircraft'; ?></h3>
							<p>Your message has been sent to <strong style="color: #0c3389;"><?php echo !empty($product_detail['fullname']) ? $product_detail['fullname'] : 'Seller'; ?></strong></p>
							<div style="background: #e6eaee; padding: 20px 30px; margin-bottom: 12px; border-radius: 50px; border: 2px solid #d5d7db;">
								<strong>Seller Information:</strong>
								<p style="text-align: left;line-height: 21px; margin: 20px 0 6px;">Seller Name: <?php echo !empty($product_detail['fullname']) ? $product_detail['fullname'] : 'Seller'; ?><br/>
								Telephone Number: <?php echo !empty($product_detail['phone']) ? $product_detail['phone'] : '-'; ?><br/>
								Location: <?php echo !empty($product_detail['address']) ? $product_detail['address'] : '-'; ?> <br/>
								Aircraft Price: <?php echo ($product_detail['price'] != NULL) ? 'USD $'.number_format((float)str_replace(',', '',$product_detail['price']), 2, '.', ',') : 'Call for Price'; ?></p>
							</div>
							<a href="<?php echo base_url('/listings/'.$product_detail['permalink'].'/'.$product_detail['id'].'/'.(!empty($product_detail['display_name'])?str_replace(' ','-',strtolower($product_detail['display_name'])):'')); ?>" style=" background: #f89f1e; letter-spacing:1px; display: block; font-weight: 700; text-decoration: none; color: #ffffff; padding: 12px; border-radius: 25px;">CONTACT SELLER AGAIN</a>
							<a href="<?php echo base_url('/listings/'.$product_detail['permalink'].'/'.$product_detail['id'].'/'.(!empty($product_detail['display_name'])?str_replace(' ','-',strtolower($product_detail['display_name'])):'')); ?>" style=" background: #07163a; letter-spacing:1px; margin-top: 12px; display: block; font-weight: 700; text-decoration: none; color: #ffffff; padding: 12px; border-radius: 25px;">ADD TO MY FAVORITES</a>
							<p style="font-size: 11px; margin:3px 0 25px;">Must be logged in as a registered user</p>
							<hr style="opacity: 0.2;">
							<?php if(!empty($additional)){ ?>
							<h3 style="font-weight: 900;font-size: 24px; margin-bottom: 18px;color: #07163a;">Additional items you may like!</h3>
							<div style="display: inline-block;width:100%;">
							<table width="100%" cellpadding="5" cellspacing="0" style="text-align:left;">
							<tr>
							<?php foreach($additional as $cat){ ?>
								<td>
									<img src="<?php echo !empty($cat['image']) ? $cat['image'] : 'images/plane1.png'; ?>" style="width: 100%;border-radius: 15px; overflow: hidden;" />
									<h4 style="margin:10px 0 0;color: #07163a;"><?php echo !empty($cat['name']) ? $cat['name'] : '-'; ?></h4>
									<h4 style="margin:0; color: #f89f1e;"><?php echo !empty($cat['sub_cat_name']) ? $cat['sub_cat_name'] : '-'; ?></h4>
									<p style="margin:0;color:#8f8f8f;"><?php echo !empty($cat['address']) ? $cat['address'] : '-'; ?> </p>
									<h4 style="color: #07163a;"><?php echo ($cat['price'] != NULL) ? 'USD $'.number_format($cat['price'], 2, '.', ',') : 'Call for Price'; ?></h4>
								</td>
							<?php } ?>
							</tr>
							</table>						
							</div>
							<?php } ?>
							<a href="#" style=" background: #f89f1e; letter-spacing:1px; display: block; font-weight: 700; text-decoration: none; color: #ffffff; padding: 12px; border-radius: 25px;">VIEW ALL LISTINGS</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- END MAIN CONTENT AREA -->
	</table>
<?php echo $this->include('email/email_footer') ?>