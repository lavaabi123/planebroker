
		<div class="accordion accordion-flush" id="searchFilter">
	<div class="accordion-item">
  <h2 class="accordion-header" id="flush-heading-sort">
    <button class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapse-sort"
            aria-expanded="false"
            aria-controls="flush-collapse-sort">
      Sort By
    </button>
  </h2>

  <div id="flush-collapse-sort"
       class="accordion-collapse collapse"
       aria-labelledby="flush-heading-sort"
       data-bs-parent="#searchFilter">

    <div class="accordion-body">

      <div class="sFields">
        <label for="sort_price_asc">
          <input type="radio" name="sort_by" id="sort_price_asc"  value="price_asc">
          <span>Price (Low – High)</span>
        </label>
      </div>

      <div class="sFields">
        <label for="sort_price_desc">
          <input type="radio" name="sort_by" id="sort_price_desc" value="price_desc">
          <span>Price (High – Low)</span>
        </label>
      </div>

      <div class="sFields">
        <label for="sort_newest">
          <input type="radio" name="sort_by" id="sort_newest"     value="newest">
          <span>Newest</span>
        </label>
      </div>

      <div class="sFields">
        <label for="sort_oldest">
          <input type="radio" name="sort_by" id="sort_oldest"     value="oldest">
          <span>Oldest</span>
        </label>
      </div>

    </div>
  </div>
</div>
	
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Category
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#searchFilter">
      <div class="accordion-body">
	  <?php if(!empty($categories_list)){
		foreach($categories_list as $row){ ?>
		<div class="sFields"><label for="category_<?php echo $row->id; ?>"><input type="checkbox" <?php echo in_array($row->id,$filter_ids['category_ids']) ? 'checked' : ''; ?> name="category[]" value="<?php echo $row->id; ?>" id="category_<?php echo $row->id; ?>"> <span><?php echo $row->name; ?></span><span class="text-muted">(<?php echo $row->product_count ?? 0; ?>)</span></label></div>
	  <?php } } ?>
	  </div>
    </div>
  </div>
		<?php if(!empty($filters)){ 
			foreach($filters as $f => $filter){ 			
			//$usename = strtolower(preg_replace('/[^A-Za-z0-9]+/', '_', $filter['name']));
			$usename = $filter['slug'];
			?>			
			  <div class="accordion-item">
				<h2 class="accordion-header" id="flush-heading<?php echo $f; ?>">
				  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $f; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $f; ?>">
					<?php echo $filter['name']; ?>
				  </button>
				</h2>
				<div id="flush-collapse<?php echo $f; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $f; ?>" data-bs-parent="#searchFilter">
				  <div class="accordion-body">
				  <?php 
				  if($filter['filter_type'] == 'checkbox'){ 
				  if($filter['name']=='Manufacturer' && $category == 'aircraft-for-sale'){
					  if(!empty($manufacturers)){
							foreach($manufacturers as $r => $row){ if(!empty($row->name)){ ?>
							<div class="sFields"><label for="<?php echo $usename; ?>_<?php echo $r; ?>"><input type="checkbox" <?php echo (!empty($filter_ids[$usename]) && in_array($row->name,$filter_ids[$usename])) ? 'checked' : ''; ?> name="<?php echo $usename; ?>[]" value="<?php echo $row->name; ?>" id="<?php echo $usename; ?>_<?php echo $r; ?>"> <span><?php echo $row->name; ?></span><span class="text-muted">(<?= $row->count ?? 0 ?>)</span></label></div>
							<?php } } }
				  }else{
				  if(!empty($filter['values'])){
					foreach($filter['values'] as $r => $row){ if(!empty($row['name'])){ ?>
					<div class="sFields"><label for="<?php echo $usename; ?>_<?php echo $r; ?>"><input type="checkbox" <?php echo (!empty($filter_ids[$usename]) && in_array($row['name'],$filter_ids[$usename])) ? 'checked' : ''; ?> name="<?php echo $usename; ?>[]" value="<?php echo $row['name']; ?>" id="<?php echo $usename; ?>_<?php echo $r; ?>"> <span><?php echo $row['name']; ?></span><span class="text-muted">(<?= $row['count'] ?? 0 ?>)</span></label></div>
					<?php } } }
					}
				  }
					if($filter['filter_type'] == 'number'){ ?>
						<div class="sFields">
						<?php if(!empty($price_range_array) && $usename=='price' && count($price_range_array) > 1){ 
						foreach($price_range_array as $ta => $ra){ 
						if($ra[2] > 0){
						?>
						<label for="<?php echo $ta; ?>"><input type="radio" name="price_static[]" data-p-min="<?php echo ($ra[0] > 0) ? $ra[0] : 0; ?>" data-p-max="<?php echo $ra[1]; ?>" value="" id="<?php echo $ta; ?>"> <span><?php echo $ta.' ('.$ra[2].')'; ?></span></label>						
						<?php }}} ?>
							<input id="range-input-min-<?php echo $usename; ?>" name="<?php echo $usename; ?>[]" type="number" step="1" placeholder="Min" class="range-input" value="<?php echo (!empty($filter_ids[$usename]) && !empty($filter_ids[$usename][0])) ? $filter_ids[$usename][0] : ''; ?>">
							<input id="range-input-max-<?php echo $usename; ?>" name="<?php echo $usename; ?>[]" type="number" step="1" placeholder="Max" class="range-input" value="<?php echo (!empty($filter_ids[$usename]) && !empty($filter_ids[$usename][1])) ? $filter_ids[$usename][1] : ''; ?>">
						</div>						
					<?php }if($filter['filter_type'] == 'text'){ ?>
						<div class="sFields">
							<input class="text-input" type="text" name="<?php echo $usename; ?>" id="<?php echo $usename; ?>" placeholder="Enter <?php echo $filter['name']; ?>" min="0" value="<?php echo (!empty($filter_ids[$usename])) ? $filter_ids[$usename] : ''; ?>">
						</div>						
					<?php } ?>
				  </div>
				</div>
			  </div>
			<?php }  ?><?php } ?>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingFive">
				  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
					Search Results by Date
				  </button>
				</h2>
				<div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#searchFilter">
				  <div class="accordion-body">
					<div class="sFields">
						<input class="range-input" type="date" name="created_at[]" class="range-input" value="<?php echo (!empty($filter_ids['created_at']) && !empty($filter_ids['created_at'][0])) ? $filter_ids['created_at'][0] : ''; ?>">
						<input class="range-input" type="date" name="created_at[]" class="range-input" value="<?php echo (!empty($filter_ids['created_at']) && !empty($filter_ids['created_at'][1])) ? $filter_ids['created_at'][1] : ''; ?>">
					</div>
				  </div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="flush-headingSix">
				  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
					Show Featured
				  </button>
				</h2>
				<div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#searchFilter">
				  <div class="accordion-body">
					<div class="sFields"><label for="featured_0"><input type="checkbox" <?php echo (!empty($filter_ids['featured']) && ('yes'==$filter_ids['featured'])) ? 'checked' : ''; ?> name="featured" value="yes" id="featured_0"> <span>Yes</span></label></div>
				  </div>
				</div>
			</div>
			
					
		</div>