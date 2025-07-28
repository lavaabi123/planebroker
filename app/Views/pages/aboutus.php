<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>  
<main class="pt-4 pt-sm-5">

	<div class="container">
		<div class="row">
			<div class="col-sm-6 pe-xl-4 mb-3">
				<h4 class="title-md">About Plane Broker</h4>
				<h2 class="fw-bolder mb-3 mb-md-4">We make it Easy <br>
					to find and sell <br>
					your next Aircraft!</h2>
				<p>Plane Broker is designed to simplify the aircraft sales process, for owners who are ready to list and buyers who know what they're looking for. We’ve created a platform that cuts through the noise and focuses on what matters: clear listings, flexible plans, and direct connections.</p>
				<p>Whether you're selling your first aircraft or managing multiple listings, Plane Broker gives you the tools to stay in control. Create your listing in minutes, update details as needed, and hear directly from interested buyers, without unnecessary steps or outside pressure.</p>
				<p>For buyers, it's a straightforward way to explore what's available. Listings include the key information you need to decide whether to reach out, helping you avoid the runaround.</p>
				<p>We built Plane Broker to keep things simple, reliable, and focused. No clutter. No confusion. Just a better way to buy and sell aircraft.</p>
			</div>
			<div class="col-sm-6 text-center">
				<img src="<?= base_url('assets/frontend/images/abtimg.jpg') ?>" class="img-fluid withShadow">
				<a href="<?php echo base_url('listings/aircraft-for-sale'); ?>" class="btn yellowbtn minbtn mt-5">View All Aircraft for Sale</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 my-4 my-sm-5">
		<h2 class="fw-bolder mb-3 mb-md-4">Our Mission</h2>
		<p>Our mission is to simplify the aircraft marketplace by creating a trusted, easy-to-use platform that supports real connections between buyers and sellers. We’re here to help aviation enthusiasts, owners, and professionals manage aircraft transactions with more confidence and less hassle.</p>
		</div>
		</div>
	</div>

<div class="abt-testimonial text-center">
<div class="bluebg col-md-5 py-4 py-md-5">
		<div class="owl-carousel stestimonial owl-theme"  id="stestimonial">
		     <?php if(!empty($testimonials)){foreach($testimonials as $testimonial){ ?>
		     <div class="col item">
				<div class="bg-white">
					<img src="<?= base_url('assets/frontend/images/stars.png') ?>">
					<p><?php echo $testimonial->content; ?></p>
					<h6 class="black title-sm">- <?php echo $testimonial->name; ?>.</h6>
				</div>
			</div>
		     <?php } } ?>
			<!--<div class="col item">
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
			</div>-->
		</div>
	</div>	
</div>

	<div class="container">
		<div class="row py-md-5 position-relative">
			<div class="col-sm-12 py-5">
				<div class="position-relative z-1">
				<h4 class="title-md mb-2">Have questions?</h4>
				<h2 class="fw-bolder mb-2">Visit our FAQs!</h2>
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
	<div class="container py-5">
		<h3 class="d-blue fw-bolder">Ready to get started?</h3>
		<p class="col-lg-10 mx-auto">Create your account, choose a plan, and list your aircraft in just a few steps. Whether you're here to sell or search, Plane Broker makes the process simple, direct, and built around you.</p>
		<div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-4 mt-md-5">
			<a href="<?php echo base_url('/pricing'); ?>" class="btn b-blue py-xl-3 px-xxl-5">SELL MY AIRCRAFT</a>
			<a href="<?php echo base_url('listings/aircraft-for-sale'); ?>" class="btn blue-btn py-xl-3 px-xxl-5">BUY AN AIRCRAFT</a>
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