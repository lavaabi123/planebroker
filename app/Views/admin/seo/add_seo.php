<?php echo $this->extend('admin/includes/_layout_view') ?> 

<?php echo $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>seo"><?php echo trans('SEO') ?></a></li>
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
            <?php echo form_open_multipart('admin/seo/add_seo_post', ['id' => 'form',  'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
            <input type="hidden" id="crsf">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class=" ml-0"><?php echo trans("Page"); ?><span class="required"> *</span></label>  
										<select name="page_name" class="form-control" required>
										<option value="">Select</option>
										<option value="Home" <?php echo (old("page_name") == "Home") ? 'selected':''; ?>>Home</option>
										<option value="About Us" <?php echo (old("page_name") == "About Us") ? 'selected':''; ?>>About Us</option>										
										<option value="Find a Broker" <?php echo (old("page_name") == "Find a Broker") ? 'selected':''; ?>>Find a Broker</option>
										<option value="FAQ" <?php echo (old("page_name") == "FAQ") ? 'selected':''; ?>>FAQ</option>
										<option value="How It Works" <?php echo (old("page_name") == "How It Works") ? 'selected':''; ?>>How It Works</option>
										<option value="Blog" <?php echo (old("page_name") == "Blog") ? 'selected':''; ?>>Blog</option>										
										<option value="BECOME  A BROKER" <?php echo (old("page_name") == "BECOME  A BROKER") ? 'selected':''; ?>>BECOME  A BROKER</option>
										<option value="Terms and Conditions" <?php echo (old("page_name") == "Terms and Conditions") ? 'selected':''; ?>>Terms and Conditions</option>
										<option value="Privacy Policy" <?php echo (old("page_name") == "Privacy Policy") ? 'selected':''; ?>>Privacy Policy</option>
										<option value="How it Works" <?php echo (old("page_name") == "How it Works") ? 'selected':''; ?>>How it Works</option>
										<option value="Contact Us" <?php echo (old("page_name") == "Contact Us") ? 'selected':''; ?>>Contact Us</option>
										<option value="Pricing" <?php echo (old("page_name") == "Pricing") ? 'selected':''; ?>>Pricing</option>	
										<option value="Testimonials" <?php echo (old("page_name") == "Testimonials") ? 'selected':''; ?>>Testimonials</option>	
										<option value="Checkout" <?php echo (old("page_name") == "Checkout") ? 'selected':''; ?>>Checkout</option>	
										<option value="Thank You" <?php echo (old("page_name") == "Thank You") ? 'selected':''; ?>>Thank You</option>	
										<option value="Forgot Password" <?php echo (old("page_name") == "Forgot Password") ? 'selected':''; ?>>Forgot Password</option>
										<option value="Login" <?php echo (old("page_name") == "Login") ? 'selected':''; ?>>Login</option>	
										<option value="Register" <?php echo (old("page_name") == "Register") ? 'selected':''; ?>>Register</option>	
										<option value="Reset Password" <?php echo (old("page_name") == "Reset Password") ? 'selected':''; ?>>Reset Password</option>
										<option value="Profile" <?php echo (old("page_name") == "Profile") ? 'selected':''; ?>>Profile</option>
										<option value="Gallery" <?php echo (old("page_name") == "Gallery") ? 'selected':''; ?>>Gallery</option>							
										</select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class=" ml-0"><?php echo trans("Meta Title"); ?><span class="required"> *</span></label>
                                        <input type="text" name="meta_title" class="form-control auth-form-input" placeholder="<?php echo trans("Meta Title"); ?>" value="<?php echo old("meta_title"); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class=" ml-0"><?php echo trans("Meta Description"); ?><span class="required"> *</span></label>
                                        <textarea name="meta_description" class="form-control auth-form-input" placeholder="<?php echo trans("Meta Description"); ?>" required><?php echo old("meta_description"); ?></textarea>
                                    </div>
                                </div>
                            </div>
							<input type="hidden" name="meta_keywords" value="<?php echo old("meta_keywords"); ?>">
                            <!--<div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class=" ml-0"><?php echo trans("Meta Keywords"); ?><span class="required"> *</span></label>
                                        <input type="text" name="meta_keywords" class="form-control auth-form-input" placeholder="<?php echo trans("Meta Keywords"); ?>" value="<?php echo old("meta_keywords"); ?>" required>
                                    </div>
                                </div>
                            </div>-->

                        <div class="form-group mb-3 float-right">
                            <button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                        </div>
                        <div class="card-footer clearfix" style="clear: both">
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
<?php echo $this->endSection() ?>