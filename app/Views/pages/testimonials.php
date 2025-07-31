<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<main class="bg-gray">  
<div class="stestimonial text-center py-5">
	<div class="pageTitle py-2 text-center text-white">
		<h2 class="title-xl fw-900 mb-3 mb-sm-0">Testimonials</h2>
	</div>
	<div class="container py-sm-4">
		<div class="row row-cols-1 row-cols-sm-3 g-4 pb-3">			
			 <?php if(!empty($testimonials)){foreach($testimonials as $testimonial){ ?>
			<div class="col">
				<div class="bg-white item h-100">
					<img src="<?= base_url('assets/frontend/images/stars.png') ?>">
					<p><?php echo $testimonial->content; ?></p>
					<h6 class="dblue title-sm">- <?php echo $testimonial->name; ?>.</h6>
				</div>
			</div>
			<?php } } ?>
		</div>
	</div>
</div>
</main>		
<?= $this->endSection() ?>