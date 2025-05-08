<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

	<style>
	.yellowBtn {
		background: #ff9600;
		border-radius: 25px;
		font-weight: 700;
		border: none;
		padding: 12px 30px;
	}
	.yellowBtn:hover {
		background: #014a81;
	}
	.login-box, .register-box {
		width: 540px;
		font-family: "Gotham";
	}
	.login-box .card, .register-box .card {
		margin-bottom: 0;
		border-radius: 50px;
		box-shadow: none;
	}
	.login-box h4 {
		font-family: "Gotham";
    font-weight: 900;
	}
	</style>
<div class="login-page bg-gray pt-5 pb-5 pb-xl-5">
    <div class="login-box m-auto pt-5 pb-5">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary border-0">
            <div class="card-body pt-5 pb-5">
                <div class="text-center m-auto">
                    <img src="<?php echo base_url() ?>/assets/admin/img/mail_sent.svg" alt="mail sent image" height="64" />
                    <?php if (!empty($success)) : ?>
                        <h6 class="text-dark-50 text-center mt-4 fw-bold"><?php echo $success; ?><?php //echo $title; ?></h6>
                        <p class="text-muted mb-4">
                            <?php //echo $success; ?>
                        </p>
                    <?php elseif (!empty($error)) : ?>
                        <h6 class="text-dark-50 text-center mt-4 fw-bold"><?php echo $error; ?></h6>
                        <p class="text-muted mb-4">
                            <?php //echo $error; ?>
                        </p>
                    <?php endif; ?>

                </div>

                <!-- form -->
                <form action="<?php echo lang_base_url(); ?>" class="mb-3">
                    <div class="mb-0 text-center">
					<?php if($user->plan_id > 1){ ?>
						<a href="<?php echo base_url('providerauth/dashboard'); ?>"> <button class="btn btn-primary yellowbtn" type="button"><i class="mdi mdi-home me-1"></i> <?php echo trans("Go to Dashboard"); ?> </button></a>
					<?php }else{ ?>
                       <a href="<?php echo base_url('providerauth/checkout?plan_id='.$user->register_plan.'&type=trial'); ?>"> <button class="btn btn-primary yellowbtn" type="button"><i class="mdi mdi-home me-1"></i> <?php echo trans("Start Free Trial"); ?> </button></a>
					<?php } ?>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</div>

    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>/assets/admin/js/adminlte.min.js"></script>

<?= $this->endSection() ?>