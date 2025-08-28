<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<main class="bg-gray pt-4 pt-sm-5">  
<div class="blogs bg-gray text-center" style="background: none;">	<div class="pageTitle py-2 text-center">		<h2 class="fw-bolder"><?php echo $title; ?></h2>	</div>
	<div class="container py-3 py-xl-5 px-xxl-5">
		<div class="row row-cols-1 row-cols-sm-3 justify-content-center g-4 pb-3">		
		<?php if(!empty($blogs)){ foreach($blogs as $blog){ ?>		
			<div class="col">
				
				<div class="bg-white pb-4" style="position:relative;">
					<a href="<?php echo  base_url('blog_detail/'.$blog['clean_url']); ?>">
					<div class="w-100">
						<img src="<?php echo !empty($blog['image']) ? base_url().'/uploads/blog/'.$blog['image'] : base_url().'/assets/img/user.png'; ?>" class="d-block w-100" alt="...">
					</div>
					<div class="blogCol-Btm p-3 d-flex align-items-center flex-column">
						<h6 class="dblue title-xs px-2"><?php echo $blog['name']; ?></h6>
						<div class="blog_content text-black my-3 fs-6"><?php echo strip_tags(substr($blog['content'], 0, 160)).'...'; ?></div>
						<p class="btn">Read More</p>
					</div>
				</a>
				</div>
				
			</div>
		<?php } } ?>
		</div>
	</div>
</div>
</main>		
<?= $this->endSection() ?>