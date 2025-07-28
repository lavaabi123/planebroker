
		<?php if(!empty($categories)){ ?>
		<div class="d-grid grid-col-4">
		<?php foreach($categories as $cat){ ?>
			<div class="item">
				<div class="provider-Details mb-4">
					<div class="providerImg mb-3">
						<a href="<?php echo base_url('/listings/'.$cat['permalink'].'/'.$cat['id'].'/'.(!empty($cat['name'])?str_replace(' ','-',strtolower($cat['name'])):'')); ?>">
						<img class="d-block w-100" alt="..." src="<?php echo $cat['image']; ?>">
						<?php if(!empty($cat['is_premium_listing'])){ ?><span class="pl-tag">Premium Listing</span><?php } ?>
						<?php if(!empty($cat['aircraft_status']) && $cat['aircraft_status'] != 'Available'){ ?><span class="pl-tag" style="   bottom: 10px;top: auto;"><?php echo $cat['aircraft_status']; ?></span><?php } ?>
						</a>
						<span class="wishlist favorite-btn <?php echo !empty($cat['wishlist_added']) ? 'wishlist-added' : ''; ?>" role="button" data-wish="<?php echo !empty($wishlist_added) ? 1 : 0; ?>" data-product-id="<?= $cat['id']; ?>"><img class="icons" src="<?php echo base_url('assets/frontend/images/wishlist.png'); ?>" /></span>
					</div>
					<a href="<?php echo base_url('/listings/'.$cat['permalink'].'/'.$cat['id'].'/'.(!empty($cat['name'])?str_replace(' ','-',strtolower($cat['name'])):'')); ?>">
						<div class="pro-content">
							<h5 class="fw-medium title-xs"><?php echo !empty($cat['name']) ? $cat['name'] : '-'; ?></h5>
							<h5 class="fw-medium text-primary title-xs"><?php echo $cat['sub_cat_name']; ?></h5>
							<p class="text-grey mb-3"><?php echo $cat['address']; ?></p>
							<h5 class="fw-medium title-xs"><?php echo ($cat['price'] != NULL) ? 'USD $'.number_format($cat['price'], 2, '.', ',') : 'Call for Price'; ?></h5>
						</div>
					</a>
				</div>
			</div>
		<?php } ?>
		</div>
		<?php }else{ ?>
			<div class="d-flex flex-column flex-md-row no-list align-items-center justify-content-center gap-4 my-5 py-md-5">
						<div class="mb-4 mb-md-5">
							<h3 class="fw-bolder my-0">No results found</h3>
						</div>
						<div class="">
						<img src="<?php echo base_url('assets/frontend/images/nolist.png'); ?>" />
						</div>
					</div>
		<?php } ?>