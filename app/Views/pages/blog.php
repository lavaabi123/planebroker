<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.blogs .col > div {    
	height: 100%;    
	border-radius: 40px;    
	padding: 0px;    
	display: flex;    
	flex-direction: column;    
	align-items: center;
}
.blogs .col img {    
	border-radius: 40px 40px 0 0;    
	object-fit: contain;
}
.blogs .col h6 {
	margin-top: 15px;
    margin-bottom: 5px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: initial;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    min-height: 47px;
}
</style>
<main class="bg-gray pt-4 pt-sm-5">  
<div class="blogs bg-gray text-center" style="background: none;">	<div class="pageTitle py-2 text-center">		<h2 class="title-xxl black fw-900 mb-0">Blog</h2>	</div>
	<div class="container py-3 py-xl-5">
		<div class="row row-cols-1 row-cols-sm-3 justify-content-center g-4 pb-3">		
		<?php if(!empty($blogs)){ foreach($blogs as $blog){ ?>		
			<div class="col">
				
				<div class="bg-white" style="position:relative;">
					<a href="<?php echo  base_url('blog_detail/'.$blog['clean_url']); ?>">
					<div class="w-100">
						<img src="<?php echo !empty($blog['image']) ? base_url().'/uploads/blog/'.$blog['image'] : base_url().'/assets/img/user.png'; ?>" class="d-block w-100" alt="...">
					</div>
					<div class="blogCol-Btm p-3 d-flex align-items-center flex-column">
						<h6 class="dblue title-xs px-2"><?php echo $blog['name']; ?></h6>
						<div class="blog_content p-3 text-black"><?php echo strip_tags(substr($blog['content'], 0, 160)).'...'; ?></div>
						<p class="text-orange">Read More -></p>
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