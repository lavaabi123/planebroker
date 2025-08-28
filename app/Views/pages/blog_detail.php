<?= $this->extend('layouts/main') ?><?= $this->section('content') ?><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css"><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css"><script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script> 
<style>
    .b-det .blog_content p{
        margin-bottom: 0.5rem !important;
    }
    .b-det .blog_content h4{
        margin-top: 2rem;    margin-bottom: 2rem;
    }
    .b-det .blog_content strong{
            font-weight: bold;
    }
</style>
<main class="bg-gray b-det">  
<div class="py-5" style="background: none;">
	<div class="container py-sm-4">
		<div class="row">
			<div class="col-sm-8">
				<h3 class="title-md fw-bolder mb-1"><?php echo $blog['name']; ?></h3>
				<p class="my-0 py-0  mb-2 pb-sm-1"><?php echo date("F jS, Y", strtotime($blog['created_at'])); ?></p>	
				<div class="row g-4 pb-3">	
						
				<?php if(!empty($blog)){ ?>		
					<div class="col">
						<img src="<?php echo !empty($blog['image']) ? base_url().'/uploads/blog/'.$blog['image'] : base_url().'/assets/img/user.png'; ?>" class="d-block w-100" alt="...">
						<div class="full_content fs-6 mt-3"><?php echo $blog['content']; ?></div>	
					</div>
				<?php  } ?>
				</div>
				<div class="container blogs mt-5">

					<h3 class="title-md mb-3 pb-sm-3 fw-bolder text-center">Similar Posts</h3>

					<div class="owl-carousel blog-carousel owl-theme"  id="blog">
					<?php  foreach($blogs as $blog1){ if($blog['id'] != $blog1['id']){ ?>		
						<div class="col item">
							<div class="bg-white mb-3" style="position:relative;">
								<div class="w-100">
									<a href="<?php echo  base_url('blog_detail/'.$blog1['clean_url']); ?>"><img src="<?php echo !empty($blog1['image']) ? base_url().'/uploads/blog/'.$blog1['image'] : base_url().'/assets/img/user.png'; ?>" class="d-block w-100" alt="..."></a>
								</div>
								<div class="p-3"><a class="fs-6 fw-bold d-blue" href="<?php echo  base_url('blog_detail/'.$blog1['clean_url']); ?>"><h6><?php echo $blog1['name']; ?></h6></a></div>
							</div>
						</div>
					<?php } } ?>

					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="ps-sm-4 position-sticky recent-posts d-none d-md-block">
					<h5 class="title-md pb-sm-3 fw-bolder">Recent Posts</h3>
					<ul>
						<?php if(!empty($blogs)){ foreach($blogs as $blog){ ?>		
								<li class="text-left">
									<a href="<?php echo  base_url('blog_detail/'.$blog['clean_url']); ?>"><?php echo $blog['name']; ?></a>
								</li>
						<?php } }else{
							echo '<p>No Records Found!</p>';
						} ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</main>	

<script>
jQuery(document).ready(function($){
	$(".blog-carousel").owlCarousel({
		loop:false,
		margin:5,
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
})
</script>	
<?= $this->endSection() ?>