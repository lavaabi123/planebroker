<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo !empty($meta_title) ? $meta_title : 'Find a Plane Broker Near You!'; ?></title>
    <meta name="description" content="<?php echo !empty($meta_desc) ? $meta_desc : 'At planebroker.com, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.'; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>/assets/img/favicon-v2.ico" />
    
    <meta name="keywords" content="<?php echo !empty($meta_keywords) ? $meta_keywords : 'plane broker las vegas'; ?>">
    <meta property="og:title" content="Find a Plane Broker Near You!"/>
    <meta property="og:description" content="At planebroker.com, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s."/>
    <meta property="og:image" content="<?php echo base_url(); ?>/assets/img/fmg-logo.jpg"/>
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" as="font" type="font/woff" crossorigin>-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Fonts and icons -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet"> 
    <!-- Reset CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/reset.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/style.css?version=1.12">    <!-- Responsive  CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/responsive.css">
    <!-- STYLES -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/lightbox.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/slimselect.css">
  
	<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/selectize/css/selectize.min.css" /> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/pickadate/themes/pickadate.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/cc/styles/skeuocard.reset.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/cc/styles/skeuocard.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/sweetalert2.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/frontend/js/sweetalert2.all.min.js"></script>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/croppie.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/daterangepicker/daterangepicker.css">
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
	
    <style {csp-style-nonce}>
        
    </style>
	<style>
	.ss-main .ss-single-selected {
  transition: color 0.2s ease;
}
.marquee {
	transition: opacity 250ms ease-in;
  margin: 0 auto;
  white-space: nowrap;
  overflow: hidden;
  box-sizing: border-box;
  padding-top: 0.8em;
    padding-bottom: 0.8em;
    background: #07163a;
	color:#fff;font-size: 18px;
    font-style: normal;
    font-weight: 600;
}

.marquee span {
	
  display: inline-block;
  padding-left: 10%;
  /* show the marquee just outside the paragraph */
  animation: marquee 21s linear infinite;
}

.marquee span:hover {
  /*animation-play-state: paused*/
}


/* Make it move */

@keyframes marquee {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(-101%, 0);
  }
}


/* Respect user preferences about animations */

@media (prefers-reduced-motion: reduce) {
  .marquee { 
    white-space: normal 
  }
  .marquee span {
    animation: none;
    padding-left: 0;
  }
}
	</style>
    <!-- jQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script>
        csrfName = '<?php echo csrf_token() ?>';
        csrfCookie = '<?php echo config('cookie')->prefix . config('security')->cookieName ?>';
        baseUrl = "<?php echo base_url(); ?>";
        userId = "<?php echo session()->get('vr_sess_user_id'); ?>";
    </script>
    <script src="<?php echo base_url(); ?>/assets/frontend/js/custom-frontend.js?version=1.0"></script>
    
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T7PMX5MS');</script>
<!-- End Google Tag Manager -->
</head>
<?php $uri = current_url(true);?>
<body class="hold-transition <?php echo (session()->get('vr_sess_logged_in') == TRUE) ? ' logged-in ' : ''; ?> <?php echo (base_url() == str_replace('/index.php/','',$uri)) ? 'home' : ''; ?> " >
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T7PMX5MS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <!-- HEADER: MENU + HEROE SECTION -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="bootstrap" viewBox="0 0 118 94">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
  </symbol>
  <symbol id="home" viewBox="0 0 16 16">
    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
  </symbol>
  <symbol id="speedometer2" viewBox="0 0 16 16">
    <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
    <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
  </symbol>
  <symbol id="table" viewBox="0 0 16 16">
    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/>
  </symbol>
  <symbol id="people-circle" viewBox="0 0 16 16">
    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
  </symbol>
  <symbol id="grid" viewBox="0 0 16 16">
    <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
  </symbol>
</svg>
<?php
$currentsegment = ($uri->getTotalSegments() >= (env('urlsegment')-1) && !empty($uri->getSegment(env('urlsegment')-1))) ? $uri->getSegment(env('urlsegment')-1) : ''; ?>
	<header class="sticky-top" id="header" style="display: <?php echo (!empty($from_cron)|| ($currentsegment == 'login') || $currentsegment == 'user-signup') ? 'none' : ''; ?>">
		<p class="marquee">
	   <span>
		   List your aircraft and receive a 30 Day Free Trial!
	   </span>
	   <span>
		   List your aircraft and receive a 30 Day Free Trial!
	   </span>
	   <span>
		   List your aircraft and receive a 30 Day Free Trial!
	   </span>
	   <span>
		   List your aircraft and receive a 30 Day Free Trial!
	   </span>
	   <span>
		   List your aircraft and receive a 30 Day Free Trial!
	   </span>
	   <span>
		   List your aircraft and receive a 30 Day Free Trial!
	   </span>
	   </p>

		<div class="bg-orange top-nav py-1">
		<div class="container-fluid px-xl-5 d-flex justify-content-center align-items-center">
			<?php if (session()->get('vr_sess_logged_in') != TRUE) : ?>
				<h6></h6>
			<?php else : ?>	
				<h6 class="text-white fw-bolder"><?php echo '<span>Welcome back </span>'.getFirstName(session()->get('vr_sess_user_id')); ?>!</h6>
			<?php endif; ?>
			<ul class="navbar-nav ms-sm-auto align-items-center d-flex flex-row text-white gap-4">
				<li class="nav-item"><a class="nav-link text-white" href="<?php echo base_url('user-signup'); ?>"><img src="<?= base_url('assets/img/advertise.png') ?>" alt="ads" width="20" height="20" /> Advertise</a></li>
				<?php if (session()->get('vr_sess_logged_in') != TRUE) : ?>
					<!--<li class="nav-item d-none d-sm-block"><a class="nav-link text-white" href="<?php echo base_url('user-signup'); ?>"><img src="<?= base_url('assets/img/signup.png') ?>" alt="signup" width="20" height="20" /> Sign Up</a></li>-->
					<li class="nav-item"><a class="nav-link text-white" href="<?php echo base_url('login'); ?>"><svg class="bi mx-auto" width="20" height="20"><use xlink:href="#people-circle"></use></svg> Login</a></li>
										
				<?php else : ?>					
					<li class="nav-item ms-0">
						<ol class="d-flex gap-4">
						<li class="nav-item"><a class="nav-link fs-7" href="<?php echo base_url('dashboard'); ?>"><img src="<?= base_url('assets/frontend/images/dashboard.png') ?>" alt="dashboard" width="20" /> Dashboard</a></li>
						<li class="nav-item"><a class="nav-link fs-7" href="<?php echo base_url('logout'); ?>"><svg xmlns="http://www.w3.org/2000/svg" class="ioniconswhites" width="20px" fill="#ffffff" viewBox="0 0 512 512"><path d="M258.9 48C141.92 46.42 46.42 141.92 48 258.9c1.56 112.19 92.91 203.54 205.1 205.1 117 1.6 212.48-93.9 210.88-210.88C462.44 140.91 371.09 49.56 258.9 48zm126.42 327.25a4 4 0 01-6.14-.32 124.27 124.27 0 00-32.35-29.59C321.37 329 289.11 320 256 320s-65.37 9-90.83 25.34a124.24 124.24 0 00-32.35 29.58 4 4 0 01-6.14.32A175.32 175.32 0 0180 259c-1.63-97.31 78.22-178.76 175.57-179S432 158.81 432 256a175.32 175.32 0 01-46.68 119.25z"/><path d="M256 144c-19.72 0-37.55 7.39-50.22 20.82s-19 32-17.57 51.93C191.11 256 221.52 288 256 288s64.83-32 67.79-71.24c1.48-19.74-4.8-38.14-17.68-51.82C293.39 151.44 275.59 144 256 144z"/></svg> Logout</a></li>
							
						</ol>
					</li>
				<?php endif; ?>
				<?php if (session()->get('vr_sess_logged_in') != TRUE) : ?>
				  <li class="nav-item d-block d-sm-none">
					<a class="nav-link" href="<?= base_url('/pricing') ?>">Sell Today</a>
				  </li>
				<?php endif; ?>
			</ul>
		</div>
		</div>
		<nav class="navbar navbar-expand-lg">
		<div class="container-fluid py-xl-3">
		<div class="row w-100 m-auto align-items-center justify-content-between">
		  <a class="navbar-brand col-sm-2 me-0" href="<?= base_url('/') ?>"><img class="img-fluid" title="CodeIgniter Logo" alt="Visit CodeIgniter.com official website!" src="<?= base_url('assets/img/logo.png') ?>"></a>
		  <button class="navbar-toggler burger-container" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<div id="burger">
				<div class="bar topBar"></div>
				<div class="bar btmBar"></div>
			  </div>
		  </button>
		  <div class="collapse navbar-collapse col-sm-10" id="navbarCollapse">
			<ul class="navbar-nav ms-auto mb-2 mb-md-0 align-items-center flex-wrap-reverse justify-content-end">
			  <li class="nav-item">
				<a class="nav-link <?php echo (base_url() == str_replace('/index.php/','',$uri)) ? 'active' :''; ?>" aria-current="page" href="<?= base_url('/') ?>">Home</a>
			  </li>
			  <?php 
			  $categories_all = getAllCategories();
			  if(!empty($categories_all)){ foreach($categories_all as $cat_u){
			  ?>
			  <li class="nav-item">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')) == $cat_u->permalink) ? 'active' :''; ?>" href="<?= base_url('/listings/'.$cat_u->permalink) ?>"><?= $cat_u->name ?></a>
			  </li>
			  <?php } } ?>
			  <!--<li class="nav-item">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')) == 'aircraft-services') ? 'active' :''; ?>" href="<?= base_url('/listings/aircraft-services') ?>">Aircraft Services</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')) == 'accessories') ? 'active' :''; ?>" href="<?= base_url('/listings/accessories') ?>">Accessories</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')) == 'real-estate') ? 'active' :''; ?>" href="<?= base_url('/listings/real-estate') ?>">Real Estate</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'wanted') ? 'active' :''; ?>" href="<?= base_url('/about-us') ?>">Wanted</a>
			  </li>-->
			  <li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					Education
				  </a>
				  <ul class="dropdown-menu">
					<li><a class="dropdown-item <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'blog') ? 'active' :''; ?>" href="<?= base_url('/blog') ?>">Articles</a></li>
					<li><a class="dropdown-item <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'videos') ? 'active' :''; ?>" href="<?= base_url('/videos') ?>">Videos</a></li>
					<li><a class="dropdown-item <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'faq') ? 'active' :''; ?>" href="<?= base_url('/faq') ?>">FAQs</a></li>
					<li><a class="dropdown-item <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'news') ? 'active' :''; ?>" href="<?= base_url('/news') ?>">News & Trends</a></li>
				  </ul>
				</li>
			  <li class="nav-item">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'about-us') ? 'active' :''; ?>" href="<?= base_url('/about-us') ?>">About Us</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'contact') ? 'active' :''; ?>" href="<?= base_url('/contact') ?>">Contact Us</a>
			  </li>
			  <li class="nav-item mrev-order d-sm-none">
				<a class="nav-link <?php echo ($uri->getTotalSegments() >= env('urlsegment')-1 && $uri->getSegment(env('urlsegment')-1) == 'pricing') ? 'active' :''; ?>" href="<?= base_url('/pricing') ?>">Sell Today</a>
			  </li>
			  <li class="nav-item d-block d-sm-none">
				<?php if (session()->get('vr_sess_logged_in') != TRUE) : ?>
				<a class="nav-link" href="<?= base_url('login') ?>"><svg class="me-1" style="fill:#000000a6;align-items: center;" width="20" height="20"><use xlink:href="#people-circle"></use></svg>Login</a>
				<?php else : ?>	
				<?php endif; ?>
			  </li>
			  <!--<li class="nav-item">
				<a class="nav-link" href="<?= base_url('/pricing') ?>">Pricing</a>
			  </li>	-->		  			  
			  

			<?php if (session()->get('vr_sess_logged_in') != TRUE) : ?>
			  <li class="nav-item d-none d-sm-block">
				<a class="btn bg-orange" href="<?php echo base_url('pricing'); ?>">SELL MY AIRCRAFT</a>
			  </li>
			  <?php else : ?>
				<!--<li class="nav-item d-none d-sm-block">			  
				<a class="btn bg-orange" href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
				</li>-->
			<?php endif; ?>
				
			  <?php 
			  if (session()->get('vr_sess_logged_in') == TRUE){
				 ?>
			  <li class="nav-item">
				<a class="btn yellowbtn " href="<?php echo (getUserLevel(session()->get('vr_sess_user_id')) == 1) ? base_url('add-listing') : base_url('plan'); ?>">SELL MY AIRCRAFT</a>
			  </li>
			  <?php  } ?>
			  
			  
			</ul>
		  </div>
		  </div>
		</div>
	  </nav>    
  </header>    
    <!-- CONTENT -->
    <?= $this->renderSection('content') ?>
    <footer style="display: <?php echo (!empty($from_cron)|| ($currentsegment == 'login')|| $currentsegment == 'user-signup') ? 'none' : ''; ?>">
<?php
if( base_url() == str_replace('/index.php/','',$uri) || ($currentsegment == 'listings' && empty($uri->getSegment(env('urlsegment')+1))) || ($currentsegment == 'videos') || ($currentsegment == 'faq') || ($currentsegment == 'news')){ 
$blogs = get_all_blog(0); ?>		
<div class="blog text-center py-5 px-3 px-xl-5 bg-gray">
<?php if($currentsegment == 'listings' && !empty($category_detail) && !empty($category_detail->id)){ ?>
	<?php
	$get_image = get_ad($category_detail->id,'Left');
	if(!empty($get_image)){
		echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img class="d-none d-md-block" src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
	}else{
		$get_image = get_ad('Home','Left');
		if(!empty($get_image)){
			echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img class="d-none d-md-block" src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
		}else{
			echo '<img class="d-none d-md-block" src="'. base_url('assets/frontend/images/ads-vertical.jpg').'">';
		}
	}
	?>
	
<?php }else{ ?>

	<?php
	$get_image = get_ad('Home','Left');
	if(!empty($get_image)){
		echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img class="d-none d-md-block" src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
	}else{
		echo '<img class="d-none d-md-block" src="'. base_url('assets/frontend/images/ads-vertical.jpg').'">';
	}
	?>
	
	
<?php } ?>
	<div class="container blogs px-3 px-xl-5">

		<h3 class="d-blue fw-bold mb-3">Resource Articles</h3>
		<p>Get practical tips and insights on buying, selling, and maintaining aircraft, all in one place.</p>

		<div class="owl-carousel blog-carousel owl-theme my-3 my-xxl-5"  id="blog">
		<?php  foreach($blogs as $blog){ ?>		
			<div class="col item">
				<div class="bg-white mb-3" style="position:relative;">
					<div class="mb-1 mb-md-3 w-100">
						<a href="<?php echo  base_url('blog_detail/'.$blog['clean_url']); ?>"><img src="<?php echo !empty($blog['image']) ? base_url().'/uploads/blog/'.$blog['image'] : base_url().'/assets/img/user.png'; ?>" class="d-block w-100" alt="..."></a>
					</div>
					<a href="<?php echo  base_url('blog_detail/'.$blog['clean_url']); ?>"><h6 class="black title-sm px-3 pb-4"><?php echo $blog['name']; ?></h6></a>
				</div>
			</div>
		<?php } ?>

		</div>
		<a href="<?php echo base_url('/blog'); ?>" class="btn py-xl-3 px-xxl-5">View All Articles</a>
	</div>
	<?php if($currentsegment == 'listings' && !empty($category_detail) && !empty($category_detail->id)){ ?>
	<?php
	$get_image = get_ad($category_detail->id,'Right');
	if(!empty($get_image)){
		echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img class="d-none d-md-block" src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
	}else {
		$get_image = get_ad('Home','Right');
		if(!empty($get_image)){
			echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img class="d-none d-md-block" src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
		}else{
			echo '<img class="d-none d-md-block" src="'. base_url('assets/frontend/images/ads-vertical.jpg').'">';
		}
	}
	?>
	
	<?php }else{ ?>
	<?php
	$get_image = get_ad('Home','Right');
	if(!empty($get_image)){
		echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img class="d-none d-md-block" src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
	}else{
		echo '<img class="d-none d-md-block" src="'. base_url('assets/frontend/images/ads-vertical.jpg').'">';
	}
	}
	?>	
	
	</div>
	<div class="bg-gray pb-5 text-center">	
	<?php if($currentsegment == 'listings' && !empty($category_detail) && !empty($category_detail->id)){ ?>
	<?php
	$get_image = get_ad($category_detail->id,'Bottom');
	if(!empty($get_image)){
		echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img class="" src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
	}
	?>
	
	<?php }else{ ?>	
	<?php
	$get_image = get_ad('Home','Bottom');
	if(!empty($get_image)){
		echo '<a class="ad_link_click" onclick="update_ad_click_count('.$get_image['id'].')" href="'.$get_image['ad_link'].'" target="_blank"><img src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
	}
	}
	?>	
	</div>
<?php } ?>
		<div class="container py-5 py-sm-5 text-center">
			<img width="400" title="CodeIgniter Logo" alt="Visit CodeIgniter.com official website!" src="<?= base_url('assets/img/flogo.png') ?>">
			<ul class="unstyled-list d-flex align-items-center justify-content-center gap-3 my-4 my-md-5">
				<li><a href="<?= base_url('/terms') ?>">Terms and Conditions</a></li> |
				<li><a href="<?= base_url('/privacy') ?>">Privacy Policy</a></li> |
				<!--<li><a href="<?= base_url('/how-it-works') ?>">How it Works</a></li> |-->
				<li><a href="<?= base_url('/blog') ?>">Blog</a></li> |
				<li><a href="<?= base_url('/contact') ?>">Contact Us</a></li>
			</ul>
			<div class="social-media">			
			<?php if (!empty(get_general_settings()->facebook_url) && get_general_settings()->facebook_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->facebook_url); ?>" target="_blank">	
				<img src="<?php echo base_url('assets/img/fb.png'); ?>" />	
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->twitter_url) && get_general_settings()->twitter_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->twitter_url); ?>" target="_blank">							
				<img src="<?php echo base_url('assets/img/twitter.png'); ?>" />	
			</a>
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->pinterest_url) && get_general_settings()->pinterest_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->pinterest_url); ?>" target="_blank">
				<img src="<?php echo base_url(); ?>assets/images/social-icons/pinterest.png" alt="" style="width: 28px; height: 28px;" />
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->instagram_url) && get_general_settings()->instagram_url != '#') : ?>
			<a href="<?php echo html_escape(get_general_settings()->instagram_url); ?>" target="_blank">
				<img src="<?php echo base_url('assets/img/insta.png'); ?>" />	
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->linkedin_url) && get_general_settings()->linkedin_url != '#') : ?>
			<a href="<?php echo html_escape(get_general_settings()->linkedin_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
				<img src="<?php echo base_url(); ?>assets/images/social-icons/linkedin.png" alt="" style="width: 28px; height: 28px;" />
			</a>
			<?php endif; ?>
			<?php if (!empty(get_general_settings()->vk_url) && get_general_settings()->vk_url != '#') : ?>
			<a href="<?php echo html_escape(get_general_settings()->vk_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
				<img src="<?php echo base_url(); ?>assets/images/social-icons/vk.png" alt="" style="width: 28px; height: 28px;" />
			</a>					
			<?php endif; ?>					
			<?php if (!empty(get_general_settings()->youtube_url) && get_general_settings()->youtube_url != '#') : ?>						
			<a href="<?php echo html_escape(get_general_settings()->youtube_url); ?>" target="_blank">
				<img src="<?php echo base_url('assets/img/youtube.png'); ?>" />					
			</a>						
			<?php endif; ?>	

				
			</div>
		</div>
    </footer>
	<div class="footer2 text-center text-sm-start" style="display: <?php echo (!empty($from_cron)|| ($currentsegment == 'login') || $currentsegment == 'user-signup') ? 'none' : ''; ?>">
		<div class="container py-3 d-flex justify-content-between flex-column flex-sm-row">
			<p class="mb-0">Copyright &copy; <?= date('Y') ?> Plane Broker, All rights Reserved</p>
			<p class="mb-0">Designed and Developed by: <a href="https://royalinkdesign.com/" target="_blank">Royal Ink</a></p>
		</div>
	</div>
<style>

/* Cookie Dialog */
#gdpr-cookie-message {
    position: fixed;
    left: 10px;
    bottom: 30px;
    max-width: 375px;
    background-color: #181719e3;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 6px 6px rgba(0,0,0,0.25);
    font-family: system-ui;
    z-index: 999;
}
#gdpr-cookie-message h4 {
    color: #ff6c00;
    font-family: 'Quicksand', sans-serif;
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 10px;
}
#gdpr-cookie-message h5 {
    color: #ff6c00;
    font-family: 'Quicksand', sans-serif;
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 10px;
}
#gdpr-cookie-message p, #gdpr-cookie-message ul {
    color: white;
    font-size: 15px;
    line-height: 1.5em;
}
#gdpr-cookie-message p:last-child {
    margin-bottom: 0;
    text-align: right;
}
#gdpr-cookie-message li {
    width: 49%;
    display: inline-block;
}
#gdpr-cookie-message a {
    color: #ff6c00;
    text-decoration: none;
    font-size: 15px;
    padding-bottom: 2px;
    border-bottom: 1px dotted rgba(255,255,255,0.75);
    transition: all 0.3s ease-in;
}
#gdpr-cookie-message a:hover {
    color: white;
    border-bottom-color: #ff6c00;
    transition: all 0.3s ease-in;
}
#gdpr-cookie-message button,
button#ihavecookiesBtn {
    border: none;
    background: #ff6c00;
    color: white;
    font-family: 'Quicksand', sans-serif;
    font-size: 15px;
    padding: 7px;
    border-radius: 3px;
    margin-left: 15px;
    cursor: pointer;
    transition: all 0.3s ease-in;
}
#gdpr-cookie-message button:hover {
    background: white;
    color: #ff6c00;
    transition: all 0.3s ease-in;
}
button#gdpr-cookie-advanced {
    background: white;
    color: #ff6c00;
}
#gdpr-cookie-message button:disabled {
    opacity: 0.3;
}
#gdpr-cookie-message input[type="checkbox"] {
    float: none;
    margin-top: 0;
    margin-right: 5px;
}
.logoSwiper .swiper-wrapper {
  pointer-events: auto;
  animation-play-state: running !important;
}

.logoSwiper:active .swiper-wrapper,
.logoSwiper:focus .swiper-wrapper {
  animation-play-state: running !important;
}
.logoSwiper {
  pointer-events: none;
}
.swiper-slide * {
  pointer-events: auto;
}
.dbContent.subspage label,.dbContent.billingpage label{
	display:block;
	margin-left:0;
}
</style>
	<!-- jquery latest version -->
	<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.min.js"></script>
	<!-- popper.min.js -->
	<script src="<?php echo base_url(); ?>/assets/frontend/js/popper.min.js"></script>    
	<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.min.js"></script>
	<!-- jquery.steps js -->
	<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js'></script>
	<script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.steps.js"></script>
	<!--<script type='text/javascript' src='<?php echo base_url(); ?>/assets/selectize/js/standalone/selectize.min.js'></script> -->
	<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.time.js'></script>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/jquery-confirm/jquery-confirm.min.css">
	<script src="<?php echo base_url();?>/assets/jquery-confirm/jquery-confirm.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<?php if($uri->getTotalSegments() >= env('urlsegment')-1 && ($uri->getSegment(env('urlsegment')-1) == 'checkout'  || $uri->getSegment(env('urlsegment')-1) == 'update-card'  || $uri->getSegment(env('urlsegment')-1) == 'billing')) { ?>
	<script src="<?php echo base_url();?>/assets/cc/javascripts/skeuocard.js"></script>
	<script src='<?php echo base_url();?>/assets/cc/javascripts/vendor/cssua.min.js'></script>
	<?php } ?>
	<script src="<?php echo base_url(); ?>/assets/frontend/js/provider.js?version=1.12"></script>
	<script src="<?php echo base_url(); ?>/assets/frontend/js/lightbox.js"></script>
	
	
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.js"></script>
    <script src="<?php echo base_url(); ?>/assets/admin/plugins/chart.js/Chart.min.js"></script>
	<script src="https://www.amcharts.com/lib/4/core.js"></script>
	<script src="https://www.amcharts.com/lib/4/charts.js"></script>
	<?php if($uri->getSegment(env('urlsegment')-1) == 'analytics') { ?>
    <script src="<?php echo base_url(); ?>/assets/frontend/js/analytics.js?version=1.6"></script>
	<?php }else{ ?>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/dashboard.js?version=1.3"></script>
	<?php } ?>
	<script src="<?php echo base_url(); ?>/assets/frontend/js/slimselect.js" defer></script>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>  
	<script>
	

	function showLocation(position){
		console.log(position);
		var latitude = (position.coords!== undefined) ? position.coords.latitude : '';
		var longitude = (position.coords!== undefined) ? position.coords.longitude : '';
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>'+'/providerauth/set-location',
			data:'latitude='+latitude+'&longitude='+longitude,
			success:function(msg){
				//$('#demo').html('<div id="testing" class="owl-carousel"></div>');            
				$(".owl-carousel-load").html('<div id="testing" class="owl-carousel featured-carousel">'+msg+'</div>');
				
				$(".featured-carousel").owlCarousel({
					loop:false,
					margin:10,
					nav:true,
					responsive:{
						0:{
							items:1
						},
						600:{
							items:3
						},
						1000:{
							items:4
						}
					}
				})
				/*
				$(".testimonial-carousel").owlCarousel({
					loop:true,
					margin:10,
					nav:true,
					autoplay: true,
					responsive:{
						0:{
							items:1
						},
						600:{
							items:2
						},
						1000:{
							items:3
						}
					}
				}) */
				
			
			}
		})
	}
document.addEventListener("DOMContentLoaded", function () {
  const swipers = document.querySelectorAll('.logoSwiper');

  const isMobile = window.innerWidth <= 768;
  const baseSpeed = isMobile ? 0.7 : 0.5;

  swipers.forEach((swiper) => {
    const wrapper = swiper.querySelector('.swiper-wrapper');

    // Clone all slides to ensure seamless loop
    const originalSlides = wrapper.innerHTML;
    wrapper.innerHTML += originalSlides;

    let currentX = 0;

    const isReverse = swiper.classList.contains('reverse');
    const scrollSpeed = isReverse ? baseSpeed : -baseSpeed;

    const scrollLoop = () => {
      currentX += scrollSpeed;

      // Reset logic for loop
      const resetPoint = wrapper.scrollWidth / 2;
      if (!isReverse && Math.abs(currentX) >= resetPoint) {
        currentX = 0;
      } else if (isReverse && currentX >= 0) {
        currentX = -resetPoint;
      }

      wrapper.style.transform = `translateX(${currentX}px)`;
      requestAnimationFrame(scrollLoop);
    };

    requestAnimationFrame(scrollLoop);
  });
});
		$(document).ready(function(){
			var isBrowserCompatible = 
			  $('html').hasClass('ua-ie-10') ||
			  $('html').hasClass('ua-webkit') ||
			  $('html').hasClass('ua-firefox') ||
			  $('html').hasClass('ua-opera') ||
			  $('html').hasClass('ua-chrome');

			if(isBrowserCompatible){
			  window.card = new Skeuocard($('#skeuocard'), {
				debug: false
			  });
			}
		});
	</script>
	<?php if($uri->getTotalSegments() >= (env('urlsegment')-1) && ($uri->getSegment(env('urlsegment')-1) == 'checkout' || $uri->getSegment(env('urlsegment')-1) == 'update-card'  || $uri->getSegment(env('urlsegment')-1) == 'billing')) { ?>
		<script src="https://js.stripe.com/v3/" ></script>
		<script src="<?php echo base_url(); ?>/assets/frontend/js/charge.js"></script>
	<?php } ?>
	
<script src="<?php echo base_url(); ?>/assets/frontend/js/croppie.js"></script>
	</body>
	<script>
		jQuery(window).scroll(function() {    
			var scroll = jQuery(window).scrollTop();
			if (scroll >= 1) {
				jQuery(".home #header").addClass("fixed");
			} else {
				jQuery(".home #header").removeClass("fixed");
			}
		});
		</script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/frontend/js/jquery.ihavecookies.js"></script>
    <script type="text/javascript">
    var options = {
        title: '&#x1F36A; Accept Cookies & Privacy Policy?',
        message: 'This website uses cookies to ensure you get the best experience on our website.',
        delay: 600,
        expires: 1,
        link: '<?php echo base_url(); ?>/privacy',
        onAccept: function(){
            var myPreferences = $.fn.ihavecookies.cookie();
            console.log('Yay! The following preferences were saved...');
            console.log(myPreferences);
        },
        uncheckBoxes: true,
        acceptBtnLabel: 'Accept Cookies',
        moreInfoLabel: 'More information',
        cookieTypesTitle: 'Select which cookies you want to accept',
        fixedCookieTypeLabel: 'Essential',
        fixedCookieTypeDesc: 'These are essential for the website to work correctly.'
    }

    $(document).ready(function() {
        //$('body').ihavecookies(options);

        if ($.fn.ihavecookies.preference('marketing') === true) {
            //console.log('This should run because marketing is accepted.');
        }

        $('#ihavecookiesBtn').on('click', function(){
            //$('body').ihavecookies(options, 'reinit');
        });
		<?php 
		if (session()->get('vr_sess_logged_in') == TRUE && session()->get('vr_sess_email_status') == 0) : ?>
		setInterval(function(){ 
			//code goes here that will be run every 5 seconds.
			checkLoggedIn();			
		}, 5000);
		<?php endif; ?>
    });
	function checkLoggedIn(){
		$.ajax({
			url: '<?php echo base_url(); ?>/providerauth/check-email-verified',
			type: 'POST',
			dataType: 'HTML',
			data: {},
			error: function() {
			},
			success: function(res) {
				if(res == 'success'){
					location.reload();
				}
			}
		});
	}$(document).ready(function () {
    $('select').each(function () {
      const selectElement = this;

      // Create SlimSelect instance
      const slim = new SlimSelect({
        select: selectElement,
		showSearch: true, 
		searchFocus: true,    
        onChange: function (info) {
          updateSlimColor(selectElement, info.value);
        }
      });

      // Initial color based on current value
      updateSlimColor(selectElement, selectElement.value);
    });

    // Function to color selected SlimSelect text
    function updateSlimColor(originalSelect, value) {
      const mainDiv = $(originalSelect).next('.ss-main').find('.ss-single-selected');

      if (value === '') {
        mainDiv.css('color', '#9b9b9b'); // grey for placeholder
		mainDiv.find('.placeholder').css('opacity', '0.5');
		mainDiv.find('.placeholder').css('font-weight', '300');
      } else {
        mainDiv.css('color', '#1b2e5b'); // blue for selected value
		mainDiv.find('.placeholder').css('opacity', '1');
		mainDiv.find('.placeholder').css('font-weight', '600');
      }
    }
  });

  $(document).ready(function () {
    $('#navbarCollapse').on('shown.bs.collapse', function () {
      $('header').addClass('menu-opened');
    });

    $('#navbarCollapse').on('hidden.bs.collapse', function () {
      $('header').removeClass('menu-opened');
    });
  });
  
  $(document).ready(function () {
    $('#sidemenu').on('shown.bs.collapse', function () {
      $('.leftsidecontent').addClass('smenu-opened');
    });

    $('#sidemenu').on('hidden.bs.collapse', function () {
      $('.leftsidecontent').removeClass('smenu-opened');
    });
	
	
	$(document).on('click', '.favorite-btn', function () {
		console.log('test');
		const productId = $(this).data('product-id');
		const wish = $(this).data('wish');
		var _this = $(this);
		$.ajax({
			url: '<?php echo base_url(); ?>/favorites_add',
			type: 'POST',
			data: { product_id: productId,wish:wish,current_url:'<?php echo str_replace('/index.php','',current_url()); ?>' },
			success: function (response) {
				if (response.status === 'redirect') {
					window.location.href = response.url;
				} else if (response.status === 'added') {
					_this.addClass('wishlist-added');
					_this.find('.wishtext').text('Remove from Wishlist');
					_this.data('wish',1);
					if(_this.data('page-type') != 'listing'){
					Swal.fire({
						icon: 'success',
						text: 'Added to favorites!',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true
					});
					}
				} else if (response.status === 'removed') {
					_this.removeClass('wishlist-added');
					_this.data('wish',0);
					_this.find('.wishtext').text('Wishlist');
					if(_this.data('page-type') != 'listing'){
					Swal.fire({
						icon: 'success',
						text: 'Removed from favorites!',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true
					});
					}
				}
			},
			error: function () {
				alert('Something went wrong.');
				
			}
		});
	});

  });
  $(document).ready(function () {
		if ($('.leftsidecontent').length > 0) {
			$('body').addClass('left-menu-added');
		} else {
			$('body').removeClass('left-menu-added');
		}
		
			$(".blog-carousel").owlCarousel({
					loop:false,
					margin:10,
					nav:true,
					responsive:{
						0:{
							items:1
						},
						600:{
							items:2
						},
						1000:{
							items:3
						}
					}
				})
				
	});
</script>
<!-- Add CSS & JS -->
<!-- Include DataTables + Bootstrap 5 CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function () {
  // Global custom filter that respects each table's own range + column index
  $.fn.dataTable.ext.search.push(function (settings, data) {
    const api = new $.fn.dataTable.Api(settings);
    const $wrap = $(api.table().container());

    const range = $wrap.data('range') || {};
    const dateIndex = $wrap.data('dateIndex');
    if (!dateIndex && dateIndex !== 0) return true;            // no date column configured

    if (!range.start || !range.end) return true;               // no active range

    const raw = (data[dateIndex] || '').trim();
    if (!raw) return true;

    // Parse common formats; adjust if needed
    const m = moment(raw, ['MM/DD/YYYY','YYYY-MM-DD','DD/MM/YYYY','MMM D, YYYY'], true);
    if (!m.isValid()) return true;

    const v = m.startOf('day');                                // compare in days
    return v.isSameOrAfter(range.start) && v.isSameOrBefore(range.end);
  });

  $('.substable, .billingtable, .msgtable').each(function () {
    const $table = $(this);
    const thCount = $table.find('thead th').length;

    const dt = $table.DataTable({
      order: [[0, 'asc']],
      pageLength: 5,
      lengthChange: true,
      lengthMenu: [5, 10, 25, 50, 100],
      dom: '<"d-flex justify-content-between align-items-center mb-3"l<"date-filter">f<"reset-filter ms-2">>t<"d-flex justify-content-center align-items-center mt-3"p>',
      language: {
        paginate: {
          previous: "<i class='fas fa-caret-left'></i>",
          next: "<i class='fas fa-caret-right'></i>"
        }
      },
      columnDefs: (thCount == 5) ? [{ orderable: false, targets: [4] }] : (thCount > 5) ? [{ orderable: false, targets: [5, 6] }] : [],
      drawCallback: function () {
        const api = this.api();
        const info = api.page.info();
        const $wrapper = $(api.table().container());
        $wrapper
          .find('.dataTables_paginate, .dataTables_length, .dataTables_info')
          .toggle(info.pages > 1);
      },
      initComplete: function () {
        const api = this.api();
        const $thead = $(api.table().header());
        const $wrap  = $(api.table().container());

        // Decide which column holds the date for THIS table
        // (change logic as needed)
        const dateIndex = $table.hasClass('substable') ? 2 : 0;
        $wrap.data('dateIndex', dateIndex);

        // Add sort icons to sortable headers once
        api.columns().every(function (idx) {
          const sortable = api.settings()[0].aoColumns[idx].bSortable !== false;
          const $th = $thead.find('th').eq(idx);
          if (sortable && !$th.find('.sort-icons').length) {
            $th.append(
              '<span class="sort-icons ms-1">' +
                '<i class="fas fa-sort-up sort-icon-up"></i>' +
                '<i class="fas fa-sort-down sort-icon-down"></i>' +
              '</span>'
            );
          }
        });

        // Initial paint + on every order/draw
        updateSortIcons(api);
        $(api.table().node()).on('order.dt draw.dt', function () {
          updateSortIcons(api);
        });

        // Inject date input + reset (NO duplicate IDs; scoped to this wrapper)
        $wrap.find('.date-filter').html(`
          <div class="d-flex align-items-center gap-2">
            <input type="text" class="form-control form-control-sm date-range" placeholder="Start Date - End Date">
          </div>
        `);
        $wrap.find('.reset-filter').html(`
          <button type="button" class="btn btn-sm resetFilters">Reset</button>
        `);

        // Init daterangepicker for this table's input
        const $input = $wrap.find('.date-range');
        $input.daterangepicker({
          autoUpdateInput: false,
          locale: { cancelLabel: 'Clear' }
        });

        $input.on('apply.daterangepicker', function (ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
          $wrap.data('range', {
            start: picker.startDate.clone().startOf('day'),
            end:   picker.endDate.clone().endOf('day')
          });
          dt.draw();
        });

        $input.on('cancel.daterangepicker', function () {
          $(this).val('');
          $wrap.removeData('range');
          dt.draw();
        });

        // Reset button handler for THIS table
        $wrap.on('click', '.resetFilters', function () {
          $wrap.removeData('range');
          $wrap.find('.date-range').val('');
          $wrap.find('.dataTables_filter input').val('');
          dt.search('');
          dt.columns().search('');
          dt.order([[0, 'asc']]).draw();
        });

        // Clean the default "Search:" label & set placeholder (scoped)
        const $label = $wrap.find('.dataTables_filter label');
        $label.contents().filter(function () { return this.nodeType === 3; }).remove();
        $wrap.find('.dataTables_filter input').attr('placeholder', 'Search');

        // Optional: style the length select for THIS table
        const sel = $wrap.find('.dataTables_length select')[0];
        if (sel) new SlimSelect({ select: sel });
      }
    });
  });

  function updateSortIcons(api) {
    const $thead = $(api.table().header());
    $thead.find('.sort-icon-up, .sort-icon-down').removeClass('active');

    const ord = api.order();
    if (ord.length) {
      const colIdx = ord[0][0];
      const dir = ord[0][1];
      const $th = $thead.find('th').eq(colIdx);
      (dir === 'asc' ? $th.find('.sort-icon-up') : $th.find('.sort-icon-down')).addClass('active');
    }
  }
});

function update_ad_click_count(ad_id){
	$.ajax({
		type: "GET",
		url: '<?php echo base_url(); ?>' + "/update_ad_click_count/"+ad_id,
		success: function (data) {
		}
	});
}
</script>

<style>
/* Container styling */
.dataTables_wrapper {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 35px;
}

/* Top controls (Show entries + Search) */
.dataTables_length select {
    border-radius: 0.5rem;
    padding: 0.3rem;
}

/* Search box */
.dataTables_filter input {
    border-radius: 0.5rem;
    padding: 0.3rem 0.6rem;
}

/* Table styling */
.table {
    border-radius: 1rem;
    overflow: hidden;
}
.table thead th {
    background: #001f4d;
    color: #fff;
    font-weight: 600;
}
.table tbody tr:hover {
    background: #f1f5ff;
}
.table td {
    vertical-align: middle;
}

/* Pagination */
.dataTables_paginate {
    margin-top: 1rem;
    text-align: center;
}
.dataTables_paginate .pagination {
    justify-content: center;
    gap: 0.5rem;
}
.dataTables_paginate .paginate_button.current {
    background: #ff9900 !important;
    color: #fff !important;
    border: none;
}
/* Hide default sort icons */
table.dataTable thead .sorting:before,
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_desc:before {
    opacity: 0.5 !important;	
    font-size: 10px !important;
}
table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:after, table.dataTable thead>tr>td.sorting_asc:before, table.dataTable thead>tr>td.sorting_desc:after{
	opacity: 1 !important;
}
@media (max-width:767px) {
	.dataTables_wrapper {
    border-radius: 15px;
}
}
.date-filter{
    margin-left: auto;
    max-width: 20rem;
}
</style>

<style>
.dataTables_filter,.dataTables_length{
	display:flex;
	flex-direction:column;
}
/* Remove built-in DataTables arrows */
table.dataTable thead > tr > th.sorting:before,
table.dataTable thead > tr > th.sorting:after,
table.dataTable thead > tr > th.sorting_asc:before,
table.dataTable thead > tr > th.sorting_asc:after,
table.dataTable thead > tr > th.sorting_desc:before,
table.dataTable thead > tr > th.sorting_desc:after {
    display: none !important;
}
/* Default gray arrows */
.sort-icon-up,
.sort-icon-down {
    margin-left: 4px;
    font-size: 0.7rem;
    color: #aaa;
    position: relative;
}

/* Active arrow white */
.sort-icon-up.active,
.sort-icon-down.active {
    color: #fff;
}

.sshome.ss-main .ss-content .ss-search {
    display: block !important; 
}
.ss-main .ss-content .ss-search input{
	height:auto !important;
	padding:8px 20px !important;
}
</style>

<script>
    let allCityStates = [];

    // Load JSON file
    fetch('us_states_and_cities.json')
      .then(response => response.json())
      .then(data => {
        for (let state in data) {
          data[state].forEach(city => {
            allCityStates.push(city + ", " + state);
          });
        }

        // Enable autocomplete
        $(".city-state").each(function () {
		  $(this).autocomplete({
			source: allCityStates,
			minLength: 2,
			autoFocus: true,
			appendTo: $(this).parent(), // keeps dropdown under each input
			messages: {
			  noResults: "",    // disable "No search results."
			  results: function () {}
			}
		  });
		});
      });
	  $(document).ready(function() {
		// Find all .city-state inputs and add relative positioning to their parent
		$('.city-state').each(function() {
			$(this).parent().css('position', 'relative');
		});
	});
  </script>

</html>