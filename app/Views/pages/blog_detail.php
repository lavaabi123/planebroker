<?= $this->extend('layouts/main') ?><?= $this->section('content') ?><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css"><link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css"><script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>  <style>
.blogs .col img {
    object-fit: contain;
}
.blogs .col h6 {
	margin-top: 15px;
	margin-bottom: 5px;
}
.blog_content{	
    text-align : left;
}
.blog_content span{
	background-color: transparent !important;
}
.text-left{
	text-align:left;
}
.blogs a {
	color:#000000;
}
.blogs a:hover {
	color:#ff6c00;
}
</style>
<main class="bg-gray">  
<div class="blogs py-5" style="background: none;">
	<div class="container py-sm-4">
		<div class="row">
			<div class="col-sm-8">
				<h3 class="title-md dblue mb-1"><?php echo $blog['name']; ?></h3>
				<p class="my-0 py-0  mb-2 pb-sm-1"><?php echo date("F jS, Y", strtotime($blog['created_at'])); ?></p>	
				<div class="row g-4 pb-3">	
						
				<?php if(!empty($blog)){ ?>		
					<div class="col">
						<img src="<?php echo !empty($blog['image']) ? base_url().'/uploads/blog/'.$blog['image'] : base_url().'/assets/img/user.png'; ?>" class="d-block w-100" alt="...">
						<div class="blog_content mt-3"><?php echo $blog['content']; ?></div>	
					</div>
				<?php  } ?>
				</div>
				<div class="container blogs mt-5">

					<h3 class="title-md mb-3 mb-sm-3 pb-sm-3 text-dark text-center">Similar Posts</h3>

					<div class="owl-carousel blog-carousel owl-theme"  id="blog">
					<?php  foreach($blogs as $blog1){ if($blog['id'] != $blog1['id']){ ?>		
						<div class="col item">
							<div class="bg-white mb-3" style="position:relative;">
								<div class="w-100">
									<a href="<?php echo  base_url('blog_detail/'.$blog1['clean_url']); ?>"><img src="<?php echo !empty($blog1['image']) ? base_url().'/uploads/blog/'.$blog1['image'] : base_url().'/assets/img/user.png'; ?>" class="d-block w-100" alt="..."></a>
								</div>
								<div class="p-3"><a class="fs-6 fw-bold p-sm-3 d-block" href="<?php echo  base_url('blog_detail/'.$blog1['clean_url']); ?>"><?php echo $blog1['name']; ?></a></div>
							</div>
						</div>
					<?php } } ?>

					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="ps-sm-4 position-sticky recent-posts d-none d-md-block">
					<h5 class="title-xs black pb-sm-3 text-left">RECENT POSTS</h3>
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
})
</script>	
<?= $this->endSection() ?>