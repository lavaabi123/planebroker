<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
p.mb-0::before {
    content: "*";
    padding-right: 10px;
}
</style>
<main class="pt-4 pt-sm-5">	<div class="container max-1170">		<h4 class="title-md fw-normal text-black">How it Works!</h4>			<ul class="tick list-unstyled my-3">			


</ul>			</div>	<img src="<?= base_url('assets/frontend/images/howitworks.jpg') ?>" class="img-fluid w-100 mt-sm-5" alt="" />	<div class="container max-1170">		<div class="row py-md-5 position-relative">			<div class="col-sm-12 py-5">				<div class="position-relative z-1">				<h4 class="title-md mb-2">Have questions?</h4>				<h2 class="title-xl fw-900 mb-2">Visit our FAQs!</h2>				<p>We’ve answered a lot of common questiions here or you can visit our <a href="<?php echo base_url('/contact'); ?>">Contact Page</a> to message us directly.</p>				<a href="<?php echo base_url('/faq'); ?>" class="btn yellowbtn minbtn">FAQs</a>				</div>			</div>		</div>	</div>
</main>			
<?= $this->endSection() ?>