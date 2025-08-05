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
					
					<ul class="nav nav-tabs gap-3" id="myTab" role="tablist">
						<?php if(!empty($categories)){ ?>
						<?php foreach($categories as $c => $category){ ?>
						<li class="nav-item" role="presentation">
						  <button class="nav-link <?php echo ($c ==0) ? 'active' : ''; ?>" id="cat<?php echo $c; ?>-tab" data-bs-toggle="tab" data-bs-target="#cat<?php echo $c; ?>" type="button" role="tab"><?php echo $category->name; ?></button>
						</li>
						<?php } ?>
						<?php } ?>
					</ul>
					<div class="tab-content mt-3 mt-md-5" id="myTabContent">
					<?php if(!empty($categories)){ ?>
					<?php foreach($categories as $c => $category){ ?>
					<div class="tab-pane fade <?php echo ($c ==0) ? 'show active' : ''; ?>" id="cat<?php echo $c; ?>" role="tabpanel">
					<?php if(!empty($results) && $c == 0){ ?>
					
						<div class="d-grid gap-2 proList grid-col-4 px-0">
						<?php foreach($results as $row){ ?>
						<div class="card rounded-5 p-3" id="p_id_<?php echo $row['id']; ?>">
							<div class="providerImg mb-2">
								<img class="d-block w-100" alt="..." src="<?php echo $row['image']; ?>">
							</div>
							<div class="pro-content mb-3">
								<h5 class="fw-medium fs-6"><?php echo !empty($row['name']) ? $row['name'] : '-'; ?></h5>
								<h5 class="fw-medium text-primary fs-6"><?php echo $row['sub_cat_name']; ?></h5>
								<p class="fw-medium text-grey mb-3"><?php echo $row['address']; ?></p>
								<h5 class="fw-medium fs-6"><?php echo ($row['price'] != NULL) ? 'USD $'.number_format($row['price'], 2, '.', ',') : 'Call for Price'; ?></h5>
							</div>
							<ul class="userDetails mb-3">

								<li><img src="<?php echo base_url('assets/frontend/images/phone.png'); ?>" /> <?php echo $row['phone']; ?><a href="tel:+1<?php echo $row['phone']; ?>" class="call" title="Call">Call</a></li>

								<li><img src="<?php echo base_url('assets/frontend/images/fuser.png'); ?>" /><?php echo !empty($row['business_name']) ? $row['business_name'] : $row['user_name']; ?></li>

								<li><img src="<?php echo base_url('assets/frontend/images/pin.png'); ?>" /> <?php echo $row['address']; ?></li>

							</ul>
							<a class="btn blue-btn min-w-auto py-3" target="_blank" href="<?php echo base_url('/listings/'.$row['permalink'].'/'.$row['id'].'/'.(!empty($row['name'])?str_replace(' ','-',strtolower($row['name'])):'')); ?>">VIEW LISTING</a>
							<div class="text-center">
								<a class="text-danger openDeleteModal" data-id="<?php echo $row['id']; ?>" href="javascript:void(0);">REMOVE LISTING</a>
							</div>
						</div>
						<?php } ?>
						</div>
					<?php }else{?>

						<div class="d-flex flex-column flex-md-row no-list  align-items-center justify-content-center gap-4 my-5 py-md-5">
						<div class="mb-4 mb-md-5">
							<h3 class="fw-bolder my-0">You have no Favorite!</h3>
							<p>You can save any listing in your Favorites. </p>
							<a href="<?php echo base_url('listings/aircraft-for-sale'); ?>" class="btn py-3">VIEW <?php echo strtoupper($category->in_house); ?></a>
						</div>
						<div class="">
						<img src="<?php echo base_url('assets/frontend/images/nolist.png'); ?>" />
						</div>
						</div>
						
					<?php } ?>
					</div>
					<?php } ?>
					<?php } ?>
					</div>
					
				<?php /*if(!empty($results)){ ?>
				<?php }else{ ?>
					<div class="d-flex align-items-center justify-content-center gap-4 my-5 py-md-5">
						<div class="mb-4 mb-md-5">
							<h3 class="fw-bolder my-0">You have no Favorite!</h3>
							<p>You can save any listing in your Favorites.</p>
							<a href="<?php echo base_url('listings/aircraft-for-sale'); ?>" class="btn d-inline-flex gap-2 align-items-center"><img src="<?php echo base_url('assets/frontend/images/new.png'); ?>" /> VIEW AIRCRAFT LISTINGS</a>
						</div>
						<div class="">
						<img src="<?php echo base_url('assets/frontend/images/nolist.png'); ?>" />
						</div>
					</div>
				<?php }*/ ?>
				
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

      <h5 class="fw-bolder text-dark mb-3">Are you sure you want to<br/> remove this listing?</h5>
      <p class="text-black fw-medium pb-2 mb-1">
        You are about to remove an favorite listing.
      </p>

      <!-- Delete Button -->
      <button class="btn btn-danger rounded-pill py-3 my-4 confirmDelete min-w-auto" data-id="">
        YES, REMOVE THIS LISTING
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
    $.ajax({
		url: '<?php echo base_url(); ?>/remove_favorite',
		data: {csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',p_id:$('.confirmDelete').attr('data-id')},
		type: 'POST',
		dataType: 'HTML',
		success: function(response){
			// Hide modal after action
			$('#p_id_'+$('.confirmDelete').attr('data-id')).hide();
			//console.log($('#p_id_'+$('.confirmDelete').attr('data-id')).closest('.tab-pane').find('.card:visible').length());
			var p_length = $('.tab-pane.active .proList .card:visible').length;
			if(p_length == 0){
				$('#p_id_'+$('.confirmDelete').attr('data-id')).closest('.tab-pane').html('<div class="d-flex flex-column flex-md-row no-list  align-items-center justify-content-center gap-4 my-5 py-md-5"><div class="mb-4 mb-md-5"><h3 class="fw-bolder my-0">You have no Favorite!</h3><p>You can save any listing in your Favorites. </p><a href="<?php echo base_url('listings/aircraft-for-sale'); ?>" class="btn py-3">VIEW AIRCRAFT LISTINGS</a></div><div class=""><img src="<?php echo base_url('assets/frontend/images/nolist.png'); ?>" /></div></div>');
			}
			Swal.fire({
				icon: 'success',
				text: 'Removed successfully.',
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 2000,
				timerProgressBar: true
			});			
		}
	})
  });
});
</script>
<?= $this->endSection() ?>