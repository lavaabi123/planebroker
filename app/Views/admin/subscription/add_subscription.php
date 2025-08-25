<?php echo $this->extend('admin/includes/_layout_view') ?> 

<?php echo $this->section('content') ?>
<div class="content-wrapper bg-grey">
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
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>subscription"><?php echo trans('Subscription') ?></a></li>
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
            <?php echo form_open_multipart('admin/subscription/add_subscription_post', ['id' => 'form',  'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
            <input type="hidden" id="crsf">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                        </div>
                        <div class="card-body subscrip-center">
						
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Package Name"); ?><span class="required"> *</span></label>
										 <input type="text" name="name" class="form-control auth-form-input" placeholder="<?php echo trans("Package Name"); ?>" value="<?php echo old("name"); ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Price"); ?><span class="required"> *</span></label>
										 <input type="number" name="price" step=".01" class="form-control auth-form-input" placeholder="<?php echo trans("Price"); ?>" value="<?php echo old("price"); ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Number of Weeks Listing allowed?"); ?><span class="required"> *</span></label>
										 <input type="number" name="no_of_weeks" class="form-control auth-form-input" placeholder="<?php echo trans("No of Weeks"); ?>" value="<?php echo old("no_of_weeks"); ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Number of Photos"); ?><span class="required"> *</span></label>
										 <input type="text" name="no_of_photos" class="form-control auth-form-input" placeholder="<?php echo trans("No of Photos"); ?>" value="<?php echo old("no_of_photos"); ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Number of Videos"); ?><span class="required"> *</span></label>
										 <input type="text" name="no_of_videos" class="form-control auth-form-input" placeholder="<?php echo trans("Number of Videos"); ?>" value="<?php echo old("no_of_videos"); ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Allowed in Featured Listing?"); ?><span class="required"> *</span></label>
										<select name="is_featured_listing" class="form-control auth-form-input" required>
											<option value="0" <?php echo (old("is_featured_listing") == 1) ? 'selected':''; ?>>No</option>
											<option value="1" <?php echo (old("is_featured_listing") == 1) ? 'selected':''; ?>>Yes</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Allowed in Premium Listing?"); ?><span class="required"> *</span></label>
										<select name="is_premium_listing" class="form-control auth-form-input" required>
											<option value="0" <?php echo (old("is_premium_listing") == 1) ? 'selected':''; ?>>No</option>
											<option value="1" <?php echo (old("is_premium_listing") == 1) ? 'selected':''; ?>>Yes</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Stripe Payment ID"); ?><span class="required"> *</span></label>
										 <input type="text" name="stripe_price_id" class="form-control auth-form-input" placeholder="<?php echo trans("Stripe Payment ID"); ?>" value="<?php echo old("stripe_price_id"); ?>" required>
									</div>
								</div>
							</div>
							<!--
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Paypal Plan ID with Trial"); ?><span class="required"> *</span></label>
										 <input type="text" name="paypal_plan_id_with_trial" class="form-control auth-form-input" placeholder="<?php echo trans("Paypal Plan ID with Trial"); ?>" value="<?php echo old("paypal_plan_id_with_trial"); ?>" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label><?php echo trans("Paypal Plan ID without Trial"); ?><span class="required"> *</span></label>
										 <input type="text" name="paypal_plan_id_without_trial" class="form-control auth-form-input" placeholder="<?php echo trans("Paypal Plan ID without Trial"); ?>" value="<?php echo old("paypal_plan_id_without_trial"); ?>" required>
									</div>
								</div>
							</div>-->
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label class=""><?php echo trans("Recommended Package?"); ?><span class="required"> *</span></label>
										<select name="is_recommended" class="form-control" required>
										<option value="0" <?php echo (old("is_recommended") == 0) ? 'selected':''; ?>>No</option>
										<option value="1" <?php echo (old("is_recommended") == 1) ? 'selected':''; ?>>Yes</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group mb-3">
										<label class=""><?php echo trans("Status"); ?><span class="required"> *</span></label>
										<select name="status" class="form-control" required>
										<option value="1" <?php echo (old("status") == 1) ? 'selected':''; ?>>Active</option>
										<option value="2" <?php echo (old("status") == 2) ? 'selected':''; ?>>Inactive</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group mb-3 text-center">
								<button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
							</div>
							<div class="card-footer p-0 pt-3 clearfix" style="clear: both">
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