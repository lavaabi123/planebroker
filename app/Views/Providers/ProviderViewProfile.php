<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- reCAPTCHA JS-->
<script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>"></script>
<!-- Include script -->
<script type="text/javascript">
	grecaptcha.ready(function() {
		 grecaptcha.execute("<?= getenv('GOOGLE_RECAPTCHAV3_SITEKEY') ?>", {action: 'validate'}).then(function(token) {
			  // Store recaptcha response
			  $("#g-recaptcha-response").val(token);
$("#g-recaptcha-response1").val(token);
		 });
	});
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>
 
<?php
$img = '';
if(!empty($product_detail['image'])){
	$img = $product_detail['image'];
}else{ 
	$img =  base_url()."/assets/img/user.png";				
}
?>

<div class="profileGallery text-center bg-blue py-5">
	<h4 class="mb-0 text-white"><?php echo !empty($product_detail['name']) ? $product_detail['name'] : ''; ?></h4>
	<p class="mb-3 text-primary fw-bold title-sm"><?php echo $product_detail['sub_cat_name']; ?></p>
	<h4 class="mb-4 text-white"><?php echo ($product_detail['price'] != NULL) ? 'USD $'.number_format($product_detail['price'], 2, '.', ',') : 'Call for Price'; ?></h4>
	<p class="mb-3 text-primary fw-bold title-sm"><?php echo $product_detail['aircraft_status']; ?></p>
	
	<div class="container pt-2">
<?php 
$file_overall = array();
$images = array();
$videos = array();
if(!empty($user_photos)){
	foreach($user_photos as $p => $photo){ 
		if($photo['file_type'] == 'image'){
			$images[] = array('image',base_url()."/uploads/userimages/".$userId."/".$photo['file_name'],$photo['image_tag']);
		}else{
			$images[] = array('video',base_url()."/uploads/userimages/".$userId."/".$photo['file_name'],$photo['image_tag']);
		}
	}
}
$count = !empty($images) ? count($images) : 0;
?>

<div class="row mb-5">
    <?php if ($count === 0): ?>
        <div class="col-12 col-md-6 mx-auto">
		<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt(0)">
		<img class="d-block w-100 br-full" alt="..." src="<?php echo !empty($cat['image']) ? $cat['image'] : base_url()."/assets/frontend/images/user.png"; ?>">
		</a>
        </div>
		
	<?php elseif ($count === 1): ?>
        <div class="col-12 col-md-6 mx-auto">
		<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt(0)">
		<?php if($images[0][0] == 'image'){ ?>
            <img class="img-fluid w-100 br-full" src="<?= $images[0][1] ?>">
		<?php }else{ ?>
			<div class="video-wrapper">
				<video  muted playsinline preload="metadata" style="cursor: pointer;">
					<source src="<?= $images[0][1] ?>" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			</div>
		<?php } ?>
		</a>
        </div>

    <?php elseif ($count === 2): ?>
        <?php foreach ($images as $kl => $imgv): ?>
            <div class="col-6 two">
			<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt('<?= $kl ?>')">
			<?php if($imgv[0] == 'image'){ ?>
                <img class="img-fluid w-100" src="<?= $imgv[1] ?>">
			<?php }else{ ?>			
				<div class="video-wrapper">
					<video  muted playsinline preload="metadata" class="w-100" style="cursor: pointer;">
						<source src="<?= $imgv[1] ?>" type="video/mp4">
						Your browser does not support the video tag.
					</video>
				</div>
			<?php } ?>
			</a>
            </div>
        <?php endforeach; ?>

    <?php elseif ($count === 3): ?>
        <div class="col-6 two">
		<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt(0)">
		<?php if($images[0][0] == 'image'){ ?>
            <img class="img-fluid w-100 h-100 br-left" src="<?= $images[0][1] ?>">
		<?php }else{ ?>
			<div class="video-wrapper">
			<video  muted playsinline preload="metadata" style="cursor: pointer;">
				<source src="<?= $images[0][1] ?>" type="video/mp4">
				Your browser does not support the video tag.
			</video>
			</div>
		<?php } ?>
		</a>
        </div>
        <div class="col-6 two">
		<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt(1)">
		<?php if($images[1][0] == 'image'){ ?>
            <img class="img-fluid w-100" src="<?= $images[1][1] ?>">
		<?php }else{ ?>
			<div class="video-wrapper">
			<video  muted playsinline preload="metadata" style="cursor: pointer;">
				<source src="<?= $images[1][1] ?>" type="video/mp4">
				Your browser does not support the video tag.
			</video>
			</div>
		<?php } ?>
		</a>
        </div>

    <?php elseif ($count === 4): ?>
       <div class="col-6 two">
		<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt(0)">
	    <?php if($images[0][0] == 'image'){ ?>
            <img class="img-fluid w-100 h-100 br-left" src="<?= $images[0][1] ?>">
		<?php }else{ ?>
			<div class="video-wrapper">
			<video  muted playsinline preload="metadata" style="cursor: pointer;">
				<source src="<?= $images[0][1] ?>" type="video/mp4">
				Your browser does not support the video tag.
			</video>
			</div>
		<?php } ?>
		</a>
        </div>
        <div class="col-6 two">
		<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt(1)">
		<?php if($images[1][0] == 'image'){ ?>
            <img class="img-fluid w-100" src="<?= $images[1][1] ?>">
		<?php }else{ ?>
			<div class="video-wrapper">
			<video  muted playsinline preload="metadata" style="cursor: pointer;">
				<source src="<?= $images[1][1] ?>" type="video/mp4">
				Your browser does not support the video tag.
			</video>
			</div>
		<?php } ?>
		</a>
        </div>

    <?php elseif ($count >= 5): ?>
        <div class="col-sm-6 five">
		<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt(0)">
			<?php if($images[0][0] == 'image'){ ?>
            <img class="img-fluid w-100 h-100 br-left" src="<?= $images[0][1] ?>">
			<?php }else{ ?>
				<div class="video-wrapper">
				<video  muted playsinline preload="metadata" style="cursor: pointer;">
					<source src="<?= $images[0][1] ?>" type="video/mp4">
					Your browser does not support the video tag.
				</video>
				</div>
			<?php } ?>
		</a>
        </div>
        <div class="col-sm-6 five">
            <div class="row last">
                <?php for ($i = 1; $i < 5; $i++): ?>
                    <div class="col-6">
					<a href="javascript:void(0);" class="text-white" onclick="openGlightboxAt('<?= $i ?>')">
					<?php if($images[$i][0] == 'image'){ ?>
                        <img class="img-fluid w-100" src="<?= $images[$i][1] ?>">
						<?php }else{ ?>
							<div class="video-wrapper">
							<video  muted playsinline preload="metadata" style="cursor: pointer;">
								<source src="<?= $images[$i][1] ?>" type="video/mp4">
								Your browser does not support the video tag.
							</video>
							</div>
						<?php } ?>
						</a>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php if ($count >= 1){ ?>
		<a href="javascript:void(0);" class="btn col-lg-3" id="viewAllPhotosBtn">View All Photos</a>
<?php } ?>
	</div>
</div>

<!-- Hidden Lightbox Anchors for Remaining Images -->
<!--<div id="lightbox-hidden-links" style="display: none;">
    <?php for ($i = 0; $i < count($images); $i++): ?>
        <a href="<?= $images[$i][1] ?>"
           class="lightbox-hidden"
           data-lightbox="jet-gallery"
           data-title="Jet Photo <?= $i+1 ?>">
           Jet Photo <?= $i+1 ?>
        </a>
    <?php endfor; ?>
</div>
-->
<div id="lightbox-hidden-links" style="display: none;">
    <?php foreach ($images as $i => $imgc): ?>
        <?php if ($imgc[0] == 'video'): ?>
            <a href="<?= $imgc[1] ?>"
               class="glightbox"
               data-type="video"
               data-source="local"
               data-title="<?= $imgc[2] ?>">
               <?= $imgc[2] ?>
            </a>
        <?php else: ?>
            <a href="<?= $imgc[1] ?>"
               class="glightbox"
               data-title="<?= $imgc[2] ?>">
               <?= $imgc[2] ?>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

    <div class="viewProfile pt-4 pt-sm-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="container pb-5">
			<div class="row text-black">
				<div class="col-sm-6">
					<?php 
					if(!empty($product_description)){
					?>
					
					<div class="abtAircraft bg-gray rounded-5 px-4 py-5">
						<h4 class="mb-2"><?php echo trans('About this Aircraft'); ?></h4>
						<p><?php echo $product_description->field_value; ?></p>
					</div>			
					<hr class="my-4">	
					<?php }  ?>					
									
					<div class="bg-gray rounded-5 px-4 py-5 mb-4">
						<h4 class="border-bottom mb-0 pb-3"><?php echo trans('General Information'); ?></h4>
						
						<?php
						if(!empty($product_dynamic_fields)){
							foreach($product_dynamic_fields as $pd){
								if(!empty($pd)){
									foreach($pd as $pds){ if(!empty($pds['frontend_show']) && ($pds['group_name'] == 'General Information' || $pds['group_name'] == 'Basic Property Details')){ ?>
									<div class="d-flex justify-content-between border-bottom py-3">
										<span class="left fw-medium"><?php echo str_replace(' ex. OBO, FIRM, MAKE AN OFFER, etc.','',$pds['field_name']); ?></span>
										<span class="right"><?php echo $pds['name']; ?></span>
									</div>	
									<?php } }									
								}
								//break;
							}
						}
						/*
						if(!empty($product_dynamic_fields['Log Book']) && !empty($product_dynamic_fields['Log Book'][0]['name'])){
							foreach($product_dynamic_fields['Log Book'] as $logbook){
						?>
						<div class="text-center mt-4">
						<?php echo '
						<a class="btn blue-btn fw-bold py-4 btn-lg" download href="'.base_url().'/uploads/userimages/'.$userId.'/'.$logbook['name'].'" >Download '.(!empty($logbook['file_field_title']) ? $logbook['file_field_title'] : 'Log Book').'</a>'; ?>
						</div>
							<?php } } */ ?>
					</div>
					
				</div>
				<div class="col-sm-6 proDetails ps-sm-5">
					<h4 class="mb-0"><?php echo $product_detail['name']; ?></h4>
					<p class="mb-3"><?php echo $product_detail['sub_cat_name']; ?></p>
					<h4 class="mb-2"><?php echo ($product_detail['price'] != NULL) ? 'USD $'.number_format($product_detail['price'], 2, '.', ',') : 'Call for Price'; ?></h4>
					<p class="text-primary mb-2 fw-bold"><?php echo !empty($product_detail['price_notes']) ? $product_detail['price_notes'] : ''; ?></p>
					<!--<div class="d-flex align-items-center fw-medium mb-0 open-finance-modal" role="button">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/calculator.png'); ?>" />
						<p class="text-primary">Financial Calculator</p>
					</div>	-->				
					
					<hr>
					
					<?php if(!empty($user_detail->mobile_no)){ ?>
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/phone.png'); ?>" />
						<p class="mb-0"><?php echo !empty($product_detail['phone']) ? $product_detail['phone'] : $user_detail->mobile_no; ?></p>
						<a class="showPhone btn btn-sm mx-3" href="tel:+1<?php echo !empty($product_detail['phone']) ? preg_replace('/\D+/', '', $product_detail['phone']) : preg_replace('/\D+/', '', $user_detail->mobile_no); ?>"> CALL </a>		
						<!--<a href="javascript:void(0)" data-phone="<?php echo phoneFormat($user_detail->mobile_no); ?>" data-label="<?php if(!empty($user_detail->business_name)){ echo "Us"; }else{ echo "Me"; } ?>" class="showPhone button btn yellowbtn mx-3" data-id="<?php echo $userId; ?>" data-pid="<?php echo $product_detail['id']; ?>" onclick="showPhone(this)"> CALL </a>	-->
					
					</div>
					<hr>
					<?php } ?>		
					
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/usericon.png'); ?>" />
						<p class=""><?php echo !empty($product_detail['business_name']) ? $product_detail['business_name'] : $product_detail['user_name']; ?></p>
					</div>
					<hr>
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/pin.png'); ?>" />
						<p class=""><?php echo $product_detail['address']; ?></p>
					</div>
					<hr>
					
					<!-- MESSAGE ME - START -->
					<div id="contact-provider" class="providerMsg rounded-5 p-4 my-5 bg-grey">
					<h5 class="fw-bolder text-center">Message Seller Directly</5>
						<form action="" method="post" id="messageProviderForm" class="form-input mt-4">
							<input type="hidden" id="fromuserId" name="fromuserId" value="<?php echo $fromuserId;?>">
							<input type="hidden" id="userId" name="userId" value="<?php echo $userId;?>">
							<input type="hidden" id="productId" name="productId" value="<?php echo $productId;?>">
							<div class="form-section">
								<div class="form-group"><input type="text" name="name" id="name" class="ucwords form-control" placeholder="Your Name"></div>
								<div class="form-group"><input type="text" name="email" id="email"placeholder="Your Email" class="form-control"></div>
								<div class="form-group"><input type="text" name="phone" id="phone" data-max="10" class="onlyNum form-control" placeholder="Your Phone"></div>
								<div class="form-group">
								<select name="best_way" id="best_way" class="form-control">
								<option value="" >Best way to reach you?</option>
								<option value="Text">Text</option>
								<option value="Call">Call</option>
								<option value="Email">Email</option>
								</select>
								</div>
								<div class="form-group"><textarea name="message" id="message" class="form-control" placeholder="Message"></textarea></div>
								<input type="hidden" id="g-recaptcha-response"  class="form-control" name="check_bot" value="" >
								<input type="submit" value="Submit" class="button btn w-100 mb-4 yellowbtn">
							</div>
						</form>	
					</div><!-- MESSAGE ME - END -->
					<hr>
					<div class="d-flex align-items-center fw-medium mb-0 favorite-btn <?php echo !empty($wishlist_added) ? 'wishlist-added' : ''; ?>" data-page-type="detail" role="button" data-product-id="<?= $product_detail['id']; ?>" data-wish="<?php echo !empty($wishlist_added) ? 1 : 0; ?>">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/wishlist.png'); ?>" />
						<p class="text-primary wishtext"><?php echo !empty($wishlist_added) ? 'Remove from Wishlist' : 'Wishlist';?></p>
					</div>				
					
					<hr>
					<div class="d-flex align-items-center fw-medium mb-0" role="button" data-id="<?php echo $userId; ?>" data-pid="<?php echo $product_detail['id']; ?>" onclick="open_social_share(this)">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/upload.png'); ?>" />
						<p class="text-primary">Share Profile</p>
					</div>					
					
					<hr>
					<!--<hr>
					<a href="javascript:void(0);" class="open-report-modal"><h6 class="dblue mt-3 mb-0">Report ></h6></a>
					<hr>-->
					<!--<div class="px-4 mb-4 providerMsg">
					<?php if(!empty($user_detail->mobile_no)){ ?>
						<a href="javascript:void(0)" data-phone="<?php echo phoneFormat($user_detail->mobile_no); ?>" data-label="<?php if(!empty($user_detail->business_name)){ echo "Us"; }else{ echo "Me"; } ?>" class="showPhone button btn w-100 yellowbtn" onclick="showPhone(this)"><i class="fas fa-phone"></i> CALL ME</a>
					<?php } ?>	
					</div>-->
				</div>
			</div>
			<div class="accordion" id="productDes">
			
			<?php
			if(!empty($product_dynamic_fields)){
				foreach($product_dynamic_fields as $p => $pdv){
					$filecount = 0;
					$newarray = [];
					if(!empty($pdv) && !empty($pdv[0])){
						foreach($pdv as $rg){
							if($rg['field_type'] == 'File'){
								$filecount++;
								$newarray[$rg['field_name']][] = $rg;
							}
						}
						if(count($pdv) == $filecount){
							//all files
							$product_dynamic_fields[$p][0]['items'] = $newarray;
							$product_dynamic_fields[$p] = [ $product_dynamic_fields[$p][0] ];
						}
					}
					 
				}
			}
			//echo '<pre>';
			//print_r($product_dynamic_fields);exit; 
			$pg = 0;
			if(!empty($product_dynamic_fields)){
				foreach($product_dynamic_fields as $p => $pd){
					$pg++;
					if(!empty($pd) && $p != 'General Information' && $p != 'Basic Property Details' && $p != 'Aircraft Status'){ ?>					
						<div class="accordion-item">
							<h2 class="accordion-header">
							  <button class="accordion-button <?php echo ($p != 'Log Book') ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#pd-<?php echo $pg; ?>" aria-expanded="<?php echo ($pg == 2) ? 'true' : 'false'; ?>" aria-controls="pd-<?php echo $pg; ?>">
								<?php echo $p; ?>
							  </button>
							</h2>
							<div id="pd-<?php echo $pg; ?>" class="accordion-collapse collapse <?php echo ($p != 'Log Book') ? 'show' : ''; ?>" >
							  <div class="accordion-body">
						<?php foreach($pd as $pds){ ?>
								<div class="item-list logBook border-0 pb-0 mb-0">
								<?php 
								if($pds['field_type'] == 'File'){
									if(!empty($pds['items'])){ ?>
									<?php 
											$gty = 0;
											foreach($pds['items'] as $rgi => $pdssv){
												if(!empty($pdssv)){	 ?>
									<div class="row mb-3">
										 <div class="col-12 col-md-4">
										 <?= '<h6 class="my-3 title-md">'.$rgi.'</h6>'; ?>
										 </div>
										 <div class="col-12 col-md-8">
										 <?php
											foreach($pdssv as $pdss){
												echo '<div class="d-flex align-items-center justify-content-between"><p class="mb-0 d-flex align-items-center gap-2"><i class="fa '.getFileIconClass($pdss['name']).'"></i> '.(!empty($pdss['file_field_title']) ? $pdss['file_field_title'] : $pdss['field_name']).'</p>';
												echo '<div><a class="log-dl ms-3" download href="'.base_url().'/uploads/userimages/'.$userId.'/'.$pdss['name'].'" >Download</a>';
												echo '<a class="log-view ms-3" target="_blank" href="'.base_url().'/uploads/userimages/'.$userId.'/'.$pdss['name'].'" >View</a></div></div>';
											} ?>
										 </div>
									</div>
									<hr>
									<?php
												}
												$gty++;
											} ?>
									<?php }else{
										echo '<h6>'.$pds['field_name'].'</h6>';
										echo '<a class="card p-3 text-center" download href="'.base_url().'/uploads/userimages/'.$userId.'/'.$pds['name'].'" ><i class="fa '.getFileIconClass($pds['name']).'"></i> '.(!empty($pds['file_field_title']) ? $pds['file_field_title'] : $pds['field_name']).'</a>';
									}
								}else{ if($pds['field_type'] != 'Checkbox'){ ?>
									<h6><?php echo $pds['field_name']; ?></h6>
								<?php } ?>
									<?php echo $pds['name'];
								}
								?>
								</div>								
					<?php }	?>										
							  </div>
							</div>
						  </div>					
					<?php }
				}
			}
			?>	
			
			</div>
			
		</div>
		<!--<div class="bg-gray py-5">
			<div class="container">
				<?php if(!empty($featured[0]['total_users'])){ ?>
				<div class="wrapper">
				   <h3 class="title-md dblue text-center mb-3 mb-sm-5">Featured <?php echo $user_detail->category_name; ?> near <?php echo $search_location_name; ?></h3>
					<div class="owl-carousel owl-theme">
						<?php foreach($featured[0]['providers'] as $p => $provider ){ 
						$busin_name = !empty($provider['business_name']) ? str_replace(' ','-',strtolower($provider['business_name'])) : $user_detail->permalink ;
						?>					
						<div class="item">
							<a href="<?php echo base_url('/provider/'.$busin_name.'/'.$provider['id']); ?>">
								<div class="provider-Details">
									<div class="proPic">
									<img src="<?php echo $provider['image']; ?>" class="img-fluid">
									</div>
									<div class="pro-content py-3">
										<p class="text-grey mb-0 fw-bold"><?php echo $provider['name']; ?></p>

							<p class="text-orange mb-0 fw-bold"><?php echo $provider['business_name']; ?></p>

							<h6 class="text-grey"><?php echo $provider['address']; ?></h6>
									</div>
								</div>
							</a>
						</div>
						<?php } ?>	
					</div>	
				</div>
				<?php } ?>
			</div>
		</div>-->
	</div>
<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo trans('Report Profile'); ?></h4>
				<a data-bs-dismiss="modal"><i class="fa fa-times pe-0"></i></a>
            </div>
            <div class="modal-body form-section">
			<div class="form-group">
                <label><input type="radio" name="report" value="Spam" />Spam</label>
                <label><input type="radio" name="report" value="Wrong Content" />Wrong Content</label>
			</div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="save_report()" class="btn yellowbtn m-auto">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="myModalFinance" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-5 p-3 px-md-5 py-md-5 position-relative align-items-center">
            <div class="modal-header border-0">
                <h4 class="modal-title fw-bolder text-dark mb-3"><?php echo trans('Financial Calculator'); ?></h4>
				<a role="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"><img src="<?php echo base_url('assets/frontend/images/close.png'); ?>" /></a>
            </div>
            <div class="modal-body form-section w-100">
				<div class="row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
							<label for="paymentFrequency" class="bold"> Payment Frequency </label>
							<select class="form-control" id="paymentFrequency" name="paymentFrequency">
								<option value="12">Monthly</option>
								<option value="4">Quarterly</option>
								<option value="2">Bi-Annually</option>
								<option value="1">Annually</option>
							</select>
						</div>
						<div class="form-group">
							<label class="bold" for="termID"> Term  </label>
							<input type="number" class="form-control" name="term" id="termID" min="0" value="">
						</div>
						<div class="form-group">
							<label class="bold" for="interestID"> Interest %  </label>
							<input type="number" class="form-control" name="interest" id="interestID" min="0" value="7.5">
						</div>
						<div class="form-group">
							<label class="bold" for="loanAmountID"> Loan Amount (USD)  </label>
							<input type="text" class="form-control" name="loanAmount" id="loanAmountID" min="0" value="<?php echo ($product_detail['price'] != NULL) ? $product_detail['price'] : ''; ?>">
						</div>
						
					</div>
					<div class="col-md-6">				
						<div class="bg-gray rounded-5 px-4 py-5 mb-3">
							<div class="d-flex justify-content-between border-bottom py-3">
								<span class="left fw-medium">Payments</span>
								<span class="right"></span>
							</div>
							<div class="d-flex justify-content-between border-bottom py-3">
								<span class="left fw-medium">Amount Financed</span>
								<span class="right"></span>
							</div>
							<div class="d-flex justify-content-between border-bottom py-3">
								<span class="left fw-medium">Total Amount</span>
								<span class="right"></span>
							</div>
							<div class="d-flex justify-content-between border-bottom py-3">
								<span class="left fw-medium">Finance Charge</span>
								<span class="right"></span>
							</div>
						</div>					
						
					</div>
				</div>
            </div>
			
            <div class="modal-footer border-0 gap-3 justify-content-center w-100">
                <button type="button" onclick="" class="btn blue-btn min-w-auto col-lg-4">Calculate</button>
                <button type="button" onclick="" class="btn btn min-w-auto col-lg-4">Reset</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<style>
#sync1 .item {
  margin: 5px;
  color: #fff;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  text-align: center;
}

#sync2 .item {
  background: #c9c9c9;
  /* padding: 10px 0px; */
  margin: 5px;
  color: #fff;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  text-align: center;
  cursor: pointer;
}

#sync2 .item h1 {
  font-size: 18px;
}

#sync2 .current .item {
  background: #0c83e7;
}

.owl-theme .owl-nav [class*="owl-"] {
  transition: all 0.3s ease;
}

.owl-theme .owl-nav [class*="owl-"].disabled:hover {
  background-color: #d6d6d6;
}

#sync1.owl-theme {
  position: relative;
}

#sync1.owl-theme .owl-next,
#sync1.owl-theme .owl-prev {
  width: 22px;
  height: 40px;
  margin-top: -20px;
  position: absolute;
  top: 50%;
}

#sync1.owl-theme .owl-prev {
  left: 10px;
}

#sync1.owl-theme .owl-next {
  right: 10px;
}
/* animate fadin duration 1.5s */
.owl-carousel .animated {
  animation-duration: 1.5s !important;
}
/* 輪播的前後按鈕背景調大 */
#sync1.owl-theme .owl-next,
#sync1.owl-theme .owl-prev {
  width: 35px !important;
  height: 55px !important;
}
#sync1 svg {
  width: 22px !important;
}
.popover {
    --bs-popover-max-width: 310px;
}
.fs-8 {
font-size: 15px;
}
.a2a_logo_color {
    background-color: #ff6c00;
}
#messageProviderForm select { background: #ffffff url(../images/triangle.png) no-repeat 95% center / 26px 14px; }

#messageProviderForm select,
#messageProviderForm select option {
  color: #000000;
}

#messageProviderForm select:invalid,
#messageProviderForm select option[value=""] {
  color: #999999;
}
.empty { color: #999 !important; }
.lb-nav a.lb-prev, .lb-nav a.lb-next{
	opacity:1;
}
</style>

			
<div id="social-share" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content rounded-5 p-3 px-md-2 position-relative">
			<div class="modal-header bg-solid-warning justify-content-center p-4 pb-0 border-0">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5 position-absolute top-0 end-0 m-3"><i class="fa-solid fa-xmark"></i></a>
			<h5 class="fw-bolder mb-0">Share Listing</h5>
			</div>
			<div class="modal-body p-4">
			<img src="<?php echo $img; ?>" width="100%" class="rounded-4" />
			<h6 class="mb-0 text-black"><?php 'hjhkkjj';//echo !empty($user_detail->business_name) ? $user_detail->business_name : $user_detail->fullname; ?></h6>						
			<p class="fs-7"><?php //echo $user_detail->city.', '.$user_detail->state_code.' '.$user_detail->zipcode; ?></p>
			<!-- AddToAny BEGIN -->
			<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
			<a class="a2a_button_facebook w-100">Facebook</a>
			<a class="a2a_button_x w-100">Twitter</a>
			<a onclick="copyURI(event)" data-link="<?php echo $share_url; ?>" class="w-100" target="_top" rel="nofollow noopener" ><span class="a2a_svg a2a_s__default a2a_s_link a2a_img_text" style="background-color: rgb(136, 137, 144);"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="#fff" d="M7.591 21.177c0-.36.126-.665.377-.917l2.804-2.804a1.235 1.235 0 0 1 .913-.378c.377 0 .7.144.97.43-.026.028-.11.11-.255.25-.144.14-.24.236-.29.29a2.82 2.82 0 0 0-.2.256 1.056 1.056 0 0 0-.177.344 1.43 1.43 0 0 0-.046.37c0 .36.126.666.377.918a1.25 1.25 0 0 0 .918.377c.126.001.251-.015.373-.047.125-.037.242-.096.345-.175.09-.06.176-.127.256-.2.1-.094.196-.19.29-.29.14-.142.223-.23.25-.254.297.28.445.607.445.984 0 .36-.126.664-.377.916l-2.778 2.79a1.242 1.242 0 0 1-.917.364c-.36 0-.665-.118-.917-.35l-1.982-1.97a1.223 1.223 0 0 1-.378-.9l-.001-.004Zm9.477-9.504c0-.36.126-.665.377-.917l2.777-2.79a1.235 1.235 0 0 1 .913-.378c.35 0 .656.12.917.364l1.984 1.968c.254.252.38.553.38.903 0 .36-.126.665-.38.917l-2.802 2.804a1.238 1.238 0 0 1-.916.364c-.377 0-.7-.14-.97-.418.026-.027.11-.11.255-.25a7.5 7.5 0 0 0 .29-.29c.072-.08.139-.166.2-.255.08-.103.14-.22.176-.344.032-.12.048-.245.047-.37 0-.36-.126-.662-.377-.914a1.247 1.247 0 0 0-.917-.377c-.136 0-.26.015-.37.046-.114.03-.23.09-.346.175a3.868 3.868 0 0 0-.256.2c-.054.05-.15.148-.29.29-.14.146-.222.23-.25.258-.294-.278-.442-.606-.442-.983v-.003ZM5.003 21.177c0 1.078.382 1.99 1.146 2.736l1.982 1.968c.745.75 1.658 1.12 2.736 1.12 1.087 0 2.004-.38 2.75-1.143l2.777-2.79c.75-.747 1.12-1.66 1.12-2.737 0-1.106-.392-2.046-1.183-2.818l1.186-1.185c.774.79 1.708 1.186 2.805 1.186 1.078 0 1.995-.376 2.75-1.13l2.803-2.81c.751-.754 1.128-1.671 1.128-2.748 0-1.08-.382-1.993-1.146-2.738L23.875 6.12C23.13 5.372 22.218 5 21.139 5c-1.087 0-2.004.382-2.75 1.146l-2.777 2.79c-.75.747-1.12 1.66-1.12 2.737 0 1.105.392 2.045 1.183 2.817l-1.186 1.186c-.774-.79-1.708-1.186-2.805-1.186-1.078 0-1.995.377-2.75 1.132L6.13 18.426c-.754.755-1.13 1.672-1.13 2.75l.003.001Z"></path></svg></span>Copy Link</a>
			<div class="d-flex align-items-center fw-medium mb-0" role="button" onclick="open_email_share()">
				<img class="icons" src="<?php echo base_url('assets/frontend/images/msg.png'); ?>" />
				<p class="text-primary">Email a friend</p>
			</div>	
			</div>
			<!-- AddToAny END -->
			</div>
			<!--<div class="modal-footer p-4">
				<button type="button" data-bs-dismiss="modal" class="btn btn-secondary m-0">Close</button>
				
			</div>-->
		</div>
	</div>
</div>	

	
<div id="email-share" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content rounded-5 p-3 px-md-5 position-relative">
			<div class="modal-header bg-solid-warning justify-content-center p-4 pb-0 border-0">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5 position-absolute top-0 end-0 m-3"><i class="fa-solid fa-xmark"></i></a>
			<h5 class="mb-0 fw-bolder">Email A Friend</h5>
			</div>
			<div class="modal-body">
				<form action="" method="post" id="shareEmail" class="form-input mt-4">
					<input type="hidden" id="fromuserId" name="fromuserId" value="<?php echo $fromuserId;?>">
					<input type="hidden" id="userId" name="userId" value="<?php echo $userId;?>">
					<input type="hidden" id="productId" name="productId" value="<?php echo $productId;?>">
					<input type="hidden" name="link" value="<?php echo $share_url; ?>">
					<div class="form-section">
						<div class="form-group"><input type="email" name="email" id="email" class="ucwords form-control" placeholder="Your Email"></div>
						<div class="form-group"><input type="email" name="remail" id="remail"placeholder="Recipient's  Email" class="form-control"></div>
						<div class="form-group"><textarea name="message" id="message" class="form-control" placeholder="Message"></textarea></div>
						<input type="hidden" id="g-recaptcha-response1"  class="form-control" name="check_bot" value="" >
						<input type="submit" value="Submit" class="btn w-100 mb-4">
					</div>
				</form>	
			</div>
			<!--<div class="modal-footer p-4">
				<button type="button" data-bs-dismiss="modal" class="btn btn-secondary m-0">Close</button>				
			</div>-->
		</div>
	</div>
</div>	



<div class="alert text-white bg-success sticky-top alert alert-dismissible alert-dismissible" id="suc-alert" style="top: 10px;
    position: fixed;
    right: 20px;
    display: none;
    z-index: 9999;">
	<i class="icon fas fa-check me-2"></i> Copied to Clipboard !
</div>
<div class="loader"></div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

			<script>
			var a2a_config = a2a_config || {};
			a2a_config.onclick = 1;
			</script>
			<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>
function open_social_share(ths){
	$("#social-share").modal('show');
    let uid = $(ths).data('id');
    let pid = $(ths).data('pid');
	$.ajax({
		type: "GET",
		url: '<?php echo base_url(); ?>' + "/update_share_count/"+uid+"/"+pid,
		success: function (data) {
		}
	});
}
function open_email_share(){
	$("#email-share").modal('show');
	$("#shareEmail").validate({
        rules: {
			check_bot:{required: true},
            remail: { required: true, maxlength:255},
            email: { required: true, email: true, maxlength:255}, 
            message: { required: true},           
        },
        messages: {
			check_bot:{
				required: "You are not a human!"
			}
        },
        submitHandler: function (form) {
            send_email_to_friend(form);
            return false; // Prevent form submission
        }
    });
}
function save_report(){
	var report_type = $('input[name="report"]:checked').val();
	var user_id = '<?php echo $userId; ?>';
	$.ajax({
		url: '<?php echo base_url(); ?>/providerauth/save_report',
		type: 'POST',
		data: {report_type:report_type,user_id:user_id},
		success: function(res) {
			$('#myModal').modal('hide');
			Swal.fire({
				text: "Reported Profile!",
				icon: "success",
				confirmButtonColor: "#34c38f",
				confirmButtonText: "<?php echo trans("ok"); ?>",
			})
			
		}
	});
}
$(document).ready(function(){
	$("#best_way").change(function () {
		if($(this).val() == "") $(this).addClass("empty");
		else $(this).removeClass("empty")
	});
	$("#best_way").change();
	
	$('.open-report-modal').on('click', function(e){
			e.preventDefault();
			$('#myModal').modal('show');
		});
	$('.open-finance-modal').on('click', function(e){
			e.preventDefault();
			$('#myModalFinance').modal('show');
		});
	var simg = '<?php echo base_url().'/assets/img/favicon.png'; ?>';
    $('[data-toggle="popover"]').popover({
        placement : 'right',
		trigger : 'hover',
        html : true,
        content : '<div class="tooltip-inner text-start"><p class="dblue mb-2 d-flex align-items-center gap-1 fw-bold fs-8"><img width="24" src="'+simg+'"> A little extra about your broker!</p><p class="mb-0">These are 2 mandatory questions for your broker to answer when creating a profile.</p><p>This givens you a little more insight into who you choose to broker your plane!</p></div>'
    });
});
</script>
<style>
	.bs-example{
    	margin: 200px 150px 0;
    }
	.bs-example button{
		margin: 10px;
    }
	.a2a_full_footer{
		display:none;
	}
	
.grecaptcha-badge{visibility:hidden !important;}
</style>


		<script>    var geocoder;	var map;	var address = "<?php //echo $user_detail->business_name.', '.$user_detail->address.', '.$user_detail->city.', '.$user_detail->state_code.', '.$user_detail->zipcode; ?>";	function initMap() {		geocoder = new google.maps.Geocoder();		codeAddress(address);	}	function codeAddress(address) {		geocoder.geocode({ 'address': address }, function (results, status) {			console.log(results);			var latLng = {lat: results[0].geometry.location.lat (), lng: results[0].geometry.location.lng ()};			console.log (latLng);			map = new google.maps.Map(document.getElementById('map'), {				zoom: 11,				center: latLng,				disableDefaultUI: true,			});			if (status == 'OK') {				var marker = new google.maps.Marker({					position: latLng,					map: map				});				console.log (map);			} else {				alert('Geocode was not successful for the following reason: ' + status);			}		});	}</script><script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVOEBebUkCDtSrIMdFekS9T9CcmRECNPo&callback=initMap"></script>
<script>
function phprun(target) { // <-----( INJECT THE EVENT TARGET)

    // get the video element from the target
    let videoEl = target.parentNode.parentNode.childNodes[0];

    // retrieve the data you want (eg. the video url and title)
    let videoUrl = 'http';
    let videoTitle = 'tit';

    // inject it into the desired containers
    h1.innerHTML = 'Share:' + videoTitle;
    h2.innerHTML = videoUrl;

    // do more stuff...
    if (copy.style.display === "none") {
        copy.style.display = "block";
    } else {
        copy.style.display = "none";
    }

}

    var sync1 = jQuery("#sync1");
    var sync2 = jQuery("#sync2");
    var slidesPerPage = 5; //globaly define number of elements per page
    var syncedSecondary = true;

    sync1.owlCarousel({
		items: 1,
		slideSpeed: 3000,
		nav: false,
		margin:10,
		animateIn: "fadeIn",
		autoplayHoverPause: true,
		autoplaySpeed: 1400, //過場速度
		dots: false,
		loop: false,
		responsiveClass: true,
		responsive: {
			0: {
			item: 1
			},
			600: {
			items: 1
			},
			1000:{
			items:1
			}
		},
		responsiveRefreshRate: 200,
		navText: [
		'<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
		'<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'
		]
	});

    sync2.owlCarousel({
      loop:false,
		margin:10,
		nav:true,
		responsive:{
			0:{
				items:3
			},
			600:{
				items:4
			},
			1000:{
				items:5
			}
		}
    });

    function syncPosition(el) {
      //if you set loop to false, you have to restore this next line
      //var current = el.item.index;

      //if you disable loop you have to comment this block
      var count = el.item.count - 1;
      var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

      if (current < 0) {
        current = count;
      }
      if (current > count) {
        current = 0;
      }

      //end block

      sync2
        .find(".owl-item")
        .removeClass("current")
        .eq(current)
        .addClass("current");
      var onscreen = sync2.find(".owl-item.active").length - 1;
      var start = sync2
      .find(".owl-item.active")
      .first()
      .index();
      var end = sync2
      .find(".owl-item.active")
      .last()
      .index();

      if (current > end) {
        sync2.data("owl.carousel").to(current, 100, true);
      }
      if (current < start) {
        sync2.data("owl.carousel").to(current - onscreen, 100, true);
      }
    }

    function syncPosition2(el) {
      if (syncedSecondary) {
        var number = el.item.index;
        sync1.data("owl.carousel").to(number, 100, true);
      }
    }

    sync2.on("click", ".owl-item", function(e) {
      e.preventDefault();
      var number = jQuery(this).index();
      sync1.data("owl.carousel").to(number, 300, true);
    });
$('.owl-carousel').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})

function showPhone(ths){
    let phone = $(ths).data('phone');
    let label = $(ths).data('label');
    let uid = $(ths).data('id');
    let pid = $(ths).data('pid');
	$.ajax({
		type: "GET",
		url: '<?php echo base_url(); ?>' + "/update_call_count/"+uid+"/"+pid,
		success: function (data) {
		}
	});
    Swal.fire({
      title: 'Contact '+label+' Now!',
      html: '<a href="tel:+1'+phone+'">'+phone+'</a>',
      imageUrl: '<?php echo base_url(); ?>' + '/assets/img/sawMeOn.png',
      imageWidth: 400,
      imageHeight: 200,
      imageAlt: 'Say you saw me on planebroker.com',
	  showConfirmButton: false,
	  customClass: {
		  container: 'callmePopup',
		}
    })
}
function direction_count(id){
	$.ajax({
		type: "GET",
		url: '<?php echo base_url(); ?>' + "/update_direction_count/"+id,
		success: function (data) {
		}
	});
}
function copyURI(evt) {
    evt.preventDefault();
    navigator.clipboard.writeText(evt.target.getAttribute('data-link')).then(() => {
      /* clipboard successfully set */
	  $("#social-share").modal('hide');
	  $("#suc-alert").fadeIn().delay(2000).fadeOut();
    }, () => {
      /* clipboard write failed */
    });
}


</script><script>
$(document).ready(function() {
	let lightbox = GLightbox({
		selector: '.glightbox',
		autoplayVideos: true,
	});

    $('#viewAllPhotosBtn').on('click', function(e) {
        e.preventDefault();
        // Dynamically trigger click on the 6th image (first hidden)
        lightbox.openAt(0);
    });
});
	function openGlightboxAt(index) {
	let lightbox = GLightbox({
		selector: '.glightbox',
		autoplayVideos: true,
	});
		console.log('clicked');
        lightbox.openAt(index);
    }
	
</script><script>
/*lightbox.option({
  fadeDuration: 300,
  resizeDuration: 300,
  wrapAround: true, // Allows circular browsing
  alwaysShowNavOnTouchDevices: true
});
*/


function send_email_to_friend(val) {        
     var formData = $('#shareEmail').serialize();        
    //var csrfName = $.cookie(csrfCookie);
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/send_email_to_friend",
        data: formData,
        success: function (response) {
            $('.loader').hide();
            if (!response.success) {
                console.log(response.error);
                Swal.fire(response.message, '', 'error');
            }else if(response.success){ 
                Swal.fire('Successfully sent email. Thank you!', '', 'success');
				$('#shareEmail')[0].reset();
				$("#email-share").modal('hide');
            }
            return false;
        }
    });
    return false;
}
</script>


<?= $this->endSection() ?>