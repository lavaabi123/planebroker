<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<main class="bg-gray pt-4 pt-sm-5">  
<div class="testimonial  bg-gray text-center py-5" style="background: none;">
	<div class="container py-sm-4">
		<h3 class="title-md dblue mb-3 mb-sm-5 pb-sm-3">Testimonials</h3>
		<div class="row row-cols-1 row-cols-sm-3 g-4 pb-3">			
			 <?php if(!empty($testimonials)){foreach($testimonials as $testimonial){ ?>
			<div class="col">
				<div class="bg-white">
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