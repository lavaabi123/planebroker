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
					<h3 class="title-lg fw-bolder my-4"><?php echo $title; ?></h3>
				</div>
				<div class="dbContent">
					<div class="container-fluid px-0">
				<?php if(!empty($results)){ ?>
				<div class="row proList g-3 justify-content-center">
				<?php foreach($results as $row){ ?>
				<div class="col-12 col-sm-6 col-xl-3" id="p_id_<?php echo $row['id']; ?>">
				<div class="card rounded-5 p-3 h-100">
					<?php if ($row['status'] == 1 && $row['is_cancel'] == 1){ ?>
						<span class="text-danger" title="<?php echo trans('active'); ?>">CANCELED</span>
					<?php }else if ($row['status'] == 1 && $row['is_cancel'] == 0){ ?>
						<span class="text-success" title="<?php echo trans('active'); ?>">ACTIVE</span>
					<?php }else if ($row['status'] == 0 && $row['is_cancel'] == 0){ ?>
						<span class="text-danger" title="<?php echo trans('active'); ?>">INACTIVE</span>
					<?php }else{ ?>
						<span class="text-danger" title="<?php echo trans('banned'); ?>">CANCELED</span>
					<?php } ?>
					<div class="providerImg mb-3">
						<img class="d-block w-100" alt="..." src="<?php echo $row['image']; ?>">
					</div>
					<div class="pro-content mb-3">
						<h5 class="fw-medium title-xs"><?php echo !empty(trim($row['name'])) ? $row['name'] : '-'; ?></h5>
						<h5 class="fw-medium text-primary fs-6"><?php echo !empty($row['sub_cat_name']) ? $row['sub_cat_name'] : '-'; ?></h5>
						<p class="fw-medium text-grey mb-3"><?php echo !empty($row['address']) ? $row['address'] : '-'; ?></p>
						<h5 class="fw-medium title-xs"><?php echo ($row['price'] != NULL && !empty($row['price'])) ? 'USD $'.number_format((float)str_replace(',', '', $row['price']), 2, '.', ',') : 'Call for Price'; ?></h5>
					</div>
					<a class="btn yellowbtn mb-2 min-w-auto py-3" href="<?php echo base_url().'/add-listing?category='.$row['cat_id'].'&id='.$row['id'];?>">EDIT MY LISTING</a>
					<a class="btn blue-btn min-w-auto py-3" target="_blank" href="<?php echo base_url('/listings/'.$row['permalink'].'/'.$row['id'].'/'.(!empty($row['name'])?str_replace(' ','-',strtolower($row['name'])):'')); ?>">VIEW LISTING</a>
					<div class="text-center">
						<div class="form-check form-switch mt-4">
							<label class="form-check-label">Enable</label>
							<input class="form-check-input toggle-status" type="checkbox" data-id="<?= $row['id']; ?>" <?php echo ($row['status'] == 1) ? 'checked' : ''; ?> role="switch" id="switchCheck">
							<label class="form-check-label">Disable</label>
						</div>
						<a class="text-danger openDeleteModal" data-id="<?php echo $row['id']; ?>" href="javascript:void(0);">DELETE LISTING</a>
					</div>
				</div>
				</div>
				<?php } ?>
				</div>
				<?php }else{ ?>
					<div class="d-flex flex-column flex-md-row no-list align-items-center justify-content-center gap-4 my-5 py-md-5">
						<div class="mb-4 mb-md-5">
							<h3 class="fw-bolder my-0">You have no listings!</h3>
							<p>Ready to publish your next listing?</p>
							<?php if(!empty($user_detail->user_level)){  ?>
							<a href="<?php echo base_url('add-listing'); ?>" class="btn d-inline-flex gap-2 align-items-center"><img src="<?php echo base_url('assets/frontend/images/new.png'); ?>" /> CREATE NEW LISTING</a>
							<?php }else{ ?>
							<a href="<?php echo base_url('plan'); ?>" class="btn d-inline-flex gap-2 align-items-center"><img src="<?php echo base_url('assets/frontend/images/new.png'); ?>" /> CREATE NEW LISTING</a>
							<?php } ?>
						</div>
						<div class="">
						<img src="<?php echo base_url('assets/frontend/images/nolist.png'); ?>" />
						</div>
					</div>
				<?php } ?>
				
            </div>                    
            </div>                    
            </div>                    
		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-5 p-3 px-md-5 text-center position-relative align-items-center">
      
      <!-- Close Icon -->
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close">
		<img src="<?php echo base_url('assets/frontend/images/close.png'); ?>" />
	  </button>

      <!-- Warning Icon -->
      <div class="fs-1 text-danger my-3"><img src="<?php echo base_url('assets/frontend/images/alert.png'); ?>" /></div>

      <h5 class="fw-bolder text-dark mb-3">Are you sure you want to<br/> delete your listing?</h5>
      <p class="text-black fw-medium pb-2 mb-1">
        You are about to delete an existing listing.<br>
        This change is not reversible.
      </p>

      <!-- Delete Button -->
      <button class="btn btn-danger rounded-pill py-3 my-4 confirmDelete min-w-auto" data-id="">
        YES, DELETE THIS LISTING
      </button>

      <!-- Close Text -->
      <div>
        <a href="#" class="text-decoration-underline text-black fs-6" data-bs-dismiss="modal">
          Close this window
        </a>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
	// Open modal via jQuery
	$('.openDeleteModal').click(function() {
		$('.confirmDelete').attr('data-id',$(this).attr('data-id'));
		$('#deleteModal').modal('show');
	});

  // Handle delete confirmation
  $('.confirmDelete').click(function() {
    $.ajax({
		url: '<?php echo base_url(); ?>/product_delete',
		data: {csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',p_id:$('.confirmDelete').attr('data-id')},
		type: 'POST',
		dataType: 'HTML',
		success: function(response){
			// Hide modal after action
			$('#deleteModal').modal('hide');
			$('#p_id_'+$('.confirmDelete').attr('data-id')).hide();
			Swal.fire({
				icon: 'success',
				text: 'Deleted successfully.',
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 2000,
				timerProgressBar: true
			});			
		}
	})
  });
  
	$('.toggle-status').change(function() {
		let checkbox = $(this);
		let listingId = $(this).data('id');
		let status = $(this).is(':checked') ? 1 : 0;

		// Show confirmation dialog
		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you want to change the status of this listing?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, change it',
			cancelButtonText: 'Cancel',
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {			
				$.ajax({
				  url: '<?php echo base_url(); ?>/product_status_change', // Replace with your endpoint
				  method: 'POST',
				  data: {
					listing_id: listingId,
					status: status,
					csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db'
				  },
				  success: function(response) {
					  if(response == 'success'){
						var status_text = (status == 1) ? '<span class="text-success" title="active">ACTIVE</span>' : '<span class="text-danger" title="banned">INACTIVE</span>';
						$('#p_id_'+listingId+' span').replaceWith(status_text);
						Swal.fire({
							icon: 'success',
							text: 'Status updated successfully',
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true
						});
					  }else{
						  $('.toggle-status').prop('checked', false);
							Swal.fire({
								icon: 'warning',
								text: 'Oops! It looks like some required fields are missing. Please complete all fields before publishing your listing.',
							  showConfirmButton: true,
							  allowOutsideClick: true,
							  allowEscapeKey: true
							});
					  }
				  },
				  error: function(xhr) {
					alert('Error: ' + xhr.responseText);
				  }
				}); 
			} else {
				// Revert checkbox state if cancelled
				checkbox.prop('checked', !status);
			}
		});
	});
});
</script>

<?= $this->endSection() ?>