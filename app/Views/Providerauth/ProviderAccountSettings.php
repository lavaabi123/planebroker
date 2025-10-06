<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="bg-grey d-flex flex-column flex-lg-row">
        <?php echo $this->include('Common/_messages') ?>
		<div class="leftsidecontent" id="stickySection">
			<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3 mb-5">
			<div class="container-fluid">
				<div class="titleSec">
					<h3 class="title-lg fw-bolder my-4"><?php echo $title; ?></h3>
				</div>
				<div class="row row-gap-3">
					<div class="col-md-4 pe-md-0">
						<div class="dbContent h-100">
						<div class="text-center mb-4">
						
						<div class="uploader-row">
						  <div class="file-upload d-none">
							<label class="dz-wrap">
							  <span>Upload Profile Photo</span><br />
							  <span>(.png,.jpeg,.jpg,.avif)</span>
							  <input type="file" id="profile-pic-input" name="profile_picture" class="choose-file-button" accept=".jpg,.jpeg,.png,.avif">
							</label>
						  </div>

						  <!-- Preview Card -->
						  <div class="proPic" id="upload-icon" aria-label="Change or remove photo">
							  <img class="uimg"
								   src="<?php echo !empty($user_detail->avatar) ? base_url().'/uploads/userimages/'.$user_detail->id.'/'.$user_detail->avatar : base_url('assets/frontend/images/user-pic-new-1.png'); ?>"
								   alt="Current profile photo" />
							  <div class="proPic-actions">
								<button type="button" class="btn-change" id="btn-change-photo"><i class="fa fa-camera"></i></button>
								<button type="button" style="display:<?php echo !empty($user_detail->avatar) ? '' :'none'; ?>" class="btn-remove" id="btn-remove-photo"><i class="far fa-trash-o"></i></button>
							  </div>
							</div>
						</div>
						

								<p class="TwCenMT fw-bold fs-6 mt-3">Upload Profile Photo / Logo</p>

							</div>
							<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								<button class="nav-link active" id="account-details-tab" data-bs-toggle="pill" data-bs-target="#account-details" type="button" role="tab" aria-controls="account-details" aria-selected="true">Account Details</button>
								<button class="nav-link" id="update-password-tab" data-bs-toggle="pill" data-bs-target="#update-password" type="button" role="tab" aria-controls="update-password" aria-selected="false">Update Password</button>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="dbContent h-100">
							<div class="container">
								<div class="tab-content" id="v-pills-tabContent">
									<div class="tab-pane fade show active" id="account-details" role="tabpanel" aria-labelledby="account-details-tab">
										<form id="edit-account-form" method="post" action="<?php echo base_url(); ?>/providerauth/edit-account-post">
										<?php echo csrf_field() ?>
										<input type="hidden" name="id" value="<?php echo $user_detail->id ?>">
										<fieldset class="form-input">				
											<h4 class="title-sm text-center mb-4 mb-md-5 fw-bolder">Basic Info</h4>
											<div class="form-section d-sm-flex gap-2">
											<div class="row p-0">
													<div class="col-md-6">
														<input class="form-control required" type="text" id="first_name" name="first_name" placeholder="<?php echo trans('form_firstname') ?>" value="<?php echo $user_detail->first_name ?>">
													</div>
													<div class="col-md-6">
														<input class="form-control required" type="text" id="last_name" name="last_name" placeholder="<?php echo trans('form_lastname') ?>" value="<?php echo $user_detail->last_name ?>">
													</div>
													<div class="col-md-6">
														<input class="form-control" type="text" id="business_name" name="business_name" placeholder="Company Name" value="<?php echo $user_detail->business_name ?>">
													</div>
												<div class="col-md-6">
													<input class="form-control required" type="text" id="mobile_no" name="mobile_no" placeholder="<?php echo trans('Telephone Number') ?>" value="<?php echo $user_detail->mobile_no ?>">
												</div>
												<div class="col-md-6">
													<input class="form-control required email" type="email" id="email" name="email" placeholder="<?php echo trans('form_email') ?>" value="<?php echo $user_detail->email ?>">
												</div>
												<div class="col-md-6">
													<!--<input class="form-control" type="text" id="city" name="city" placeholder="<?php echo trans('City') ?>" value="<?php echo $user_detail->city ?>">-->
													<input class="form-control city-state" type="text" id="cityState" name="address" placeholder="<?php echo trans('Location (City, State)') ?>" autocomplete="off" value="<?php echo $user_detail->address; ?>">
												</div>
												<!--<div class="col-md-6">
													<input class="form-control" type="text" id="state" name="state" placeholder="<?php echo trans('State') ?>" value="<?php echo $user_detail->state ?>">
												</div>-->
													<div class="col-md-6">
														<input class="form-control" type="text" id="website" name="website" placeholder="Website Link" value="<?php echo $user_detail->website ?>">
													</div>
													<div class="col-md-6">
														<input class="form-control" type="text" id="facebook" name="facebook_link" placeholder="Facebook Link" value="<?php echo $user_detail->facebook_link ?>">
													</div>
													<div class="col-md-6">
														<input class="form-control" type="text" id="linkedin" name="linkedin_link" placeholder="LinkedIn Link" value="<?php echo $user_detail->linkedin_link ?>">
													</div>
													<div class="col-md-6">
														<input class="form-control" type="text" id="instagram" name="insta_link" placeholder="Instagram Link" value="<?php echo $user_detail->insta_link ?>">
													</div>													
													
													<div class="col-md-6">
														<input class="form-control" type="text" id="tiktok_link" name="tiktok_link" placeholder="<?php echo trans('TikTok Link') ?>" value="<?php echo $user_detail->tiktok_link ?>">
													</div>
													<div class="col-md-6">
														<input class="form-control" type="text" id="youtube_link" name="youtube_link" placeholder="<?php echo trans('YouTube Link') ?>" value="<?php echo $user_detail->youtube_link ?>">
													</div>
													
												</div>
												
											</div>	
											<div class="form-group w-100">
												<textarea class="w-100" name="about_me" placeholder="About Seller"><?php echo $user_detail->about_me ?></textarea>
											</div>											
														
											<div class="form-group mt-3 mb-3 text-center">
												<input type="submit" class="btn" value="Save Details" />	
											</div>									
														
										</fieldset>
										</form>
									</div>
									<div class="tab-pane fade" id="update-password" role="tabpanel" aria-labelledby="update-password-tab">
										<form id="edit-password-form" method="post" action="<?php echo base_url(); ?>/providerauth/edit-password-post">
											<input type="hidden" name="id" value="<?php echo $user_detail->id ?>">
											<fieldset class="form-input">					
												<h4 class="title-sm text-center mb-4 mb-md-5 fw-bolder">Update Password</h4>
												<div class="form-section row row-cols-1">						
													<div class="form-group">
														<input class="form-control required" type="password" id="current_password" name="current_password" placeholder="<?php echo trans('Current Password') ?>">
													</div>					
													<div class="form-group">
														<input class="form-control required" type="password" id="new_password" name="new_password" placeholder="<?php echo trans('New Password') ?>">
													</div>
													<div class="form-group">
														<input type="password" name="confirm_new_password" class="form-control required" placeholder="<?php echo trans("Confirm New Password"); ?>" data-parsley-equalto="#new_password">
													</div>
												</div>	
												<input type="submit" class="btn" value="Change" />					
											</fieldset>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		</div>

<!-- Crop Modal -->
<div id="cropper-modal" class="cropper-modal" aria-hidden="true">
  <div class="cropper-dialog rounded-5 position-relative">
    <div class="cropper-header text-center py-4">
      <h3 class="title-md fw-bolder">Crop your photo</h3>
      <button type="button" class="cropper-close position-absolute top-0 end-0 m-4" id="cropper-cancel">&times;</button>
    </div>
    <div class="cropper-body p-0">
      <img id="cropper-image" alt="Crop preview" />
    </div>
    <div class="cropper-footer flex-column flex-sm-row gap-3">
      <div class="left-actions">
        <button type="button" id="zoom-in" class="btn btn-sm">Zoom +</button>
        <button type="button" id="zoom-out" class="btn btn-sm">Zoom −</button>
		<div class="position-absolute top-0 start-0 m-4">
        <button type="button" id="rotate-left" class="revision-btn">⟲</button>
        <button type="button" id="rotate-right" class="revision-btn">⟳</button>
		</div>
        <button type="button" id="reset" class="btn btn-sm">Reset</button>
      </div>
      <div class="right-actions">
        <button type="button" id="cropper-confirm" class="primary btn btn-sm">Crop & Upload</button>
      </div>
    </div>
  </div>
</div>

<script>
/* ===========================================================
   Profile Photo Uploader + Cropper + Change/Remove
   Requires jQuery. Cropper.js is auto-loaded by this script.
   =========================================================== */

$(document).ready(function() {
  // ---------- CONFIG ----------
  const ASPECT_W = 135;          // PlaneBroker ratio width
  const ASPECT_H = 100;          // PlaneBroker ratio height
  const OUTPUT_W = 1350;         // export width (px)
  const OUTPUT_H = 1000;         // export height (px) - keep ratio with OUTPUT_W
  const OUTPUT_TYPE = 'image/jpeg'; // 'image/png' if you need transparency
  const OUTPUT_QUALITY = 0.9;
  const MAX_MB = 8;              // client-side size limit
  const PLACEHOLDER_URL = '<?php echo base_url("assets/frontend/images/user-pic-new-1.png"); ?>';

  // Your endpoints (same as your existing code)
  const UPLOAD_URL = '<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/'+'<?php echo session()->get('vr_sess_user_id'); ?>';
  const SAVE_URL   = '<?php echo base_url(); ?>/providerauth/upload_profile_photo';
  const REMOVE_URL = '<?php echo base_url(); ?>/providerauth/remove_profile_photo';

  // If your CI4 routes need CSRF, fill these (else leave blank)
  const CSRF_NAME = '<?= csrf_token() ?>';
  const CSRF_HASH = '<?= csrf_hash() ?>';

  // ---------- DYNAMIC LOADER FOR CROPPER ----------
  function ensureCropper(){
    return new Promise((resolve) => {
      const hasCss = !!document.querySelector('link[data-cropper-css]');
      const hasJs  = !!window.Cropper;

      const done = () => resolve();

      if (!hasCss) {
        const l = document.createElement('link');
        l.rel = 'stylesheet';
        l.href = 'https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css';
        l.setAttribute('data-cropper-css','1');
        document.head.appendChild(l);
      }
      if (!hasJs) {
        const s = document.createElement('script');
        s.src = 'https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js';
        s.onload = done;
        document.head.appendChild(s);
      } else {
        done();
      }
    });
  }

  // ---------- MODAL (auto-injected) ----------
  function injectModal(){
    if (document.getElementById('cropper-modal')) return;
    const html = `
      <div id="cropper-modal" class="cropper-modal" aria-hidden="true">
        <div class="cropper-dialog">
          <div class="cropper-header">
            <strong>Crop your photo</strong>
            <button type="button" class="cropper-close" id="cropper-cancel">&times;</button>
          </div>
          <div class="cropper-body">
            <img id="cropper-image" alt="Crop preview" />
          </div>
          <div class="cropper-footer">
            <div class="cropper-controls">
              <button type="button" id="zoom-in">Zoom +</button>
              <button type="button" id="zoom-out">Zoom −</button>
              <button type="button" id="rotate-left">⟲ 90°</button>
              <button type="button" id="rotate-right">⟳ 90°</button>
              <button type="button" id="reset">Reset</button>
            </div>
            <button type="button" id="cropper-confirm" class="cropper-primary">Crop & Upload</button>
          </div>
        </div>
      </div>`;
    document.body.insertAdjacentHTML('beforeend', html);
  }

  // ---------- ACTION OVERLAY (auto-injected) ----------
  function injectActions(){
    const $wrap = $('#upload-icon');
    if (!$wrap.length) return;
    if ($wrap.find('.proPic-actions').length) return;
    $wrap.append(`
      <div class="proPic-actions">
        <button type="button" class="btn-change" id="btn-change-photo"><i class="fa fa-camera"></i></button>
        <button type="button" class="btn-remove" id="btn-remove-photo"><i class="far fa-trash-o"></i></button>
      </div>
    `);
  }

  // ---------- HELPERS ----------
  function sanitizeName(name){ return (name || 'upload').replace(/[^\w\-.]+/g, '_'); }
  function addCsrf(data){
    if (!CSRF_NAME || !CSRF_HASH) return data;
    return Object.assign({}, data, { [CSRF_NAME]: CSRF_HASH });
  }

  $(async function(){
    const $input  = $('#profile-pic-input');
    const $wrap   = $('#upload-icon');
    const $imgEl  = $('#upload-icon .uimg');
    const $dz     = $('.dz-wrap');

    // Show orange border when a real image is present (optional)
    if ($imgEl.attr('src') && !$imgEl.attr('src').includes('user-pic-new-1.png')){
      $wrap.addClass('has-image');
    }

    // Inject UI
    injectActions();
    injectModal();
    await ensureCropper();

    // Cropper refs
    const $modal = $('#cropper-modal');
    const $cropImg = $('#cropper-image');
    let cropper = null;
    let currentFileName = null;

    function openCropper(){
      if (cropper) { cropper.destroy(); cropper = null; }
      $modal.addClass('show').attr('aria-hidden','false');
      cropper = new window.Cropper($cropImg[0], {
        aspectRatio: ASPECT_W / ASPECT_H,
        viewMode: 2,
        dragMode: 'move',
        autoCropArea: 1,
        responsive: true,
        background: false,
        zoomOnTouch: true,
        zoomOnWheel: true,
        movable: true,
        rotatable: true,
        scalable: true,
        checkOrientation: true,
		minCropBoxWidth: 600,
		minCropBoxHeight: 400
      });
    }
    function closeCropper(){
      if (cropper){ cropper.destroy(); cropper = null; }
      $modal.removeClass('show').attr('aria-hidden','true');
      $cropImg.attr('src','');
      $input.val('');
    }

    // Controls
    $('#zoom-in').on('click', () => cropper && cropper.zoom(0.1));
    $('#zoom-out').on('click', () => cropper && cropper.zoom(-0.1));
    $('#rotate-left').on('click', () => cropper && cropper.rotate(-90));
    $('#rotate-right').on('click', () => cropper && cropper.rotate(90));
    $('#reset').on('click', () => cropper && cropper.reset());
    $('#cropper-cancel').on('click', closeCropper);

    // Clicking image or Change opens picker
    $('#upload-icon')
	  .off('click.profile')
	  .on('click.profile', function (e) {
		if ($(e.target).closest('.proPic-actions').length) return; // skip if Change/Remove clicked
		$input.trigger('click');
	  });

	/* 2) Change button: stop bubbling, open once */
	$(document)
	  .off('click.profile', '#btn-change-photo')
	  .on('click.profile', '#btn-change-photo', function (e) {
		e.preventDefault();
		e.stopPropagation();
		$input.trigger('click');
	  });

    // Drag & drop highlight
    $dz.on('dragover', function(e){ e.preventDefault(); $(this).addClass('over'); });
    $dz.on('dragleave drop', function(e){ e.preventDefault(); $(this).removeClass('over'); });
    $dz.on('drop', function(e){
      const f = e.originalEvent.dataTransfer.files?.[0];
      if (f) handleFile(f);
    });

    // File input change
    $input.on('change', function(){
      const f = this.files && this.files[0];
      if (f) handleFile(f);
    });

    // Instant local preview
    function instantPreview(file){
      const tmp = URL.createObjectURL(file);
      $imgEl.attr('src', tmp);
      $wrap.addClass('has-image');
      setTimeout(()=> URL.revokeObjectURL(tmp), 5000);
    }

    function handleFile(file){
	  const okTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/avif'];
	  if (!okTypes.includes(file.type)) { alert('Please select a JPG or PNG or AVIF image.'); return; }
	  if (file.size > MAX_MB * 1024 * 1024) { alert('Image is too large. Max '+MAX_MB+'MB.'); return; }

	  currentFileName = sanitizeName(file.name);

	  const reader = new FileReader();
	  reader.onload = function(e){
		$cropImg.attr('src', e.target.result);
		openCropper();   // only show in modal, no preview change yet
	  };
	  reader.readAsDataURL(file);
	}

    // Confirm crop -> upload blob -> save -> update preview
    $('#cropper-confirm').on('click', function(){
      if (!cropper) return;

      const canvas = cropper.getCroppedCanvas({
        width: OUTPUT_W,
        height: OUTPUT_H,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
      });
      if (!canvas){ alert('Could not crop this image.'); return; }

      canvas.toBlob(function(blob){
        if (!blob){ alert('Could not prepare the cropped image.'); return; }

        const ext = OUTPUT_TYPE === 'image/png' ? 'png' : 'jpg';
        const safeName = (currentFileName?.replace(/\.[^/.]+$/, '') || 'profile') + '.' + ext;

        const formData = new FormData();
        formData.append('upload', blob, safeName);

    $('.loader').show(); 
        // Upload to your existing upload endpoint
        $.ajax({
          url: UPLOAD_URL,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            try { if (typeof response === 'string') response = JSON.parse(response); } catch(e){}
            if (response?.uploaded == 1) {
              // Save filename to DB
              $.ajax({
                url: SAVE_URL,
                type: 'POST',
                dataType: 'json',
                data: addCsrf({ image: response.fileName,user_id:'' }),
                success: function(resp){
                  // Update avatar to final URL
                  const finalUrl = (response.url || $imgEl.attr('src')) + '?t=' + Date.now();
                  $imgEl.attr('src', finalUrl);
                 $('#btn-remove-photo').show();
                  $wrap.addClass('has-image');
                  closeCropper();
                },
                error: function(){ alert('Saved file, but failed to update profile. Please refresh.'); }
              });
            } else {
              alert((response?.error) || 'Upload failed. Please try again.');
            }
			$('.loader').hide();
          },
          error: function () { alert('Upload failed. Please try again.');$('.loader').hide(); }
        });
      }, OUTPUT_TYPE, OUTPUT_QUALITY);
    });

    // REMOVE -> delete on server + reset preview
    $(document).on('click', '#btn-remove-photo', function(e){
  e.stopPropagation();

  $.confirm({
    title: "Confirm Deletion",
    content: "Are you sure you want to remove your profile photo?",
    type: 'red',
    buttons: {
      confirm: {
        text: 'Yes, remove',
        btnClass: 'btn-red',
        action: function(){
          const $btn = $('#btn-remove-photo').prop('disabled', true).html('<i class="fas fa-trash-alt"></i>');

          $.ajax({
            url: REMOVE_URL,
            type: 'POST',
            dataType: 'json',
            data: addCsrf({}),
            success: function(resp){
              if(resp && resp.success){
                const placeholder = resp.url || PLACEHOLDER_URL;
                $('#upload-icon .uimg').attr('src', placeholder + '?t=' + Date.now());
                 $('#btn-remove-photo').hide();
                $('#upload-icon').removeClass('has-image');
                $('#profile-pic-input').val('');
              }else{
                $.alert(resp?.message || 'Could not remove the photo.');
              }
            },
            error: function(){
              $.alert('Remove failed. Please try again.');
            },
            complete: function(){
              $btn.prop('disabled', false).html('<i class="fas fa-trash-alt"></i>');
            }
          });
        }
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-default'
      }
    }
  });
});


  });
});
</script>

<style>
/* Make sure autocomplete appears on top */
.ui-autocomplete {
  position: absolute !important;
  z-index: 9999 !important;
  background: #fff;
  border: 1px solid #ccc;
  max-height: 250px;
  overflow-y: auto;   /* scroll if too many items */
  overflow-x: hidden;
  font-size: 14px;
  border-radius: 6px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Style each item */
.ui-menu-item {
  padding: 8px 12px;
  cursor: pointer;
}

/* Hover effect */
.ui-menu-item:hover {
  background: #f5f5f5;
}
.ui-autocomplete {
  position: absolute !important;
  top: 100% !important;   /* directly below input */
  left: 0 !important;
  z-index: 9999 !important;
  background: #fff;
  border: 1px solid #ccc;
  max-height: 250px;
  overflow-y: auto;
  border-radius: 6px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  width: 100% !important; /* match input width */
}

.ui-menu-item {
  padding: 8px 12px;
  cursor: pointer;
}

.ui-menu-item:hover {
  background: #f5f5f5;
}



/* Layout */
.uploader-row{
  display:flex;
  align-items:center;
  gap:18px;
}

/* ===== Dropzone ===== */
.dz-wrap{
  border:2px dashed #cfd7df;
  padding:22px 24px;
  text-align:center;
  position:relative;
  border-radius:16px;
  cursor:pointer;
  min-height:92px;
  width:100%;
}
.dz-wrap.over{ background:#f7fbff; }
.dz-wrap input[type="file"]{ position:absolute; inset:0; opacity:0; cursor:pointer; }

/* ===== Right-side preview card ===== */
.proPic{               /* set the card width you want */
  aspect-ratio: 135 / 100;     /* PlaneBroker-style ratio; use 1/1 for square */
  /*border:1px solid #e5e8ec;*/
  border-radius:12px;
  overflow: hidden;
  position: relative;
  max-width:270px;
}
.proPic .uimg{ width:100%; height:100%; object-fit:cover; display:block;border-radius: 0;}
.proPic.has-image{ border-color:#f59e0b; }

/* Hover actions (Change / Remove) */
.proPic-actions{
  position:absolute; left:0; right:0; bottom:0;
  display:flex; gap:8px; justify-content:center;
  padding:10px;
  background:linear-gradient(to top, rgba(0,0,0,.75), rgba(0,0,0,0));
  opacity:1; transition:opacity .2s ease-in-out;
}
.proPic:hover .proPic-actions{ opacity:1; }

/* Show actions on mobile */
@media (max-width: 768px){
  .proPic-actions{ opacity:1; }
}

/* Action buttons */
.proPic-actions button{
	appearance: none;
    border: 0;
    border-radius: 100px;
    font-size: 16px;
    padding: 0px 8px;
    color: var(--white);
    cursor: pointer;
    background: var(--primary);
    aspect-ratio: 1 / 1;
    width: 34px;
}
/*.proPic-actions .btn-change{ background:#2563eb; }   blue */
/*.proPic-actions .btn-remove{ background:#dc2626; }   red */
.proPic-actions .btn-change:hover,
.proPic-actions .btn-remove:hover{ color: var(--white); }

/* ===== Cropper Modal ===== */
.cropper-modal{
  position:fixed; inset:0; background:rgba(0,0,0,.55);
  display:none; align-items:center; justify-content:center;
  z-index:9999;
}
.cropper-modal.show{ display:flex; }
.cropper-dialog{
  width:min(92vw, 620px);
  background:#fff; border-radius:14px; overflow:hidden;
  box-shadow:0 10px 40px rgba(0,0,0,.25);
}
.cropper-footer{
  padding:12px 16px; display:flex; align-items:center; justify-content:space-between;
}
.cropper-body{ padding:12px 16px; max-height:70vh; }
.cropper-body img{ max-width:100%; display:block; margin:0 auto; }
.cropper-close{ background:none; border:0; font-size:24px; line-height:1; cursor:pointer; }
.cropper-controls{ display:flex; gap:8px; flex-wrap:wrap; }
.cropper-controls button{
  padding:8px 12px; border:1px solid #ddd; background:#fafafa; border-radius:8px; cursor:pointer;
}
.cropper-primary{ background:#1a73e8; color:#fff; border-color:#1a73e8; }
.cropper-modal{
	opacity:1;
}
.revision-btn {
	    border: none;
    background: transparent;
    font-size: 21px;
    font-weight: 700;
}
.loader{
	z-index:99999;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    display: none;
}
.loader:before {
    content: "";
    box-sizing: border-box;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    margin-top: -30px;
    margin-left: -30px;
    border-radius: 50%;
    border: 2px solid #ccc;
    border-top-color: #333;
    animation: spin 1s 
ease-in-out infinite;
}
</style>
<div class="loader"></div>
<?= $this->endSection() ?>