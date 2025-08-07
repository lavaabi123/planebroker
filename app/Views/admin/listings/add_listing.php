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
<script src="<?php echo base_url(); ?>/assets/admin/js/provider.js?v=1.0"></script>
<!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.min.js"></script>
	
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.css">
	<style>
	.progress-bar-wrapper {
  width: 100%;
  height: 20px;
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
<div class="content-wrapper">
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
						
						<input type="hidden" name="sale_id" value="<?php echo !empty($selected_sale_id) ? $selected_sale_id : (!empty($product_detail['sale_id']) ? $product_detail['sale_id'] : '') ; ?>">
						<input type="hidden" name="payment_type" value="<?php echo !empty($selected_payment) ? $selected_payment : (!empty($product_detail['payment_type']) ? $product_detail['payment_type'] : 'stripe'); ?>">
						<input type="hidden" name="plan_id" value="<?php echo !empty($_GET['plan_id']) ? $_GET['plan_id'] : (!empty($product_detail['plan_id']) ? $product_detail['plan_id'] : ''); ?>">
						
							<h3></h3>
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
												echo '<div class="services-group form-group pr-2 d_fields '.(($field->show_cat_based == 0) ? "" : "catbasedfield" ).'" style="'.(($field->show_cat_based == 0) ? "" : "none" ).'" data-category="'.$field->category_ids.'" data-subcategory="'.$field->subcategory_ids.'">
														<label class="mb-0">'.$field->name.' '.$req_op.'</label>';
														if($field->field_type == 'Text'){
															echo '<input type="text" name="dynamic_fields['.$field->id.']" class="form-control" placeholder="'.$field->name.' '.$req_op.'" value="'. (!empty($dynamic_fields_values[$field->id]) ? $dynamic_fields_values[$field->id] : '').'" '.$req_op_text.'>';
														}else if($field->field_type == 'Number'){
															echo '<input type="number" name="dynamic_fields['.$field->id.']" class="form-control" placeholder="'.$field->name.' '.$req_op.'" value="'. (!empty($dynamic_fields_values[$field->id]) ? $dynamic_fields_values[$field->id] : '').'" '.$req_op_text.'>';
														}else if($field->field_type == 'Textarea'){
															$rowsnumber = ($field->name == 'About this Aircraft' || $field->id == 14) ? 'rows="10"' :'';
															echo '<textarea name="dynamic_fields['.$field->id.']" class="form-control" placeholder="'.$field->name.' '.$req_op.'" '.$req_op_text.' '.$rowsnumber.'>'. (!empty($dynamic_fields_values[$field->id]) ? $dynamic_fields_values[$field->id] : '').'</textarea>';
														}else if($field->field_type == 'Checkbox'){
															$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
															if (!empty($decoded_option) && count($decoded_option) > 0) {
																echo '
												<div class="dyn-error-holder d-none"></div><div class="row">';
																foreach($decoded_option as $oi => $option){
																	echo '<div class="col-sm-12 col-xs-12 col-option d-flex my-2 align-items-center"><input type="checkbox" name="dynamic_fields['.$field->id.'][]" id="status_'.$oi.'" class="" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->id]) && in_array($option, $dynamic_fields_values[$field->id]) ) ? 'checked' : '').'  '.$req_op_text.'><label for="status_'.$oi.'" class="option-label d-block">'.$option.'</label></div>';
																}	
																echo '</div>';															
															}else{
																echo 'Options not available';
															}
														}else if($field->field_type == 'Radio'){
															$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
															if (!empty($decoded_option) && count($decoded_option) > 0) {
																echo '<div class="row">';
																foreach($decoded_option as $oi => $option){
																	echo '<div class="col-sm-4 col-xs-12 col-option d-flex"><input type="radio" name="dynamic_fields['.$field->id.']" id="status_'.$oi.'" class="" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->id]) && $option== $dynamic_fields_values[$field->id]) ? 'checked' : '').'  '.$req_op_text.'><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
																}	
																echo '</div>';															
															}else{
																echo 'Options not available';
															}
														}else if($field->field_type == 'Dropdown'){
															$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
															$option_html = '';
															if (!empty($decoded_option) && count($decoded_option) > 0) {
																echo '<select class="form-control" name="dynamic_fields['.$field->id.']"  '.$req_op_text.'><option value="">--'.$field->name.' '.$req_op.'--</option>';
																foreach($decoded_option as $oi => $option){
																	echo '<option value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->id]) && ($option == $dynamic_fields_values[$field->id]) ) ? 'selected' : '').'>'.$option.'</option>';
																}
																echo '</select>';															
															}else{
																echo 'Options not available';
															}
														}else if($field->field_type == 'File'){
															if($groupName == 'Log Book'){
																echo '<label class="m-0 d-flex">'.$field->name.'</label>';
															}
															echo '<label class="dz-wrap mb-3" style="display:block !important;margin-left:0 !important;">
										<span>Drag and drop or click to upload</span><input type="file" name="dynamic_fields['.$field->id.'][]" class="form-control dynamic-file-input" placeholder="'.$field->name.'" value="" data-field-id="' . $field->id . '" accept=".pdf,.doc,.docx,.png,.jpeg,.jpg"  multiple>
									</label>';
															echo '<button type="button" class="btn btn-sm px-5 mb-3 edit-titles-btn min-w-auto d-none" data-field-id="'.$field->id.'">Edit File Details</button>';
															if(!empty($dynamic_fields_values[$field->id]) && is_array($dynamic_fields_values[$field->id])){
																foreach($dynamic_fields_values[$field->id] as $df => $dfv){
																	
																	if(!empty($dynamic_fields_values[$field->id][$df]['field_value'])){
																		echo '<div class="existing-files-wrapper existing-file mb-2" data-file-index="'.$df.'" data-field-id="'.$field->id.'">';
																		echo '<input type="hidden" value="'.$dynamic_fields_values[$field->id][$df]['field_value'].'" name="dynamic_fields_old['.$field->id.'][]"  data-url="'.base_url().'/uploads/userimages/'.session()->get('admin_sess_user_id').'/'.$dynamic_fields_values[$field->id][$df]['field_value'].'"  />';
																		echo '<input type="hidden" value="'.$dynamic_fields_values[$field->id][$df]['file_field_title'].'" name="dynamic_fields_titles_old['.$field->id.'][]" /></div>';
																	}
																}
															}else{
																//echo !empty($dynamic_fields_values[$field->id]) ? '<a class="btn" target="_blank" href="'.base_url().'/uploads/userimages/'.session()->get('admin_sess_user_id').'/'.$dynamic_fields_values[$field->id].'" >View '.$field->name.'</a><button type="button" class="btn btn-danger btn-sm remove-existing-btn">Remove</button>' : '';
																if(!empty($dynamic_fields_values[$field->id])){
																	echo '<div class="existing-files-wrapper existing-file mb-2" data-file-index="0" data-field-id="'.$field->id.'">';
																	echo '<input type="hidden" value="'.$dynamic_fields_values[$field->id].'" name="dynamic_fields_old['.$field->id.'][]"  data-url="'.base_url().'/uploads/userimages/'.session()->get('admin_sess_user_id').'/'.$dynamic_fields_values[$field->id].'"  />';
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

							<h3></h3>
							<fieldset class="form-input">
								<h3 class="title-xl black mt-3 mb-4"><?php echo trans('Photos and Videos') ?></h3>
								<div class="form-section">
									<div class="form-group">
								<div class='row'>
						
						
							<div class='col-12 <?php if(!empty($user_photos)){ ?>col-sm-6<?php }else{ ?>col-sm-6<?php } ?>'>
								<h5 class="mb-3">Add Photo or Video <span style="font-weight: 100;font-size: 0.7rem;vertical-align: middle;">(.jpg, .jpeg, .png, .mp4, .mov)</span></h5>
								
									<div class="mt-4 file-upload">
									<label class="dz-wrap" style="display:block !important;margin-left:0 !important;">
										<span>Drag and drop or click to upload</span>
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
											echo "<div class='d-flex justify-content-between bg-orange text-white py-1 px-3'><div class='trash' onclick='editphotos(".$row['id'].",this)' data-id='".$row['id']."' data-file-type='".$row['file_type']."' data-tags='".$row['image_tag']."' style='cursor:pointer'><i class='fa fa-pen'></i></div><div class='trash' onclick='deletephotos(".$row['id'].")' data-id='".$row['id']."' style='cursor:pointer'><i class='fa fa-trash-o'></i></div></div></div></li>";
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

							<h3></h3>
							<fieldset class="form-input">
								<h3 class="title-xl black my-3"><?php echo trans('Seller Information') ?></h3>
								<div class="form-section row row-cols-1 row-cols-md-2">
								<div class="form-group pr-2">
									<input class="form-control required" type="text" id="business_name" name="business_name" placeholder="<?php echo trans('Name') ?>" value="<?php echo !empty($product_detail['business_name']) ? $product_detail['business_name'] : (!empty(old('business_name'))?old('business_name'):$user_detail->fullname); ?>" required>
								</div>													
								<div class="form-group pr-2">
									<input class="form-control required" type="text" id="phone" name="phone" placeholder="<?php echo trans('Phone Number') ?>" autocomplete="off" value="<?php echo !empty($product_detail['phone']) ? $product_detail['phone'] : (!empty(old('phone'))?old('phone'):$user_detail->mobile_no); ?>" required>
								</div>													
								<div class="form-group pr-2">
									<input class="form-control required" type="text" id="address" name="address" placeholder="<?php echo trans('Location (City or State)') ?>" autocomplete="off" value="<?php echo !empty($product_detail['address']) ? $product_detail['address'] : old('address'); ?>" required>
								</div>	  
																				
								<div class="form-group pr-2">
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
							
							<?php if(!empty($_GET['id'])){ ?>
							<input type="submit" value="UPDATE LISTING" class="btn py-3 col-12 col-sm-6 col-lg-5 col-xl-4 mx-auto d-block mt-4" />
							<?php }else{ ?>
							<input type="submit" value="Submit" class="btn py-3 col-12 col-sm-6 col-lg-5 col-xl-4 mx-auto d-block" />
							<?php } ?>
						</form> 
                            </div>
                        </div>
                        <div class="card-footer clearfix">
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
			  <div class="progress-label">Starting upload...</div>
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
							<span>Replace Photo/Video</span>
							<input type='file' id="userphoto_edit" name='uploads[]' data-type="edit" style="padding: 4px 4px !important;" class="w-100 cropimageedit" accept=".pdf,.doc,.docx,.png,.jpeg,.jpg">	
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
  <div class="modal-dialog modal-dialog-centered modal-md">
    <form id="titlesForm" class="w-100">
      <div class="modal-content rounded-5 p-3 px-md-5 position-relative">
        <div class="modal-header px-0">
          <h5 class="modal-title">Edit File Details</h5>
          <button type="button" class="btn-close fs-5 position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-0" id="modalBody">
          <!-- JS-generated file list will appear here -->
        </div>
        <div class="modal-footer px-0 justify-content-between">
		<div class="m-0">
		  <a href="javascript:void(0);" class="m-0" data-field-id="" id="triggerModalFileInput"><i class="fa fa-plus-circle me-2"></i>Add File</a>
		</div>
          <button type="submit" class="btn min-w-auto m-0 btn-success px-5">Save</button>
        </div>
      </div>
    </form>
  </div>
</div><style>
  .dz-wrap {
    border: 2px dashed #ccc;
    padding: 2rem;
    text-align: center;
    position: relative;
    border-radius: 10px;
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

  // Helper: make one drop‑zone work
  function wireDropZone(dz) {
    const input = dz.querySelector('input[type="file"]');
    if (!input) return;                      // safety

    // Highlight on drag‑over
    dz.addEventListener('dragenter', e => { e.preventDefault(); dz.classList.add('over'); });
    dz.addEventListener('dragover',  e => { e.preventDefault(); });

    // Remove highlight
    dz.addEventListener('dragleave', e => dz.classList.remove('over'));
    dz.addEventListener('drop',      e => {
      e.preventDefault();
      dz.classList.remove('over');

      if (!e.dataTransfer.files.length) return;

      // Put dropped files into the correct <input>
      const dt = new DataTransfer();               // Safari 15.4+ OK
      [...e.dataTransfer.files].forEach(f => dt.items.add(f));
      input.files = dt.files;

      // Fire YOUR existing .on('change') handlers (cropimage *or* any other)
      input.dispatchEvent(new Event('change', { bubbles: true }));
    });
  }

  // ➤ 1.  Wire every drop‑zone present on first load
  document.querySelectorAll('.dz-wrap').forEach(wireDropZone);

  // ➤ 2.  If you add fields dynamically (AJAX, “Add more” button, etc.)
  //        watch the DOM and wire those, too.
  const observer = new MutationObserver(muts => {
    muts.forEach(m => {
      m.addedNodes.forEach(node => {
        if (node.nodeType !== 1) return;           // 1 = element
        if (node.matches('.dz-wrap')) wireDropZone(node);
        node.querySelectorAll?.('.dz-wrap')        // nested drop‑zones
            .forEach(wireDropZone);
      });
    });
  });
  observer.observe(document.body, { childList: true, subtree: true });

});
</script>

<script>
// Assumes Bootstrap 5 and jQuery are loaded
// You must include the following HTML elements somewhere in your form:
// - <div id="modalBody"></div> inside a modal with id="titlesModal"
// - <form id="titlesForm"></form> with submit button inside modal

let currentFieldId = '';
let filesStore = {}; // fieldId => [{ name, title, file, existing, url, tempInput }]

$(document).on('click', '.edit-titles-btn', function () {
  currentFieldId = $(this).data('field-id');
  $('#triggerModalFileInput').attr('data-field-id', currentFieldId);
  showTitlesModal(currentFieldId);
});

function showTitlesModal(fieldId) {
  const modalBody = $('#modalBody').empty();
  const fileList = filesStore[fieldId] || [];

  fileList.forEach((fileObj, i) => {
    const viewBtn = fileObj.existing && fileObj.url ? `<a href="${fileObj.url}" target="_blank" class="ms-2">View</a>` : '';

    modalBody.append(`
      <div class="modal-file-row mb-3" data-index="${i}" data-filename="${fileObj.name}">
        <label>${fileObj.name}<span>${viewBtn}</span></label>
        <div class="input-group gap-3 align-items-center">
          <input type="text" class="form-control file-title mb-0" data-index="${i}" value="${$('<div>').text(fileObj.title || '').html()}" placeholder="Enter title">
          <div class="remove-file-btn"><i class="fa fa-trash"></i></div>
        </div>
      </div>
    `);
  });

  $('#titlesModal').modal('show');
}

function updateTitleStoreFromModal() {
  const fieldId = currentFieldId;
  const titleInputs = $('#modalBody .file-title');
  const list = filesStore[fieldId];

  titleInputs.each(function () {
    const idx = $(this).data('index');
    if (list[idx]) {
      list[idx].title = $(this).val();
    }
  });
}

$(document).on('change', '.dynamic-file-input', function () {
  const fieldId = $(this).data('field-id');
  const files = Array.from(this.files);
  filesStore[fieldId] = filesStore[fieldId] || [];

  files.forEach(file => {
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
    }
  });

  currentFieldId = fieldId;
  updateTitleStoreFromModal();
  showTitlesModal(fieldId);

  // ✅ Reveal the Edit button
  $(`.edit-titles-btn[data-field-id="${fieldId}"]`).removeClass('d-none');

  // ✅ Update file count visually
  updateCustomFileLabel(fieldId);
});

$(document).on('click', '.remove-file-btn', function () {
  const index = $(this).closest('.modal-file-row').data('index');
  const fileList = filesStore[currentFieldId];
  const removed = fileList.splice(index, 1)[0];
  if (removed.tempInput) {
    $(removed.tempInput).remove();
  }
  showTitlesModal(currentFieldId);
});

$('#titlesForm').on('submit', function (e) {
  e.preventDefault();
  updateTitleStoreFromModal();

  const fieldId = currentFieldId;
  const updatedList = filesStore[fieldId];

  $(`input[name="dynamic_fields_titles[${fieldId}][]"]`).remove();
  $(`input[name="dynamic_fields_old[${fieldId}][]"]`).remove();
  $(`input[name="dynamic_fields_titles_old[${fieldId}][]"]`).remove();

  const form = $(`.dynamic-file-input[data-field-id="${fieldId}"]`).closest('form');

  updatedList.forEach(fileObj => {
    if (fileObj.existing) {
      form.append(`<input type="hidden" name="dynamic_fields_old[${fieldId}][]" value="${fileObj.name}" data-url="${fileObj.url}">`);
      form.append(`<input type="hidden" name="dynamic_fields_titles_old[${fieldId}][]" value="${fileObj.title}">`);
    } else {
      form.append(`<input type="hidden" name="dynamic_fields_titles[${fieldId}][]" value="${fileObj.title}" data-filename="${fileObj.name}">`);
    }
  });

  $('#titlesModal').modal('hide');
});

$(document).on('click', '#triggerModalFileInput', function (e) {
  e.preventDefault();
  updateTitleStoreFromModal();

  const fieldId = $(this).attr('data-field-id');

  const tempInput = $('<input type="file" accept=".pdf,.doc,.docx" multiple style="display:none;">');
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
  });
});

$(document).ready(function () {
  $('.dynamic-file-input').each(function () {
    const fieldId = $(this).data('field-id');
    const editBtn = $(`.edit-titles-btn[data-field-id="${fieldId}"]`);

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

      editBtn.removeClass('d-none');
    }
  });
});

</script>



<script>
function updateProgress(percent, label, err = 1) {
    $("#upload-progress-bar").css("width", percent + "%");
	if(err == 1){
		$(".progress-label").html('<div class="text-success">'+label+'</div>');
	}else{
		$(".progress-label").html('<div class="text-danger">'+label+'</div>');
	}    
}
	$(document).ready(function(){
		let lightbox = GLightbox({
			selector: '.glightbox-video',
			touchNavigation: true,
			autoplayVideos: true
		});
		$('#image_tag').on('itemAdded', function(event) {
			if ($('.photouploadupdate').is(':visible')) {
				//$('.photouploadupdate').trigger('click');
			}else{
				//$('.photoupload').trigger('click');
			}
		});
	});
	function deletephotosdiv(_this){
		$(_this).closest('.up-ca').hide();
		// Check if any visible .pic divs are left
		  if ($('#upload-file-modal .up-ca:visible').length === 0) {
			   $("#userphoto").val(null);
			$('#upload-file-modal').modal('hide');
		  }
	}
	function deletephotos(photo_id){
		$.confirm({
			title: 'Confirm Deletion',
			content: 'Are you sure you want to delete this photo?',
			buttons: {
				confirm: function () {
					$.ajax({
						url: '<?php echo base_url(); ?>/providerauth/photos_delete',
						data: {photo_id:photo_id,product_id:'<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>',user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>'},
						type: 'POST',
						dataType: 'HTML',
						success: function(response){
							if(response != ''){
								$(".load-images").html(response);
								$(".upload-loading-success").html('Deleted Successfully!');
								$(".upload-loading-success").show().delay(5000).fadeOut();
							}	
							$("#imageListId").sortable({
								update: function(event, ui) {
										getIdsOfImages();
									} //end update	
							});	
							if($('.listitemClass:first-child').find('img').attr('src') === undefined){
								//$('.proPic').find('img').attr('src','<?php echo base_url().'/assets/frontend/images/user.png'; ?>');
							}else{
								//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));
							}
								
														
						}
					})
				},
				cancel: function(){
					
				}
			}
		});
	}
	function editphotos(photo_id,_this){
		$('.final-result-container').hide();
		$("#userphoto_edit").val(null);		
		$('#image_tag').val($(_this).attr('data-tags'));
		$('.photouploadupdate').attr('data-id',photo_id);
		if($(_this).attr('data-file-type') == 'image'){
			console.log('image');
			$('.editablemedia').html(
				'<img width="100%" class="load-edit-image" height="auto" style="object-fit:cover;border-radius: 25px;border: 1px solid #eee;height: 200px;" data-id="' + photo_id + '" src="' + $(_this).closest('li').find('img').attr('src') + '" />'
			);
		}else{
			console.log('video');
				const videoWithOverlay = `
				<div class="video-wrappers" style="position: relative; display: inline-block;border-radius: 25px;border: 1px solid #eee;">
				<video data-id="${photo_id}" style="object-fit:cover; width: 100%; border-radius: 25px; border: 1px solid #eee; height: 200px;" muted src="${$(_this).closest('li').find('source').attr('src')}">
				</video>
				</div>`;

				$('.editablemedia').html(
				'' +
				videoWithOverlay +
				'' 
				);

		}
		$('.csimage').removeClass('cropped_image_save');
		$('.csimage').addClass('cropped_image_save_edit');
		$('#edit-file-modal').modal('show');
	}
	function cancel_edit(){		
		$("#image_tag").val('');
		$('.photouploadupdate').attr('data-id','');
		$('.load-edit-image').attr('src','');
		$('.csimage').addClass('cropped_image_save');
		$('.csimage').removeClass('cropped_image_save_edit');
		$("#userphoto_edit").val(null);	
		$('#edit-file-modal').modal('hide');
	}
	function editphotospost(_this){
		var p_id = $(_this).attr('data-id');
		if ($('#userphoto_edit').get(0).files.length === 0) {
			$.ajax({
				url: '<?php echo base_url(); ?>/providerauth/photosedit_post',
				data: {p_id:p_id,image_tag:$("#image_tag").val(),product_id:'<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>',plan_id:$('input[name="plan_id"]').val(),user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>'},
				type: 'POST',
				dataType: 'HTML',
				success: function(response){
					if(response != ''){
						$(".load-images").html(response);
					}
					$("#imageListId").sortable({
						update: function(event, ui) {
								getIdsOfImages();
							} //end update	
					});
					//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));					
					$("#image_tag").val('');						
					Swal.fire('Updated Successfully!', '', 'success');									
				}
			})
		}else{
			var form_data = new FormData();			
		    form_data.append("upload", $('#userphoto_edit')[0].files[0]);			
		    form_data.append("tag",$("#image_tag").val());
							   
			var imgt = $("#image_tag").val();
			$.ajax({
				url: '<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/'+'<?php echo $_GET['user_id']; ?>',
				data: form_data,
				type: 'POST',
				dataType: 'JSON',
				processData: false,
				contentType: false,
				cache: false,
				enctype: 'multipart/form-data',
				beforeSend: function(){
				},
				success: function(response){
					if(response.uploaded == 1){
						$("#userphoto_edit").val(null);
						$.ajax({
							url: '<?php echo base_url(); ?>/providerauth/photosedit_post',
							data: {p_id:p_id,image:response.fileName,file_type:response.fileType,image_tag:imgt,product_id:'<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>',plan_id:$('input[name="plan_id"]').val(),user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>'},
							type: 'POST',
							dataType: 'HTML',
							success: function(response){
								if(response != ''){
									$(".load-images").html(response);
								}
								$("#imageListId").sortable({
									update: function(event, ui) {
											getIdsOfImages();
										} //end update	
								});	
								
					$('.final-result-container').hide();	//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));								
							}
						})
						$("#image_tag").val('');						
						Swal.fire('Updated Successfully!', '', 'success');	
					}else{
						Swal.fire(response.error, '', 'error');
					}
				}
			}) 
		}	
			
		$('.photouploadupdate').attr('data-id','');
		$('.load-edit-image').attr('src','');
		$('.csimage').addClass('cropped_image_save');
		$('.csimage').removeClass('cropped_image_save_edit');	
		$('#edit-file-modal').modal('hide');
	}
	$(function() {
		$("#imageListId").sortable({
			update: function(event, ui) {
					getIdsOfImages();
				} //end update	
		});
	});
	function getIdsOfImages() {
		var values = [];
		$('.listitemClass').each(function(index) {
			values.push($(this).attr("id")
						.replace("imageNo", ""));
		});
		$('#outputvalues').val(values);
		$.ajax({
			url: '<?php echo base_url(); ?>/providerauth/photos_post',
			data: {check:'3',ids:values,product_id:'<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>',plan_id:$('input[name="plan_id"]').val(),user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>'},
			type: 'POST',
			dataType: 'HTML',
			success: function(response){		
				//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));
			}
		})
	}
	function load_croppie(_this) {		
		$('#upload-image').attr('data-id',$(_this).find('img').attr('data-id'));
		$('#upload-image').croppie('bind', {
			url: $(_this).find('img').attr('src')
		}).then(function(){
			console.log('jQuery bind complete');
		});
		$('#crop-image').modal('show');
	}
	$(document).ready(function(){ 
	var myCroppie = $('#upload-image').croppie({
			enableExif: true,
			viewport: {
				width: 200,
				height: 150,	
				type: 'rectangle',				
				enableResize: true,
				enableOrientation: true,
			},
			boundary: {
				width: 400,
				height: 300
			}
		});
	$('#crop-image').on('shown.bs.modal', function(){	
		//$('#upload-image').attr('data-id',$('#upload-image').attr('data-id'));			
		myCroppie.croppie('bind',{
			url: $(".test"+$('#upload-image').attr('data-id')).find('img').attr('src')
		});
	});
	$('#crop-image').on('hide.bs.modal', function(){ 
		//$("#image_tag").tagsinput('removeAll');
		//$("#userphoto").val(null);
		myCroppie.croppie('bind',{
			url: ''
		});
	});

// Utility to format seconds into mm:ss
function formatTime(seconds) {
  seconds = Math.floor(seconds);
  const m = Math.floor(seconds / 60);
  const s = seconds % 60;
  return `${m}:${s.toString().padStart(2, '0')}`;
}
	/*$('.cropimage').on('change', function () { 
		$('#crop-image').modal('show'); 
		$('.cropped_image').attr('data-id',$(this).attr('data-id'));
		$('.cropped_image').attr('data-url',$(this).attr('data-url'));
	});*/
	var fileList = [];
	var fileListedit = [];
	$('.cropimage').on('click', function (event) {
		fileList = [];
		$('.load-images-final').html('');
		$('.final-result-container').hide();						
	})	
	$('.cropimageedit').on('click', function (event) {
		fileListedit = [];						
	})			
	$('.cropimage').on('change', function (event) {
		//$('#crop-image').modal('show'); 
		if (event.target.files.length) {
			var i = 0;
			var index = 0;
			for (let singleFile of event.target.files) {
				
				var reader = new FileReader();
				reader.onload = function (e) {
				const isImage = singleFile.type.startsWith("image/");
				const isVideo = singleFile.type.startsWith("video/");

				if (isImage) {
				// Append final preview
				$('.load-images-final').append(
				'<div class="up-ca" style="padding: 2px !important;">' +
				'<img width="100%" height="auto" style="object-fit:cover;border-radius: 25px;border: 1px solid #eee;height: 200px;" data-id="' + i + '" src="' + e.target.result + '" />' +
				'<div class="trash" onclick="deletephotosdiv(this)" style="cursor:pointer"><i class="fa fa-trash-o"></i></div>' +
				'<label>Tags (Optional)</label>' +
				'<textarea name="image_tag[]" placeholder="Ex: Control Panel, Left Wing, Tail, etc." class="w-100"></textarea>' +
				'</div>'
				);

				i++;
				}

				else if (isVideo) {
				const video = document.createElement('video');
				video.src = e.target.result;
				video.preload = 'metadata';

				video.addEventListener('loadedmetadata', function () {
				const duration = formatTime(video.duration);

				const videoThumb = `
				<video data-id="${i}" style="object-fit:cover; width: 100%; height: auto;" muted>
				<source src="${e.target.result}" type="${singleFile.type}" />
				Your browser does not support the video tag.
				</video>`;

				const videoWithOverlay = `
				<div class="video-wrappers" style="position: relative; display: inline-block;border-radius: 25px;border: 1px solid #eee;">
				<video data-id="${i}" style="object-fit:cover; width: 100%; border-radius: 25px; border: 1px solid #eee; height: 200px;"  muted>
				<source src="${e.target.result}" type="${singleFile.type}" />
				</video>
				<span class="video-duration" style="
				position: absolute;
				bottom: 8px;
				right: 8px;
				background-color: rgba(0, 0, 0, 0.6);
				color: #fff;
				font-size: 12px;
				padding: 2px 6px;
				border-radius: 4px;
				">${duration}</span>
				</div>`;

				$('.load-images-final').append(
				'<div class="up-ca" style="padding: 2px !important;">' +
				videoWithOverlay +
				'<div class="trash" onclick="deletephotosdiv(this)" style="cursor:pointer"><i class="fa fa-trash-o"></i></div>' +
				'<label>Tags (Optional)</label>' +
				'<textarea name="image_tag[]" placeholder="Ex: Control Panel, Left Wing, Tail, etc."></textarea>' +
				'</div>'
				);

				i++;
				});
				}
					$('.final-result-container').show();
					$('#upload-file-modal').find('.header-message').html('<h5 class="mb-0 fw-bolder">Add Tags and Upload</h5>');
					$('#upload-file-modal').find('.modal-footer .photoupload').show();
					$('#upload-file-modal').find('.modal-footer .photouploaddone').hide();
					$('.upload-loading').hide();
					$('#upload-file-modal').modal('show');
					i++;
				}
				fileList.push(singleFile);
				reader.readAsDataURL(singleFile);
			}
		}
		$('.cropped_image').attr('data-id',$(this).attr('data-id'));
		$('.cropped_image').attr('data-url',$(this).attr('data-url'));			
	});	
	
	$('.cropimageedit').on('change', function (event) {
		//$('#crop-image').modal('show'); 
		if (event.target.files.length) {
			var i = 0;
			var index = 0;
			for (let singleFile of event.target.files) {
				
				var reader = new FileReader();
				reader.onload = function (e) {
				const isImage = singleFile.type.startsWith("image/");
				const isVideo = singleFile.type.startsWith("video/");

				if (isImage) {
				// Append final preview
				$('.editablemedia').html(
				'<img width="100%" class="load-edit-image" height="auto" style="object-fit:cover;border-radius: 25px;border: 1px solid #eee;height: 200px;" data-id="' + i + '" src="' + e.target.result + '" />'
				);

				i++;
				}

				else if (isVideo) {
				const video = document.createElement('video');
				video.src = e.target.result;
				video.preload = 'metadata';

				video.addEventListener('loadedmetadata', function () {
				const duration = formatTime(video.duration);

				const videoThumb = `
				<video data-id="${i}" style="object-fit:cover; width: 100%; height: auto;" muted>
				<source src="${e.target.result}" type="${singleFile.type}" />
				Your browser does not support the video tag.
				</video>`;

				const videoWithOverlay = `
				<div class="video-wrappers" style="position: relative; display: inline-block;border-radius: 25px;border: 1px solid #eee;">
				<video data-id="${i}" style="object-fit:cover; width: 100%; border-radius: 25px; border: 1px solid #eee; height: 200px;"  muted>
				<source src="${e.target.result}" type="${singleFile.type}" />
				</video>
				<span class="video-duration" style="
				position: absolute;
				bottom: 8px;
				right: 8px;
				background-color: rgba(0, 0, 0, 0.6);
				color: #fff;
				font-size: 12px;
				padding: 2px 6px;
				border-radius: 4px;
				">${duration}</span>
				</div>`;

				$('.editablemedia').html(
				'' +
				videoWithOverlay +
				'' 
				);

				i++;
				});
				}
					
					i++;
				}
				fileListedit.push(singleFile);
				reader.readAsDataURL(singleFile);
			}
		}		
	});
	
	
	$(document).on('mouseenter', '.load-images-final video, .editablemedia video', function () {
	  this.play();
	});

	$(document).on('mouseleave', '.load-images-final video, .editablemedia video', function () {
	  this.pause();
	  this.currentTime = 0;
	});
	$('.cropped_image').on('click', function (ev) {
		
		myCroppie.croppie('result', {
			type: 'blob',
			size: 'original',
			quality: 1
		}).then(function (response) {
			fileList[$('#upload-image').attr('data-id')] = response;
			console.log(fileList);
			var image = new Image();
			image.src = URL.createObjectURL(response);
			image.style.width = '150px';
			image.style.height = '113px';
			image.style.border = '1px solid #eee';
			image.style.borderRadius = '25px';
			image.style.objectFit ="cover";
			$('.fid-'+$('#upload-image').attr('data-id')).html(image);
			//$('.fid-'+$('#upload-image').attr('data-id')).append('<div class="icon-container"><i class="fa fa-crop"></i></div>');
			
		});
	});	
	
	$(".cropped_image_save").on("click", function(){
		$('#crop-image').modal('hide'); 
	})
	$(".cropped_image").on("click", function(){
		$('#crop-image').modal('hide'); 
	})
	$(".open-image-modal").on("click", function(){
		$('#crop-image').modal('show'); 
	})
	$(".photouploaddone").on("click", function(){
		$("#userphoto").val(null);	
		$('#upload-file-modal').modal('hide'); 
	})
	
	let shouldForceClose = false;
	$('#upload-file-modal').on('hide.bs.modal', function (e) {
	  if (!$('#upload-file-modal').find('.modal-footer .photoupload').is(':visible') || shouldForceClose || $('#upload-file-modal .up-ca:visible').length === 0) {
		shouldForceClose = false; // reset
		return; // allow close
	  }

	  e.preventDefault(); // block close
	  $('#confirmCloseModal').modal('show'); // show confirmation
	});

	// Handle "Continue" - resume upload
	$('#continueUpload').on('click', function () {
	  $('#confirmCloseModal').modal('hide'); // just hide confirmation
	});

	// Handle "Discard" - force close upload modal
	$('#discardUpload').on('click', function () {
	  $('#confirmCloseModal').modal('hide');

	  shouldForceClose = true; // allow modal to close next time
	  $('#upload-file-modal').modal('hide'); // close upload modal
	  $("#userphoto").val(null);	
	});
	
		$(".photoupload").on("click", function(){
			/*if($("#image_tag").val() == ''){
				console.log('1cv');
				$('.load-images-final').html('');
				$('.upload-loading').show();
				updateProgress(0, "Please add tags to your photo/video",0);
				$('.progress-bar-wrapper').hide();
				//$(".upload-loading-error").html('Please add tags to your photo.');
				//$(".upload-loading-error").show().delay(5000).fadeOut();$('#crop-image').modal('hide');
				$('.final-result-container').hide();
			}else{ */
				$('.upload-loading').show();
				if ($('#userphoto')[0].files.length > 0) {
					updateProgress(10, "Uploading...");
					$('.progress-bar-wrapper').show();
				}else{
					updateProgress(0, 'Select Image/Video to Upload',0);
					$('.progress-bar-wrapper').hide();
				}
			if ($(".csimage").hasClass("cropped_image_save")) {
			console.log('1');
			var form_data1 = new FormData();
		    form_data1.append("upload", $('#userphoto')[0].files[0]);
		    form_data1.append("check", 1);
		    form_data1.append("product_id", '<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>');
		    form_data1.append("plan_id", $('input[name="plan_id"]').val());
			$.ajax({
				url: '<?php echo base_url(); ?>/providerauth/photos_post',
				data: form_data1,
				type: 'POST',
				dataType: 'JSON',
				processData: false,
				contentType: false,
				cache: false,
				enctype: 'multipart/form-data',
				beforeSend: function(){
					$('.loader').show();
				},
				success: async function(response){
					if(response == '2' || response.status == 'error'){
						updateProgress(0, response.message,0);
						$('.progress-bar-wrapper').hide();
						//$('.final-result-container').hide();
						//$(".upload-loading-error").html(response.message);
						//$(".upload-loading-error").show().delay(5000).fadeOut();
						$('#crop-image').modal('hide');
						//$("#image_tag").tagsinput('removeAll');
						$("#userphoto").val("");
						//$('.upload-loading').hide();
					}else if(response == '8'){
						//updateProgress(0, 'Select Image/Video to Upload',0);
						//$(".upload-loading-error").html('Select Image/Video to Upload');			
						//$(".upload-loading-error").show().delay(5000).fadeOut();		
					}else{
						updateProgress(25, "Uploading...");
					$('.progress-bar-wrapper').show();
						
						// Read selected files
						 var form_data = new FormData();
						  var totalfiles = fileList.length;
						  for (var index = 0; index < totalfiles; index++) {
							  form_data.delete("upload");
							   form_data.append("upload", fileList[index]);
							   form_data.append("tag", $('textarea[name="image_tag[]"]').eq(index).val());
								$.ajax({
									url: '<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/'+'<?php echo $_GET['user_id']; ?>',
									data: form_data,
									type: 'POST',
									dataType: 'JSON',
									processData: false,
									contentType: false,
									cache: false,
									enctype: 'multipart/form-data',
									beforeSend: function(){
										//$('.upload-loading').show();
									},
									success: function(response){
										if(response.uploaded == 1){
											updateProgress(90, "Uploading...");
											$('.progress-bar-wrapper').show();
											$("#userphoto").val(null);
											console.log(index);
											console.log(imtg);
											$.ajax({
												url: '<?php echo base_url(); ?>/providerauth/photos_post',
												data: {check:'2',image:response.fileName,file_type:response.fileType,image_tag:response.tag,product_id:'<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>',plan_id:$('input[name="plan_id"]').val(),user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>'},
												type: 'POST',
												dataType: 'HTML',
												success: function(response){
													if(response != ''){
														$(".load-images").html(response);


														const video = document.querySelector('video');
														video.addEventListener('loadeddata', function () {
															this.currentTime = 0.1; // seek to a frame slightly after 0 to avoid blank
														});
														
														let lightbox = GLightbox({
															selector: '.glightbox-video',
															touchNavigation: true,
															autoplayVideos: true
														});
													}
													$("#imageListId").sortable({
														update: function(event, ui) {
																getIdsOfImages();
															} //end update	
													});	
													//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));										
												}
											})
											updateProgress(100, 'Uploading...');
											$('.progress-bar-wrapper').show();
											setTimeout(() => {
												$(".upload-loading").fadeOut(() => {
													// Callback after fadeOut completes
													$('#upload-file-modal').find('.header-message').html(`
														<div class="alert alert-success d-flex align-items-start p-3 shadow-sm" role="alert">
															<i class="fa-solid fa-check me-2 mt-1 text-success"></i>
															<div>Your photos and videos have been uploaded.</div>
														</div>
													`);
													$('#upload-file-modal').modal('hide'); 
												});
											}, 2000);
											
										}else{
											updateProgress(0, response.error,0);
											$('.progress-bar-wrapper').hide();
											setTimeout(() => {
												$(".upload-loading").fadeOut(() => {
													// Callback after fadeOut completes
													$('#upload-file-modal').find('.header-message').html(`
														<div class="alert alert-success d-flex align-items-start p-3 shadow-sm" role="alert">
															<i class="fa-solid fa-check me-2 mt-1 text-success"></i>
															<div>${response.error}</div>
														</div>
													`);
												});
											}, 2000);
										}
										$('.loader').hide();
									}
								})
							
							
										if((index+1) == totalfiles){
											//$("#image_tag").tagsinput('removeAll');
										}
						}
					}	
					$('.loader').hide();	$('#crop-image').modal('hide');
					//$('.final-result-container').hide(); 	
					fileList = [];	
					$('#upload-file-modal').find('.modal-footer .photoupload').hide();
					$('#upload-file-modal').find('.modal-footer .photouploaddone').show();
					$('#upload-file-modal').find('.trash').hide();
					
					$('.up-ca').find('input, textarea').prop('readonly', true).prop('disabled', true);
				}
				
			})	
			}else{
			console.log('2');
		var p_id = $('.photouploadupdate').attr('data-id');	

	 var form_data = new FormData();
	  var totalfiles = fileList.length;
	  for (var index = 0; index < totalfiles; index++) {
		  console.log(fileList[index]);
		  form_data.delete("upload");
		  form_data.append("upload", fileList[index]);
			var imtg = $('textarea[name="image_tag[]"]').eq(index).val();
		
						updateProgress(25, "Uploading...");
					$('.progress-bar-wrapper').show();
		$.ajax({
			url: '<?php echo base_url(); ?>/fileupload.php?uploadpath=userimages/'+'<?php echo $_GET['user_id']; ?>',
			data: form_data,
			type: 'POST',
			dataType: 'JSON',
			processData: false,
			contentType: false,
			cache: false,
			enctype: 'multipart/form-data',
			beforeSend: function(){
				//$('.upload-loading').show();$('.loader').show();
			},
			success: function(response){
				//$('.upload-loading').hide();$('.loader').hide();
				if(response.uploaded == 1){
					
					updateProgress(50, "Uploading...");
					$('.progress-bar-wrapper').show();
					$("#userphoto").val(null);
					$.ajax({
						url: '<?php echo base_url(); ?>/providerauth/photosedit_post',
						data: {p_id:p_id,image:response.fileName,image_tag:imtg,product_id:'<?php echo !empty($_GET['id']) ? $_GET['id'] :''; ?>',plan_id:$('input[name="plan_id"]').val(),user_id:'<?php echo !empty($_GET['user_id']) ? $_GET['user_id'] :''; ?>'},
						type: 'POST',
						dataType: 'HTML',
						success: function(response){
							if(response != ''){
								$(".load-images").html(response);
							}
							$("#imageListId").sortable({
								update: function(event, ui) {
										getIdsOfImages();
									} //end update	
							});
					$('.final-result-container').hide();	
							//$('.proPic').find('img').attr('src',$('.listitemClass:first-child').find('img').attr('src'));											
						}
					})
					$('#crop-image').modal('hide'); 
					$('.final-result-container').hide();
					updateProgress(100, "Updated Successfully!");
					$('.progress-bar-wrapper').show();
					setTimeout(() => $(".upload-loading").fadeOut(), 1500);
					//$(".upload-loading-success").html('Updated Successfully!');
					//$(".upload-loading-success").show().delay(5000).fadeOut();
				}else{
					$('#crop-image').modal('hide'); 
					updateProgress(0, response.error,0);
					$('.progress-bar-wrapper').hide();
					//setTimeout(() => $(".upload-loading").fadeOut(), 1500);
					//$(".upload-loading-error").html(response.error);
					//$(".upload-loading-error").show().delay(5000).fadeOut();
				}
			}
		})
		
		
		$('.photoupload').show();
		$('.photouploadupdate').attr('data-id','');
		$('.load-edit-image').attr('src','');
		$('.csimage').addClass('cropped_image_save');
		$('.csimage').removeClass('cropped_image_save_edit');fileList = [];
		if ($("#userphoto").hasClass("cmul")) {
			$('#userphoto').attr('multiple',true);
		}
	  }
			}
		//}
	});
});
</script>



<script>

$(document).ready(function() {

    // On change, load subcategories
    $('#category_id').on('change', function() {
        let selected = $(this).val();
		var field_id = $(this).attr('data-field-id');
        if (selected && selected.length > 0) {
            $.ajax({
                url: baseUrl + "/common/get_sub_category_by_ids",
                method: 'POST',
				dataType:'json',
                data: { category_ids: selected, field_id:field_id },
                success: function(response) {
                    $('#sub_category_id').html(response.text);
                }
            });
        } else {
            $('#sub_category_id').html('');
        }
    });
	
	$('#category_id, #sub_category_id').on('change', function () {
		const selectedCategory = $('#category_id').val();
		const selectedSubcategory = $('#sub_category_id').val();

		$('.d_fields').each(function () {
			const catList = $(this).data('category').toString().split(',');
			const subcatList = $(this).data('subcategory').toString().split(',');

			const matchCategory = selectedCategory === '' || catList.includes(selectedCategory);
			const matchSubcategory = selectedSubcategory === '' || subcatList.includes(selectedSubcategory);

			if (matchCategory && matchSubcategory) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	});
});

    $(document).ready(function() {
        $('select[name="category_id"]').trigger('change');
    });
	$(function() {
		$('input[name="admin_plan_end_date"]').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minDate:new Date(),
			minYear: parseInt(moment().subtract(1, 'years').format('YYYY'),10),
			maxYear: parseInt(moment().add(10, 'years').format('YYYY'), 10),
			autoUpdateInput: false,
		}).on("apply.daterangepicker", function (e, picker) {
			picker.element.val(picker.startDate.format(picker.locale.format));
		});
	});
	
$(function () {

    // Cache the jQuery objects once
    const $subSelect   = $('select[name="sub_category_id"]');
    const $allCatBoxes = $('.catbasedfield');

    function toggleBoxes () {
        const id = $subSelect.val();           // '' if "Select Category" chosen
		if(id != ''){
			$('.catbasedtitle').show();
		}else{
			$('.catbasedtitle').hide();
		}
		
        // 1) Hide everything
        $allCatBoxes.hide();                   // or addClass('d-none') if using Bootstrap

        // 2) Show the matching block(s) – skip if no selection
        if (id) {
            $allCatBoxes
                .filter('[data-subcategory="' + id + '"]')
                .show();                       // or removeClass('d-none')
        }
    }

    // Run once on page load (useful when editing an existing listing)
    toggleBoxes();

    // Re‑run every time the user changes the sub‑category
    $subSelect.on('change', toggleBoxes);
});
</script>


<?php echo $this->endSection() ?>