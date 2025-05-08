<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>  
<div class="searchSec py-5">

	<div class="container-fluid h-100">

		<div class="row h-100">
		
			<div class="col-12 col-sm-6 pt-md-5">
				
				<img src="<?= base_url('assets/frontend/images/plane.png') ?>" width="100%">
			
			</div>

			<div class="col-12 col-sm-6 form-section mt-2 align-self-center ps-xl-5">

				<h2 class="d-blue fw-bolder">Find an aircraft</h3>

				<p class="title-sm text-white mb-4 fw-bold">We make it easy to find the perfect aircraft</p>

				<form class="form-input col-sm-10 col-lg-8 col-xxl-6" method='post' id="search-form" action='<?php echo base_url(); ?>/providers'>

					<div class="form-section">

						<div class="form-group">

							<select name='category_id' class='form-control' >

								<option value=''>All Categories</option>

								<?php if(!empty($categories_list)){

									foreach($categories_list as $row){ ?>

									<option value=<?php echo $row->permalink; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						
						<div class="form-group">

							<select name='category_id' class='form-control' >

								<option value=''>All Manufacturers</option>

								<?php if(!empty($categories_list)){

									foreach($categories_list as $row){ ?>

									<option value=<?php echo $row->permalink; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						<div class="form-group">

							<input type="text" id="keyword" placeholder="Search by Keyword"	/>

						</div>

						

						<input type='submit' value='Search' class='btn blue-btn'>

					</div>

				</form>

				

			</div>

		</div>

	</div>

</div>

<div class="process py-5">
	<div class="container-fluid px-xxl-5">
		<div class="row justify-content-center row-gap-3">
			<div class="col-sm-6 col-lg-4 d-flex align-items-center gap-3">
				<div class="circle">
					<h2 class="fw-bolder">1</h2>
				</div>
				<div class="pro-content">
					<h5 class="text-white mb-2">Create your Account</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
				</div>
			</div>
			<div class="col-sm-6 col-lg-4 d-flex align-items-center gap-3">
				<div class="circle">
					<h2 class="fw-bolder">2</h2>
				</div>
				<div class="pro-content">
					<h5 class="text-white mb-2">Choose a Plan</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
				</div>
			</div>
			<div class="col-sm-6 col-lg-4 d-flex align-items-center gap-3">
				<div class="circle">
					<h2 class="fw-bolder">3</h2>
				</div>
				<div class="pro-content">
					<h5 class="text-white mb-2">Take off!</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
				</div>
			</div>
		</div>
	</div>
</div>
			

	<?php if(!empty($featured)){ ?>
	<div class="container py-5">	
		<div class="wrapper filterResult text-center" id="demo">
			<h3 class="text-center d-blue fw-bolder mb-5">Featured Aircrafts</h3>
			<div class="owl-carousel-load"></div>
			<a href="<?php echo base_url('/providers'); ?>" class="btn mt-3 mt-sm-5">View All Featured Aircrafts</a>
		</div>
	</div>
	<?php }else{ ?>
	<div class="container mys-sm-3">
	</div>		
	<?php } ?>
	<div class="container pb-5 text-center">
		<img src="<?= base_url('assets/frontend/images/ads-hoz.jpg') ?>">
	</div>

<div class="bg-gray text-center">
	<div class="container-fluid py-5">	
			<h3 class="d-blue fw-bolder mt-xl-4 mb-5">Aircrafts for Sale</h3>
				<div class="d-grid planes">
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/JA.png') ?>">
						<h5>Jet <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/TA.png') ?>">
						<h5>Turboprop <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/PSA.png') ?>">
						<h5>Piston Single <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/PTA.png') ?>">
						<h5>Piston Twin <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/LSA.png') ?>">
						<h5>Light Sport <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/EHA.png') ?>">
						<h5>Experimental/ <br>Homebuilt Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/PA_A.png') ?>">
						<h5>Piston Agricultural <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/TA_A.png') ?>">
						<h5>Turbine Agricultural <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/PMA.png') ?>">
						<h5>Piston Military <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/TMA.png') ?>">
						<h5>Turbine Military <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/PAA.png') ?>">
						<h5>Piston Amphibious <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/TAA.png') ?>">
						<h5>Turbne Amphibious <br>Aircraft</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/PH.png') ?>">
						<h5>Piston <br>Helicopters</h5>
					</div>
					<div class="plane-list">
						<img src="<?= base_url('assets/frontend/images/planes/TH.png') ?>">
						<h5>Turbine <br>Helicopters</h5>
					</div>
				</div>
			
			<a href="<?php echo base_url('/providers'); ?>" class="btn mt-3 mt-sm-5 px-xxl-5">View All Aircrafts for Sale</a>
	</div>
</div>

<div class="abtSec py-md-5 text-center text-white">
	<div class="container py-5 px-xxl-5">
		<img src="<?= base_url('assets/frontend/images/PB.png') ?>">
		<h3 class="text-white fw-bold mt-2 mb-3">About Plane Broker</h3>
		<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, dicta sunt explicabo. Nemo enim ipsam voluptate.aspernatur aut odit aut fugit, sed quia consequuntur magni dolores.</p>
		<div class="row my-4 my-xxl-5">
			<div class="col-md-4">
				<img src="<?= base_url('assets/frontend/images/aircraft.png') ?>">
				<h6 class="text-white title-xs">Buy and Sell Aircraft with Ease</h6>
			</div>
			<div class="col-md-4">
				<img src="<?= base_url('assets/frontend/images/recycle.png') ?>">
				<h6 class="text-white title-xs">Keep your Aircraft in Top Condition</h6>
			</div>
			<div class="col-md-4">
				<img src="<?= base_url('assets/frontend/images/airpark.png') ?>">
				<h6 class="text-white title-xs">Find the right Hangar, Airpark and Strip</h6>
			</div>
		</div>
		<a href="<?php echo base_url('/providers'); ?>" class="btn py-xl-3 px-xxl-5">LEARN ABOUT US</a>
	</div>
</div>

<div class="vlogo py-md-4">
	<div class="container-fluid py-5">
		<div class="d-grid">
			<img src="<?= base_url('assets/frontend/images/logos/beechcraft.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/bombardier.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/cessna.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/cirrus.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/dassault.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/diamond.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/embraer.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/gulfstream.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/jancair.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/mooney.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/pilatus.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/piper.png') ?>">
			<img src="<?= base_url('assets/frontend/images/logos/robinson.png') ?>">
			
		</div>
	</div>
</div>

<div class="testimonial text-center py-5">

		<h3 class="d-blue fw-bolder">Client Testimonials</h3>
		<p>Read what some of our previous clients have to say!</p>

		<div class="owl-carousel testimonial-carousel owl-theme mt-5"  id="testimonial">
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
		<a href="<?php echo base_url('/testimonials'); ?>" class="btn py-xl-3 mt-3 mt-sm-5">VIEW ALL TESTIMONIALS</a>
</div>

<div class="bg-gray py-5">
	<div class="container text-center pb-5 px-lg-5">	
		<h3 class="d-blue fw-bolder mt-xl-4 mb-2">The Plane Broker Difference</h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
	</div>
	<div class="container-fluid mw-100">
		<div class="row">
			<div class="col-md-6 ps-0">
				<img src="<?= base_url('assets/frontend/images/pbd.jpg') ?>" class="coverImg">
			</div>
			<div class="col-md-6 ps-0">
				<div class="row h-100">
					<div class="col-md-4 pe-0">
						<div class="box">
							<img src="<?= base_url('assets/frontend/images/dollar.png') ?>">
							<h5 class="title-xs">Buy, Sell, and Service Your Aircraft – Simplified</h5>
							<p>Plane Broker makes it simple to manage all aspects of aircraft ownership. From buying and selling planes to finding the right parts and services, we streamline the process so you can focus on what matters most—flying.</p>
						</div>
					</div>
					<div class="col-md-4 pe-0">
						<div class="box">
							<img src="<?= base_url('assets/frontend/images/search.png') ?>">
							<h5 class="title-xs">Connect with Trusted Sellers and Service Providers</h5>
							<p>At Plane Broker, we connect you with a network of trusted aircraft sellers, brokers, service providers, and parts suppliers. Rest easy knowing you're dealing with experienced professionals who understand the aviation industry.</p>
						</div>
					</div>
					<div class="col-md-4 pe-0">
						<div class="box">
							<img src="<?= base_url('assets/frontend/images/notes.png') ?>">
							<h5 class="title-xs">Your Aircraft Resource Hub</h5>
							<p>Plane Broker is more than just a marketplace. We offer a comprehensive resource hub filled with expert insights, industry news, and educational tools to help you navigate every step of aircraft ownership, buying, and selling.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container text-center pt-5">
		<a href="<?php echo base_url('/providers'); ?>" class="btn py-xl-3 px-xxl-5">LEARN MORE</a>
	</div>
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
<?php //if(!empty($blogs)){ ?>		
<div class="blog text-center py-5 px-3 px-xl-5">

<img class="d-none d-md-block" src="<?= base_url('assets/frontend/images/ads-vertical.jpg') ?>">

	<div class="container blogs px-3 px-xl-5">

		<h3 class="d-blue fw-bold mb-3">Resource Articles</h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>

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
<img class="d-none d-md-block" src="<?= base_url('assets/frontend/images/ads-vertical.jpg') ?>">
</div>
<?php //} ?>

<script>


	$(document).ready(function(){		

		attachLocationHome();

	})

	function attachLocationHome(){

		$('select.locationhome').selectize({

			valueField: 'homesearch',

			labelField: 'zipcode',

			searchField: 'zipcode',

			create: false,

			//preload: true,

			render: {

				option: function(item, escape) {

					return '<div>'+escape(item.zipcode)+'</div>';

				}

			},

			load: function(query, callback) {
				$('#text-input').val(query);

				$.ajax({

					url: '<?php echo base_url(); ?>/providerauth/get-locations?from=home&q=' + encodeURIComponent(query),

					type: 'GET',

					error: function() {

						callback();

					},

					success: function(res) {

						res = $.parseJSON(res);

						callback(res.locations);

					}

				});

			}

		});

	}

	function provider_set_session(_this){

		var location = $(_this).attr('data-value');

		var city_state = location.split('||')[0]+', '+location.split('||')[1];

		var city_state1 = city_state.replace(', ', '-').replace(' ', '-').toLowerCase();

		window.location = '<?php echo base_url(); ?>/providers/'+city_state1;     

	}

</script>
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
				
				$(".testimonial-carousel").owlCarousel({
					loop:true,
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
			
			}
		})
	}
	})
</script>
<?= $this->endSection() ?>