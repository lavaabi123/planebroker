<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="searchSec py-5">

	<div class="container-fluid h-100">

		<div class="row h-100">
		
			<div class="col-12 col-sm-6 pt-md-5">
				
				<img src="<?= base_url('assets/frontend/images/plane.png') ?>" width="100%">
			
			</div>

			<div class="col-12 col-sm-6 form-section mt-2 align-self-center ps-xl-5">

				<h2 class="d-blue fw-bolder">Find an aircraft</h3>

				<p class="title-sm text-white mb-4 fw-bold">We make it easy to find the perfect aircraft</p>

				<form class="form-input col-sm-10 col-lg-8 col-xxl-6" method='get' id="search-fornm" action='<?php echo base_url(); ?>/listings/aircraft-for-sale'>

					<div class="form-section">

						<div class="form-group">

							<select name='category' class='form-control slim-select' >

								<option value=''>All Categories</option>

								<?php if(!empty($sub_categories_list)){

									foreach($sub_categories_list as $row){ ?>

									<option value=<?php echo $row->id; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						
						<div class="form-group">

							<select name='manufacturer' class='form-control slim-select slim-grey-blue' >

								<option value=''>All Manufacturers</option>

								<?php if(!empty($manufacturers)){

									foreach($manufacturers as $row){ ?>

									<option value=<?php echo $row->name; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						<div class="form-group">

							<input type="text" name="keywords" id="keyword" placeholder="Search by Keyword"	/>

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
					<p>Get started with a simple sign-up. It only takes a minute to open the door to your next aircraft sale.</p>
				</div>
			</div>
			<div class="col-sm-6 col-lg-4 d-flex align-items-center gap-3">
				<div class="circle">
					<h2 class="fw-bolder">2</h2>
				</div>
				<div class="pro-content">
					<h5 class="text-white mb-2">Choose a Plan</h5>
					<p>Select the listing package that fits your aircraft. You’ll get everything you need to post and manage your listing.</p>
				</div>
			</div>
			<div class="col-sm-6 col-lg-4 d-flex align-items-center gap-3">
				<div class="circle">
					<h2 class="fw-bolder">3</h2>
				</div>
				<div class="pro-content">
					<h5 class="text-white mb-2">Take off!</h5>
					<p>Your listing goes live and the action begins. Start hearing from buyers and move closer to sealing the deal.</p>
				</div>
			</div>
		</div>
	</div>
</div>
			

	<?php if(!empty($featured)){ ?>
	<div class="container py-5">	
		<div class="wrapper filterResult text-center" id="demo">
			<h3 class="text-center d-blue fw-bolder mb-5">Featured Aircraft</h3>
			<div class="owl-carousel-load"></div>
			<a href="<?= base_url('listings/'.$categories_list[0]->permalink).'?featured=yes' ?>" class="btn max-btn mt-3 mt-sm-4">View All Featured Aircraft</a>
		</div>
	</div>
	<?php }else{ ?>
	<div class="container py-5">
	</div>		
	<?php } ?>
	<div class="container pb-5 text-center">
		<?php
		$get_image = get_ad('Home','Top');
		if(!empty($get_image)){
			echo '<a href="'.$get_image['ad_link'].'" onclick="update_ad_click_count('.$get_image['id'].')" class="ad_link_click" target="_blank"><img src="'. base_url('uploads/ad/'.$get_image['image'].'').'"></a>';
		}else{
			echo '<img class="d-none d-md-block" src="'. base_url('assets/frontend/images/ads-hoz.jpg').'">';
		}
		?>
	</div>

<div class="bg-gray text-center">
	<div class="container-fluid py-5">	
			<h3 class="d-blue fw-bolder mt-xl-4 mb-5">Aircraft for Sale</h3>
				<div class="d-grid planes">
				<?php if(!empty($sub_categories_list)){
					foreach($sub_categories_list as $s_cat){ ?>
					<div class="plane-list">
						<a href="<?= base_url('listings/'.$s_cat->permalink.'?category='.$s_cat->id) ?>">
						<img src="<?= base_url('uploads/subcategory/'.$s_cat->subcategory_icon) ?>">
						<h5><?= $s_cat->name ?></h5>
						</a>
					</div>
					<?php						
					}
				} ?>
					
				</div>
			
			<a href="<?= base_url('listings/'.$categories_list[0]->permalink) ?>" class="btn max-btn mt-3 mt-sm-5 px-xxl-5">View All Aircraft for Sale</a>
	</div>
</div>

<div class="vlogo py-md-4">
	<div class="py-5">
		<div class="d-grid">
		<div class="swiper logoSwiper">
			<div class="swiper-wrapper">
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Beechcraft') ?>"><img src="<?= base_url('assets/frontend/images/logos/beechcraft.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Bombardier') ?>"><img src="<?= base_url('assets/frontend/images/logos/bombardier.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Cessna') ?>"><img src="<?= base_url('assets/frontend/images/logos/cessna.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Cirrus') ?>"><img src="<?= base_url('assets/frontend/images/logos/cirrus.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Dassault+Aviation') ?>"><img src="<?= base_url('assets/frontend/images/logos/dassault.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Diamond+Aircraft') ?>"><img src="<?= base_url('assets/frontend/images/logos/diamond.png') ?>"></a></div>
				<!-- Add more logos as needed -->
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Beechcraft') ?>"><img src="<?= base_url('assets/frontend/images/logos/beechcraft.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Bombardier') ?>"><img src="<?= base_url('assets/frontend/images/logos/bombardier.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Cessna') ?>"><img src="<?= base_url('assets/frontend/images/logos/cessna.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Cirrus') ?>"><img src="<?= base_url('assets/frontend/images/logos/cirrus.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Dassault+Aviation') ?>"><img src="<?= base_url('assets/frontend/images/logos/dassault.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Diamond+Aircraft') ?>"><img src="<?= base_url('assets/frontend/images/logos/diamond.png') ?>"></a></div>
			</div>
		</div>
		<div class="swiper logoSwiper reverse" dir="rtl">
		    
			<div class="swiper-wrapper">
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Embraer') ?>"><img src="<?= base_url('assets/frontend/images/logos/embraer.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Gulfstream') ?>"><img src="<?= base_url('assets/frontend/images/logos/gulfstream.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Lancair') ?>"><img src="<?= base_url('assets/frontend/images/logos/jancair.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Mooney') ?>"><img src="<?= base_url('assets/frontend/images/logos/mooney.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Pilatus') ?>"><img src="<?= base_url('assets/frontend/images/logos/pilatus.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Piper') ?>"><img src="<?= base_url('assets/frontend/images/logos/piper.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Robinson+Helicopter+Company') ?>"><img src="<?= base_url('assets/frontend/images/logos/robinson.png') ?>"></a></div>
				<!-- Add more logos as needed -->
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Embraer') ?>"><img src="<?= base_url('assets/frontend/images/logos/embraer.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Gulfstream') ?>"><img src="<?= base_url('assets/frontend/images/logos/gulfstream.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Lancair') ?>"><img src="<?= base_url('assets/frontend/images/logos/jancair.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Mooney') ?>"><img src="<?= base_url('assets/frontend/images/logos/mooney.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Pilatus') ?>"><img src="<?= base_url('assets/frontend/images/logos/pilatus.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Piper') ?>"><img src="<?= base_url('assets/frontend/images/logos/piper.png') ?>"></a></div>
				<div class="swiper-slide"><a href="<?= base_url('listings/'.$s_cat->permalink.'?manufacturer=Robinson+Helicopter+Company') ?>"><img src="<?= base_url('assets/frontend/images/logos/robinson.png') ?>"></a></div>
			</div>
		</div>		
		</div>
	</div>
</div>

<div class="abtSec py-md-5 text-center text-white">
	<div class="container py-5 px-xxl-5">
		<img src="<?= base_url('assets/frontend/images/PB.png') ?>">
		<h3 class="text-white fw-bold mt-2 mb-3">About Plane Broker</h3>
		<p>Plane Broker is built for aircraft owners, buyers, and sellers who want a smarter, more straightforward way to navigate the market. Whether you're listing a single aircraft or searching for your next one, our platform gives you the tools to take off with confidence.</p>
		<div class="row my-4 my-xxl-5">
			<div class="col-md-4">
				<img src="<?= base_url('assets/frontend/images/aircraft.png') ?>">
				<h6 class="text-white title-xs">Buy and Sell Aircraft <br/>with Ease</h6>
			</div>
			<div class="col-md-4">
				<img src="<?= base_url('assets/frontend/images/recycle.png') ?>">
				<h6 class="text-white title-xs">Keep your Aircraft <br/>in Top Condition</h6>
			</div>
			<div class="col-md-4">
				<img src="<?= base_url('assets/frontend/images/airpark.png') ?>">
				<h6 class="text-white title-xs">Find the right Hangar, <br/>Airpark and Strip</h6>
			</div>
		</div>
		<a href="<?php echo base_url('/about-us'); ?>" class="btn py-xl-3 px-xxl-5">LEARN ABOUT US</a>
	</div>
</div>

<div class="testimonial text-center py-5">

		<h3 class="d-blue fw-bolder">Client Testimonials</h3>
		<p>Read what some of our previous clients have to say!</p>


<div class="swiper logoSwiper">
				
  <div class="swiper-wrapper testimonial-track">
      <?php if(!empty($testimonials)){foreach($testimonials as $testimonial){ ?>
        <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
         <p><?php echo $testimonial->content; ?></p>
          <h6 class="black title-sm">- <?php echo $testimonial->name; ?>.</h6>
        </div>
        </div>
      <?php }} ?>
    <?php for ($i = 0; $i < 2; $i++): ?>
     <!-- <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
         <p>I wasn’t sure where to start with selling my aircraft, but Plane Broker made it easy to get the listing up. I liked that I could manage everything myself and update it whenever I needed.</p>
          <h6 class="black title-sm">- Alan M.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I had my doubts about listing online, but Plane Broker felt more focused than other sites I’ve tried. I got a few solid inquiries within the first month and ended up closing with one of them.</p>
          <h6 class="black title-sm">- Michelle P.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I spent a lot of time comparing aircraft across a few sites, and this one was the easiest to navigate. I appreciated that the listings were detailed without being cluttered.</p>
          <h6 class="black title-sm">- Samantha T.</h6>
        </div>
      </div>
	  <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
         <p>What I appreciated most was how simple it was to get the listing live. The platform didn’t overwhelm me with options, and I liked being in control of the process.</p>
          <h6 class="black title-sm">- Ken S.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>found my plane here after casually browsing for a few weeks. The seller was responsive and the whole thing went smoother than I expected.”</p>
          <h6 class="black title-sm">- Paul G.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I’ve used a few aircraft listing sites over the years, and this was one of the smoothest experiences I’ve had. Everything was clear, and I didn’t have to jump through hoops to make changes.</p>
          <h6 class="black title-sm">- Daniel K.</h6>
        </div>
      </div>
	  <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
         <p>I liked that I could contact the seller directly and get a feel for the deal before diving in. No middlemen, just straight communication.”</p>
          <h6 class="black title-sm">- Jose R.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I listed my plane here after trying a couple of other platforms with no luck. I didn’t expect much, but I actually got more interest than anywhere else.”</p>
          <h6 class="black title-sm">- Rachel D.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I wasn’t in a rush, but I checked back every few days and eventually found a great deal on a clean aircraft. I’m happy with the experience.</p>
          <h6 class="black title-sm">- Kim M.</h6>
        </div>
      </div>
	  <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
         <p>As a first-time seller, I was nervous about the process. Plane Broker made it feel manageable. I didn’t feel pressured and could go at my own pace.</p>
          <h6 class="black title-sm">- Eddie R.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>Everything I needed was on the listing—logbook info, photos, the right details. I reached out and flew out a week later to go see it in person.”</p>
          <h6 class="black title-sm">- Dave C.</h6>
        </div>
      </div>
      <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I’m not someone who sells planes often, but when I needed to list mine, this site worked well. Straightforward, nothing flashy, just what I needed to get it out there.”</p>
          <h6 class="black title-sm">- Tina H.</h6>
        </div>
      </div>
	  <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I used Plane Broker to sell a trainer aircraft and it did exactly what I needed. I got some interest, had a couple of back-and-forths, and eventually sold it to someone who flew in to pick it up.</p>
          <h6 class="black title-sm">- Jim L.</h6>
        </div>
      </div>
	  <div class="swiper-slide testimonial-item">
        <div class="bg-white">
          <img src="<?= base_url('assets/frontend/images/stars.png') ?>">
          <p>I’ve bought aircraft through brokers before, but I liked being able to handle this one directly. Found a good match and worked it out with the seller myself.”</p>
          <h6 class="black title-sm">- Brian T.</h6>
        </div>
      </div>-->
    <?php endfor; ?>
  </div>
</div>
		<!--<div class="owl-carousel testimonial-carousel owl-theme mt-5"  id="testimonial">
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
		</div>-->
		<a href="<?php echo base_url('/testimonials'); ?>" class="btn py-xl-3 mt-3 mt-sm-5">VIEW ALL TESTIMONIALS</a>
</div>

<div class="bg-gray py-5">
	<div class="container text-center pb-5 px-lg-5">	
		<h3 class="d-blue fw-bolder mt-xl-4 mb-2">The Plane Broker Difference</h3>
		<p>We're here to make aircraft transactions easier to navigate. With clear tools, real listings, and a platform designed for pilots and sellers, Plane Broker helps you move through the process without unnecessary steps or confusion. It's everything you need, without everything you don't.</p>
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
		<a href="<?php echo base_url('/'); ?>" class="btn py-xl-3 px-xxl-5">LEARN MORE</a>
	</div>
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
<style>
.testimonial{
  overflow: hidden;
	
}
.testimonial-marquee {
  width: 100%;
}

.testimonial-track {
  display: flex;
  gap: 10px;
}

.testimonial-item {
  min-width: 350px;
  max-width: 350px;
  flex-shrink: 0;
}

.testimonial-item .bg-white {
  border: 2px solid #f2f2f2 !important;
    box-shadow: 5px 5px 10px #00000011;
    border-radius: 30px;
    background: #ffffff;
    overflow: hidden;
    padding: 2rem 1.5rem;
	height:100%;
}


.testimonial-item p {
  font-size: 14px;
  line-height: 1.5;
  color: #333;
  text-wrap: auto;
}

.testimonial-item h6 {
  margin-top: 15px;
  font-weight: 600;
}
.testimonial-item img {
    max-width: 210px;
    margin: 0 auto 1.4rem;
}

@keyframes scroll-testimonials {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.logo-marquee {
  overflow: hidden;
  white-space: nowrap;
  position: relative;
  width: 100%;
}

.logo-track {
  display: inline-block;
  white-space: nowrap;
  animation: scroll-left 30s linear infinite;
}

.logo-marquee.left-to-right .logo-track {
  animation: scroll-right 30s linear infinite;
}

.logo-marquee img {
  margin: 0 30px;
  vertical-align: middle;
  object-fit: contain;
}
@keyframes scroll-left {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
@keyframes scroll-right {
  0%   { transform: translateX(-50%); }
  100% { transform: translateX(0); }
}
.logoSwiper {
  width: 100%;
  overflow: hidden;
}

.swiper-wrapper {
  transition-timing-function: linear !important; /* 👈 ensure smooth constant speed */
}

.swiper-slide {
  width: auto !important; /* 👈 allow variable width logos */
  display: flex;
  align-items: center;
  justify-content: center;
}

.swiper-slide img {
  height: 60px;
  margin: 0 30px;
  object-fit: contain;
}

.reverse .swiper-wrapper {
  flex-direction: row-reverse;
}
.logoSwiper.reverse .swiper-wrapper {
  flex-direction: row-reverse;
}
</style>
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

	})
</script>
<script>
  document.getElementById("search-fornm").addEventListener("submit", function(e) {
    const form = e.target;
    const elements = form.querySelectorAll("input, select, textarea");

    for (let el of elements) {
      if (!el.value.trim()) {
        el.disabled = true; // prevent it from being submitted
      }
    }
  });
</script>
<?= $this->endSection() ?>