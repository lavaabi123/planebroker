<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="front-login-box login-sec py-5">
        <!-- /.login-logo -->
        <div class="container py-md-4">
				<div class="titleSec text-center mt-0 mb-4 mb-xl-5">
					<h3 class="title-xl text-black mb-2">Forgot Password</h3>
					<p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
				</div>

                <div class="form-input">
                <?php echo $this->include('Common/_messages') ?>
                <?php echo form_open("providerauth/forgot-password-post", ['id' => 'form_safe', 'class' => '']); ?>
                <?php echo csrf_field() ?>
                <div class="form-section">
                    <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control form-input" placeholder="Type <?php echo trans("email"); ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-lg btn-block w-100"><?php echo trans('forgot_password') ?></button>
                    </div>
                    <!-- /.col -->
                </div>
				</div>
                <?php echo form_close(); ?>
                <!--<p class="mt-3 mb-1 text-center">
                    <a class="dblue" href="<?php echo base_url() ?>/providerauth/login"><?php echo trans('login') ?></a>
                </p>-->
			</div>
        </div>
    </div>
    <!-- /.login-box -->
<?= $this->endSection() ?>