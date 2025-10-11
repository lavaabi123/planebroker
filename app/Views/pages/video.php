<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); 
function getVideoEmbedUrl($url) {
    // YouTube embed
    if (strpos($url, 'youtube.com/embed/') !== false || strpos($url, 'youtu.be/') !== false || strpos($url, 'youtube.com/watch') !== false) {
        // Short YouTube URL
        if (strpos($url, 'youtu.be/') !== false) {
            $videoId = ltrim(parse_url($url, PHP_URL_PATH), '/');
            return 'https://www.youtube.com/embed/' . $videoId;
        }

        // YouTube embed URL
        if (strpos($url, 'youtube.com/embed/') !== false) {
            return $url;
        }

        // YouTube watch URL
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query) {
            parse_str($query, $params);
            if (!empty($params['v'])) {
                return 'https://www.youtube.com/embed/' . $params['v'];
            }
        }
    }

    // Vimeo embed
    if (strpos($url, 'vimeo.com/') !== false) {
        $path = parse_url($url, PHP_URL_PATH);
        if (preg_match('#/(\d+)#', $path, $matches)) {
            $videoId = $matches[1];
            return 'https://player.vimeo.com/video/' . $videoId;
        }
    }

    // Unknown or invalid
    return '';
}
?>

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
<main class="bg-gray pt-4 pt-sm-5">  
<div class="blogs bg-gray text-center" style="background: none;">	<div class="pageTitle py-2 text-center">		<h2 class="fw-bolder">Videos</h2>	</div>
	<div class="container py-3 py-xl-5 px-xxl-5">
		<div class="row row-cols-1 row-cols-sm-3 justify-content-center g-4 pb-3">		
		<?php if(!empty($videos)){ foreach($videos as $video){ ?>		
			<div class="col">
				
				<div class="bg-white pb-4" style="position:relative;">
					<div class="w-100 provider-Details">
						<iframe width="100%" height="315" 
								src="<?php echo htmlspecialchars(getVideoEmbedUrl($video->video_url)); ?>" 
								title="YouTube video player" 
								frameborder="0" 
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
								allowfullscreen>
						</iframe>
						
						<!--<a onclick="copyURI(event)" data-toggle="tooltip" title="Share"
						   data-link="<?php echo htmlspecialchars($video->video_url, ENT_QUOTES); ?>"
						   class="w-100" rel="nofollow noopener" href="#">
						  <span class="wishlist" role="button" data-wish="0" data-page-type="listing" data-product-id="91">
							<img class="icons" src="<?php echo base_url(); ?>/assets/frontend/images/msg.png" alt="Share">
						  </span>
						</a>-->
					</div>
					<div class="blogCol-Btm p-3 d-flex align-items-center flex-column">
						<h6 class="dblue title-xs px-2"><?php echo $video->name; ?></h6>
						
					</div>
						
						<div class="d-flex align-items-center fw-medium mb-0" role="button" data-id="1" data-pid="1" onclick="open_social_share(this)" data-link="<?php echo htmlspecialchars(getVideoEmbedUrl($video->video_url)); ?>">
							<img class="icons" src="<?php echo base_url('assets/frontend/images/upload.png'); ?>" />
							<p class="text-primary">Share Video</p>
						</div>
				</div>
				
			</div>
		<?php } } ?>
		</div>
	</div>
</div>
</main>	

			
<div id="social-share" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content rounded-5 p-3 px-md-2 position-relative">
			<div class="modal-header bg-solid-warning justify-content-center p-4 pb-0 border-0">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5 position-absolute top-0 end-0 m-3"><i class="fa-solid fa-xmark"></i></a>
			<h5 class="fw-bolder mb-0">Share Video</h5>
			</div>
			<div class="modal-body p-4">
			<iframe width="100%" height="315" 
					src="" 
					title="YouTube video player" 
					frameborder="0" 
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
					allowfullscreen>
			</iframe>
			<h6 class="mb-0 text-black"><?php 'hjhkkjj';//echo !empty($user_detail->business_name) ? $user_detail->business_name : $user_detail->fullname; ?></h6>						
			<p class="fs-7"><?php //echo $user_detail->city.', '.$user_detail->state_code.' '.$user_detail->zipcode; ?></p>
			<!-- AddToAny BEGIN -->
			<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
			<a class="a2a_button_facebook w-100">Facebook</a>
			<a class="a2a_button_x w-100">Twitter</a>
			<a onclick="copyURI(event)" data-link="" class="w-100 load-share" target="_top" rel="nofollow noopener" ><span class="a2a_svg a2a_s__default a2a_s_link a2a_img_text" style="background-color: rgb(136, 137, 144);"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="#fff" d="M7.591 21.177c0-.36.126-.665.377-.917l2.804-2.804a1.235 1.235 0 0 1 .913-.378c.377 0 .7.144.97.43-.026.028-.11.11-.255.25-.144.14-.24.236-.29.29a2.82 2.82 0 0 0-.2.256 1.056 1.056 0 0 0-.177.344 1.43 1.43 0 0 0-.046.37c0 .36.126.666.377.918a1.25 1.25 0 0 0 .918.377c.126.001.251-.015.373-.047.125-.037.242-.096.345-.175.09-.06.176-.127.256-.2.1-.094.196-.19.29-.29.14-.142.223-.23.25-.254.297.28.445.607.445.984 0 .36-.126.664-.377.916l-2.778 2.79a1.242 1.242 0 0 1-.917.364c-.36 0-.665-.118-.917-.35l-1.982-1.97a1.223 1.223 0 0 1-.378-.9l-.001-.004Zm9.477-9.504c0-.36.126-.665.377-.917l2.777-2.79a1.235 1.235 0 0 1 .913-.378c.35 0 .656.12.917.364l1.984 1.968c.254.252.38.553.38.903 0 .36-.126.665-.38.917l-2.802 2.804a1.238 1.238 0 0 1-.916.364c-.377 0-.7-.14-.97-.418.026-.027.11-.11.255-.25a7.5 7.5 0 0 0 .29-.29c.072-.08.139-.166.2-.255.08-.103.14-.22.176-.344.032-.12.048-.245.047-.37 0-.36-.126-.662-.377-.914a1.247 1.247 0 0 0-.917-.377c-.136 0-.26.015-.37.046-.114.03-.23.09-.346.175a3.868 3.868 0 0 0-.256.2c-.054.05-.15.148-.29.29-.14.146-.222.23-.25.258-.294-.278-.442-.606-.442-.983v-.003ZM5.003 21.177c0 1.078.382 1.99 1.146 2.736l1.982 1.968c.745.75 1.658 1.12 2.736 1.12 1.087 0 2.004-.38 2.75-1.143l2.777-2.79c.75-.747 1.12-1.66 1.12-2.737 0-1.106-.392-2.046-1.183-2.818l1.186-1.185c.774.79 1.708 1.186 2.805 1.186 1.078 0 1.995-.376 2.75-1.13l2.803-2.81c.751-.754 1.128-1.671 1.128-2.748 0-1.08-.382-1.993-1.146-2.738L23.875 6.12C23.13 5.372 22.218 5 21.139 5c-1.087 0-2.004.382-2.75 1.146l-2.777 2.79c-.75.747-1.12 1.66-1.12 2.737 0 1.105.392 2.045 1.183 2.817l-1.186 1.186c-.774-.79-1.708-1.186-2.805-1.186-1.078 0-1.995.377-2.75 1.132L6.13 18.426c-.754.755-1.13 1.672-1.13 2.75l.003.001Z"></path></svg></span>Copy Link</a>
			<div class="d-flex align-items-center fw-medium mb-0 load-share" role="button" data-link="" onclick="open_email_share()">
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
					<input type="hidden" id="link-share" name="link" value="">
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



<div class="alert text-white bg-success sticky-top alert alert-dismissible"
     id="suc-alert"
     style="top:10px;right:20px;display:none;z-index:9999;position:fixed;">
  <i class="icon fas fa-check me-2"></i> Video Link Copied to Clipboard !
</div>
<script>
function open_social_share(ths){
	$("#social-share").modal('show');
    $("#social-share").find("iframe").attr('src',$(ths).attr('data-link'));
    $("#social-share").find(".load-share").attr('data-link',$(ths).attr('data-link'));
}
function open_email_share(){
	$("#email-share").modal('show');
	$("#link-share").val($("#social-share").find(".load-share").attr('data-link'));
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
function copyURI(e) {
  e.preventDefault();
  e.stopPropagation();

  // Prefer the element that the handler is bound to
  const anchor = e.currentTarget || e.target.closest('a[data-link]');
  const link   = anchor?.dataset?.link;

  if (!link) {
    console.warn('No data-link found on anchor');
    return;
  }

  // Modern API with fallback
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(link)
      .then(showCopied)
      .catch(fallbackCopy);
  } else {
    fallbackCopy();
  }

  function fallbackCopy() {
    try {
      const ta = document.createElement('textarea');
      ta.value = link;
      ta.setAttribute('readonly', '');
      ta.style.position = 'fixed';
      ta.style.left = '-9999px';
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      document.body.removeChild(ta);
      showCopied();
    } catch (err) {
      console.error('Copy failed:', err);
    }
  }

  function showCopied() {
    // If you have a modal with id #social-share, hide it safely
    if (window.jQuery && $('#social-share').length) {
      $('#social-share').modal('hide');
    }
    if (window.jQuery) {
      $('#suc-alert').fadeIn().delay(2000).fadeOut();
    } else {
      const el = document.getElementById('suc-alert');
      el.style.display = 'block';
      setTimeout(() => el.style.display = 'none', 2000);
    }
  }
}
function send_email_to_friend(val) {        
     var formData = $('#shareEmail').serialize();        
    //var csrfName = $.cookie(csrfCookie);
    $('.loader').show();
    $.ajax({
        type: "POST",
        url: baseUrl + "/common/send_email_to_friend_video",
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
<style>
.provider-Details span.wishlist {
    bottom: 10px;top: auto;
}
.a2a_logo_color {
    background-color: #ff6c00;
}
.a2a_full_footer{
	display:none;
}
</style>
<script>
			var a2a_config = a2a_config || {};
			a2a_config.onclick = 1;
			</script><script async src="https://static.addtoany.com/menu/page.js"></script>
<?= $this->endSection() ?>

