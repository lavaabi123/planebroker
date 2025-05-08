<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<main class="pt-4 pt-sm-5">
	<div class="pageTitle py-2 text-center">
		<h2 class="title-xxl black fw-900 mb-0">Frequently Asked Questions</h2>
    </div>
	<div class="container py-3 py-xl-5">
		<div class="m-auto faqs" id="">
		  <div class="border-bottom mb-4">
			<h6>What is planebroker.com?</h6>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
		  </div>
		  
		</div>
	</div>
	<div class="wbprovider text-center">	<div class="container py-sm-3 d-flex flex-column">		<h3 class="title-md mb-2 text-black">Want to become a broker?</h3>		<p class="title-xs text-grey fw-bold">It’s easy and you can make a profile absolutely FREE!</p>		<div class="d-flex justify-content-center gap-3 mt-4">			<a href="<?php echo base_url('/pricing'); ?>" class="btn yellowbtn minbtn">Become a Plane Broker</a>			<a href="<?php echo base_url('/how-it-works'); ?>" class="btn yellowbtn minbtn">How It Works</a>		</div>	</div></div>
</main>
<?= $this->endSection() ?>