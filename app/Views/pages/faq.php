<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<main class="pt-4 pt-sm-5">
	<div class="pageTitle py-2 text-center">
		<h2 class="title-xxl fw-bolder mb-0">Frequently Asked Questions</h2>
    </div>
	<div class="container py-3 py-xl-5">
		<div class="m-auto faqs" id="">
		  <div class="border-bottom mb-4">
			<h6>1. What is PlaneBroker.com?</h6>
			<p>PlaneBroker.com is an online platform where individuals and businesses can list, browse, and connect to buy or sell aircraft. We make it easier to manage aircraft sales without the usual hassle.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>2. Who can list an aircraft on Plane Broker?</h6>
			<p>Anyone with a registered account can list an aircraft for sale, whether you're an individual owner, dealer, or broker.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>3. How do I create a listing?</h6>
			<p>Once you create an account and choose a plan, you'll be guided through a step-by-step process to add photos, aircraft details, and contact info.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>4. Are there different listing plans available?</h6>
			<p>Yes, we offer multiple listing plans to fit different needs. Each plan comes with its own features and listing duration.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>5. Can I edit my listing after it's published?</h6>
			<p>Yes, you can make changes to your listing at any time by logging into your dashboard.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>6. How do buyers contact me about my aircraft?</h6>
			<p>Buyers will reach out using the contact form on your listing. Messages are sent directly to the email address associated with your account.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>7. Does Plane Broker handle payments or transactions?</h6>
			<p>No, we do not process payments or manage transactions. Buyers and sellers coordinate directly to complete the sale.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>8. Can I see how many people have viewed my listing?</h6>
			<p>Yes, your dashboard includes basic listing stats, including view counts, so you can keep track of interest over time.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>9. Is there customer support if I need help?</h6>
			<p>Yes, you can reach out through our contact page for support with listings, account issues, or general questions.</p>
		  </div>
		  <div class="border-bottom mb-4">
			<h6>10. How long will my listing stay active?</h6>
			<p>Listing duration depends on the plan you choose. Each plan clearly outlines how long your listing will remain live on the site.</p>
		  </div>
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
</main>
<?= $this->endSection() ?>