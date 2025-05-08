<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>

    <div class="viewProfile bg-gray pt-2 pb-4 pb-xl-5">
        <?php echo $this->include('Common/_messages') ?>
		<div class="titleSec text-center mb-0">
			<h3 class="title-xl dblue mb-0"><?php echo ($search_location_name == '') ? 'Brokers' : 'Brokers within 1 miles of '.$search_location_name; ?></h3>
		</div>
		<div class="container">
			<div class="row filterResult">
				<?php 
				$result = 0;
				if(!empty($categories)){
				foreach($categories as $k => $cat){	if(!empty($cat['providers'])){ ?>
					<div class="col-12">
						<div class="text-center">
						<h3 class="title-md mt-4 mb-4 dblue"><?php echo $cat['name']; ?></h3>
						<?php 
						if(!empty($cat['providers'])){ $result = 1; ?>
						<div class="owl-carousel owl-theme">
							<?php foreach($cat['providers'] as $p => $providers){ ?>				
							<div class="item">
								<a href="<?php echo base_url('/provider/'.$cat['permalink'].'/'.$providers['id']); ?>">
									<div class="provider-Details">
										<img src="<?php echo $providers['image']; ?>" class="img-fluid">
										<div class="bg-dgray pro-content p-3">
										<h6 class="dblue mb-0"><?php echo $providers['name']; ?></h6>
										<h5 class="dblue"><?php echo $cat['name']; ?></h5>
										<h6 class="dblue"><?php echo $providers['city']; ?></h6>
										</div>
									</div>
								</a>
							</div>
							<?php } ?>	
						</div>
									
							
						<a class="d-block mt-4 mt-sm-5" href="<?php echo base_url('/providers/'.$search_location_url.'/'.$cat['permalink']) ?>"><button class="btn">See all <?php echo $cat['total_users']; ?> <?php echo $cat['name']; ?></button></a>
						<?php }
						?>
						</div>
					</div>	
				<?php } } }
				
				if($result == 0){
					echo "No Brokers in this area, try another:";
				}?>			
			</div>
		</div>
		</div>
<div class="loader"></div>	
<script>
$('.owl-carousel').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
</script>	
<?= $this->endSection() ?>