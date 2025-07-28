<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0"><?php echo $title ?>
						<a class="btn btn-primary" href="<?php echo admin_url() . 'listings/sales'; ?>"><?php echo trans('Back'); ?></a>
						</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<?php if ($title === 'Dashboard') : ?>
								<li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
							<?php else :  ?>
								<li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
								<li class="breadcrumb-item"><a href="<?php echo admin_url() ?>listings"><?php echo trans('Listings') ?></a></li>
								<li class="breadcrumb-item active"><?php echo $title ?></li>
							<?php endif  ?>

						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<div class="titleSec text-center mb-4">
			<h5>Select Package for the Listing </h5>
		</div>
			<div class="container-fluid">
				<div class="dbContent">
					<div id="advanced_options" class="pb-md-5">
						<div class="row">
							<div class="type_list new_list col-centered col-12 px-md-5">
								<div class="row row-gap-4">
								<?php if(!empty($categories)){ 
									foreach($categories as $cat){ ?>
									<div class="col-6 col-md-3 text-center">
										<a href="<?php echo admin_url().'listings/add?category='.$cat->id.'&plan_id='.$_GET['plan_id'].'&user_id='.$_GET['user_id'].'&sale_id='.$sale_id;?>">
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
					<!--<div class="mt-5 mb-md-4 text-center">
						<h3 class="title-lg fw-bolder mb-3">Selected user have <span class="text-primary"><?php echo $product_count; ?></span> lisiting:</h3>
						<a href="<?php echo admin_url().'listings?user_id='.$_GET['user_id'];?>" class="btn text-uppercase py-3 lh-lg">View Listing</a>
					</div>-->
				</div>
            </div>  
	</div>

    
<?= $this->endSection() ?>