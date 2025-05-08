<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="plan bg-gray pt-2 pb-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-3 mb-xl-4">
			<h3 class="title-lg dblue mb-0 mb-sm-5"><?php echo $title; ?></h3>
		</div>
		<div class="container">
			<div class="row">
			<div class="leftsidecontent col-12 col-sm-4 col-lg-3">
			<?php echo $this->include('Common/_sidemenu') ?>
			</div>
			<div class="col-12 col-sm-8 col-lg-9">
			<div id="advanced_options">
				<div class="row">
					<div class="type_list new_list col-centered">
						<div class="row">
						<?php if(!empty($categories)){ 
							foreach($categories as $cat){ ?>
							<div class="col-md-3 text-center">
								<a href="<?php echo base_url().'/add-listing?type='.$cat->id;?>">
									<div class="list-item">
									
										<?php if(!empty($cat->category_icon)){ ?>
										<?php header("Content-Type: image/svg+xml");
										readfile(base_url().'/uploads/category/'.$cat->category_icon); ?>
								
										<?php } ?>
										<h5 class="mb-0 mt-3 title-xs"><?php echo $cat->name; ?></h5>
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
<?= $this->endSection() ?>