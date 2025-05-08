<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="front-login-box login-sec py-5">
        <?php echo $this->include('Common/_messages') ?>
        <!-- /.login-logo -->
        <div class="container py-md-4">
				<div class="titleSec text-center mt-0 mb-4 mb-xl-5">
					<h3 class="title-xl text-black mb-0">Login</h3>
				</div>
                <form id="form_safe" class="form-input" action="<?php echo base_url(); ?>/providerauth/login-post" method="post">
                    <?php echo csrf_field() ?>
					<div class="form-section">
                    <div class="form-group input-group">
                        <input type="email" name="email" class="form-control" placeholder="<?php echo trans('email') ?>" value="<?php echo old('email') ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group input-group">
                        <input type="password" name="password" class="form-control" placeholder="<?php echo trans('form_password') ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small class="d-flex justify-content-between flex-column align-items-center flex-sm-row">
						<a class="" href="<?php echo base_url() ?>/providerauth/forgot-password"><?php echo trans('forgot_password') ?></a>
						<p class="text-muted mb-0">Don't have an account? <a href="<?php echo base_url(); ?>/user-signup" class="text-muted"><?php echo trans("register"); ?></a></p>
					</small>

                    <div class="row justify-content-between flex-column align-items-center flex-sm-row mt-4">
						<div class="icheck-primary col-6">
							<input type="checkbox" name="remember_me" id="remember" value="1">
							<label for="remember">
								<?php echo trans("remember_me"); ?>
							</label>
						</div>

						<button type="submit" class="btn btn-lg btn-block py-3 col-6"><?php echo trans("Login"); ?></button>
                    </div>
					</div>
                </form>


                

            
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
<?= $this->endSection() ?>