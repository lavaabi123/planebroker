<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ;

$orders = array('created_at', 'location_id', 'name');
$order = !empty($_GET['order']) && in_array($_GET['order'], $orders) ? 'u.'.$_GET['order']:'u.created_at';
if($order == 'u.name'){ $order = 'name'; $dir = 'asc'; }elseif($order == 'u.created_at'){ $dir = 'desc'; }else{ $dir = 'asc'; }

function createUrl($key, $val, $add){
	return changeQuery($key, $val, $add, false, array('location', 'category'));
}
function checkbox($name){
	$return = "data-href='"; 
	if(!empty($_GET[$name])){ 
		$return .= createUrl($name, '0', false)."' checked='checked"; 
	}else{ 
		$return .= createUrl($name, '1', true); 
	}
	$return .= "'";
	return $return;
}
function radio($name, $val){
	if(!empty($_GET[$name]) && $_GET[$name] == $val){ 
		$return = "data-href='".createUrl($name, false, false)."'";
	}else{
		$return = "data-href='".createUrl($name, $val, false)."'";	
	} 
	if(!empty($_GET[$name]) && $_GET[$name] == $val){ 
		$return .= " checked='checked'"; 
	}
	return $return;
}

function normalizeUrl($url, $platform) {
    $url = trim($url);

    // If already absolute
    if (preg_match('~^https?://~i', $url)) {
        return $url;
    }

    // If it's a bare domain
    if (preg_match('~\.[a-z]{2,}(/.*)?$~i', $url)) {
        return 'https://' . ltrim($url, '/');
    }

    // Otherwise treat it like a username/handle
    switch (strtolower($platform)) {
        case 'facebook':
            return 'https://www.facebook.com/' . ltrim($url, '@');
        case 'instagram':
            return 'https://www.instagram.com/' . ltrim($url, '@');
        case 'youtube':
            return 'https://www.youtube.com/@' . ltrim($url, '@');
        case 'tiktok':
            return 'https://www.tiktok.com/@' . ltrim($url, '@');
        case 'gmb':
            return 'https://www.google.com/search?q=' . rawurlencode($url);
        default:
            return 'https://' . ltrim($url, '/');
    }
}

$icons = [
    'facebook'  => 'fab fa-facebook',
    'instagram' => 'fab fa-instagram',
    'linkedin'   => 'fab fa-linkedin',
    'twitter'   => 'fab fa-x-twitter',
    'youtube'   => 'fab fa-youtube',
    'tiktok'    => 'fab fa-tiktok',
    'gmb'       => 'fas fa-map-marker-alt',
];

?>
<style>
#filterSidebar{
    max-height:100vh;
    overflow-y:auto;
}
.z-999{
	z-index:999 !important;
}
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>   
<div class="d-flex flex-column flex-sm-row justify-content-end">
	
	<div class="carftList right-section">
		<div class="container-xl">
		
		<div class="row mb-5 mt-5">
			<div class="col-sm-6">
				<img class="img-fluid w-100 br-full" src="<?php echo ($user_detail->avatar) ? base_url().'/uploads/userimages/'.$user_detail->id.'/'.$user_detail->avatar : base_url('assets/frontend/images/user-pic-new.jpg'); ?>">
				<?php 
				if(!empty($user_detail->about_me)){
				?>
				<hr class="my-4">
				
				<div class="abtAircraft bg-gray rounded-5 px-4 py-5 mb-4">
					<h4 class="mb-2"><?php echo !empty($user_detail->business_name) ? $user_detail->business_name : $user_detail->fullname; ?></h4>
					<div class="rte-output">
					<p><?php echo $user_detail->about_me; ?></p>
					</div>	
				</div>	
				<?php }  ?>		
			</div>
			<div class="col-sm-6 proDetails ps-sm-5">
				<h4 class="mb-0"><?php echo !empty($user_detail->business_name) ? $user_detail->business_name : $user_detail->fullname; ?></h4>
				<hr>				
				<?php if(!empty($user_detail->mobile_no)){ ?>
				<div class="d-flex align-items-center fw-medium mb-0">
					<img class="icons" src="<?php echo base_url('assets/frontend/images/phone.png'); ?>" />
					<p class="mb-0"><?php echo !empty($user_detail->mobile_no) ? $user_detail->mobile_no : $user_detail->mobile_no; ?></p>
					<a class="showPhone btn btn-sm mx-3" href="tel:+1<?php echo !empty($user_detail->mobile_no) ? preg_replace('/\D+/', '', $user_detail->mobile_no) : preg_replace('/\D+/', '', $user_detail->mobile_no); ?>"> CALL </a>
				</div>
				<hr>
				<?php } ?>	
				<div class="d-flex align-items-center fw-medium mb-0">
					<img class="icons" src="<?php echo base_url('assets/frontend/images/usericon.png'); ?>" />
					<p class=""><?php echo $user_detail->fullname; ?></p>
				</div>
				<?php if(!empty($user_detail->address)){ ?>
				<hr>
				<div class="d-flex align-items-center fw-medium mb-0">
					<img class="icons" src="<?php echo base_url('assets/frontend/images/pin.png'); ?>" />
					<p class=""><?php echo $user_detail->address; ?></p>
				</div>
				<?php } ?>
				<?php if(!empty($user_detail->website)){ ?>
					<hr>
					<div class="d-flex align-items-center fw-medium mb-0">
					<a class="d-flex align-items-center" target="_blank" href="<?php echo $user_detail->website; ?>">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/web.png'); ?>" />
						<p class="mb-0"><?php echo $user_detail->website; ?></p>
					</a>
					</div>
				<?php } if(!empty($user_detail->facebook_link) || !empty($user_detail->insta_link) || !empty($user_detail->	twitter_link) || !empty($user_detail->linkedin_link) || !empty($user_detail->tiktok_link) || !empty($user_detail->youtube_link)){ ?>
					<hr>
					<div class="social-media">
					<?php
					if(!empty($user_detail->facebook_link)){
						//$href = normalizeUrl($user_detail->facebook_link, 'facebook');
						if (isset($icons[strtolower('facebook')])) {
							echo '<a href="'.$user_detail->facebook_link.'" target="_blank" rel="noopener noreferrer" class="mx-2">
									<i class="'.$icons[strtolower('facebook')].'"></i>
								  </a>';
						}
					}
					if(!empty($user_detail->linkedin_link)){
						//$href = normalizeUrl($user_detail->linkedin_link, 'linkedin');
						if (isset($icons[strtolower('linkedin')])) {
							echo '<a href="'.$user_detail->linkedin_link.'" target="_blank" rel="noopener noreferrer" class="mx-2">
									<i class="'.$icons[strtolower('linkedin')].'"></i>
								  </a>';
						}
					}
					if(!empty($user_detail->insta_link)){
						//$href = normalizeUrl($user_detail->insta_link, 'instagram');
						if (isset($icons[strtolower('instagram')])) {
							echo '<a href="'.$user_detail->insta_link.'" target="_blank" rel="noopener noreferrer" class="mx-2">
									<i class="'.$icons[strtolower('instagram')].'"></i>
								  </a>';
						}
					}
					if(!empty($user_detail->twitter_link)){
						//$href = normalizeUrl($user_detail->twitter_link, 'twitter');
						if (isset($icons[strtolower('twitter')])) {
							echo '<a href="'.$user_detail->twitter_link.'" target="_blank" rel="noopener noreferrer" class="mx-2">
									<i class="'.$icons[strtolower('twitter')].'"></i>
								  </a>';
						}
					}
					if(!empty($user_detail->tiktok_link)){
						//$href = normalizeUrl($user_detail->tiktok_link, 'tiktok');
						if (isset($icons[strtolower('tiktok')])) {
							echo '<a href="'.$user_detail->tiktok_link.'" target="_blank" rel="noopener noreferrer" class="mx-2">
									<i class="'.$icons[strtolower('tiktok')].'"></i>
								  </a>';
						}
					}
					if(!empty($user_detail->youtube_link)){
						//$href = normalizeUrl($user_detail->youtube_link, 'youtube');
						if (isset($icons[strtolower('youtube')])) {
							echo '<a href="'.$user_detail->youtube_link.'" target="_blank" rel="noopener noreferrer" class="mx-2">
									<i class="'.$icons[strtolower('youtube')].'"></i>
								  </a>';
						}
					}
					echo '</div>';
					
				}	?>
				
				<hr>
				<!-- MESSAGE ME - START -->
					<div id="contact-provider" class="providerMsg rounded-5 p-4 my-5 bg-grey">
					<h5 class="fw-bolder text-center">Message Seller Directly</5>
						<form action="" method="post" id="messageProviderForm" class="form-input mt-4">
							<input type="hidden" id="fromuserId" name="fromuserId" value="<?php echo $fromuserId;?>">
							<input type="hidden" id="userId" name="userId" value="<?php echo $userId;?>">
							<input type="hidden" id="productId" name="productId" value="0">
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
					<div class="d-flex align-items-center fw-medium mb-0" role="button" data-id="<?php echo $userId; ?>" data-pid="" onclick="open_social_share(this)">
						<img class="icons" src="<?php echo base_url('assets/frontend/images/upload.png'); ?>" />
						<p class="text-primary">Share Profile</p>
					</div>
					<hr>
			</div>
		</div>
		<div class="mb-5">
		<?php 
		if(!empty($categories)){ ?>
		<!-- Category Tabs -->
		<div class="category-tabs">
		  <span class="tab active" data-cat="all">All</span>
		  <?php if(!empty($categories_list)) {
			foreach($categories_list as $row) { ?>
			  <span class="tab" data-cat="<?php echo $row->name; ?>">
				<?php echo $row->name; ?>
			  </span>
		  <?php } } ?>
		</div>	
		<h3 id="category-title" class="text-center d-blue fw-bolder mt-5 mb-3 my-md-5" style=""></h3>
		<div class="d-grid grid-col-4 listing-wrap">
		<?php foreach($categories as $cat){ ?>
			<div class="item" data-cat="<?php echo $cat['cat_name']; ?>">
				<div class="provider-Details mb-4">
					<div class="providerImg mb-3">
						<a href="<?php echo base_url('/listings/'.$cat['permalink'].'/'.$cat['id'].'/'.(!empty($cat['name'])?str_replace(' ','-',strtolower($cat['name'])):'')); ?>">
						<img class="d-block w-100" alt="..." src="<?php echo $cat['image']; ?>">
						<?php if(!empty($cat['is_premium_listing'])){ ?><span class="pl-tag">Premium Listing</span><?php } ?>
						<?php if(!empty($cat['aircraft_status']) && $cat['aircraft_status'] != 'Available'){ ?><span class="pl-tag" style="   bottom: 10px;top: auto;"><?php echo $cat['aircraft_status']; ?></span><?php } ?>
						</a>
						<span class="wishlist favorite-btn <?php echo !empty($cat['wishlist_added']) ? 'wishlist-added' : ''; ?>" role="button" data-wish="<?php echo !empty($wishlist_added) ? 1 : 0; ?>" data-page-type="listing" data-product-id="<?= $cat['id']; ?>"><img class="icons" src="<?php echo base_url('assets/frontend/images/wishlist.png'); ?>" /></span>
					</div>
					<a href="<?php echo base_url('/listings/'.$cat['permalink'].'/'.$cat['id'].'/'.(!empty($cat['name'])?str_replace(' ','-',strtolower($cat['name'])):'')); ?>">
						<div class="pro-content">
							<h5 class="fw-medium title-xs"><?php echo !empty($cat['name']) ? $cat['name'] : '-'; ?></h5>
							<h5 class="fw-medium text-primary title-xs"><?php echo $cat['sub_cat_name']; ?></h5>
							<p class="text-grey mb-3"><?php echo $cat['address']; ?></p>
							<h5 class="fw-medium title-xs"><?php 							
							$check_price_field = !empty($cat['cat_id']) ? check_price_field($cat['cat_id']) : '';
							echo ( $check_price_field == '') ? '' : (($cat['price'] != NULL) ? 'USD $'.number_format($cat['price'], 2, '.', ',') : 'Call for Price'); ?></h5>
						</div>
					</a>
				</div>
			</div>
		<?php } ?>
		</div>
		<?php }?>
		</div>
		
		</div>
	</div>
</div>
  
<div class="loader"></div>
<style>
.hidden-filter {
    display: none;
}
.selected-filter button.clearSelected {
    border: none;
    background: transparent;
    font-size: 14px;
    text-decoration: underline;
	line-height: normal;
	font-family: 'TwCenMT';
	text-underline-offset: 2px;
	margin-top: 10px;
}

.category-tabs {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin: 20px 0;
  flex-wrap: wrap;
}

.category-tabs .tab {
  padding: 8px 20px;
  background: #f2f2f2;
  border-radius: 20px;
  cursor: pointer;
  transition: 0.3s;
  font-weight: 500;
}

.category-tabs .tab.active {
  background: #f9b233; /* highlight */
  color: #fff;
}
.item {
  display: inline-block; /* grid or flex in your style */
}

</style>
			
<div id="social-share" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content rounded-5 p-3 px-md-2 position-relative">
			<div class="modal-header bg-solid-warning justify-content-center p-4 pb-0 border-0">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5 position-absolute top-0 end-0 m-3"><i class="fa-solid fa-xmark"></i></a>
			<h5 class="fw-bolder mb-0">Share User Profile</h5>
			</div>
			<div class="modal-body p-4">
			<img src="<?php echo ($user_detail->avatar) ? base_url().'/uploads/userimages/'.$user_detail->id.'/'.$user_detail->avatar : base_url('assets/frontend/images/user-pic-new.jpg'); ?>" width="100%" class="rounded-4" />
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
$(document).on("click", ".category-tabs .tab", function() {
    var selected = $(this).data("cat");

    // active tab UI
    $(".category-tabs .tab").removeClass("active");
    $(this).addClass("active");

    // filter items
    if (selected === "all") {
        $(".listing-wrap .item").show();
        $("#category-title").hide().text(""); // hide title
    } else {
        $(".listing-wrap .item").hide();
        $('.listing-wrap .item[data-cat="'+selected+'"]').show();
        $("#category-title").show().text(selected); // show category title
    }
});


</script>
<?= $this->endSection() ?>
