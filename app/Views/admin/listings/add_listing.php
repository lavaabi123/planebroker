<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/selectize/css/selectize.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/pickadate/themes/pickadate.min.css" /> 
<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/selectize/js/standalone/selectize.min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.time.js'></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/provider.js?v=2.0"></script>
<!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.min.js"></script>
	
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.css">
	<style>
	.progress-bar-wrapper {
  width: 100%;
  height: 8px;
  background-color: #e6e6e6;
  border-radius: 30px;
  overflow: hidden;
  margin-top: 10px;
  box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
}

.progress-bar {
  height: 100%;
  background: linear-gradient(90deg, #4caf50, #81c784);
  transition: width 0.3s ease;
  border-radius: 30px;
}

.progress-label {
  font-weight: bold;
  text-align: center;
  margin-bottom: 5px;
}
	.bootstrap-tagsinput .badge {
		color: #797979;
	}	
/*	ul#imageListId li:first-child:after {
    content: "Profile Picture";
    background-color: #ffffffe0;
    top: 27%;
    position: absolute;
    display: inline-block;
	right: calc(var(--bs-gutter-x) * .5);
    left: calc(var(--bs-gutter-x) * .5);
	color: #000;
	transform: rotate(317deg);
    font-size: 0.7rem;
    text-align: center;
} */
.bootstrap-tagsinput{
border-color: #b3b3b3;
    border-radius: 50px !important;
    box-shadow: none;
    font-size: 14px;
    padding: 15px 30px 15px 20px;
	}
	#upload-image-i {
	background:#e1e1e1;
	width:300px;
	padding:30px;
	height:300px;
}
.image-container {
  position: relative;
  display: inline-block; /* Ensure container fits the size of the image */
}

.icon-container {
  position: absolute;
  top: 33%; /* Adjust the positioning as needed */
  left: 39%; /* Adjust the positioning as needed */
  color: white; /* Color of the icon */
  background-color: rgba(0, 0, 0, 0.5); /* Background color for icon container */
  padding: 5px;
  border-radius: 6px; /* To make it a circle, adjust size if needed */
}

.icon-container i {
  font-size: 24px; /* Adjust the size of the icon */
}
label.error {
    display: none !important;
}
.services-group label.error,
.dyn-error-holder label.error { /* checkbox errors show */
    display: block !important;
    color: #dc3545;
    font-size: .875rem;
    margin-top: .25rem;
}
.form-control.error,.error-border input, .error-border textarea{
    border-color: #dc3545 !important;
}
.form-control.error {
    border-color: red !important;
}
.video__wrapper{
  margin:20px 0;
  display:inline-block;
  position:relative;
}
video{
  width:100%;
  aspect-ratio: 16/9;
  object-fit: cover;
  max-width:100%;
  display:inline-block;
  vertical-align:top;
}
.video__play-button{
  margin:0;
  padding:0;
  cursor:pointer;
  position:absolute;
  top:0;
  left:0;
  width:100%;
  height:100%;
  border:0;
  border-radius:0;
  background-color:rgba(0,0,0,0.8);
  -webkit-appearance:none;
  z-index:2;
  transition: all 200ms ease-in-out;
}

.video__play-button-icon{
  width:15%;
  transition: all 200ms ease-in-out;
}

.video__play-button-icon--play polygon{
  transform-origin: 50% 50%;
  transition: all 200ms ease-in-out;
}

.video__play-button-icon--play:hover polygon{
  transform: scale(1.5);
}

.video__play-button[data-button-state="pause"] .video__play-button-icon--pause{
  display:none;
}

.video__play-button[data-button-state="play"] .video__play-button-icon--play{
  display:none;
}

.video__play-button[data-button-state="play"] .video__play-button-icon{
  opacity:0;
}

.video__play-button[data-button-state="play"]:hover .video__play-button-icon{
  opacity:1;
}

.video__play-button[data-button-state="play"]{
  background-color:rgba(0,0,0,0);
}

.video__play-button[data-button-state="play"]:hover{
  background-color:rgba(0,0,0,.4);
}

.video__fullscreen-button{
  margin:0;
  padding:0;
  position:absolute;
  bottom:10px;
  right:10px;
  border:0;
  background:transparent;
  cursor:pointer;
  border-radius:0;
  -webkit-appearance:none;
  z-index:3;
  transition: all 200ms ease-in-out;
}

.video__fullscreen-icon{
  padding:10px;
  display:block;
  vertical-align:top;
  color:#fff;
  opacity:0;
  visibility:hidden;
  transition: all 200ms ease-in-out;
}

.video__wrapper[data-state="pause"] .video__fullscreen-icon,
.video__wrapper[data-state="play"]:hover .video__fullscreen-icon{
  opacity:1;
  visibility:visible;
}

.video__fullscreen-icon polygon{
  fill:currentColor;
}
	</style>
<div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo !empty($_GET['id']) ? 'Edit Listing' : 'Add Listing'; ?>
					<?php if(!empty($_GET['id'])){ ?>
                        <a class="btn btn-primary" href="<?php echo admin_url() . 'listings'; ?>"><?php echo trans('Back'); ?></a>
					<?php }else{ ?>
						<a class="btn btn-primary" href="<?php echo admin_url() . 'listings/add?plan_id='.$_GET['plan_id'].'&user_id='.$_GET['user_id'].''; ?>"><?php echo trans('Back'); ?></a>
					<?php } ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>listings"><?php echo trans('Listings') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <?php echo form_open_multipart('add-listing-post', ['id' => 'aircraft-add-form-1',  'class' => 'custom-validation needs-validation']); ?>
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <input type="hidden" id="crsf">
                                    
						<?php echo csrf_field() ?>
						<input type="hidden" name="listing_from" value="admin">
						<input type="hidden" name="added_by" value="1">
						<input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
						<input type="hidden" name="status" value="<?php echo !empty($product_detail['status']) ? $product_detail['status'] : 1; ?>">
						<input type="hidden" name="category_id" value="<?php echo $_GET['category']; ?>">
						<input type="hidden" name="product_id" value="<?php echo !empty($_GET['id']) ? $_GET['id'] : ''; ?>">
						<input type="hidden" name="status" value="<?php echo !empty($product_detail['status']) ? $product_detail['status'] : 0; ?>">
						
						<input type="hidden" name="sale_id" value="<?php echo !empty($selected_sale_id) ? $selected_sale_id : (!empty($product_detail['sale_id']) ? $product_detail['sale_id'] : '') ; ?>">
						<input type="hidden" name="payment_type" value="<?php echo !empty($selected_payment) ? $selected_payment : (!empty($product_detail['payment_type']) ? $product_detail['payment_type'] : 'stripe'); ?>">
						<input type="hidden" name="plan_id" value="<?php echo !empty($_GET['plan_id']) ? $_GET['plan_id'] : (!empty($product_detail['plan_id']) ? $product_detail['plan_id'] : ''); ?>">
						
							<fieldset class="form-input">
							
								<div class="form-section">
									<div class="form-group">
										<select name="sub_category_id" class="form-control required mb-4" required>
											<option value=""><?php echo trans('Select Category') ?></option>
											<?php
											if(!empty($sub_categories)){
												foreach($sub_categories as $category){ ?>
													<option value="<?php echo $category->id; ?>" <?php echo (!empty($product_detail['sub_category_id']) && $product_detail['sub_category_id'] == $category->id) ? 'selected':''; ?>><?php echo $category->name; ?></option>
											<?php }
											}
											?>
										</select>
										<?php 
										if(!empty($dynamic_fields)){
											foreach ($dynamic_fields as $groupName => $dynamic_field): 
											$hasShowCatBasedZero = !empty(array_filter($dynamic_field, function($item) {
												return isset($item->show_cat_based) && $item->show_cat_based == 0;
											}));
											echo '<div class="'.(($hasShowCatBasedZero) ? "" : "catbasedtitle" ).'" style="display:'.(($hasShowCatBasedZero) ? "" : "none" ).'">';
											?>
											<h5><?= esc($groupName) ?></h5>
											<?php 
											$dynamic_fields_values = !empty($product_detail['dynamic_fields']) ? json_decode($product_detail['dynamic_fields'],true) : array();
											
											echo '<div class="row  mt-3">
											<div class="col-12">
												<div class="form-group mb-3">
												<div class="form-section row row-cols-1 row-cols-md-2">';
											foreach($dynamic_field as $field){
												
												$req_op = !empty($field->field_condition) ? '*' : (!empty($field->field_optional_show) ? '(optional)' : '');
												$req_op_text = ($field->field_condition) ? 'required' : '';
												if($field->field_type == 'Checkbox'){
													$decoded_option1 = !empty($field->field_options) ? json_decode($field->field_options) : array();
													if (!empty($decoded_option1) && count($decoded_option1) > 0) {
														echo '</div><div class="form-section row">'; 
													}
												}
												echo '<div class="services-group form-group pr-2 d_fields '.(($field->show_cat_based == 0) ? "" : "catbasedfield" ).'" style="'.(($field->show_cat_based == 0) ? "" : "none" ).'" data-category="'.$field->category_ids.'" data-subcategory="'.$field->subcategory_ids.'">
														';
														if($field->field_type == 'Text'){
															$placeholder = $field->name . ' ' . $req_op;

															// Check if placeholder contains Location / City / State
															$extra_class = '';
															if (preg_match('/location|city|state/i', $placeholder)) {
																$extra_class = ' city-state';
															}
															echo '<input type="text" name="dynamic_fields['.$field->id.']" class="form-control ' . $extra_class . '" placeholder="'.$field->name.' '.$req_op.'" value="'. (!empty($dynamic_fields_values[$field->id]) ? $dynamic_fields_values[$field->id] : '').'" '.$req_op_text.'>';
														}else if($field->field_type == 'Number'){
															echo '<input type="number" name="dynamic_fields['.$field->id.']" class="form-control" placeholder="'.$field->name.' '.$req_op.'" value="'. (!empty($dynamic_fields_values[$field->id]) ? $dynamic_fields_values[$field->id] : '').'" '.$req_op_text.'>';
														}else if($field->field_type == 'Textarea'){
															$rowsnumber = ($field->name == 'About this Aircraft' || $field->id == 14) ? 'rows="5"' :'';
															echo '<textarea name="dynamic_fields['.$field->id.']" class="form-control '.(!empty($field->show_text_editor)? 'show_text_editor' : '').'" placeholder="'.$field->name.' '.$req_op.'" '.$req_op_text.' '.$rowsnumber.'>'. (!empty($dynamic_fields_values[$field->id]) ? $dynamic_fields_values[$field->id] : '').'</textarea>';
														}else if($field->field_type == 'Checkbox'){
															echo empty($field->show_cat_based) ? '<label class="mb-1 mt-4 d-block mx-0 fw-bold text-black">'.$field->name.' '.$req_op.'</label>':'';
															$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
															if (!empty($decoded_option) && count($decoded_option) > 0 && is_array($decoded_option)) {
																 $selectedValues = !empty($dynamic_fields_values[$field->id])
        ? (is_array($dynamic_fields_values[$field->id])
            ? $dynamic_fields_values[$field->id]
            : [$dynamic_fields_values[$field->id]])
        : [];
																echo '
												<div class="dyn-error-holder d-none"></div><div class="row">';
																foreach($decoded_option as $oi => $option){
																	if (!empty($decoded_option1) && count($decoded_option1) > 0) {
																		echo '<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-option d-flex my-2 align-items-center">';
																	}else{
																		echo '<div class="col-sm-12 col-xs-12 col-option d-flex my-2 align-items-center">';
																	}
        echo '<input type="checkbox" 
                name="dynamic_fields['.$field->id.'][]" 
                id="status_'.$oi.'" 
                value="'.$option.'" 
                '. (in_array($option, $selectedValues) ? 'checked' : '') .' '.$req_op_text.'>
              <label for="status_'.$oi.'" class="option-label d-block">'.$option.'</label>';
        echo '</div>';
																}	
																echo '</div>';															
															}else{
																echo 'Options not available';
															}
														}else if($field->field_type == 'Radio'){
															echo '<label class="mb-1 d-block mx-0 mt-4 fw-bold text-black">'.$field->name.' '.$req_op.'</label>';
															$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
															if (!empty($decoded_option) && count($decoded_option) > 0) {
																echo '<div class="row">';
																foreach($decoded_option as $oi => $option){
																	echo '<div class="col-sm-4 col-xs-12 col-option d-flex"><input type="radio" name="dynamic_fields['.$field->id.']" id="status_'.$oi.'" class="" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->id]) && $option== $dynamic_fields_values[$field->id]) ? 'checked' : '').'  '.$req_op_text.'><label for="status_'.$oi.'" class="option-label d-block">'.$option.'</label></div>';
																}	
																echo '</div>';															
															}else{
																echo 'Options not available';
															}
														}else if($field->field_type == 'Dropdown'){
															$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
															$option_html = '';
															if (!empty($decoded_option) && count($decoded_option) > 0) {
																$nclass = (count($decoded_option) > 8) ?'sshome' : '';
																echo '<select class="form-control '.$nclass.'" name="dynamic_fields['.$field->id.']"  '.$req_op_text.'><option value="">'.$field->name.' '.$req_op.'</option>';
																foreach($decoded_option as $oi => $option){
																	echo '<option value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->id]) && ($option == $dynamic_fields_values[$field->id]) ) ? 'selected' : '').'>'.$option.'</option>';
																}
																echo '</select>';															
															}else{
																echo 'Options not available';
															}
														}else if($field->field_type == 'File'){
															if($groupName == 'Logbook(s)'){
																echo '<label class="me-3 d-flex fw-bold">'.$field->name.'</label>';
															}
															echo '<label class="dz-wrap mb-3" style="display:block !important;margin-left:0 !important;">
										<span>Upload your files — drag & drop or click to select (multiple files allowed) </span><br />
										<span>(pdf,.doc,.docx,.png,.jpeg,.jpg)</span><input type="file" name="dynamic_fields['.$field->id.'][]" class="form-control dynamic-file-input" placeholder="'.$field->name.'" value="" data-field-id="' . $field->id . '" accept=".pdf,.doc,.docx,.png,.jpeg,.jpg"  multiple>
									</label>';
									echo '<div id="file-previews-'.$field->id.'" class="file-previews-grid" data-field-id="'.$field->id.'"></div>';
															//echo '<button type="button" class="btn btn-sm px-5 mb-3 edit-titles-btn min-w-auto d-none" data-field-id="'.$field->id.'">Edit File Details</button>';
															if(!empty($dynamic_fields_values[$field->id]) && is_array($dynamic_fields_values[$field->id])){
																foreach($dynamic_fields_values[$field->id] as $df => $dfv){
																	
																	if(!empty($dynamic_fields_values[$field->id][$df]['field_value'])){
																		echo '<div class="existing-files-wrapper existing-file mb-2" data-file-index="'.$df.'" data-field-id="'.$field->id.'">';
																		echo '<input type="hidden" value="'.$dynamic_fields_values[$field->id][$df]['field_value'].'" name="dynamic_fields_old['.$field->id.'][]"  data-url="'.base_url().'/uploads/userimages/'.$_GET['user_id'].'/'.$dynamic_fields_values[$field->id][$df]['field_value'].'"  />';
																		echo '<input type="hidden" value="'.$dynamic_fields_values[$field->id][$df]['file_field_title'].'" name="dynamic_fields_titles_old['.$field->id.'][]" /></div>';
																	}
																}
															}else{
																//echo !empty($dynamic_fields_values[$field->id]) ? '<a class="btn" target="_blank" href="'.base_url().'/uploads/userimages/'.$_GET['user_id'].'/'.$dynamic_fields_values[$field->id].'" >View '.$field->name.'</a><button type="button" class="btn btn-danger btn-sm remove-existing-btn">Remove</button>' : '';
																if(!empty($dynamic_fields_values[$field->id])){
																	echo '<div class="existing-files-wrapper existing-file mb-2" data-file-index="0" data-field-id="'.$field->id.'">';
																	echo '<input type="hidden" value="'.$dynamic_fields_values[$field->id].'" name="dynamic_fields_old['.$field->id.'][]"  data-url="'.base_url().'/uploads/userimages/'.$_GET['user_id'].'/'.$dynamic_fields_values[$field->id].'"  />';
																	echo '<input type="hidden" value="'.$dynamic_fields_values[$field->id].'" name="dynamic_fields_titles_old['.$field->id.'][]" /></div>';
																}
															}
														}
													echo '</div>';
											
											}
											echo '</div>						
												</div>
											</div>                                    
										</div></div>';
										
										endforeach; 
										}									
										?>
									</div>
								</div>
							</fieldset>

							<fieldset class="form-input">
								<div class="form-section">
									<div class="form-group">
								<div class='row'>
						
						
							<div class='col-12 <?php if(!empty($user_photos)){ ?>col-sm-6<?php }else{ ?>col-sm-6<?php } ?>'>
								<h3 class="title-xl black mt-0 mb-2"><?php echo trans('Photos and Videos') ?></h3>
								<h5 class="mb-3">Add Photos or Videos <span style="font-weight: 100;font-size: 0.7rem;vertical-align: middle;"></span></h5>
								
									<div class="file-upload">
									<label class="dz-wrap" style="display:block !important;margin-left:0 !important;">
										<span>Upload your files — drag & drop or click to select (multiple files allowed) </span><br />
										<span>(pdf,.doc,.docx,.png,.jpeg,.jpg)</span>
										<input type='file' id="userphoto" name='uploads[]' data-type="add" multiple class="cropimage w-100" accept=".jpg,.jpeg,.png,.mp4,.mov">
									</label>
									</div>
									
									<div class="d-flex justify-content-between align-items-center mt-3">
										
									</div>
									
							</div>
						
							
							<div class='col-12 <?php if(!empty($user_photos)){ ?>col-sm-6<?php }else{ ?>col-sm-6<?php } ?>'>
								<h5 class="mb-3">Current Photos & Videos</h5>
								<div class='load-images'>
									<?php if(!empty($user_photos)){ ?>
									<input name="image_ids" class="form-control" type="hidden" value="<?php echo $user_photos[0]['all_ids']; ?>" />
									<?php if(count($user_photos) > 1){ ?>
									<p>(<?php echo trans('Drag and drop to organize your photos and videos'); ?>)</p>
									<?php } ?>
									<ul class="row" id="imageListId">
									<?php
										foreach($user_photos as $r => $row){
											echo "<li class='col-6 col-md-3 listitemClass' id='imageNo".$row['id']."'><div class='pic'>";
											if($row['file_type']=='image'){
												echo "<img width='100%' height='100px' style='display:block;' src='".base_url()."/uploads/userimages/".$_GET["user_id"]."/".$row['file_name']."'>";
											}else{
												echo '
												<div class="video__wrapper" data-state="pause">
												  <button type="button" class="video__fullscreen-button"><svg class="video__fullscreen-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><polygon points="0 0 0 5 2 5 2 2 5 2 5 0 "/><polygon points="14 0 9 0 9 2 12 2 12 5 14 5 "/><polygon points="14 14 14 9 12 9 12 12 9 12 9 14 "/><polygon points="0 14 5 14 5 12 2 12 2 9 0 9 "/></svg></button>
												  <a href="'.base_url().'/uploads/userimages/'.$_GET["user_id"].'/'.$row["file_name"].'"
												   class="glightbox-video"
												   data-type="video"
												   data-width="1280"
												   data-height="720">
												   <button type="button" class="video__play-button" data-button-state="pause">
													<svg class="video__play-button-icon video__play-button-icon--play" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140"><path fill-rule="evenodd" clip-rule="evenodd" fill="white" d="M70 140L70 140c-38.7 0-70-31.3-70-70l0 0C0 31.3 31.3 0 70 0l0 0c38.7 0 70 31.3 70 70l0 0C140 108.7 108.7 140 70 140z"/><polygon fill-rule="evenodd" clip-rule="evenodd" points="57 50.9 57 89.4 88.5 70.2 "/></svg>
													<svg class="video__play-button-icon video__play-button-icon--pause" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140"><path fill-rule="evenodd" clip-rule="evenodd" fill="white" d="M70 140L70 140c-38.7 0-70-31.3-70-70v0C0 31.3 31.3 0 70 0h0c38.7 0 70 31.3 70 70v0C140 108.7 108.7 140 70 140z"/><rect fill-rule="evenodd" clip-rule="evenodd" x="56" y="50.8" class="st1" width="8.8" height="38.5"/><rect fill-rule="evenodd" clip-rule="evenodd" x="75.2" y="50.8" class="st1" width="8.8" height="38.5"/></svg>
													</button>
													<video  muted playsinline preload="metadata" style="cursor: pointer;">
														<source src="'.base_url().'/uploads/userimages/'.$_GET["user_id"].'/'.$row["file_name"].'" type="video/mp4">
														Your browser does not support the video tag.
													</video>
												</a>
												</div>';
											}
											echo "<div class='d-flex justify-content-between bg-orange text-white py-1 px-3'><div class='trash' onclick='editphotos(".$row['id'].",this)' data-id='".$row['id']."' data-file-type='".$row['file_type']."' data-tags='".$row['image_tag']."' style='cursor:pointer'><i class='fa fa-pen'></i></div><div class='trash' onclick='deletephotos(".$row['id'].", this)' data-id='".$row['id']."' style='cursor:pointer'><i class='fa fa-trash-o'></i></div></div></div></li>";
										}
									?>
									</ul>
									<?php 
									}else{
										echo 'please upload.';
									} ?>
								</div>
							</div>
								</div>
							</div>
						</div>
							</fieldset>

							<fieldset class="form-input">
								<h3 class="title-xl black my-3"><?php echo trans('Seller Information') ?></h3>
								<div class="form-section row row-cols-1 row-cols-md-2">
								<div class="form-group">
									<input class="form-control required" type="text" id="business_name" name="business_name" placeholder="<?php echo trans('Name') ?>" value="<?php echo !empty($product_detail['business_name']) ? $product_detail['business_name'] : (!empty(old('business_name'))?old('business_name'):$user_detail->fullname); ?>" required>
								</div>													
								<div class="form-group">
									<input class="form-control required" type="text" id="phone" name="phone" placeholder="<?php echo trans('Phone Number') ?>" autocomplete="off" value="<?php echo !empty($product_detail['phone']) ? $product_detail['phone'] : (!empty(old('phone'))?old('phone'):$user_detail->mobile_no); ?>" required>
								</div>													
								<div class="form-group">
									<input class="form-control city-state required" type="text" id="cityState" name="address" placeholder="<?php echo trans('Location (City, State)') ?>" autocomplete="off" value="<?php echo !empty($product_detail['address']) ? $product_detail['address'] : old('address'); ?>" required>
								</div>	  
																				
								<div class="form-group">
									<input class="form-control required" type="email" id="email" name="email" placeholder="<?php echo trans('Email') ?>" autocomplete="off" value="<?php echo !empty($product_detail['email']) ? $product_detail['email'] : (!empty(old('email'))?old('email'):$user_detail->email); ?>" required>
								</div>	
								<!--<div class="form-group">
									<input class="form-control" type="text" id="address2" name="suite" placeholder="<?php echo trans('Suite, Apartment, etc') ?>" value="<?php echo old('suite') ?>" >
								</div>
								<div class="form-group row">
								<div class="col-12 col-md-5 pr-md-0">							
									<input type="text" value="" placeholder="City" name='locality' id="locality" class='form-control required' />
								</div>
								<div class="col-12 col-md-4 px-md-1">							
									<input type="text" value="" placeholder="State" name='state' id="state" class='form-control required' />
								</div>
								<div class="col-12 col-md-3 pl-md-0">							
									<input type="text" value="" placeholder="Zip Code" name='postcode' id="postcode" class='form-control required' />
								</div>-->
								</div>
							</fieldset>
								
								<input type="hidden" id="g-recaptcha-response"  class="form-control required" name="check_bot" value="" >
								
								<input type="hidden" name="register_plan" value="<?php echo !empty($_GET["plan_id"]) ? $_GET["plan_id"] : 1; ?>" >
							<div class="position-sticky bottom-0 py-2 bg-gray-100 gap-2" style="display: flex;justify-content: center;">
							<?php if(!empty($_GET['id'])){ ?>
							<input type="submit" value="PUBLISH" class="btn py-3 blue-btn fw-medium mb-0" />

							<?php if(empty($product_detail['status'])){ ?>

							<span class="btn text-right save-listing py-3">SAVE LISTING</span>

							<?php }}else{ ?>

							<input type="submit" value="PUBLISH" class="btn py-3 blue-btn fw-medium mb-0" />

							<span class="btn text-right save-listing py-3">SAVE LISTING</span>
							
							<?php } ?>
							</div>
						</form> 
                            </div>
                        </div>
                        <div class="card-footer p-0 pt-3 clearfix">
                            <small><strong><span class="required"> *</span> Must be filled</strong></small>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div> <!-- end col -->

        </div>

        <?php echo form_close(); ?>
        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

	
<div id="upload-file-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl h-100">
		<div class="modal-content rounded-5 p-3 px-md-5 position-relative h-100">
			<div class="modal-header bg-solid-warning justify-content-center p-4 pb-0 border-0 flex-column">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5 position-absolute top-0 end-0 m-3"><i class="fa-solid fa-xmark"></i></a>
			<div class="header-message"><h5 class="mb-0 fw-bolder">Add Tags and Upload</h5></div>
			<div class="upload-loading" style="display:none; margin-top: 20px;width:80%;">
			  <div class="progress-label">Uploading...</div>
			  <div class="progress-bar-wrapper">
				<div class="progress-bar" id="upload-progress-bar" style="width: 0%"></div>
			  </div>
				<!--<p class="upload-loading-success text-success" style="display:none"></p>
				<p class="upload-loading-error text-danger" style="display:none"></p>-->
			</div>
			</div>
			<div class="modal-body px-0 overflow-auto">				
				<div class="final-result-container">
					<div class="load-images-final" style="display: grid;grid-template-columns: repeat(4, 1fr);gap: 20px;"></div>
					<div class="csimage cropped_image_save" data-id=""></div>					
				</div>
				
			</div>
			<div class="modal-footer py-4 px-0 gap-2 justify-content-center">
				<input type='button' value='Upload' class='btn photoupload m-0'>	
				<input type='button' value='Done' class='btn photouploaddone' style="display:none;">			
			</div>
		</div>
	</div>
</div>	

		
<div id="edit-file-modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content rounded-5 p-3 px-md-5 position-relative">
			<div class="modal-header bg-solid-warning justify-content-center p-4 pb-0 border-0">
			<a href="javascript:void(0);" data-bs-dismiss="modal" class="fs-5 position-absolute top-0 end-0 m-3"><i class="fa-solid fa-xmark"></i></a>
			<div class="header-message-edit"><h5 class="mb-0 fw-bolder">Edit Photo/Video</h5></div>
			</div>
			<div class="modal-body px-0 overflow-auto">	
				<div class="load-images-final-edit" style="display: grid;grid-template-columns: repeat(1, 1fr);gap: 20px;">
					<div class="up-ca" style="padding: 0px !important;">
					<div class="editablemedia mb-3">
						<img width="100%" height="auto" style="object-fit:cover;border-radius: 25px;border: 1px solid #eee;height: 200px;" class="change-button load-edit-image" />	
					</div>
					
						<label class="dz-wrap mb-3" style="display:block !important;margin-left:0 !important;margin-right: 0 !important;">
							<span>Replace Photo/Video (.png,.jpeg,.jpg,.mp4,.mov)</span>
							<input type='file' id="userphoto_edit" name='uploads[]' data-type="edit" style="padding: 4px 4px !important;" class="w-100 cropimageedit" accept=".png,.jpeg,.jpg,.mp4,.mov">	
						</label>					
					</div>
				</div>	
				<label>Tags (Optional)</label><textarea style="width:100%;" class="mb-0" id="image_tag" name="image_tag[]" placeholder="Ex: Control Panel, Left Wing, Tail, etc."></textarea>
								
			</div>
			<div class="modal-footer py-4 px-0 gap-2 justify-content-center">
				<input type='button' value='Cancel' onclick="cancel_edit()" class='btn bg-orange m-0 px-5 min-w-auto change-button'>
				<input type='button' value='Update' data-id="" onclick="editphotospost(this)" class='btn change-button min-w-auto m-0 px-5 photouploadupdate'>			
			</div>
		</div>
	</div>
</div>
										

<div class="modal fade" id="confirmCloseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl h-100">
    <div class="modal-content rounded-5 p-3 px-md-5 position-relative h-100" style="backdrop-filter: blur(50px); background: transparent;">
      <div class="modal-body px-0 d-flex flex-column justify-content-center text-center">
        <h5 class="mb-2">Your photos and videos aren’t uploaded yet!</h5>
		<p>Are you sure you want to leave now and lose your progress?</p>
      </div>
      <div class="modal-footer py-4 px-0 gap-2 justify-content-center">
        <button type="button" class="btn btn-danger" id="discardUpload">Yes, discard</button>
        <button type="button" class="btn btn-secondary" id="continueUpload">No, continue upload</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="titlesModal" tabindex="-1" aria-labelledby="titlesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
    
      <div class="modal-content rounded-5 p-3 px-md-5 position-relative">
        <div class="modal-header bg-solid-warning justify-content-center p-4 pb-0 border-0 flex-column">
          <h5 class="modal-title mb-0 fw-bolder">Edit File Details</h5>
          <button type="button" class="btn-close fs-5 position-absolute top-0 end-0 m-0" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body px-0 pb-0" id="modalBody">
			<form id="titlesForm" class="w-100">
          <!-- JS-generated file list will appear here -->
		  <div id="logBook-edit" class="pb-3"></div>
			<div class="modal-footer bg-white px-0 justify-content-between position-sticky bottom-0 rounded-0 z-3">
				<!--<div class="m-0">
				  <a href="javascript:void(0);" class="m-0" data-field-id="" id="triggerModalFileInput"><i class="fa fa-plus-circle me-2"></i>Add File</a>
				</div>-->
				  <button type="submit" class="btn min-w-auto m-0 btn-success px-5">Save</button>
			</div>
		  </form>
        </div>
        
      </div>
    
  </div>
</div>

<style>
  .dz-wrap {
    border: 2px dashed #ccc;
    padding: 2rem;
    text-align: center;
    position: relative;
    border-radius: 20px;
    cursor: pointer;
  }

  .dz-wrap.over {
    background-color: #f0faff;
  }

  .dz-wrap input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
  }
</style>
<script>
$(function () {

  function buildAcceptTester(input) {
    // Parse accept like ".jpg,.jpeg,.png,.mp4,.mov" OR "image/*" OR "video/mp4"
    const accepts = (input.getAttribute('accept') || '')
      .split(',')
      .map(s => s.trim().toLowerCase())
      .filter(Boolean);

    return function isAllowed(file) {
      if (!accepts.length) return true; // no accept -> allow all
      const name = (file.name || '').toLowerCase();
      const type = (file.type || '').toLowerCase();

      return accepts.some(a => {
        if (a.startsWith('.'))           return name.endsWith(a);                // extension
        if (a.endsWith('/*'))            return type.startsWith(a.slice(0, -1)); // image/*, video/*
        return type === a;                                                        // exact mime
      });
    };
  }

  // Helper: make one drop-zone work
  function wireDropZone(dz) {
    const input = dz.querySelector('input[type="file"]');
    if (!input) return;

    const isAllowed = buildAcceptTester(input);

    // Highlight on drag-over
    dz.addEventListener('dragenter', e => { e.preventDefault(); dz.classList.add('over'); });
    dz.addEventListener('dragover',  e => { e.preventDefault(); });

    // Remove highlight
    dz.addEventListener('dragleave', () => dz.classList.remove('over'));

    dz.addEventListener('drop', e => {
  e.preventDefault();
  dz.classList.remove('over');

  const files = [...(e.dataTransfer?.files || [])];
  if (!files.length) return;

  // Separate valid & invalid
  let valid = [];
  let rejected = [];

  files.forEach(file => {
    if (isAllowed(file)) {
      valid.push(file);
    } else {
      rejected.push(file.name);
    }
  });

  // If single file input, keep only the first
  if (!input.hasAttribute('multiple') && valid.length > 1) {
    valid = [valid[0]];
  }

  if (!valid.length) {
    input.value = '';
    if (rejected.length) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid file(s)',
        html: rejected.join('<br>'),
        confirmButtonColor: '#d33'
      });
    }
    return;
  }

  // Replace previous selection
  const dt = new DataTransfer();
  valid.forEach(f => dt.items.add(f));
  input.value = '';
  input.files = dt.files;

  // Fire change event
  input.dispatchEvent(new Event('change', { bubbles: true }));

  // Show warning if some were rejected
  if (rejected.length) {
    Swal.fire({
      icon: 'warning',
      title: 'Some files were skipped',
      html: rejected.join('<br>'),
      confirmButtonColor: '#f0ad4e'
    });
  }
});


  }

  // 1) Wire all existing
  document.querySelectorAll('.dz-wrap').forEach(wireDropZone);

  // 2) Wire dynamically added ones
  const observer = new MutationObserver(muts => {
    muts.forEach(m => {
      m.addedNodes.forEach(node => {
        if (node.nodeType !== 1) return;
        if (node.matches('.dz-wrap')) wireDropZone(node);
        node.querySelectorAll?.('.dz-wrap').forEach(wireDropZone);
      });
    });
  });
  observer.observe(document.body, { childList: true, subtree: true });

});
</script>

<script>
// ========================
// GLOBAL STATE
// ========================
let currentFieldId = '';
let filesStore = {};
let filesDeleted = {};
let lastBatchIndices = null;
// ========================
// UTIL: file type helpers
// ========================
function fileTypeIcon(name){
  const ext = (name.split('.').pop() || '').toLowerCase();
  if (['pdf'].includes(ext)) return '<i class="far fa-file-pdf"></i>';
  if (['doc','docx'].includes(ext)) return '<i class="far fa-file-word"></i>';
  return '<i class="far fa-file"></i>';
}
function isImageName(name){
  const ext = (name.split('.').pop() || '').toLowerCase();
  return ['png','jpg','jpeg','webp','gif'].includes(ext);
}
function previewURL(fileObj){
  if (fileObj.existing) return fileObj.url || '';
  if (fileObj.file && isImageName(fileObj.name)) {
    try { return URL.createObjectURL(fileObj.file); } catch(e){ return ''; }
  }
  return '';
}

// ========================
// PREVIEW RENDERER
// ========================
function ensurePreviewsContainer(fieldId){
  let $wrap = $('#file-previews-'+fieldId);
  if (!$wrap.length) {
    // Insert right after the file input for this field
    const $input = $(`.dynamic-file-input[data-field-id="${fieldId}"]`);
    if ($input.length){
      $wrap = $(`<div id="file-previews-${fieldId}" class="file-previews-grid" data-field-id="${fieldId}"></div>`);
      $input.closest('label.dz-wrap').after($wrap);
    }
  }
  return $wrap;
}
function renderPreviews(fieldId){
  const list = filesStore[fieldId] || [];
  const $wrap = ensurePreviewsContainer(fieldId);
  if (!$wrap || !$wrap.length) return;

  $wrap.empty();

  list.forEach((f, idx) => {
    const isImg = isImageName(f.name);
    const thumb = isImg
      ? `<img class="file-thumb" src="${previewURL(f)}" alt="">`
      : `<div class="file-type-icon">${fileTypeIcon(f.name)}</div>`;
    const titleSafe = $('<div>').text(f.title || '').html();

    $wrap.append(`
      <div class="file-card" data-field-id="${fieldId}" data-index="${idx}" title="${f.name}">
        ${thumb}
        <div class="file-actions flex-column">
          <!--<span class="text-truncates" style="max-width:100%;display:inline-block" title="${f.name}">
            ${titleSafe || f.name}
          </span>-->
          <span class="d-flex justify-content-between w-100">
            <span class="btn-icon me-3 preview-edit" title="Edit title"><i class="fa fa-pen"></i></span>
            <span class="btn-icon preview-remove" title="Remove"><i class="fa fa-trash"></i></span>
          </span>
        </div>
      </div>
    `);
  });
}

// ========================
// YOUR EXISTING MODAL FLOW
// (kept intact, only minor tweaks to call renderPreviews)
// ========================
$(document).on('click', '.edit-titles-btn', function () {
  currentFieldId = $(this).data('field-id');
  $('#triggerModalFileInput').attr('data-field-id', currentFieldId);
  showTitlesModal(currentFieldId);
});
function showTitlesModal(fieldId, onlyIndex = null, onlyIndices = null) {
  $('#logBook-edit').empty();
  $('#titlesModal').modal('hide'); // ensure clean re-open
  const list = filesStore[fieldId] || [];

  // Decide which items to render
  let indices;
  if (Array.isArray(onlyIndices) && onlyIndices.length) {
    indices = onlyIndices.slice();
  } else if (onlyIndex !== null) {
    indices = [onlyIndex];
  } else {
    indices = list.map((_, i) => i); // fallback: all
  }

  indices.forEach(i => {
    const fileObj = list[i];
    if (!fileObj) return;
    const viewBtn = fileObj.existing && fileObj.url
      ? `<a href="${fileObj.url}" target="_blank" class="ms-2">View</a>` : '';
    $('#logBook-edit').append(`
      <div class="modal-file-row mb-3" data-index="${i}">
        <label><strong>${fileObj.name}</strong>${viewBtn}</label>
        <div class="input-group gap-3 align-items-center">
          <input type="text" class="form-control file-title mb-0"
                 data-index="${i}"
                 value="${$('<div>').text(fileObj.title || '').html()}"
                 placeholder="Enter title">
        </div>
      </div>
    `);
  });

  // store for potential reuse (optional)
  lastBatchIndices = indices;

  $('#titlesModal').modal('show');
}

/*
function updateTitleStoreFromModal() {
  const fieldId = currentFieldId;
  // NOTE: your titles live inside #logBook-edit (not #modalBody)
  const titleInputs = $('#logBook-edit .file-title');
  const list = filesStore[fieldId] || [];

  titleInputs.each(function () {
    const idx = $(this).data('index');
    if (list[idx]) list[idx].title = $(this).val();
  });
} */
function updateTitleStoreFromModal() {
  const fieldId = currentFieldId;
  const list = filesStore[fieldId] || [];
  $('#logBook-edit .file-title').each(function () {
    const idx = $(this).data('index');
    if (list[idx]) list[idx].title = $(this).val();
  });
}

const allowedExtensions = ['pdf','doc','docx','png','jpeg','jpg'];

function isAllowedFile(file) {
  const ext = (file.name.split('.').pop() || '').toLowerCase();
  return allowedExtensions.includes(ext);
}

// Handle direct file input (under the dz-wrap)
$(document).on('change', '.dynamic-file-input', function () {
  const fieldId = $(this).data('field-id');
  const files = Array.from(this.files);
  filesStore[fieldId] = filesStore[fieldId] || [];

  const beforeLen = filesStore[fieldId].length;
  let addedCount = 0;

  files.forEach(file => {
    if (!isAllowedFile(file)) {
      $.alert(`"${file.name}" is not an allowed file type.`); // or your own alert
      return; // skip
    }
    if (!filesStore[fieldId].some(f => f.name === file.name && !f.existing)) {
      const tempInput = $('<input type="file" name="dynamic_fields[' + fieldId + '][]" style="display:none;">');
      const dt = new DataTransfer();
      dt.items.add(file);
      tempInput[0].files = dt.files;
      $('form').append(tempInput);

      filesStore[fieldId].push({
        name: file.name,
        file: file,
        title: '',
        existing: false,
        tempInput: tempInput[0]
      });
      addedCount++;
    }
  });

  const newIndices = Array.from({length: addedCount}, (_, k) => beforeLen + k);
  if (newIndices.length) {
    currentFieldId = fieldId;
    showTitlesModal(fieldId, null, newIndices);
  } else {
    renderPreviews(fieldId);
  }
});
$(document).on('click', '.remove-file-btn', function () {
  const index = $(this).closest('.modal-file-row').data('index');
  const fileList = filesStore[currentFieldId] || [];
  const removed = fileList.splice(index, 1)[0];
  if (removed && removed.tempInput) $(removed.tempInput).remove();
  showTitlesModal(currentFieldId);
  renderPreviews(currentFieldId);    // ⬅️ sync grid
});


// Add files via "Add more" trigger inside modal (kept)
$(document).on('click', '#triggerModalFileInput', function (e) {
  e.preventDefault();
  updateTitleStoreFromModal();

  const fieldId = $(this).attr('data-field-id');
  const tempInput = $('<input type="file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" multiple style="display:none;">');
  $('body').append(tempInput);
  tempInput.trigger('click');

  tempInput.on('change', function () {
    const selectedFiles = Array.from(this.files);
    filesStore[fieldId] = filesStore[fieldId] || [];

    selectedFiles.forEach(file => {
      if (!filesStore[fieldId].some(f => f.name === file.name && !f.existing)) {
        const singleInput = $('<input type="file" name="dynamic_fields[' + fieldId + '][]" style="display:none;">');
        const dt = new DataTransfer();
        dt.items.add(file);
        singleInput[0].files = dt.files;
        $('form').append(singleInput);

        filesStore[fieldId].push({
          name: file.name,
          title: '',
          file: file,
          existing: false,
          tempInput: singleInput[0]
        });
      }
    });

    showTitlesModal(fieldId);
    renderPreviews(fieldId);         // ⬅️ live update
  });
});

// Initial load: read existing hidden inputs and render tiles
$(document).ready(function () {
  $('.dynamic-file-input').each(function () {
    const fieldId = $(this).data('field-id');
    const existingFileInputs = $(`input[name="dynamic_fields_old[${fieldId}][]"]`);
    const existingTitleInputs = $(`input[name="dynamic_fields_titles_old[${fieldId}][]"]`);

    if (existingFileInputs.length > 0) {
      filesStore[fieldId] = filesStore[fieldId] || [];

      existingFileInputs.each(function (i) {
        const filename = $(this).val();
        const title = existingTitleInputs.eq(i).val();
        const url = $(this).attr('data-url');

        filesStore[fieldId].push({
          name: filename,
          title: title,
          file: null,
          url: url,
          existing: true
        });
      });
    }
    renderPreviews(fieldId);         // ⬅️ draw grid on load
  });
});

// ========================
// TILE ACTIONS
// ========================
/*$(document).on('click', '.preview-edit', function(){
  const $card = $(this).closest('.file-card');
  const fieldId = $card.data('field-id');
  currentFieldId = fieldId;

  $('#triggerModalFileInput').attr('data-field-id', fieldId);   // <— add this line

  showTitlesModal(fieldId);
}); */
$(document).on('click', '.preview-edit', function(){
  const $card = $(this).closest('.file-card');
  const fieldId = $card.data('field-id');
  const index   = $card.data('index');
  currentFieldId = fieldId;
  showTitlesModal(fieldId, index, null); // single file
});// trash click on a tile
$(document).on('click', '.preview-remove', function(){
  const $card   = $(this).closest('.file-card');
  const fieldId = $card.data('field-id');
  const index   = $card.data('index');

  $.confirm({
    title: "Confirm Deletion",
    content: "Are you sure you want to delete this file?",
    type: 'red', // optional styling
    buttons: {
      confirm: {
        text: 'Yes, delete',
        btnClass: 'btn-red',
        action: function(){
          const arr     = filesStore[fieldId] || [];
          const removed = arr.splice(index, 1)[0];

          if (removed?.tempInput) {
            $(removed.tempInput).remove(); // new file → remove its temp input
          }

          if (removed?.existing) {
            filesDeleted[fieldId] = filesDeleted[fieldId] || [];
            filesDeleted[fieldId].push(removed);

            const form = $(`.dynamic-file-input[data-field-id="${fieldId}"]`).closest('form');
            form.append(`<input type="hidden" name="dynamic_fields_old_deleted[${fieldId}][]" value="${removed.name}">`);
          }

          renderPreviews(fieldId);
        }
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-default'
      }
    }
  });
});


// when saving titles (your existing handler)
// IMPORTANT: exclude deleted old files when rebuilding hidden inputs
$('#titlesForm').on('submit', function(e){
  e.preventDefault();
  updateTitleStoreFromModal();

  const fieldId = currentFieldId;
  const updatedList = filesStore[fieldId] || [];
  const deletedList = filesDeleted[fieldId] || [];

  $(`input[name="dynamic_fields_titles[${fieldId}][]"]`).remove();
  $(`input[name="dynamic_fields_old[${fieldId}][]"]`).remove();
  $(`input[name="dynamic_fields_titles_old[${fieldId}][]"]`).remove();

  const form = $(`.dynamic-file-input[data-field-id="${fieldId}"]`).closest('form');

  updatedList.forEach(f => {
    if (f.existing) {
      if (deletedList.some(d => d.name === f.name)) return; // skip deleted
      form.append(`<input type="hidden" name="dynamic_fields_old[${fieldId}][]" value="${f.name}" data-url="${f.url||''}">`);
      form.append(`<input type="hidden" name="dynamic_fields_titles_old[${fieldId}][]" value="${$('<div>').text(f.title||'').html()}">`);
    } else {
      form.append(`<input type="hidden" name="dynamic_fields_titles[${fieldId}][]" value="${$('<div>').text(f.title||'').html()}" data-filename="${f.name}">`);
    }
  });

  $('#titlesModal').modal('hide');
  renderPreviews(fieldId);
});
</script>

<style>
.file-previews-grid{ display:grid;grid-template-columns:repeat(auto-fill,minmax(75px,1fr));gap:10px;margin-top:.25rem }
.file-card{border-radius:10px;overflow:hidden; margin-bottom:10px;}
.file-thumb{width:100%;height:70px;object-fit:cover;display:block;background:#f3f4f6}
.file-actions{display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#f59e0b;color:#fff}
.file-actions .btn-icon{cursor:pointer;display:inline-flex;align-items:center;gap:6px}
.file-actions i{font-size:12px}
.file-type-icon{width:100%;height:70px;display:flex;align-items:center;justify-content:center;font-size:30px;color:var(--white);background:var(--b-blue);}
@media (max-width:767px) {
.file-previews-grid {grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));}
.dz-wrap { padding: 1rem; }
}

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
</style>
<script>
/* ========= Shared progress helpers ========= */
function updateProgress(percent, label, err = 1) {
  $("#upload-progress-bar").css("width", percent + "%");
  if (err == 1) {
    $(".progress-label").html('<div class="text-success">' + label + "</div>");
  } else {
    $(".progress-label").html('<div class="text-danger">' + label + "</div>");
  }
}

/* Progress slice for precheck (0–15%) */
const PRECHECK_WEIGHT = 0.15; // 15%

/* Map a sub-phase 0..1 into a slice of the main bar */
function updateWeightedPhase(startPct, spanPct, loaded, total) {
  if (!total) return;
  let pct = startPct + Math.floor((loaded / total) * spanPct);
  if (pct < lastPct) pct = lastPct;
  lastPct = pct;
  updateProgress(pct, "Uploading...");
}

/* Map overall bytes into a slice (e.g., 15%..100%) */
function updateOverallProgressFromBase(tempLoaded, basePct, spanPct) {
  if (!totalBytes) return;
  let pct = basePct + Math.floor((tempLoaded / totalBytes) * spanPct);
  if (pct < lastPct) pct = lastPct;
  lastPct = pct;
  updateProgress(pct, "Uploading...");
}

/* ========= Abort / cancel tracking ========= */
let activeUploads = [];
let cancelUpload = false;
function abortAllUploads() {
  cancelUpload = true;
  activeUploads.forEach(req => { try { req.abort(); } catch (e) {} });
  activeUploads = [];
}

/* ========= Smooth overall progress state ========= */
let totalBytes = 0;
let uploadedBytes = 0;
let lastPct = 0;

function resetProgressUI(msg = "Uploading...") {
  totalBytes = 0;
  uploadedBytes = 0;
  lastPct = 0;
  updateProgress(0, msg);
  $(".progress-bar-wrapper").show();
}

/* Legacy (kept for non-weighted paths) */
function updateOverallProgress(tempLoaded) {
  if (!totalBytes) return;
  let pct = Math.floor((tempLoaded / totalBytes) * 100);
  if (pct < lastPct) pct = lastPct;
  lastPct = pct;
  updateProgress(pct, "Uploading...");
}

function hardResetProgress(hide = true) {
  const $bar = $("#upload-progress-bar");
  $bar.addClass("no-trans").css("width", "0%");
  $bar[0]?.offsetHeight;
  $bar.removeClass("no-trans");
  $(".progress-label").empty();
  if (hide) $(".progress-bar-wrapper").hide();
  totalBytes = 0;
  uploadedBytes = 0;
  lastPct = 0;
}

/* ========= Edit modal progress UI ========= */
function ensureEditProgressUI() {
  if (!document.getElementById("edit-upload-progress")) {
    const html = `
      <div id="edit-upload-progress" class="upload-loading" style="display:none; margin-top: 12px;">
        <div class="progress-label edit-progress-label">Uploading...</div>
        <div class="progress-bar-wrapper">
          <div class="progress-bar" id="edit-upload-progress-bar" style="width:0%"></div>
        </div>
      </div>`;
    $("#edit-file-modal .modal-body").append(html);
  }
}
function updateEditProgress(percent, label, ok = true) {
  $("#edit-upload-progress-bar").css("width", percent + "%");
  $(".edit-progress-label").html(`<div class="${ok ? "text-success" : "text-danger"}">${label}</div>`);
  $("#edit-upload-progress").show();
}
function hardResetEditProgress(hide = true) {
  ensureEditProgressUI();
  const $bar = $("#edit-upload-progress-bar");
  $bar.addClass("no-trans").css("width", "0%");
  $bar[0]?.offsetHeight;
  $bar.removeClass("no-trans");
  $(".edit-progress-label").empty();
  if (hide) $("#edit-upload-progress").hide();
}

/* ========= Chunked upload helpers ========= */
const CHUNK_SIZE = 5 * 1024 * 1024; // 5MB
const LARGE_VIDEO_THRESHOLD = 8 * 1024 * 1024; // chunk videos > 8MB
function isLargeVideo(file){
  return file && file.type && file.type.startsWith('video/') && file.size > LARGE_VIDEO_THRESHOLD;
}
function uploadFileInChunks(file, tag, onProgress){
  return new Promise(async (resolve, reject) => {
    try{
      const total = Math.ceil(file.size / CHUNK_SIZE);
      const uploadId = Date.now() + '-' + Math.random().toString(16).slice(2);
      let sent = 0;
      for (let i = 0; i < total; i++){
        const start = i * CHUNK_SIZE;
        const end   = Math.min(file.size, start + CHUNK_SIZE);
        const blob  = file.slice(start, end);
        const fd = new FormData();
        fd.append('upload', blob, file.name);
        fd.append('filename', file.name);
        fd.append('uploadId', uploadId);
        fd.append('chunkIndex', i);
        fd.append('chunkTotal', total);
        fd.append('tag', tag || '');
        await $.ajax({
          url: "<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/"+"<?php echo $_GET['user_id']; ?>",
          type: "POST",
          data: fd,
          processData: false,
          contentType: false,
          cache: false,
          enctype: "multipart/form-data",
          dataType: "json",
          xhr: function(){
            const x = new window.XMLHttpRequest();
            x.upload.addEventListener('progress', (e)=>{
              if (e.lengthComputable){
                const overall = sent + e.loaded;
                onProgress && onProgress(Math.min(overall, file.size));
              }
            });
            return x;
          },
          success: function(resp){
            if (i + 1 === total){
              if (resp && resp.uploaded == 1) {
                sent = file.size;
                onProgress && onProgress(sent);
                resolve(resp);
              } else {
                reject(resp || { uploaded:0, error:'Chunked upload failed' });
              }
            } else {
              sent = end;
              onProgress && onProgress(sent);
            }
          },
          error: function(err){ reject(err); }
        });
      }
    }catch(err){ reject(err); }
  });
}

/* ========= FAST preview with blob URLs + pre-upload delete ========= */
let previewURLs = [];
function revokePreviewURLs(){
  previewURLs.forEach(u => { try { URL.revokeObjectURL(u); } catch(e){} });
  previewURLs = [];
}

/* NEW: queue + delete-before-upload */
let queuedFiles = []; // [{uid, file, url}]
function makeUID(){ return 'q_' + Date.now().toString(36) + Math.random().toString(36).slice(2); }
function deleteQueued(btn){
  const $card = $(btn).closest('.up-ca');
  const uid   = $card.data('uid');
  const url   = $card.data('url');
  queuedFiles = queuedFiles.filter(x => x.uid !== uid);
  if (url) { try { URL.revokeObjectURL(url); } catch(e){} }
  $card.remove();
  // if none left, close modal safely
  if ($('#upload-file-modal .up-ca:visible').length === 0) {
    $("#userphoto").val(null);
    $("#upload-file-modal").modal('hide');
  }
}

/* include a trash icon in the skeleton */
function previewSkeleton(){
  return `
    <div class="up-ca" style="padding:2px !important;">
      <div class="skeleton-box" style="height:200px;border:1px solid #eee;border-radius:25px;display:flex;align-items:center;justify-content:center;background:#f7f7f7;">
        <div class="spinner-border" role="status" style="width:1.4rem;height:1.4rem;"><span class="visually-hidden">Loading...</span></div>
      </div>
      <div class="trash" onclick="deleteQueued(this)" style="cursor:pointer"><i class="fa fa-trash-o"></i></div>
      <label>Tags (Optional)</label>
      <textarea name="image_tag[]" placeholder="Ex: Control Panel, Left Wing, Tail, etc."></textarea>
    </div>`;
}

/* ========= Init ========= */
$(document).ready(function () {
  try { GLightbox({ selector: ".glightbox-video", touchNavigation: true, autoplayVideos: true }); } catch (e) {}
  $("#image_tag").on("itemAdded", function () {/* no-op */});
});

/* ========= Small helpers ========= */
function deletephotosdiv(_this){
  $(_this).closest(".up-ca").hide();
  if ($("#upload-file-modal .up-ca:visible").length === 0) {
    $("#userphoto").val(null);
    $("#upload-file-modal").modal("hide");
  }
}
function deletephotos(photo_id){
  $.confirm({
    title: "Confirm Deletion",
    content: "Are you sure you want to delete this photo?",
    buttons: {
      confirm: function(){
        $.ajax({
          url: "<?php echo base_url(); ?>/providerauth/photos_delete",
          type: "POST",
          dataType: "html",
          data: { photo_id, product_id: "<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>",user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>', },
          success: function (response) {
            const trimmed = (response || "").toString().trim();
            if (/^\d+$/.test(trimmed)) { $("#imageNo" + photo_id).remove(); refreshAfterImageChange(); return; }
            if (trimmed !== "") { $(".load-images").html(trimmed); refreshAfterImageChange(); }
          }
        });
      },
      cancel: function(){}
    }
  });
}
function refreshAfterImageChange(){
  $("#imageListId").sortable({ update: function(){ getIdsOfImages(); } });
  const ids = [];
  $("#imageListId .listitemClass").each(function(){ ids.push($(this).attr("id").replace("imageNo","")); });
  $('input[name="image_ids"]').val(ids.join(","));
  if ($("#imageListId .listitemClass").length === 0) $(".load-images").html("please upload.");
  try { GLightbox({ selector: ".glightbox-video", touchNavigation: true, autoplayVideos: true }); } catch(e){}
}

/* ========= Edit flow ========= */
function editphotos(photo_id,_this){
  $(".final-result-container").hide();
  $("#userphoto_edit").val(null);
  $("#image_tag").val($(_this).attr("data-tags"));
  $(".photouploadupdate").attr("data-id", photo_id);
  if ($(_this).attr("data-file-type") === "image") {
    $(".editablemedia").html(
      `<img width="100%" class="load-edit-image" style="object-fit:cover;border-radius:25px;border:1px solid #eee;height:200px;"
            data-id="${photo_id}" src="${$(_this).closest("li").find("img").attr("src")}" />`
    );
  } else {
    $(".editablemedia").html(`
      <div class="video-wrappers w-100" style="position:relative;display:inline-block;border-radius:25px;border:1px solid #eee;">
        <video data-id="${photo_id}" style="object-fit:cover;width:100%;border-radius:25px;border:1px solid #eee;height:200px;" muted
               src="${$(_this).closest('li').find('source').attr('src')}"></video>
      </div>`);
  }
  $(".csimage").removeClass("cropped_image_save").addClass("cropped_image_save_edit");
  $("#edit-file-modal").modal("show");
  $("#userphoto_edit").prop("disabled", false).prop("readonly", false);
  ensureEditProgressUI();
  hardResetEditProgress();
}
function cancel_edit(){
  $("#image_tag").val("");
  $(".photouploadupdate").attr("data-id", "");
  $(".load-edit-image").attr("src", "");
  $(".csimage").addClass("cropped_image_save").removeClass("cropped_image_save_edit");
  $("#userphoto_edit").val(null);
  $("#edit-file-modal").modal("hide");
  hardResetEditProgress();
}
function editphotospost(btn){
  const p_id = $(btn).attr("data-id");
  ensureEditProgressUI();
  hardResetEditProgress(false);
  if ($("#userphoto_edit").get(0).files.length === 0) {
    updateEditProgress(25, "Uploading...");
    const req = $.ajax({
      url: "<?php echo base_url(); ?>/providerauth/photosedit_post",
      type: "POST",
      dataType: "HTML",
      data: {
        p_id,
        image_tag: $("#image_tag").val(),
        product_id: "<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>",
        plan_id: $('input[name="plan_id"]').val(),
		user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>',
      },
      success: function(html){
        if (cancelUpload) return;
        if (html) $(".load-images").html(html);
        $("#imageListId").sortable({ update: function(){ getIdsOfImages(); } });
        updateEditProgress(100, "Uploading...");
        setTimeout(()=>{
          $("#edit-file-modal").modal("hide");
          hardResetEditProgress();
          $("#image_tag").val("");
          Swal.fire("Updated Successfully!", "", "success");
        }, 400);
      }
    });
    activeUploads.push(req); req.always(()=>{ activeUploads = activeUploads.filter(r=>r!==req); });
    return;
  }
  const replaceFile = $("#userphoto_edit")[0].files[0];
  const tag = $("#image_tag").val();
  const doSingleShotEdit = !isLargeVideo(replaceFile);
  updateEditProgress(10, "Uploading...");
  const sendEdit = doSingleShotEdit
    ? () => $.ajax({
        url: "<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/"+"<?php echo $_GET['user_id']; ?>",
        type: "POST",
        dataType: "JSON",
        data: (()=>{
          const fd = new FormData();
          fd.append("upload", replaceFile);
          fd.append("tag", tag);
          return fd;
        })(),
        processData: false,
        contentType: false,
        cache: false,
        enctype: "multipart/form-data",
        xhr: function(){
          const x = new window.XMLHttpRequest();
          x.upload.addEventListener("progress", (e)=>{ /* optional live edit progress */ });
          return x;
        }
      })
    : () => uploadFileInChunks(
        replaceFile,
        tag,
        (bytesSoFar)=>{
          const pct = Math.round((bytesSoFar / replaceFile.size) * 100);
          updateEditProgress(pct, "Uploading...");
        }
      );
  sendEdit().then(function(resp){
    if (cancelUpload) return;
    if (resp.uploaded == 1) {
      updateEditProgress(90, "Uploading...");
      const req2 = $.ajax({
        url: "<?php echo base_url(); ?>/providerauth/photosedit_post",
        type: "POST",
        dataType: "HTML",
        data: {
          p_id,
          image: resp.fileName,
          file_type: resp.fileType,
          image_tag: tag,
          product_id: "<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>",
          plan_id: $('input[name="plan_id"]').val(),
		  user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>',
        },
        success: function(html){
          if (cancelUpload) return;
          if (html) $(".load-images").html(html);
          $("#imageListId").sortable({ update: function(){ getIdsOfImages(); } });
          $(".final-result-container").hide();
          updateEditProgress(100, "Uploading...");
          setTimeout(()=>{
            $("#edit-file-modal").modal("hide");
            hardResetEditProgress();
            $("#userphoto_edit").val(null);
            $("#image_tag").val("");
            Swal.fire("Updated Successfully!", "", "success");
          }, 400);
        }
      });
      activeUploads.push(req2); req2.always(()=>{ activeUploads = activeUploads.filter(r=>r!==req2); });
    } else {
      updateEditProgress(100, resp.error || "Upload failed", false);
      setTimeout(()=> hardResetEditProgress(), 1200);
      Swal.fire(resp.error || "Upload failed", "", "error");
    }
  }).catch(function(){
    updateEditProgress(100, "Upload failed", false);
    setTimeout(()=> hardResetEditProgress(), 1200);
  });
}

/* ========= Sort / order ========= */
$(function () {
  $("#imageListId").sortable({ update: function(){ getIdsOfImages(); } });
});
function getIdsOfImages() {
  var values = [];
  $(".listitemClass").each(function(){ values.push($(this).attr("id").replace("imageNo","")); });
  $("#outputvalues").val(values);
  const req = $.ajax({
    url: "<?php echo base_url(); ?>/providerauth/photos_post",
    type: "POST",
    dataType: "HTML",
    data: {
      check: "3",
      ids: values,
      product_id: "<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>",
      plan_id: $('input[name="plan_id"]').val(),
	  user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>',
    }
  });
  activeUploads.push(req); req.always(()=>{ activeUploads = activeUploads.filter(r=>r!==req); });
}

/* ========= Croppie / previews / modal behaviors ========= */
function load_croppie(_this) {
  $("#upload-image").attr("data-id", $(_this).find("img").attr("data-id"));
  $("#upload-image").croppie("bind", { url: $(_this).find("img").attr("src") });
  $("#crop-image").modal("show");
}

$(document).ready(function () {
  var myCroppie = $("#upload-image").croppie({
    enableExif: true,
    viewport: { width: 200, height: 150, type: "rectangle", enableResize: true, enableOrientation: true },
    boundary: { width: 400, height: 300 },
  });
  $("#crop-image").on("shown.bs.modal", function () {
    myCroppie.croppie("bind", { url: $(".test" + $("#upload-image").attr("data-id")).find("img").attr("src") });
  }).on("hide.bs.modal", function () {
    myCroppie.croppie("bind", { url: "" });
  });

  // Input resets so re-selecting same file fires change
  var fileList = [];
  var fileListedit = [];

  $(".cropimage").on("click", function(){
    this.value = null;
    fileList = [];
    $(".load-images-final").empty();
    $(".final-result-container").hide();
  });
  $(".cropimageedit").on("click", function(){ fileListedit = []; });

  /* ===== FAST preview using blob URLs (no FileReader) + queue ===== */
  $(".cropimage").on("change", function (event) {
    $(".load-images-final").empty();
    const files = event.target.files;
    if (!files || !files.length) return;

    $("#upload-file-modal").find(".header-message").html("<h5 class='mb-0 fw-bolder'>Add Tags and Upload</h5>");
    $("#upload-file-modal").find(".modal-footer .photoupload").show();
    $("#upload-file-modal").find(".modal-footer .photouploaddone").hide();
    $(".upload-loading").hide();
    $(".final-result-container").show();
    $("#upload-file-modal").modal("show");

    fileList = [];          // keep if you still need it elsewhere
    queuedFiles = [];       // <- new queue for upload order
    revokePreviewURLs();    // clear old object URLs

    let i = 0;
    const formatDur = s => { s=Math.floor(s||0); const m=Math.floor(s/60), r=s%60; return `${m}:${r.toString().padStart(2,"0")}`; };

    for (let singleFile of files) {
      fileList.push(singleFile); // legacy
      const uid = makeUID();
      const url = URL.createObjectURL(singleFile);
      previewURLs.push(url);

      // skeleton card
      const $wrap = $(previewSkeleton()).appendTo(".load-images-final");
      $wrap.attr('data-uid', uid).attr('data-url', url);

      const $box = $wrap.find(".skeleton-box");
      if (singleFile.type.startsWith("image/")) {
        const img = new Image();
        img.onload = () => { $box.replaceWith(img); };
        img.style.cssText = "width:100%;height:200px;object-fit:cover;border:1px solid #eee;border-radius:25px;";
        img.src = url;
      } else if (singleFile.type.startsWith("video/")) {
        const v = document.createElement("video");
        v.preload = "metadata";
        v.muted = true;
        v.style.cssText = "width:100%;height:200px;object-fit:cover;border:1px solid #eee;border-radius:25px;";
        v.src = url;
        v.addEventListener("loadedmetadata", () => {
          const dur = formatDur(v.duration);
          const pill = document.createElement("span");
          pill.textContent = dur;
          pill.style.cssText = "position:absolute;bottom:8px;right:8px;background:rgba(0,0,0,0.6);color:#fff;font-size:12px;padding:2px 6px;border-radius:4px;";
          const holder = document.createElement("div");
          holder.style.cssText = "position:relative;border:1px solid #eee;border-radius:25px;overflow:hidden;";
          holder.appendChild(v);
          holder.appendChild(pill);
          $box.replaceWith(holder);
        }, { once: true });
        v.addEventListener("error", () => { $box.html('<div class="text-muted small">Preview unavailable</div>'); }, { once: true });
      } else {
        $box.html(`<div class="p-3 text-muted small">Selected: ${singleFile.name}</div>`);
      }

      // queue entry
      queuedFiles.push({ uid, file: singleFile, url });
      i++;
    }
  });

  // Edit input preview (also blob URL)
  $(".cropimageedit").on("change", function (event) {
    revokePreviewURLs();
    const files = event.target.files;
    if (files && files.length) {
      let i = 0;
      for (let singleFile of files) {
        const url = URL.createObjectURL(singleFile);
        previewURLs.push(url);
        if (singleFile.type.startsWith("image/")) {
          $(".editablemedia").html(
            `<img width="100%" class="load-edit-image" style="object-fit:cover;border-radius:25px;border:1px solid #eee;height:200px;" data-id="${i}" src="${url}" />`
          );
          i++;
        } else if (singleFile.type.startsWith("video/")) {
          $(".editablemedia").html(
            `<div class="video-wrappers w-100" style="position:relative;display:inline-block;border-radius:25px;border:1px solid #eee;">
               <video data-id="${i}" style="object-fit:cover;width:100%;border-radius:25px;border:1px solid #eee;height:200px;" muted preload="metadata" src="${url}"></video>
             </div>`
          );
          i++;
        }
      }
    }
  });

  $(document).on("mouseenter", ".load-images-final video, .editablemedia video", function(){ this.play(); });
  $(document).on("mouseleave", ".load-images-final video, .editablemedia video", function(){ this.pause(); this.currentTime = 0; });

  $(".cropped_image").on("click", function(){
    myCroppie.croppie("result", { type: "blob", size: "original", quality: 1 }).then(function (blob) {
      fileList[$("#upload-image").attr("data-id")] = blob;
      const img = new Image();
      img.src = URL.createObjectURL(blob);
      img.style.cssText = "width:150px;height:113px;border:1px solid #eee;border-radius:25px;object-fit:cover;";
      $(".fid-" + $("#upload-image").attr("data-id")).html(img);
    });
  });

  $(".cropped_image_save, .cropped_image").on("click", function(){ $("#crop-image").modal("hide"); });
  $(".open-image-modal").on("click", function(){ $("#crop-image").modal("show"); });

  $(".photouploaddone").on("click", function(){
    $("#userphoto").val(null);
    $("#upload-file-modal").modal("hide");
  });

  let shouldForceClose = false;
  $("#upload-file-modal").on("hide.bs.modal", function (e) {
    if (
      !$("#upload-file-modal").find(".modal-footer .photoupload").is(":visible") ||
      shouldForceClose ||
      $("#upload-file-modal .up-ca:visible").length === 0
    ) { shouldForceClose = false; return; }
    e.preventDefault();
    $("#confirmCloseModal").modal("show");
  });
  $("#continueUpload").on("click", function(){ $("#confirmCloseModal").modal("hide"); });
  $("#discardUpload").on("click", function () {
    $("#confirmCloseModal").modal("hide");
    shouldForceClose = true;
    abortAllUploads();
    resetUploadState();
    hardResetProgress();
    revokePreviewURLs();
    queuedFiles = [];
    $("#upload-file-modal").modal("hide");
  });
  $("#upload-file-modal").on("hidden.bs.modal", function () {
    revokePreviewURLs();
    if (shouldForceClose) {
      abortAllUploads();
      resetUploadState();
      queuedFiles = [];
      shouldForceClose = false;
    }
  });

  function resetUploadState() {
    if (typeof fileList !== "undefined") fileList.length = 0;
    if (typeof fileListedit !== "undefined") fileListedit.length = 0;
    queuedFiles = [];
    $("#userphoto").val(null);
    $("#userphoto_edit").val(null);
    $(".load-images-final").empty();
    $(".editablemedia").empty();
    $(".final-result-container").hide();
    try { updateProgress(0, "", 1); } catch(e){}
    $(".upload-loading").hide();
    $(".progress-bar-wrapper").hide();
    $("#upload-file-modal").find(".modal-footer .photoupload").show();
    $("#upload-file-modal").find(".modal-footer .photouploaddone").hide();
    $("#upload-file-modal").find(".trash").show();
    $("#upload-file-modal").find(".header-message").html('<h5 class="mb-0 fw-bolder">Add Tags and Upload</h5>');
  }
  $("#upload-file-modal").on("show.bs.modal", function(){ hardResetProgress(); });

  /* ===== MAIN UPLOAD CLICK (with precheck progress + chunking + queue) ===== */
  $(".photoupload").on("click", function () {
    hardResetProgress(false);
    $(".upload-loading").show();
    cancelUpload = false;
    activeUploads = activeUploads || [];
    resetProgressUI();

    const $cards = $('#upload-file-modal .up-ca');
    if ($cards.length === 0) {
      updateProgress(0, "Select Image/Video to Upload", 0);
      $(".progress-bar-wrapper").hide();
      return;
    }

    if ($(".csimage").hasClass("cropped_image_save")) {
      // precheck using queued metadata
      const filesMeta = queuedFiles.map(q => ({ type: q.file.type, size: q.file.size }));
      const preReq = $.ajax({
        url: "<?php echo base_url(); ?>/providerauth/photos_post",
        type: "POST",
        dataType: "JSON",
        data: {
          check: 1,
          product_id: "<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>",
          plan_id: $('input[name="plan_id"]').val(),
		  user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>',
          files: JSON.stringify(filesMeta)
        },
        xhr: function(){ return new window.XMLHttpRequest(); },
        beforeSend: function(){ $(".loader").show(); },
        success: function (response) {
          if (cancelUpload) return;
          if (response == "2" || response.status == "error") {
            updateProgress(0, response.message || "Validation failed", 0);
            $(".progress-bar-wrapper").hide();
            $("#crop-image").modal("hide");
            $("#userphoto").val("");
            return;
          }
          if (response == "8") {
            updateProgress(0, "Select Image/Video to Upload", 0);
            $(".progress-bar-wrapper").hide();
            return;
          }

          const preEnd = Math.floor(PRECHECK_WEIGHT * 100);
          if (lastPct < preEnd) updateProgress(preEnd, "Uploading...");

          // totals from queue
          totalBytes = queuedFiles.reduce((s,q)=> s + (q.file?.size||0), 0);
          uploadedBytes = 0;

          let filesDone = 0;
          // iterate current DOM order so tags match cards
          $cards.each(function(idx, el){
            const $card = $(el);
            const uid   = $card.data('uid');
            const entry = queuedFiles.find(q => q.uid === uid);
            if (!entry) { filesDone++; return; }
            const file  = entry.file;
            const tag   = $card.find('textarea').val();
            const sizeForThisReq = file?.size || 0;
            const doSingleShot = !isLargeVideo(file);

            const sendOne = doSingleShot
              ? () => $.ajax({
                  url: "<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/"+"<?php echo $_GET['user_id']; ?>",
                  type: "POST",
                  dataType: "JSON",
                  data: (()=>{
                    const fd = new FormData();
                    fd.append("upload", file);
                    fd.append("tag", tag);
                    return fd;
                  })(),
                  processData: false,
                  contentType: false,
                  cache: false,
                  enctype: "multipart/form-data",
                  xhr: function(){
                    const x = new window.XMLHttpRequest();
                    x.upload.addEventListener("progress", (e)=>{
                      if (e.lengthComputable && !cancelUpload) {
                        const tempLoaded = uploadedBytes + e.loaded;
                        updateOverallProgressFromBase(tempLoaded, PRECHECK_WEIGHT * 100, 100 - PRECHECK_WEIGHT * 100);
                      }
                    });
                    return x;
                  }
                })
              : () => uploadFileInChunks(
                  file,
                  tag,
                  (bytesSoFar)=>{
                    if (!cancelUpload){
                      const tempLoaded = uploadedBytes + bytesSoFar;
                      updateOverallProgressFromBase(tempLoaded, PRECHECK_WEIGHT * 100, 100 - PRECHECK_WEIGHT * 100);
                    }
                  }
                );

            sendOne().then(function(resp){
              if (cancelUpload) return;
              uploadedBytes += sizeForThisReq;
              updateOverallProgressFromBase(uploadedBytes, PRECHECK_WEIGHT * 100, 100 - PRECHECK_WEIGHT * 100);

              if (resp && resp.uploaded == 1) {
                const saveReq = $.ajax({
                  url: "<?php echo base_url(); ?>/providerauth/photos_post",
                  type: "POST",
                  dataType: "HTML",
                  data: {
                    check: "2",
                    image: resp.fileName,
                    file_type: resp.fileType,
                    image_tag: resp.tag,
                    product_id: "<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>",
                    plan_id: $('input[name="plan_id"]').val(),
					user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>',
                  },
                  success: function(html){
                    if (cancelUpload) return;
                    if (html) {
                      $(".load-images").html(html);
                      const video = document.querySelector("video");
                      if (video) video.addEventListener("loadeddata", function(){ this.currentTime = 0.1; });
                      try { GLightbox({ selector: ".glightbox-video", touchNavigation: true, autoplayVideos: true }); } catch(e){}
                    }
                    $("#imageListId").sortable({ update: function(){ getIdsOfImages(); } });
                  }
                });
                activeUploads.push(saveReq); saveReq.always(()=>{ activeUploads = activeUploads.filter(r=>r!==saveReq); });
              }

              filesDone++;
              if (filesDone === $cards.length) {
                updateOverallProgressFromBase(totalBytes, PRECHECK_WEIGHT * 100, 100 - PRECHECK_WEIGHT * 100);
                setTimeout(()=>{
                  if (cancelUpload) return;
                  $(".upload-loading").fadeOut(()=>{
                    $("#upload-file-modal").find(".modal-footer .photoupload").hide();
                    $("#upload-file-modal").find(".modal-footer .photouploaddone").show();
                    $("#upload-file-modal").find(".trash").hide();
                    $("#upload-file-modal").find(".header-message").html(`
                      <div class="alert alert-success d-flex align-items-start p-3 shadow-sm" role="alert">
                        <i class="fa-solid fa-check me-2 mt-1 text-success"></i>
                        <div>Your photos and videos have been uploaded.</div>
                      </div>`);
                    $("#upload-file-modal").modal("hide");
                    hardResetProgress();
                    queuedFiles = [];
                  });
                }, 600);
              }
              $(".loader").hide();
            }).catch(function(){
              updateProgress(lastPct, "Upload failed", 0);
              filesDone++;
            });
          });

          $("#crop-image").modal("hide");
          $("#upload-file-modal .up-ca").find("input, textarea").prop("readonly", true).prop("disabled", true);
        }
      });
      activeUploads.push(preReq); preReq.always(()=>{ activeUploads = activeUploads.filter(r=>r!==preReq); });

    } else {
      // EDIT multi-file path (rare)
      totalBytes = queuedFiles.reduce((s,q)=> s + (q.file?.size||0), 0);
      uploadedBytes = 0;
      const $cards2 = $('#upload-file-modal .up-ca');
      let filesDone = 0;

      $cards2.each(function(idx, el){
        const $card = $(el);
        const uid   = $card.data('uid');
        const entry = queuedFiles.find(q => q.uid === uid);
        if (!entry) { filesDone++; return; }

        const file = entry.file;
        const sizeForThisReq = file?.size || 0;
        const imtg = $card.find('textarea').val();
        const doSingleShot = !isLargeVideo(file);

        const sendOneEdit = doSingleShot
          ? () => $.ajax({
              url: "<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/"+"<?php echo $_GET['user_id']; ?>",
              type: "POST",
              dataType: "JSON",
              data: (()=>{
                const fd = new FormData();
                fd.append("upload", file);
                fd.append("tag", imtg);
                return fd;
              })(),
              processData: false,
              contentType: false,
              cache: false,
              enctype: "multipart/form-data",
              xhr: function(){
                const x = new window.XMLHttpRequest();
                x.upload.addEventListener("progress", (e)=>{
                  if (e.lengthComputable && !cancelUpload) {
                    const tempLoaded = uploadedBytes + e.loaded;
                    updateOverallProgress(tempLoaded);
                  }
                });
                return x;
              }
            })
          : () => uploadFileInChunks(
              file,
              imtg,
              (bytesSoFar)=>{
                if (!cancelUpload){
                  const tempLoaded = uploadedBytes + bytesSoFar;
                  updateOverallProgress(tempLoaded);
                }
              }
            );

        sendOneEdit().then(function (response) {
          if (cancelUpload) return;
          uploadedBytes += sizeForThisReq;
          updateOverallProgress(uploadedBytes);

          if (response.uploaded == 1) {
            $("#userphoto").val(null);
            const postReq = $.ajax({
              url: "<?php echo base_url(); ?>/providerauth/photosedit_post",
              type: "POST",
              dataType: "HTML",
              data: {
                p_id: $(".photouploadupdate").attr("data-id"),
                image: response.fileName,
                image_tag: imtg,
                product_id: "<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>",
                plan_id: $('input[name="plan_id"]').val(),
				user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>',
              },
              success: function (html) {
                if (cancelUpload) return;
                if (html) $(".load-images").html(html);
                $("#imageListId").sortable({ update: function(){ getIdsOfImages(); } });
                $(".final-result-container").hide();
              }
            });
            activeUploads.push(postReq); postReq.always(()=>{ activeUploads = activeUploads.filter(r=>r!==postReq); });
          }

          filesDone++;
          if (filesDone === $cards2.length) {
            updateOverallProgress(totalBytes);
            $("#crop-image").modal("hide");
            $(".final-result-container").hide();
            setTimeout(()=>{ if (!cancelUpload) $(".upload-loading").fadeOut(); }, 600);
            queuedFiles = [];
          }
        }).catch(function(){
          filesDone++;
        });
      });
    }
  });
});

/* ===== end of $(document).ready upload handler block ===== */

/* ========= Subcategory fields toggle ========= */
$(function () {
  const $subSelect = $('select[name="sub_category_id"]');
  const $allCatBoxes = $(".catbasedfield");
  function toggleBoxes() {
    const id = $subSelect.val();
    if (id != "" && $allCatBoxes.filter('[data-subcategory="' + id + '"]').length > 0) $(".catbasedtitle").show(); else $(".catbasedtitle").hide();
    $allCatBoxes.hide();
    if (id) $allCatBoxes.filter('[data-subcategory="' + id + '"]').show();
  }
  toggleBoxes();
  $subSelect.on("change", toggleBoxes);
});
</script>

<?php echo $this->endSection() ?>