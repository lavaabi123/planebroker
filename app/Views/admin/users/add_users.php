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
<script src="<?php echo base_url(); ?>/assets/admin/js/provider.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?>
                        <a class="btn btn-primary" href="<?php echo admin_url() . 'providers/list-providers/'; ?>"><?php echo trans('Back'); ?></a>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>providers/list-providers"><?php echo trans('users') ?></a></li>
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
            <?php echo form_open_multipart('admin/providers/add_user_post', ['id' => 'provider-form',  'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <input type="hidden" id="crsf">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("First Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="first_name" id="first_name" class="form-control auth-form-input required" placeholder="<?php echo trans("First Name"); ?>" value="<?php echo old('first_name'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Last Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="last_name" id="last_name" class="form-control auth-form-input required" placeholder="<?php echo trans("Last Name"); ?>" value="<?php echo old('last_name'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("email"); ?><span class="required"> *</span></label>
                                                <input type="email" name="email" id="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo old('email'); ?>" parsley-type="email" readonly onfocus="this.removeAttribute('readonly');">
                                            </div>
                                        </div>

                                         <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Telephone Number"); ?><span class="required"> *</span></label>
                                                <input type="text" name="mobile_no" id="mobile_no" class="form-control auth-form-input" placeholder="<?php echo trans("Telephone Number"); ?>" value="<?php echo old('mobile_no'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Plan"); ?><span class="required"> *</span></label>
                                               <select name="plan_id" id="plan_id" class="form-control required" onchange="change_user_plan(this)">
                                                   <option value=""><?php echo trans('Select Plan') ?></option>
												   <option value="1" <?php echo (old('plan_id') == '1') ? 'selected':''; ?>>Free</option>
                                                   <option value="2" <?php echo (old('plan_id') == '2') ? 'selected':''; ?>>Standard</option>
                                                   <option value="3" <?php echo (old('plan_id') == '3') ? 'selected':''; ?>>Premium</option>
                                               </select>
                                            </div>
                                        </div>
                                        <div class="col-4" id="show_premiun_date" style="display:none">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Plan End Date"); ?></label>
                                               <input type="text" name="admin_plan_end_date" class="form-control" value="" />
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Category"); ?><span class="required"> *</span></label>
                                                <select name="category_id" id="category_id" class="form-control required">
                                                    <option value=""><?php echo trans('Select') ?></option>
                                                    <?php
                                                    if(!empty($categories)){
                                                        foreach($categories as $category){ ?>
                                                            <option value="<?php echo $category->id; ?>" <?php echo (old('category_id') == $category->id) ? 'selected':''; ?>><?php echo $category->name; ?></option>
                                                    <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Sub Category"); ?><span class="required"> *</span></label>
                                                <select name="sub_category_id" id="sub_category_id" onchange="change_categories_skills(this,'')" class="form-control required">
                                                    <option value=""><?php echo trans('Select') ?></option>
                                                    <?php /*
                                                    if(!empty($sub_categories)){
                                                        foreach($sub_categories as $sub_category){ ?>
                                                            <option value="<?php echo $sub_category->id; ?>" <?php echo (old('sub_category_id') == $sub_category->id) ? 'selected':''; ?>><?php echo $sub_category->name; ?></option>
                                                    <?php }
                                                    } */
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Business Name'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="business_name" name="business_name" placeholder="<?php echo trans('Business Name (if applicable)') ?>" value="<?php echo old('business_name'); ?>">
                                            </div>
                                        </div>    
                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Address'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="address" name="address" placeholder="<?php echo trans('Address') ?>" value="<?php echo old('address'); ?>">
                                            </div>
                                        </div>                                            
                                         <div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Location"); ?><span class="required"> *</span></label>
                                               <select name="location_id" id="location_id" class="location required"></select>
                                            </div>
                                        </div>                              
                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Referred By'); ?></label>
                                              <input class="form-control auth-form-input" type="text" id="referredby" name="referredby" placeholder="<?php echo trans('Referred By') ?>" value="<?php echo old('referredby'); ?>">
                                            </div>
                                        </div>     

                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Facebook Link'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="facebook_link" name="facebook_link" placeholder="<?php echo trans('Facebook Link') ?>" value="<?php echo old('facebook_link'); ?>">
                                            </div>
                                        </div>  

                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Insta Link'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="insta_link" name="insta_link" placeholder="<?php echo trans('Insta Link') ?>" value="<?php echo old('insta_link'); ?>">
                                            </div>
                                        </div>  

                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Twitter Link'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="twitter_link" name="twitter_link" placeholder="<?php echo trans('Twitter Link') ?>" value="<?php echo old('twitter_link'); ?>">
                                            </div>
                                        </div> 
										
										<input type="hidden" name="gender" value="Male" />
                                        <!--<div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Gender"); ?><span class="required"> *</span></label>
                                               <select name="gender" id="gender" class="form-control required">
                                                   <option value=""><?php echo trans('Gender') ?></option>
                                                   <option value="Male" <?php echo (old('gender') == 'Male') ? 'selected':''; ?>>Male</option>
                                                   <option value="Female" <?php echo (old('gender') == 'Female') ? 'selected':''; ?>>Female</option>
                                               </select>
                                            </div>
                                        </div> -->
									<input type="hidden" name="licensenumber" value="123" />
                                        <!--<div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('License #'); ?></label>
                                              <input class="form-control auth-form-input" type="text" id="licensenumber" name="licensenumber" placeholder="<?php echo trans('License #') ?>" value="<?php echo old('licensenumber'); ?>">
                                            </div>
                                        </div> -->
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Years of Experience"); ?><span class="required"> *</span></label>
                                             <input class="form-control auth-form-input required" type="text" id="experience" name="experience" placeholder="<?php echo trans('Years of Experience') ?>" value="<?php echo old('experience'); ?>">
                                            </div>
                                        </div>    
                                        <!--<div class="col-4 premium-plan-block" style="<?php if(old('plan_id') != 2){ ?>display: none;<?php }?>">-->
										<div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Website"); ?></label>
                                             <input class="form-control auth-form-input" type="text" id="website" name="website" placeholder="<?php echo trans('Website') ?>" value="<?php echo old('website'); ?>">
                                            </div>
                                        </div>                                
                                    </div>
									
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">                                               
                                                <input type="hidden" name="hid_category_offering" id="hid_category_offering" value="<?php echo htmlspecialchars(json_encode(old('offering')));?>">
                                               <div class="load_category_offering">
                                              </div>
                                            </div>
                                        </div>                                    
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                            <h4 class="border-bottom pb-2 mb-3"><?php echo trans("Type of Business"); ?><span class="required"> *</span></h4>
                                                <div class="form-group row row-cols-1 row-cols-md-3 row-cols-xl-4">
                                                   <?php
                                                    if(!empty($client_types)){
                                                        foreach($client_types as $clientele){ ?>
                                                            <label class="col"><input type="radio" <?php echo (!empty(old('clientele')) && is_array(old('clientele')) && in_array($clientele->id, old('clientele'))) ? 'checked':''; ?> name="clientele[]" value="<?php echo $clientele->id; ?>"><?php echo $clientele->name; ?></label>
                                                    <?php }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">                                               
                                                <input type="hidden" name="hid_categories_skills" id="hid_categories_skills" value="<?php echo htmlspecialchars(json_encode(old('categories_skills')));?>">
                                               <div class="load_categories_skills">
                                              </div>
                                            </div>
                                        </div>                                    
                                    </div>
                                    <!-- PREMIUM START -->
                                    <!--<div class="premium-plan-block" style="<?php if(old('plan_id') != 2){ ?>display: none;<?php }?>"> -->
                                      <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">                     
                                                <label><?php echo trans('Rates') ?></label>
                                                <div class="form-group mb-3 mb-lg-5">
                                                    <div class='panel rates text-center'>                  
                                                        <a href="javascript:void(0)" class='addRate btn yellowbtn mb-3' data-rate-type=''>Add Rate</a>
                                                        <div class='text-sm'>Rates will automatically be ordered by price, ascending</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>

                                  <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label><?php echo trans("About Me/Us"); ?></label>
                                            <script src="<?php echo base_url('assets/ckeditor/build/ckeditor.js'); ?>"></script>
                                            <textarea class="form-control text-area" name="about_me" id="editor" placeholder="<?php echo trans('content'); ?>"><?php echo html_escape(old('about_me')); ?></textarea>

                                            <script>                        
                                                ClassicEditor
                                                    .create(document.querySelector('#editor'), {
                                                        // CKEditor 5 configuration options
                                                        removePlugins: [ 'MediaEmbed' ],
                                                        simpleUpload: {
                                                            uploadUrl: "<?php echo base_url('fileupload.php?uploadpath=userimages/newuser&CKEditorFuncNum=') ?>"
                                                        },
                                                    })
                                                    .then(editor => {
                                                        console.log('CKEditor 5 initialized:', editor);
                                                    })
                                                    .catch(error => {
                                                        console.error('Error initializing CKEditor 5:', error);
                                                    });
                                            </script>
                                        </div>                                    
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label><?php echo trans("Hours Of Operation"); ?><span class="required"> *</span></label>
                                            <?php 
                                            $hoo = array();
                                            //print_r($hours_of_operation);exit;
                                            if(!empty($hours_of_operation)){
                                                foreach($hours_of_operation as $row){
                                                    $hoo[$row['weekday']] = $row;   
                                                }
                                            }
                                            
                                            for($i = 1; $i <= 7; $i++){
                                                $last_sunday = strtotime('last Sunday');
                                                $cur = date('l', strtotime('+'.$i.' day', $last_sunday));
                                                $opat = '';
                                                $clat = '';
                                                $disp = "";
                                                $start = "12:00 am";
												$end = "11:30 pm";
												$tStart = strtotime($start);
												$tEnd = strtotime($end);
												$tNow = $tStart;
                                                echo "
                                                <div class='hoo row align-items-center my-3'>
                                                    <div class='thick col-2'>".$cur."</div>
                                                    <div class='panel col'>
                                                        <div class='row align-items-center dayRow'>
                                                            <div class='col'>";
															echo '<select class="form-control" name="hoo_'.$i.'_o"><option value="">Select</option>';
															while($tNow <= $tEnd){
																$selected = (date("g:ia",$tNow) == $opat)? 'selected' : '';
																echo '<option '.$selected.' value="'.date("g:ia",$tNow).'">'.date("g:ia",$tNow).'</option>';
																$tNow = strtotime('+30 minutes',$tNow);
															}
															echo "</select>
                                                            </div>";
															$start = "12:00 am";
															$end = "11:30 pm";
															$tStart = strtotime($start);
															$tEnd = strtotime($end);
															$tNow = $tStart;
                                                            echo "<div class='col'>";
															echo '<select class="form-control" name="hoo_'.$i.'_c"><option value="">Select</option>';
															while($tNow <= $tEnd){
																$selected = (date("g:ia",$tNow) == $clat)? 'selected' : '';
																echo '<option '.$selected.' value="'.date("g:ia",$tNow).'">'.date("g:ia",$tNow).'</option>';
																$tNow = strtotime('+30 minutes',$tNow);
															}
															echo "</select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col'>
                                                        <label class='hoo row align-items-center my-3'><input type='checkbox' class='allDay noMarg' ";
                                                        echo " name='hoo_".$i."_a'> Unavailable </label>
                                                    </div>
                                                </div>";
                                            } ?>
                                        </div>                                    
                                    </div>
                                  </div>
                              <!--</div>--><!-- premium-plan-block -->                                  
                               
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                            <h4 class="border-bottom pb-2 mb-3"><?php echo trans("A Little About Me"); ?></h4>
											<div class="form-section row row-cols-1 row-cols-md-2">
												<div class="form-group pr-2">
													<label>Why Did I Become A Plane Broker?</label>
													<textarea class="form-control" name="question1"><?php echo old('question1'); ?></textarea>
												</div>
												<div class="form-group">							
														<label>What Kind Of Pets Do I Have And What Are Their Names?</label>
														<textarea class="form-control" name="question2"><?php echo old('question2'); ?></textarea>
												</div>
											</div>
						
                                            </div>
                                        </div>                                    
                                    </div>
									
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_password"); ?><span class="required"> *</span></label>
                                                <input type="password" name="password" id="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" value="<?php echo old("password"); ?>"  readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_confirm_password"); ?></label>
                                                <input type="password" name="password_confirm" id="password_confirm" class="form-control form-input" value="" placeholder="<?php echo trans("form_confirm_password"); ?>" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                        </div>
                                        <div class="col-6" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("role"); ?><span class="required"> *</span></label>
                                                <input type="hidden" name="role" id="role" value="2">
                                            </div>
                                        </div>
                                    </div>
									<?php
									if(!empty($dynamic_fields)){
										echo '<div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                            <h4 class="border-bottom pb-2 mb-3">Dynamic Fields</h4>
											<div class="form-section row row-cols-1 row-cols-md-2">';
										foreach($dynamic_fields as $field){
											echo '<div class="form-group mb-3 pr-2 d_fields"  data-category="'.$field->category_ids.'" data-subcategory="'.$field->subcategory_ids.'">
													<label>'.$field->name.'</label>';
													if($field->field_type == 'Text'){
														echo '<input type="text" name="dynamic_fields['.$field->name.']" class="form-control" placeholder="'.$field->name.'" value="">';
													}else if($field->field_type == 'Textarea'){
														echo '<textarea name="dynamic_fields['.$field->name.']" class="form-control" placeholder="'.$field->name.'"></textarea>';
													}else if($field->field_type == 'Checkbox'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<div class="row">';
															foreach($decoded_option as $oi => $option){
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex align-items-center"><input type="checkbox" name="dynamic_fields['.$field->name.'][]" id="status_'.$oi.'" class="form-control" placeholder="" value="'.$option.'"><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
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
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex align-items-center"><input type="radio" name="dynamic_fields['.$field->name.']" id="status_'.$oi.'" class="form-control" placeholder="" value="'.$option.'"><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
															}
															echo '</div>';																
														}else{
															echo 'Options not available';
														}
													}else if($field->field_type == 'Dropdown'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														$option_html = '';
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<select class="form-control" name="dynamic_fields['.$field->name.']"><option value="">--Select--</option>';
															foreach($decoded_option as $oi => $option){
																echo '<option value="'.$option.'">'.$option.'</option>';
															}
															echo '</select>';															
														}else{
															echo 'Options not available';
														}
													}
												echo '</div>';
										}
										echo '</div>						
                                            </div>
                                        </div>                                    
                                    </div>';
									}									
									?>
									

                                    <div class="form-group mb-3 float-right">
                                        <button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                                    </div>
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
</script>
<?php echo $this->endSection() ?>