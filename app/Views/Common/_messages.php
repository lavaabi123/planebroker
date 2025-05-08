<style>
.dfg {
    max-width: 200px !important;
    font-size: 18px !important;
}
</style>
<?php if (session()->getFlashdata('success_form')) : ?>
<script>
Swal.fire({html:`<?php echo session()->getFlashdata('success_form'); ?>`, icon: 'success'});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('success_form1')) : ?>
<script>
Swal.fire({
  html: '<?php echo session()->getFlashdata('success_form1'); ?>',
  icon: 'success',
  showConfirmButton: false,
  allowOutsideClick: false,
  allowEscapeKey: false
})
</script>
<?php endif; ?>

<?php if (session()->get('vr_sess_logged_in') == TRUE && session()->get('vr_sess_email_status') == 0) : ?>
<script>
Swal.fire({
  html: '<?php echo trans("msg_send_confirmation_email"); ?>',
  icon: 'success',
  showConfirmButton: false,
  allowOutsideClick: false,
  allowEscapeKey: false
})
</script>
<?php endif; ?>


<?php 
    $errorShown = false;
    if (session()->getFlashdata('errors_form')) : ?>
	<script>
Swal.fire({html:`<?php echo session()->getFlashdata('errors_form'); ?>`, icon: 'error'});
</script>
<?php $errorShown = true; 
    endif; 
 ?>



<?php if (session()->getFlashdata('error_form')) : ?>
    <script>
Swal.fire({html:`<?php echo session()->getFlashdata('error_form'); ?>`, icon: 'error'});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
   <script>
Swal.fire({html:`<?php echo session()->getFlashdata('success'); ?>`, icon: 'success'});
</script>
<?php endif; ?>

<?php if (!$errorShown && session()->getFlashdata('error')) : 
        if(is_array(session()->getFlashdata('error'))):?>
        <?php 
        $errorMessages = array_unique(session()->getFlashdata('error'));
        foreach ($errorMessages as $errors) : ?>
       <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fas fa-ban"></i> <?php echo $errors ?>
       </div>
    <?php endforeach; ?>
        <?php else: ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fas fa-ban"></i> <?php echo session()->getFlashdata('error'); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php if (session()->getFlashdata('error_array')) : ?>

    <?php foreach (session()->getFlashdata('error_array') as $errors) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-ban"></i> <?php echo $errors ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>
<?php if (session()->getFlashdata('error_form1')) : ?>
<script>
Swal.fire({
  html: '<?php echo session()->getFlashdata('error_form1'); ?>',
  icon: 'warning',
  showConfirmButton: true,
  confirmButtonText:"Select your plan",
  allowOutsideClick: false,
  allowEscapeKey: false,
  customClass: {
	 confirmButton: "dfg"
   }
}).then(function() {
	window.location.href = '<?php echo base_url().'/plan'; ?>';
})
</script>
<?php endif; ?>