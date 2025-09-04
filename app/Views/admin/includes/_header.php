<!-- Navbar -->
<nav class="main-header navbar navbar-expand <?php echo check_dark_mode_enabled() ? 'navbar-dark' : 'navbar-white' ?> px-2 navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" type="button" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
		<li>
		<a href="<?php echo admin_url(); ?>" class="brand-link">
          <img src="<?php echo base_url(); ?>/assets/img/ylogo.png" alt="Plane Broker Logo" class="brand-image img-circle elevation-3">
          <span class="brand-text font-weight-light"><?php echo get_general_settings()->application_name ?></span>
		</a>
		</li>
        <li class="nav-item d-sm-inline-block" style="display: none !important">
            <span id="ct7" class="nav-link"></span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
	<?php /* Requires Bootstrap or your CSS */ ?>
	
	<div class="nav-item dropdown" id="notifDropdown">
  <a href="#" type="button"
     id="notifToggle"
     class="nav-link position-relative dropdown-toggle"
     data-toggle="dropdown"
     data-auto-close="outside"
     aria-expanded="false"
     role="button">
     <img src="<?php echo base_url(); ?>/assets/admin/img/alert.png" alt="Notifications"/>
     <span id="notifCount" class="position-absolute top-10 start-60 translate-middle badge rounded-pill bg-danger d-none"></span>
  </a>

  <div class="dropdown-menu dropdown-menu-end p-0 rounded-5"
       aria-labelledby="notifToggle"
       style="width: 380px; max-height: 70vh; overflow:auto;">
	   <div id="notifContainer">
    <div class="d-flex align-items-center justify-content-between px-3 py-2 border-bottom bg-grey position-sticky top-0 z-1">
      <strong>Notifications</strong>
      <button class="btn btn-sm btn-link" type="button" id="markAllReadBtn">Mark all as read</button>
    </div>
    <div id="notifList" class="list-group list-group-flush">
      <div class="p-3 text-muted">Loading…</div>
    </div>
	<div class="border-top p-2 position-sticky bottom-0 bg-grey">
  <a href="<?= esc(site_url('admin/notifications/all')) ?>" class="btn btn-sm btn-primary w-100">View all</a>
</div>
  </div>
  </div>
</div>


        <?php /*
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?php echo base_url(); ?>/assets/admin/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?php echo base_url(); ?>/assets/admin/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?php echo base_url(); ?>/assets/admin/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li> */ ?>
        <li class="nav-item dropdown">

            <a data-toggle="dropdown" href="#">
                <img src="<?php echo base_url().'/uploads/userimages/'.user()->id.'/'.user()->avatar; ?>" class="img-circle elevation-1 user-image" width="40px" height="40px" alt="User Image">
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                <a href="<?php echo admin_url() ?>profile" class="dropdown-item">
                    <?php echo trans('settings') ?>

                    <span class="float-right text-muted text-sm"><i class="fas fa-cog"></i></span>
                </a>
                <?php echo form_open('vr-switch-mode', ['id' => 'swith_dark_mode']); ?>
                <?php /*if (check_dark_mode_enabled() == 1) : ?>
                    <input type="hidden" name="dark_mode" value="0" />
                    <a href="javascript: void(0);" class="dropdown-item" onclick="document.getElementById('swith_dark_mode').submit();">
                        Swith Light Mode
                        <span class="float-right text-muted text-sm"><i class="fa fa-sun"></i></span>
                    </a>
                <?php else : ?>
                    <input type="hidden" name="dark_mode" value="1" />
                    <a href="javascript: void(0);" class="dropdown-item" onclick="document.getElementById('swith_dark_mode').submit();">
                        Swith Dark Mode
                        <span class="float-right text-muted text-sm"><i class="fa fa-moon"></i></span>
                    </a>
                <?php endif; */?>
                <?php echo form_close(); ?>


                <div class="dropdown-divider"></div>

                <a href="<?php echo base_url('auth/logout'); ?>" class="dropdown-item">
                    <?php echo trans('logout') ?>
                    <span class="float-right text-muted text-sm"><i class="fas fa-sign-out-alt"></i></span>
                </a>


            </div>
        </li>

    </ul>
</nav>
<!-- /.navbar -->