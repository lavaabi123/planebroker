<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>  
<main class="pt-4 pt-sm-5">

	<div class="container">
		<div class="row">
			<div class="col-sm-6 pe-xl-4">
				<h4 class="title-md">About Plane Broker</h4>
				<h2 class="fw-900 mb-3 mb-md-4">We make it Easy <br>
					to find and sell <br>
					your next Aircraft!</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
			</div>
			<div class="col-sm-6 text-center">
				<img src="<?= base_url('assets/frontend/images/abtimg.jpg') ?>" class="img-fluid withShadow">
				<a href="<?php echo base_url('providers'); ?>" class="btn yellowbtn minbtn btnWicon">View All Aircrafts for Sale</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 my-4 my-sm-5">
		<h2 class="title-xl fw-900 mb-3 mb-md-4">Our Mission</h2>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
		</div>
		</div>
	</div>

<div class="abt-testimonial text-center">
<div class="bluebg col-md-5 py-4 py-md-5">
		<div class="owl-carousel stestimonial owl-theme"  id="stestimonial">
			<div class="col item">
				<div class="bg-white">
					<img src="<?= base_url('assets/frontend/images/stars.png') ?>">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
					<h6 class="black title-sm">- Susan V.</h6>
				</div>
			</div>
			<div class="col item">
				<div class="bg-white">
					<img src="<?= base_url('assets/frontend/images/stars.png') ?>">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
					<h6 class="black title-sm">- Mary S.</h6>
				</div>
			</div>
			<div class="col item">
				<div class="bg-white">
					<img src="<?= base_url('assets/frontend/images/stars.png') ?>">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
					<h6 class="black title-sm">- Stephen M.</h6>
				</div>
			</div>
			<div class="col item">
				<div class="bg-white">
					<img src="<?= base_url('assets/frontend/images/stars.png') ?>">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
					<h6 class="black title-sm">- Stephen M.</h6>
				</div>
			</div>
			<div class="col item">
				<div class="bg-white">
					<img src="<?= base_url('assets/frontend/images/stars.png') ?>">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
					<h6 class="black title-sm">- Stephen M.</h6>
				</div>
			</div>
		</div>
	</div>	
</div>

	<div class="container">
		<div class="row py-md-5 position-relative">
			<div class="col-sm-12 py-5">
				<div class="position-relative z-1">
				<h4 class="title-md mb-2">Have questions?</h4>
				<h2 class="title-xl fw-900 mb-2">Visit our FAQs!</h2>
				<p>We’ve answered a lot of common questiions here or you can visit our <a href="<?php echo base_url('/contact'); ?>">Contact Page</a> to message us directly.</p>
				<a href="<?php echo base_url('/faq'); ?>" class="btn yellowbtn">FAQs</a>
				</div>
			</div>
		</div>
	</div>
<div class="container pb-5 text-center">
		<img src="<?= base_url('assets/frontend/images/ads-hoz.jpg') ?>">
	</div>
<div class="getstart py-md-5 text-center">
	<div class="container py-5 px-xxl-5">
		<h3 class="d-blue fw-bolder">Ready to get started?</h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
		<div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-4 mt-md-5">
			<a href="<?php echo base_url('/providers'); ?>" class="btn b-blue py-xl-3 px-xxl-5">SELL MY AIRCRAFT</a>
			<a href="<?php echo base_url('/providers'); ?>" class="btn blue-btn py-xl-3 px-xxl-5">BUY AN AIRCRAFT</a>
		</div>
	</div>
</div>

</main>	
<script>
	jQuery(document).ready(function($){
		showLocation('');
	
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showLocation);
    }


	function showLocation(position){
		console.log(position);
		var latitude = (position.coords!== undefined) ? position.coords.latitude : '';
		var longitude = (position.coords!== undefined) ? position.coords.longitude : '';
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>'+'/providerauth/set-location',
			data:'latitude='+latitude+'&longitude='+longitude,
			success:function(msg){          
				$(".owl-carousel-load").html('<div id="testing" class="owl-carousel featured-carousel">'+msg+'</div>');
				
				
				
				$(".stestimonial").owlCarousel({
					loop:true,
					margin:10,
					nav:true,
					responsive:{
						0:{
							items:1
						},
						600:{
							items:1
						},
						1000:{
							items:1
						}
					}
				})
				
			
			}
		})
	}
	})
</script>
<?= $this->endSection() ?>