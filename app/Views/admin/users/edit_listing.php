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
                         <a class="btn btn-primary" href="<?php echo admin_url() . 'providers/list-providers?page='.$page; ?>"><?php echo trans('Back'); ?></a>
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
            <?php echo $this->include('admin/includes/_messages') ?>

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="tab-form-add-user" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-profile-tab" data-toggle="pill" href="#custom-tabs-profile" role="tab" aria-controls="custom-tabs-profile" aria-selected="true"><?php echo trans('Profile') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-photos-tab" data-toggle="pill" href="#custom-tabs-photos" role="tab" aria-controls="custom-tabs-photos" aria-selected="false"><?php echo trans('Photos') ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body px-0">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                               <div class="tab-pane fade show active" id="custom-tabs-profile" role="tabpanel" aria-labelledby="custom-tabs-profile-tab">
                                <?php echo form_open_multipart('admin/providers/edit_user_post', ['id' => 'provider-form-edit', 'class' => 'custom-validation needs-validation']); ?>
                                    <input type="hidden" name="id" value="<?php echo html_escape($user_detail->id); ?>">
                                    <input type="hidden" id="crsf">

                                    <?php /*<div class="form-group mb-3 text-center">
                                        <div class="row">
                                            <div class="col-sm-12 col-profile">
                                                <center><img id="userimg" src="<?php echo get_user_avatar($user_detail->avatar); ?>" alt="" class="img-fluid rounded-circle avatar-lg img-thumbnail"> </center>
                                            </div>
                                        </div> 

                                        <div class="row mt-3">
                                            <div class="col-sm-12 col-profile">
                                                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#file_manager_image" data-bs-image-type="input" data-bs-item-id="#userimg" data-bs-input-id="#newimage_id"><i class="fa fa-image"></i><?php echo trans('change_avatar'); ?></button>
                                                <input id="newimage_id" type="hidden" class="form-control mb-3" name="newimage_id" value="">
                                            </div>
                                        </div>
                                    </div>*/ ?>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("First Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="first_name" id="first_name" class="form-control auth-form-input required" placeholder="<?php echo trans("First Name"); ?>" value="<?php echo html_escape($user_detail->first_name); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Last Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="last_name" id="last_name" class="form-control auth-form-input" placeholder="<?php echo trans("Last Name"); ?>" value="<?php echo html_escape($user_detail->last_name); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("email"); ?><span class="required"> *</span></label>
                                                <input type="email" name="email" id="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo html_escape($user_detail->email); ?>" parsley-type="email" required>
                                            </div>
                                        </div>

                                         <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Telephone Number"); ?><span class="required"> *</span></label>
                                                <input type="text" name="mobile_no" id="mobile_no" class="form-control auth-form-input" placeholder="<?php echo trans("Telephone Number"); ?>" value="<?php echo html_escape($user_detail->mobile_no); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Created Date"); ?></label>
                                                <div class="form-control"><?php echo formatted_date($user_detail->created_at,'m/d/Y h:i a'); ?></div>
                                            </div>
                                        </div>

                                         <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Last Login"); ?></label>
                                                <div class="form-control"><?php echo !empty($user_detail->last_seen) ? formatted_date($user_detail->last_seen,'m/d/Y h:i a') : '-'; ?></div>
                                            </div>
                                        </div>
									<input type="hidden" name="old_plan_id" value="<?php echo $user_detail->plan_id; ?>" />
									<?php if($user_detail->plan_id == 1){ ?>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Plan"); ?><span class="required"> *</span></label>
                                               <select name="plan_id" id="plan_id" class="form-control required" onchange="change_user_plan(this)">
                                                   <option value=""><?php echo trans('Select Plan') ?></option>
												   <option value="1" <?php echo ($user_detail->plan_id == '1') ? 'selected':''; ?>>Free</option>
                                                   <option value="2" <?php echo ($user_detail->plan_id == '2') ? 'selected':''; ?>>Standard</option>
                                                   <option value="3" <?php echo ($user_detail->plan_id == '3') ? 'selected':''; ?>>Premium</option>
                                               </select>
                                            </div>
                                        </div>
                                        <div class="col-4" id="show_premiun_date" style="display:<?php echo ($user_detail->plan_id == '1') ? 'none':''; ?>;">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Plan End Date"); ?></label>
                                               <input type="text" name="admin_plan_end_date" class="form-control" value="<?php echo ($user_detail->admin_plan_end_date != '' && $user_detail->admin_plan_end_date != NULL) ? date("m/d/Y",strtotime($user_detail->admin_plan_end_date)):''; ?>" />
                                            </div>
                                        </div>
										<?php } ?>
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Category"); ?><span class="required"> *</span></label>
                                                <select name="category_id" id="category_id" class="form-control required">
                                                    <option value=""><?php echo trans('Select') ?></option>
                                                    <?php
                                                    if(!empty($categories)){
                                                        foreach($categories as $category){ ?>
                                                            <option value="<?php echo $category->id; ?>" <?php echo ($user_detail->category_id == $category->id) ? 'selected':''; ?>><?php echo $category->name; ?></option>
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
                                                    <?php 
                                                    if(!empty($sub_categories)){
                                                        foreach($sub_categories as $sub_category){ ?>
                                                            <option value="<?php echo $sub_category->id; ?>" <?php echo (old('sub_category_id') == $sub_category->id) ? 'selected':''; ?>><?php echo $sub_category->name; ?></option>
                                                    <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Business Name (if applicable)'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="business_name" name="business_name" placeholder="<?php echo trans('Business Name(if applicable)') ?>" value="<?php echo $user_detail->business_name ?>">
                                            </div>
                                        </div> 
                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Address'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="address" name="address" placeholder="<?php echo trans('Address') ?>" value="<?php echo $user_detail->address ?>">
                                            </div>
                                        </div>  
                                              
                                         <div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Location"); ?><span class="required"> *</span></label>
                                               <select name='location_id' id="location_id" class="location required">
                                                    <option value='<?php echo $user_detail->location_id ?>'><?php echo $user_detail->city.', '.$user_detail->state_code.' '.$user_detail->zipcode ?></option>
                                                </select>
                                            </div>
                                        </div>                              
                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Referred By'); ?></label>
                                              <input class="form-control auth-form-input" type="text" id="referredby" name="referredby" placeholder="<?php echo trans('Referred By') ?>" value="<?php echo $user_detail->referredby ?>">
                                            </div>
                                        </div>  

                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Facebook Link'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="facebook_link" name="facebook_link" placeholder="<?php echo trans('Facebook Link') ?>" value="<?php echo $user_detail->facebook_link ?>">
                                            </div>
                                        </div>  

                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Insta Link'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="insta_link" name="insta_link" placeholder="<?php echo trans('Insta Link') ?>" value="<?php echo $user_detail->insta_link ?>">
                                            </div>
                                        </div>  

                                        <div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('Twitter Link'); ?></label>
                                               <input class="form-control auth-form-input" type="text" id="twitter_link" name="twitter_link" placeholder="<?php echo trans('Twitter Link') ?>" value="<?php echo $user_detail->twitter_link ?>">
                                            </div>
                                        </div>  										

										<input type="hidden" name="gender" value="Male" />
                                        <!--<div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Gender"); ?><span class="required"> *</span></label>
                                               <select name="gender" id="gender" class="form-control required">
                                                   <option value=""><?php echo trans('Gender') ?></option>
                                                   <option value="Male" <?php echo ($user_detail->gender == 'Male') ? 'selected':''; ?>>Male</option>
                                                   <option value="Female" <?php echo ($user_detail->gender == 'Female') ? 'selected':''; ?>>Female</option>
                                               </select>
                                            </div>
                                        </div> --> 
										<input type="hidden" name="licensenumber" value="123" />
                                        <!--<div class="col-4">
                                             <div class="form-group mb-3">
                                               <label><?php echo trans('License #'); ?></label>
                                              <input class="form-control auth-form-input" type="text" id="licensenumber" name="licensenumber" placeholder="<?php echo trans('License #') ?>" value="<?php echo $user_detail->licensenumber ?>">
                                            </div>
                                        </div> -->
                                        <div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Years of Experience"); ?><span class="required"> *</span></label>
                                             <input class="form-control auth-form-input required" type="text" id="experience" name="experience" placeholder="<?php echo trans('Years of Experience') ?>" value="<?php echo $user_detail->experience ?>">
                                            </div>
                                        </div>               
                                        <!--<div class="col-4 premium-plan-block" style="<?php if($user_detail->plan_id != 2){ ?>display: none;<?php }?>">-->
										<div class="col-4">
                                            <div class="form-group mb-3">
                                            <label><?php echo trans("Website"); ?></label>
                                             <input class="form-control auth-form-input" type="text" id="website" name="website" placeholder="<?php echo trans('Website') ?>" value="<?php echo $user_detail->website ?>">
                                            </div>
                                        </div>                             
                                    </div>
									
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="load_category_offering form-group mb-3">
                                                <?php                       
                                                if(!empty($offering)){ ?>
                                                    <h4 class="border-bottom pb-2 mb-3"><?php echo trans("Services"); ?>:</h4>
                                                    <div class="form-group row row-cols-1 row-cols-md-3 row-cols-xl-4 mb-3 mb-lg-5">
                                                    <?php foreach($offering as $row){ ?>
                                                        <label class="col"><input type="checkbox" <?php echo (!empty($user_detail->offering) && $user_detail->offering != 'null' && is_array(json_decode($user_detail->offering,true)) && in_array($row->id, json_decode($user_detail->offering,true))) ? 'checked':''; ?> name="offering[]" value="<?php echo $row->id; ?>"><?php echo $row->name; ?></label>
                                                    <?php } ?>
                                                    </div>
                                                <?php } ?>
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
                                                            <label class="col"><input type="radio" <?php echo (!empty($user_detail->clientele) && is_array(json_decode($user_detail->clientele,true)) && in_array($clientele->id, json_decode($user_detail->clientele,true))) ? 'checked':''; ?> name="clientele[]" value="<?php echo $clientele->id; ?>"><?php echo $clientele->name; ?></label>
                                                    <?php }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="load_categories_skills form-group mb-3">
                                                <?php                       
                                                if(!empty($categories_skills)){ ?>
                                                    <h4 class="border-bottom pb-2 mb-3"><?php echo $user_detail->skill_name ?>:</h4>
                                                    <div class="form-group row row-cols-1 row-cols-md-3 row-cols-xl-4 mb-3 mb-lg-5">
                                                    <?php foreach($categories_skills as $row){ ?>
                                                        <label class="col"><input type="checkbox" <?php echo (!empty($user_detail->categories_skills) && $user_detail->categories_skills != 'null' && is_array(json_decode($user_detail->categories_skills,true)) && in_array($row->id, json_decode($user_detail->categories_skills,true))) ? 'checked':''; ?> name="categories_skills[]" value="<?php echo $row->id; ?>"><?php echo $row->name; ?></label>
                                                    <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>                                    
                                    </div>
                                    <!-- PREMIUM START -->
                                    <?php //if($user_detail->plan_id == 2){ ?>
                                    <!--<div class="premium-plan-block" style="<?php if($user_detail->plan_id != 2){ ?>display: none;<?php }?>">-->
                                      <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">                     
                                                <h4 class="border-bottom pb-2 mb-3"><?php echo trans('Rates') ?></h4>
                                                <div class="form-group mb-3 mb-lg-5">
                                                    <div class='panel rates text-center'>
                                                        <?php 
                                                        $durations = array('m'=>'Minute '.$user_detail->rate_type, 'h'=>'Hour '.$user_detail->rate_type);
                                                        if(!empty($rate_details)){
                                                            foreach($rate_details as $row){
                                                            echo "<div class='d-flex rate gap-2 gap-sm-4'>
                                                                        <div class='col'>
                                                                            <input type='number' class='form-control' name='price[]' data-a-sign='$' data-v-max='99999999' data-v-min='0' data-m-dec='2' placeholder='59.99 per' value='".$row->price."'>
                                                                        </div>
                                                                        <div class='col'>
                                                                            <input type='text' class='onlyNum form-control' placerholder='60' value='".$row->duration_amount."' name='duration_amount[]'>
                                                                        </div>
                                                                        <div class='col'>
                                                                            <select name='duration[]' class='form-control'>";
                                                                            foreach($durations as $k=>$v){
                                                                                echo "<option value='$k'";
                                                                                if($k == $row->duration){
                                                                                    echo " selected='selected'";
                                                                                }
                                                                                echo ">$v</option>";
                                                                            }
                                                                        echo "</select>
                                                                        </div>
                                                                        <a href='javascript:void(0)' class='button tiny alert removeRate p-2'><i class='fas fa-trash'></i></a>
                                                                </div>";
                                                            }
                                                        } ?>
                                                        <a href="javascript:void(0)" class='addRate btn yellowbtn mb-3' data-rate-type='<?php echo $user_detail->rate_type; ?>'>Add Rate</a>
                                                        <div class='text-sm'>Rates will automatically be ordered by price, ascending</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>

                                  <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <h4 class="border-bottom pb-2 mb-3"><?php echo trans("About Me/Us"); ?></h4>
                                            <script src="<?php echo base_url('assets/ckeditor/build/ckeditor.js'); ?>"></script>
                                            <textarea class="form-control text-area" name="about_me" id="editor" placeholder="<?php echo trans('content'); ?>"><?php echo html_escape($user_detail->about_me); ?></textarea>

                                            <script>                        
                                                ClassicEditor
                                                    .create(document.querySelector('#editor'), {
                                                        // CKEditor 5 configuration options
                                                        removePlugins: [ 'MediaEmbed' ],
                                                        simpleUpload: {
                                                            uploadUrl: "<?php echo base_url('fileupload.php?uploadpath=userimages/'.$user_detail->id.'&CKEditorFuncNum=') ?>"
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
                                            <h4 class="border-bottom pb-2 mb-3"><?php echo trans("Hours Of Operation"); ?><span class="required"> *</span></h4>
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
                                                $opat = (!empty($hoo[$i]['opens_at']) && empty($hoo[$i]['closed_all_day'])) ? date('g:ia', strtotime($hoo[$i]['opens_at'])) : '';
                                                $clat = (!empty($hoo[$i]['closes_at']) && empty($hoo[$i]['closed_all_day'])) ? date('g:ia', strtotime($hoo[$i]['closes_at'])) : '';
                                                $disp = "";
                                                if(!empty($hoo[$i]['closed_all_day'])){
                                                    $disp = "none";
                                                }
												
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
                                                        if(!empty($hoo[$i]['closed_all_day'])){
                                                            echo " checked='checked'";
                                                        }
                                                        echo " name='hoo_".$i."_a'> Unavailable </label>
                                                    </div>
                                                </div>";
                                            } ?>
                                        </div>                                    
                                    </div>
                                  </div>
                              <!--</div>--><!-- premium-plan-block -->
                                    <?php //} ?><!-- PREMIUM END -->                                    

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                            <h4 class="border-bottom pb-2 mb-3"><?php echo trans("A Little About Me"); ?></h4>
											<div class="form-section row row-cols-1 row-cols-md-2">
												<div class="form-group pr-2">
													<label>Why Did I Become A Plane Broker?</label>
													<textarea class="form-control" name="question1"><?php echo $user_detail->question1; ?></textarea>
												</div>
												<div class="form-group">							
														<label>What Kind Of Pets Do I Have And What Are Their Names?</label>
														<textarea class="form-control" name="question2"><?php echo $user_detail->question2; ?></textarea>
												</div>
											</div>
						
                                            </div>
                                        </div>                                    
                                    </div>
									
									
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_password"); ?> (Leave Blank to Keep the Same)</label>
                                                <input type="password" name="password" id="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                             <div class="form-group mb-3">
                                                <label><?php echo trans("form_confirm_password"); ?></label>
                                                <input type="password" name="password_confirm" id="password_confirm" class="form-control form-input" value="" placeholder="<?php echo trans("form_confirm_password"); ?>" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                        </div>
                                        <div class="col-6" style="display: none">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("role"); ?><span class="required"> *</span></label>
                                                <select id="role" name="role" class="form-control select2" required>
                                                    <option value=""><?php echo trans("select"); ?> </option>
                                                    <?php foreach ($roles as $role) : ?>
                                                        <option value="<?php echo $role->id; ?>" <?php echo ($user_detail->role == $role->id) ? 'selected' : '' ?>><?php echo $role->role_name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
									<?php
									if(!empty($dynamic_fields)){
										$dynamic_fields_values = json_decode($user_detail->dynamic_fields,true);
										
										echo '<div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                            <h4 class="border-bottom pb-2 mb-3">Dynamic Fields</h4>
											<div class="form-section row row-cols-1 row-cols-md-2">';
										foreach($dynamic_fields as $field){
											echo '<div class="form-group mb-3 pr-2 d_fields" data-category="'.$field->category_ids.'" data-subcategory="'.$field->subcategory_ids.'">
													<label>'.$field->name.'</label>';
													if($field->field_type == 'Text'){
														echo '<input type="text" name="dynamic_fields['.$field->name.']" class="form-control" placeholder="'.$field->name.'" value="'. (!empty($dynamic_fields_values[$field->name]) ? $dynamic_fields_values[$field->name] : '').'">';
													}else if($field->field_type == 'Number'){
														echo '<input type="number" name="dynamic_fields['.$field->name.']" class="form-control" placeholder="'.$field->name.'" value="'. (!empty($dynamic_fields_values[$field->name]) ? $dynamic_fields_values[$field->name] : '').'">';
													}else if($field->field_type == 'Textarea'){
														echo '<textarea name="dynamic_fields['.$field->name.']" class="form-control" placeholder="'.$field->name.'">'. (!empty($dynamic_fields_values[$field->name]) ? $dynamic_fields_values[$field->name] : '').'</textarea>';
													}else if($field->field_type == 'Checkbox'){
														$decoded_option = !empty($field->field_options) ? json_decode($field->field_options) : array();
														if (!empty($decoded_option) && count($decoded_option) > 0) {
															echo '<div class="row">';
															foreach($decoded_option as $oi => $option){
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex align-items-center"><input type="checkbox" name="dynamic_fields['.$field->name.'][]" id="status_'.$oi.'" class="form-control" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && in_array($option, $dynamic_fields_values[$field->name]) ) ? 'checked' : '').'><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
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
																echo '<div class="col-sm-4 col-xs-12 col-option d-flex align-items-center"><input type="radio" name="dynamic_fields['.$field->name.']" id="status_'.$oi.'" class="form-control" placeholder="" value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && $option== $dynamic_fields_values[$field->name]) ? 'checked' : '').'><label for="status_'.$oi.'" class="option-label">'.$option.'</label></div>';
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
																echo '<option value="'.$option.'" '. ((!empty($dynamic_fields_values[$field->name]) && ($option == $dynamic_fields_values[$field->name]) ) ? 'selected' : '').'>'.$option.'</option>';
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

                               <!-- </div> -->
                                <?php echo form_close(); ?>
                                </div> <!-- PROFILE TAB END -->
                                <div class="tab-pane fade" id="custom-tabs-photos" role="tabpanel" aria-labelledby="custom-tabs-photos-tab">
                                   <div class='row'>
                                    <div class='col <?php if(!empty($user_photos)){ ?>col-6<?php }else{ ?>col-6<?php } ?>'>
                                        <h4 class="border-bottom">Add Photo</h4>
                                        <form action='<?php echo base_url(); ?>/admin/providers/photos' class='panel' id="photoupload" method='post' enctype='multipart/form-data'>
                                            <input type="hidden" id="crsf">
                                            <input type='file' id="userphoto" name='upload'> <input type='button' value='Upload' class='btn photoupload'>
                                            <p class="upload-loading" style="display:none">Uploading...</p>
                                            <p class="upload-loading-success text-success" style="display:none"></p>
                                            <p class="upload-loading-error text-danger" style="display:none"></p>
                                        </form>
                                    </div>
                                    
                                    <div class='col <?php if(!empty($user_photos)){ ?>col-6<?php }else{ ?>col-6<?php } ?>'>
                                        <h4 class="border-bottom">Current Photo<?php if(!empty($user_photos)){ echo 's'; } ?></h4>
                                        <div class='load-images'>
                                            <?php if(!empty($user_photos)){ ?>
											<?php if(count($user_photos) > 1){ ?>
                                            <p>(<?php echo trans('Drag and Drop to Re-Order'); ?>)</p>
											<?php } ?>
                                            <ul class="row proPhotos" id="imageListId">
                                            <?php
                                                foreach($user_photos as $row){
                                                    echo "<li class='col-4 listitemClass d-flex mb-3' id='imageNo".$row['id']."'><div class='pic'><img width='100%' height='150px' src='".base_url()."/uploads/userimages/".$user_detail->id."/".$row['file_name']."'></div><div class='trash' onclick='deletephotos(".$row['id'].")' data-id='".$row['id']."' style='cursor:pointer'><i class='fas fa-trash'></i></div></li>";
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

                               </div> <!-- PHOTOS - END -->

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

        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript">
$(document).ready(function(){
	
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
	
	$('select[name="category_id"]').trigger('change');
	
	
    $(".photoupload").on("click", function(){
        var data = {
            "check": '1',
            "id": <?php echo $user_detail->id;?>
        };
        data[csrfName] = $.cookie(csrfCookie);
        $.ajax({
            url: baseUrl +'/admin/providers/photos_post',
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function(response){
                if(response == '2'){
                    $(".upload-loading-error").html('Please Upgrade your plan to upload more photos.');
                    $(".upload-loading-error").show().delay(5000).fadeOut();
                }else{
                var dataf = new FormData($("#photoupload")[0]);
                dataf[csrfName] = $.cookie(csrfCookie);
                $.ajax({
                    url: baseUrl +'/fileupload.php?uploadpath=userimages/'+<?php echo $user_detail->id;?>,
                    data: dataf,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
                    beforeSend: function(){
                        $('.upload-loading').show();
                    },
                    success: function(response){
                        $('.upload-loading').hide();
                        if(response.uploaded == 1){
                            $("#userphoto").val(null);
                             var data = {
                                "check": '2',
                                image:response.fileName,
                                "id": <?php echo $user_detail->id;?>
                            };
                            data[csrfName] = $.cookie(csrfCookie);
                            $.ajax({
                                url: baseUrl +'/admin/providers/photos_post',
                                data: data,
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
                                }
                            })                      
                            $(".upload-loading-success").html('Uploaded Successfully!');
                            $(".upload-loading-success").show().delay(5000).fadeOut();
                        }else{
                            $(".upload-loading-error").html(response.error);
                            $(".upload-loading-error").show().delay(5000).fadeOut();
                        }
                    }
                })
            }                   
            }
        })
        
    });    
});

function deletephotos(photo_id){    
    Swal.fire({
        text: "Are you sure you want to delete this photo?",
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: sweetalert_ok,
        cancelButtonText: sweetalert_cancel,

    }).then(function (response) {
        if (response.value) {
            var data = {
                "photo_id": photo_id,
                "id": <?php echo $user_detail->id;?>
            };
            data[csrfName] = $.cookie(csrfCookie);
            $.ajax({
                url: baseUrl +'/admin/providers/photos_delete',
                data: data,
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
                }
            })
        }else{
                $('#emailtemplate_id option[value=""]').prop('selected', true);
            }
        });
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

    var data = {
       "check": "3",
       ids:values,
       "id": <?php echo $user_detail->id;?>
    };
    data[csrfName] = $.cookie(csrfCookie);

    $.ajax({
        url: baseUrl +'/admin/providers/photos_post',
        data: data,
        type: 'POST',
        dataType: 'HTML',
        success: function(response){
                                                    
        }
    })
}

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