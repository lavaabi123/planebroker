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
if(!empty($user_detail->avatar)){
	$img = base_url()."/uploads/userimages/".$userId."/".$user_detail->avatar;
	$user_photos = array_merge(array(array('file_name'=>$user_detail->avatar,'image_tag'=>'')),$user_photos);
}else if(!empty($user_photos)){
	$img = base_url()."/uploads/userimages/".$userId."/".$user_photos[0]['file_name'];
}else{ 
	$img =  base_url()."/assets/img/user.png";				
}

?>
    <div class="viewProfile pt-4 pt-sm-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="container pb-5">
			<div class="row text-black">
				<div class="col-sm-6">
					<?php //if($user_detail->plan_id >0 ){ 
					if(!empty($user_photos)){ ?>
					<div class="product-slider">
						<div id="sync1" class="owl-carousel owl-theme">
						<?php if(!empty($user_photos)){
								foreach($user_photos as $p => $photo){ ?>
						  <div class="item">
							<a class="proPic example-image-link" href="<?php echo base_url()."/uploads/userimages/".$userId."/".$photo['file_name']; ?>" data-lightbox="example-1">
							  <img
								src="<?php echo base_url()."/uploads/userimages/".$userId."/".$photo['file_name']; ?>"
								alt="image-1" class="example-image"
							  /></a>
						  </div>
						  <?php } } ?>
						</div>

						<div id="sync2" class="owl-carousel owl-theme">
						<?php if(!empty($user_photos)){
								foreach($user_photos as $p => $photo){ ?>
						  <div class="item">
							<img
							  src="<?php echo base_url()."/uploads/userimages/".$userId."/".$photo['file_name']; ?>"
							  alt="landscape"
							/>
						  </div>
						  <?php } } ?>
						</div>
						
					 </div>
					<?php } else{
					 ?>
					<div class="proPic gender d-none">
					<img class="img-fluid" src="<?php echo base_url()."/assets/img/user.png"; ?>">
					</div>
					<?php  } ?>
					<div class="d-none mt-3 mt-lg-5">
						<h3 class="title-sm dblue mb-0"><?php echo 'x by'; ?> <?php echo 'jjj'; ?></h3>
						<p class="dblue mb-4"><?php echo 'Aircraft';//$user_detail->category_name; ?> in <?php //echo $user_detail->city.', '.$user_detail->state_code.' '.$user_detail->zipcode; ?></h3>
						
						<div class="my-4 my-sm-5">
						<?php if(!empty($user_detail->mobile_no)){ ?>
							<a href="javascript:void(0)" data-phone="<?php echo phoneFormat($user_detail->mobile_no); ?>" data-label="<?php if(!empty($user_detail->business_name)){ echo "Us"; }else{ echo "Me"; } ?>" class="showPhone button btn yellowbtn minbtn" onclick="showPhone(this)"><i class="fas fa-phone"></i> CALL ME</a>
						<?php } ?>	
						</div>
				    </div>
					<?php 
					if(!empty($user_photos)){ ?>					
					<a href="<?php echo base_url('provider_gallery/'.$userId); ?>" class="button btn mt-3 mt-lg-5">View Photo Gallery</a>
					<?php }
					if(!empty($user_detail->about_me)){
					?>
					
					<div class="abtAircraft bg-gray rounded-5 px-4 py-5">
						<h4><?php echo trans('About this Aircraft'); ?></h4>
						<p>Aerista is proud to present this exceptional 1979 Beechc raft Baron 58—an outstanding twin-engine aircraft that combines performance, reliability, and versatility.</p>
						<p>This Baron has been meticulously maintained, featuring low total time, a strong engine setup, and a well-equipped avionics suite, including Dual Garmin 430W WAAS. This aircraft is turnkey and ready for its next owner. Whether for personal or business use, this aircraft delivers speed, comfort, and proven Beechcraft craftsmanship.</p>
						<p>Don't miss out—this Baron is priced to sell!</p>
					</div>
					<?php }  ?>					
						
					<?php /*} else{ if(!empty($user_photos)){ ?>
					<div class="proPic">
					<img class="img-fluid" src="<?php echo base_url()."/uploads/userimages/".$userId."/".$user_photos[0]['file_name']; ?>">
					</div>
					<?php } else{ if($user_detail->gender == 'Female'){ ?>
						<div class="proPic gender">
						<img class="img-fluid" src="<?php echo base_url()."/assets/img/female_user.png"; ?>">
						</div>
					<?php }else{ ?>
					<div class="proPic gender">
					<img class="img-fluid" src="<?php echo base_url()."/assets/img/user.png"; ?>">
					</div>
					<?php } } } */ ?>						
					<hr class="my-4">		
					<div class="bg-gray rounded-5 px-4 py-5">
						<h4 class="border-bottom mb-0 pb-3"><?php echo trans('General Information'); ?></h4>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Year</span>
							<span class="right">1979</span>
						</div>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Manufacturer</span>
							<span class="right">Beechcraft</span>
						</div>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Model</span>
							<span class="right">58 Baron</span>
						</div>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Serial Number</span>
							<span class="right">TH-1012</span>
						</div>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Registration #</span>
							<span class="right">N2023C</span>
						</div>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Condition</span>
							<span class="right">Used</span>
						</div>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Flight Rules</span>
							<span class="right">IFR</span>
						</div>
						<div class="d-flex justify-content-between border-bottom py-3">
							<span class="left fw-medium">Based at</span>
							<span class="right">GPT</span>
						</div>
						<div class="text-center mt-4">
							<a href="#" class="btn blue-btn fw-bold py-4 btn-lg">Download Spec Sheet</a>
						</div>
					</div>
					
				</div>
				<div class="col-sm-6 proDetails ps-sm-5">
					<h4 class="mb-0">1979 Beechcraft 58 Baron</h4>
					<p class="mb-3">Piston Twin Aircraft</p>
					<h4 class="mb-3">USD $299,000</h4>
					
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/calculator.png'); ?>" />
						<p class="text-primary">Financial Calculator</p>
					</div>					
					
					<hr>
					
					<?php if(!empty($user_detail->mobile_no)){ ?>
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/phone.png'); ?>" />
						<p class="mb-0"><?php echo phoneFormat($user_detail->mobile_no); ?></p>
						<a href="javascript:void(0)" data-phone="<?php echo phoneFormat($user_detail->mobile_no); ?>" data-label="<?php if(!empty($user_detail->business_name)){ echo "Us"; }else{ echo "Me"; } ?>" class="showPhone button btn yellowbtn mx-3" data-id="<?php echo $userId; ?>" onclick="showPhone(this)"> CALL </a>	
					
					</div>
					<hr>
					<?php } ?>		
					
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/usericon.png'); ?>" />
						<p class="">Rafael Rivas</p>
					</div>
					<hr>
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/pin.png'); ?>" />
						<p class="">Las Vegas, NV</p>
					</div>
					<hr>
					
					<!-- MESSAGE ME - START -->
					<div id="contact-provider" class="providerMsg rounded-5 p-4 my-5 bg-grey">
					<h6 class="text-dark text-center">Message Seller Directly</h6>
						<form action="" method="post" id="messageProviderForm" class="form-input mt-4">
							<input type="hidden" id="userId" name="userId" value="<?php echo $userId;?>">
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
					<div class="d-flex align-items-center fw-medium mb-0">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/msg.png'); ?>" />
						<p class="text-primary">Email a friend</p>
					</div>					
					
					<hr>
					<div class="d-flex align-items-center fw-medium mb-0">
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
			  <div class="accordion-item">
				<h2 class="accordion-header">
				  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pd-One" aria-expanded="true" aria-controls="pd-One">
					Airframe
				  </button>
				</h2>
				<div id="pd-One" class="accordion-collapse collapse show" data-bs-parent="#productDes">
				  <div class="accordion-body">
				  <hr>
					<h6>Total Time</h6>
					3,695
				  <hr>
					<h6>Airframe Notes</h6>
					1979 Beechcraft Baron 58<br>
					SN: TH-1012<br>
					3,695 hours TTSN (Hobbs)<br>
					Basic Empty Weight = 3729.6 lbs<br>
					Maximum Gross Weight = 5400 lbs<br>
					Useful Load = 1670.4 lbs
				  </div>
				</div>
			  </div>
			  <div class="accordion-item">
				<h2 class="accordion-header">
				  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pd-Two" aria-expanded="false" aria-controls="pd-Two">
					Engine 1
				  </button>
				</h2>
				<div id="pd-Two" class="accordion-collapse collapse" data-bs-parent="#productDes">
				  <div class="accordion-body">
					<strong>This is the second item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
				  </div>
				</div>
			  </div>
			  <div class="accordion-item">
				<h2 class="accordion-header">
				  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pd-Three" aria-expanded="false" aria-controls="pd-Three">
					Engine 2
				  </button>
				</h2>
				<div id="pd-Three" class="accordion-collapse collapse" data-bs-parent="#productDes">
				  <div class="accordion-body">
					<strong>This is the third item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
				  </div>
				</div>
			  </div>
			</div>
			
		</div>
		<div class="bg-gray py-5">
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

							<h6 class="text-grey"><?php echo $provider['city'].', '.$provider['state_code'].' '.$provider['zipcode']; ?></h6>
									</div>
								</div>
							</a>
						</div>
						<?php } ?>	
					</div>	
				</div>
				<?php } ?>
			</div>
		</div>
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

</style>

		
<div id="social-share" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header bg-solid-warning justify-content-start p-4">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5"><i class="fa-solid fa-xmark"></i></a>
			<h6 class="ms-2 mb-0">Share Business</h6>
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
			</div>
			<!-- AddToAny END -->
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
function open_social_share(){
	$("#social-share").modal('show');
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
	$.ajax({
		type: "GET",
		url: '<?php echo base_url(); ?>' + "/update_call_count/"+uid,
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


</script>
<?= $this->endSection() ?>