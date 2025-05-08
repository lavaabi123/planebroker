<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="front-login-box login-sec py-5">
        <!-- /.login-logo -->
        <div class="container py-md-4">
				<div class="titleSec text-center mt-0 mb-4 mb-xl-5">
					<h3 class="title-xl text-black mb-2">Reset Password</h3>
				</div>
				<div class="form-input">
                <?php echo $this->include('Common/_messages') ?>
                <?php echo form_open("providerauth/reset-password-post", ['id' => 'form_safes', 'class' => '']); ?>
                <?php echo csrf_field() ?>
                <?php if (!empty($user)) : ?>
                    <input type="hidden" name="token" value="<?php echo $user->token; ?>">
                <?php endif; ?>
                <?php if (!empty($success)) : ?>
                    <div class="form-group m-t-30 text-center">
                        <a href="<?php echo base_url('providerauth/login'); ?>" class="btn btn-primary ">Go To Login</a>
                    </div>
                <?php else : ?>
				<div class="form-section">
                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("form_password"); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" name="confirm_password" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("form_confirm_password"); ?>" required>
                    </div>

                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-lg btn-primary" type="submit"><i class="mdi mdi-login"></i> <?php echo trans("reset_password"); ?> </button>
                    </div>
                <?php endif; ?>
                <?php echo form_close(); ?>
				</div>
                <p class="mt-3 mb-1 text-center">
                    <a class="dblue" href="<?php echo base_url('providerauth/login'); ?>"><?php echo trans('login') ?></a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
<?= $this->endSection() ?>