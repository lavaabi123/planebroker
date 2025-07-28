<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

	<div class="bg-grey d-flex flex-column flex-lg-row">
        <?php echo $this->include('Common/_messages') ?>
		<div class="w-100 px-3 mb-5">
			<div class="container-fluid">
				<div class="mt-5">
					<div class="container">
					<h3 class="title-lg fw-bolder mt-4 mb-5 text-center"><?php echo $title; ?></h3>
					<div id="advanced_options" class="pb-md-5">
						<div class="row">
							<div class="type_list new_list col-centered">
								<div class="row row-gap-4">
								<?php if(!empty($categories)){ 
									foreach($categories as $cat){ ?>
									<div class="col-6 col-md-3 text-center">
										<a href="<?php echo base_url().'/add-listing?category='.$cat->id;?>">
											<div class="list-item">
											
												<?php if(!empty($cat->category_icon)){ ?>
												<?php echo '<img src="'.base_url().'/uploads/category/'.$cat->category_icon.'" />'; ?>
										
												<?php } ?>
												<h5 class="mb-0 mt-3 title-sm fw-bolder"><?php echo $cat->name; ?></h5>
											</div>
										</a>
									</div>
								<?php } } ?>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
            </div>                    
		</div>
	</div>

    
<?= $this->endSection() ?>