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
					<?php if ($row['status'] == 1) : ?>
						<span class="text-success" title="<?php echo trans('active'); ?>">ACTIVE</span>
					<?php else : ?>
						<span class="text-danger" title="<?php echo trans('banned'); ?>">INACTIVE</span>
					<?php endif; ?>
					<div class="providerImg mb-3">
						<img class="d-block w-100" alt="..." src="<?php echo $row['image']; ?>">
					</div>
					<div class="pro-content mb-3">
						<h5 class="fw-medium title-xs"><?php echo !empty($row['name']) ? $row['name'] : '-'; ?></h5>
						<h5 class="fw-medium text-primary fs-6"><?php echo $row['sub_cat_name']; ?></h5>
						<p class="fw-medium text-grey mb-3"><?php echo $row['address']; ?></p>
						<h5 class="fw-medium title-xs"><?php echo ($row['price'] != NULL) ? 'USD $'.number_format($row['price'], 2, '.', ',') : 'Call for Price'; ?></h5>
					</div>
					<a class="btn blue-btn min-w-auto py-3" target="_blank" href="<?php echo base_url('/analytics?id='.$row['id']); ?>">VIEW ANALYTICS</a>
					
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


<?= $this->endSection() ?>