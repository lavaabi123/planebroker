<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
   
			
	<div class="bg-grey d-flex flex-column flex-lg-row">
        <?php echo $this->include('Common/_messages') ?>
		<div class="leftsidecontent" id="stickySection">
			<?php echo $this->include('Common/_sidemenu') ?>
		</div>
		<div class="rightsidecontent w-100 px-3 mb-5">
			<div class="container-fluid">
				<div class="titleSec">
					<h3 class="title-lg fw-bolder my-4">Billing<?php //echo $title; ?></h3>
				</div>
				<div class="dbContent">
					<div class="container px-0">
				<?php echo $payment_methods; ?>
				<?php echo $payment_history; ?>
				
					</div>
				</div>
			</div>
		</div>
	</div>		
<script>
function confirm_cancel(subscription_id) {
    Swal.fire({
        text: "ARE YOU SURE YOU WANT TO CANCEL?",
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "<?php echo trans("YES, CANCEL MY SUBSCRIPTION"); ?>",
        cancelButtonText: "<?php echo trans("NO, KEEP MY SUBSCRIPTION"); ?>",

    }).then(function (response) {
        if (response.value) {
        	window.location = '<?php echo base_url(); ?>/providerauth/billing-cancel/'+subscription_id; 
        }
    });
}
</script>		
<?= $this->endSection() ?>