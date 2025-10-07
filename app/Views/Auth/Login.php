<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/parsley/parsley.min.js"></script>
    <script>
        csrfName = '<?php echo csrf_token() ?>';
        csrfCookie = '<?php echo config('cookie')->prefix . config('security')->cookieName ?>';
        baseUrl = "<?php echo base_url(); ?>";
        userId = "<?php echo session()->get('admin_sess_user_id'); ?>";
    </script>
    <script src="<?php echo base_url(); ?>/assets/admin/js/custom.js"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?php echo base_url(); ?>" class="h1"><b><?php echo get_general_settings()->application_name ?></b></a>
            </div>
            <div class="card-body">

                <?php echo $this->include('Common/_messages') ?>
                <form id="form_safe" action="<?php echo base_url(); ?>/auth/login-post" method="post">
                    <?php echo csrf_field() ?>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="<?php echo trans('email') ?>" value="<?= isset($remember_admin_email) ? esc($remember_admin_email) : '' ?>"  required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>


                    <div class="input-group ">
                        <input type="password" name="password" class="form-control" value="<?= isset($remember_admin_pass) ? esc($remember_admin_pass) : '' ?>" placeholder="<?php echo trans('form_password') ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small><a href="<?php echo base_url() ?>/auth/forgot-password"><?php echo trans('forgot_password') ?></a></small>

                    <div class="row mt-4">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" <?= isset($remember_admin_email) ? 'checked' : '' ?> name="remember_me" id="remember" value="1">
                                <label for="remember">
                                    <?php echo trans("remember_me"); ?>
                                </label>
                            </div>
                        </div>

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn yellowbtn btn-block"><?php echo trans("login"); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <?php if (!empty(get_general_settings()->google_client_id) || !empty(get_general_settings()->github_client_id)) : ?>
                    <div class="social-auth-links text-center mt-2 mb-3">
                        <p class="text-muted font-16"><?php echo trans("connect-with"); ?></p>
                        <?php if (!empty(get_general_settings()->google_client_id)) : ?>
                            <a href="<?php echo base_url('auth/connect-with-google') ?>" class="btn btn-block btn-danger">
                                <i class="fab fa-google-plus mr-2"></i> Google
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(get_general_settings()->github_client_id)) : ?>
                            <a href="<?php echo base_url('auth/connect-with-github') ?>" class="btn btn-block btn-danger" style="background-color: #21262d; border-color: #21262d;">
                                <i class="fab fa-github mr-2"></i> Github
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>


               <?php /* <p class="mb-0 mt-3 text-muted">Don't have an account? <a href="<?php echo base_url(); ?>/auth/register" class="text-muted ms-1"><b><?php echo trans("register"); ?></b></a></p> */ ?>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/sweetalert2/sweetalert2.all.min.js"></script>



    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>/assets/admin/js/adminlte.min.js"></script>
	<!-- Loader Overlay -->
<div id="loaderOverlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.8); z-index:9999; text-align:center;">
  <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
    <div class="spinner-border text-warning" style="width:3rem; height:3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
    <div style="margin-top:10px; font-weight:600; color:#ff6600;">Please wait...</div>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const form = document.querySelector("form");
  const loader = document.getElementById("loaderOverlay");

  if (form) {
    form.addEventListener("submit", function(e) {
      loader.style.display = "block";
    });

    // Optional safety hide after timeout (in case something fails)
    window.addEventListener("load", function() {
      loader.style.display = "none";
    });
  }
});
</script>

</body>
<style>
.spinner-border {
  display: inline-block;
  width: 3rem;
  height: 3rem;
  border: 0.35em solid #ff6600;
  border-right-color: transparent;
  border-radius: 50%;
  animation: spinner 0.75s linear infinite;
}
@keyframes spinner {
  to { transform: rotate(360deg); }
}

.yellowbtn {
	background: #ff6c00 !important;
	color: #fff !important;
}
a {
    color: #ff6c00;
}
.card-primary.card-outline {
    border-top: 3px solid #ff6c00;
}
</style>
</html>