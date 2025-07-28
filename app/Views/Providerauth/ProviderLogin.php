<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="front-login-box login-sec">
        <?php echo $this->include('Common/_messages') ?>
        <!-- /.login-logo -->
		
        <div class="row mx-0 align-items-stretch min-vh-100">
				<div class="col-md-6 leftSec p-5">
					<div class="mx-auto py-md-5">
					<h3 class="fw-bolder">New. Better. Modern.</h4>
					<hr/>
					<h3 class="fw-bolder">A Market Place<br/>
					for all things aviation.</h4>
					<p class="mt-3 mt-md-4 mb-3">Full dashboard for a seamless selling experience.</p>
					<img src="<?php echo base_url('assets/frontend/images/tab.png'); ?>" />
					</div>
				</div>
			
				<div class="col-md-6 rightSec p-5 py-md-2 align-self-center">
				
                <form id="form_safe" class="form-input" action="<?php echo base_url(); ?>/providerauth/login-post" method="post">
                    <?php echo csrf_field() ?>
					<div class="form-section">
						<a href="<?= base_url(); ?>"><img src="<?php echo base_url('assets/img/logo.png'); ?>" /></a>
						<h5 class="text-black mt-4 mb-2 fw-bolder">Welcome back! <span class="text-primary">Sign in</span></h5>
                    <div class="form-group input-group">
                        <input type="email" name="email" class="form-control" placeholder="<?php echo trans('email') ?>" value="<?php echo old('email') ?>" required>
                        <!--<div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>-->
                    </div>
					
					
                    <div class="form-group input-group">
                        <input type="password" name="password" class="form-control" placeholder="<?php echo trans('form_password') ?>" required>
                        <!--<div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>-->
                    </div>
					<div class="d-flex justify-content-between align-items-center">
					<div class="icheck-primary d-flex align-items-center gap-2">
						<input type="checkbox" name="remember_me" id="remember" value="1">
						<label for="remember">
							<?php echo trans("remember_me"); ?>
						</label>
					</div>
					<a class="text-decoration-underline fs-6" href="<?php echo base_url() ?>/providerauth/forgot-password"><?php echo trans('forgot_password') ?></a>
				
					</div>

						<button type="submit" class="btn py-3 col-12 my-4"><?php echo trans("Sign in"); ?></button>
						<p class="text-muted fs-6 mb-0">Don't have an account? <a href="<?php echo base_url(); ?>/user-signup" class="text-decoration-underline fs-6 text-primary"><?php echo trans("Sign up now"); ?></a></p>
					</div>
                </form>
				</div>


                

            
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
<?= $this->endSection() ?>