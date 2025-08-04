
		<?php if(!empty($is_get)){ ?>
		<h6 class="mb-2 px-4 pt-3 TwCenMT fw-normal">Applied Filters</h6>
		<div class="selected-filter pb-3 px-4">
		<?php 
		$f_count = 0;
			foreach($filter_texts as $f => $filter_text){ 
			 if ($f === 'sort_by') continue;
			if(is_array($filter_text)){
			foreach($filter_text as $ft => $filtert){
			$f_count++;
			?>		
			<div class="selected applied-filter" data-name="<?php echo $f; ?>" data-value="<?php echo ($f == 'category') ? (!empty(explode('-',$filtert)[0]) ? explode('-',$filtert)[0] : $filtert) : $filtert ; ?>"><?php echo ($f == 'category') ? (!empty(explode('-',$filtert)[1]) ? explode('-',$filtert)[1] : $filtert) : $filtert; ?> <i class="fa-solid fa-xmark remove-filter" role="button"></i></div>
		<?php  } }else{ if(!empty($filter_text)){ $f_count++; ?>
			<div class="selected applied-filter" data-name="<?php echo $f; ?>" data-value="<?php echo $filter_text; ?>"><?php echo $filter_text; ?> <i class="fa-solid fa-xmark remove-filter" role="button"></i></div>
			<?php } } } 
			?>
		</div>
		<?php } ?>