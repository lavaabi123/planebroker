<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ;

$orders = array('created_at', 'location_id', 'name');
$order = !empty($_GET['order']) && in_array($_GET['order'], $orders) ? 'u.'.$_GET['order']:'u.created_at';
if($order == 'u.name'){ $order = 'name'; $dir = 'asc'; }elseif($order == 'u.created_at'){ $dir = 'desc'; }else{ $dir = 'asc'; }

function createUrl($key, $val, $add){
	return changeQuery($key, $val, $add, false, array('location', 'category'));
}
function checkbox($name){
	$return = "data-href='"; 
	if(!empty($_GET[$name])){ 
		$return .= createUrl($name, '0', false)."' checked='checked"; 
	}else{ 
		$return .= createUrl($name, '1', true); 
	}
	$return .= "'";
	return $return;
}
function radio($name, $val){
	if(!empty($_GET[$name]) && $_GET[$name] == $val){ 
		$return = "data-href='".createUrl($name, false, false)."'";
	}else{
		$return = "data-href='".createUrl($name, $val, false)."'";	
	} 
	if(!empty($_GET[$name]) && $_GET[$name] == $val){ 
		$return .= " checked='checked'"; 
	}
	return $return;
}
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>   
<div class="d-flex flex-column flex-sm-row">
	<div class="filter left-section">	
		<?php if(!empty($filter_texts['category_id'])){ ?>
		<h5 class="text-center">Applied Filters</h5>
		<div class="selected-filter text-center">
		<?php foreach($filter_texts as $f => $filter_text){ foreach($filter_text as $ft => $filtert){ ?>		
			<div class="selected"><?php echo explode('-',$filtert)[1]; ?> <i class="fa-solid fa-xmark" data-name="<?php echo $f; ?>" data-value="<?php echo explode('-',$filtert)[0]; ?>" role="button"></i></div>
		<?php 
		if($ft > 3){ ?>
			<button class="viewSelected">View All Selected Filters</button>
		<?php } } } ?>
		</div>
		<?php } ?>
		<h5 class="text-center mt-3">Search Filter</h5>
		<div class="accordion accordion-flush" id="searchFilter">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Category
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#searchFilter">
      <div class="accordion-body">
		<div class="sFields"><label for="category_1"><input type="checkbox" <?php echo in_array(1,$filter_ids['category_ids']) ? 'checked' : ''; ?> name="category[]" value="1" id="category_1"> <span>Jet Aircraft</span></label></div>
		<div class="sFields"><label for="category_2"><input type="checkbox" <?php echo in_array(2,$filter_ids['category_ids']) ? 'checked' : ''; ?> name="category[]" value="2" id="category_2"> <span>Piston Helicopters</span></label></div>
		<div class="sFields"><label for="category_3"><input type="checkbox" name="category[]" id="category_3"> <span>Turbine Helicopters</span></label></div>
	  </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        Manufacturer
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#searchFilter">
      <div class="accordion-body">
		<div class="sFields"><label for="category_1"><input type="checkbox" id="category_1"> <span>Jet Aircraft</span></label></div>
		<div class="sFields"><label for="category_2"><input type="checkbox" id="category_2"> <span>Piston Helicopters</span></label></div>
		<div class="sFields"><label for="category_3"><input type="checkbox" id="category_3"> <span>Turbine Helicopters</span></label></div>
	  </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Model
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#searchFilter">
      <div class="accordion-body">
		<div class="sFields">
			<input id="range-input-min-Year" type="number" step="1" placeholder="Min" class="range-input" value="">
			<input id="range-input-max-Year" type="number" step="1" placeholder="Max" class="range-input" value="">
			<button class="btn">Search</button>
		</div>
	  </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingFour">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
        Serial/Series #
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#searchFilter">
      <div class="accordion-body">
		<div class="sFields">
			<input class="text-input" type="text" placeholder="Enter Registration #" name="RegNumber" id="RegNumber" min="0" value="">
			<button class="btn">Search</button>
		</div>
	  </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingFive">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
        Search Results by Date
      </button>
    </h2>
    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#searchFilter">
      <div class="accordion-body">
		<div class="sFields">
			<input class="range-input" type="date" class="range-input" value="">
			<input class="range-input" type="date" class="range-input" value="">
			<button class="btn">Search</button>
		</div>
	  </div>
    </div>
  </div>
</div>
	</div>
	
	<div class="carftList right-section">
		<h3 class="text-center d-blue fw-bolder my-5">Aircraft for Sale</h3>
		<div class="advSearch mb-5">
			<h5 class="mb-0">Quick Search</h5>
			<form class="form-input p-3 search-form" method='get' id="searchForm1" action='<?php echo base_url(); ?>/listings/<?php echo $category; ?>'>
					<?= csrf_field() ?>
					<div class="form-section align-items-center d-flex flex-column flex-sm-row gap-2 gap-sm-3">

						<div class="form-group w-100">

							<select name='category' multiple class='form-control mb-0'>

								<option value=''>All Categories</option>

								<?php if(!empty($categories_list)){

									foreach($categories_list as $row){ ?>

									<option value="<?php echo $row->id; ?>" <?php echo in_array($row->id,$filter_ids['category_ids']) ? 'selected' : ''; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						
						<div class="form-group w-100">

							<select name='man_id' class='form-control mb-0'>

								<option value=''>All Manufacturers</option>

								<?php if(!empty($categories_list)){

									foreach($categories_list as $row){ ?>

									<option value=<?php echo $row->id; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						<div class="form-group w-100">

							<input type="text" class="mb-0" id="keyword" placeholder="Search by Keyword"	/>

						</div>

						

						<input type='submit' value='Search' class='btn mb-0'>

					</div>

				</form>
		</div>
		<?php if(!empty($categories)){ ?>
		<div class="d-grid grid-col-4">
		<?php foreach($categories as $cat){ ?>
			<div class="item">
				<a href="<?php echo base_url('/listings/'.$cat['permalink'].'/'.$cat['id'].'/'.str_replace(' ','-',strtolower($cat['name']))); ?>">
					<div class="provider-Details mb-4">
						<div class="providerImg mb-3">
							<img class="d-block w-100" alt="..." src="<?php echo $cat['image']; ?>">
						</div>
						<div class="pro-content">
							<h5 class="fw-medium title-xs"><?php echo !empty($cat['name']) ? $cat['name'] : '-'; ?></h5>
							<h5 class="fw-medium text-primary title-xs"><?php echo $cat['sub_cat_name']; ?></h5>
							<p class="text-grey mb-3"><?php echo $cat['city'].', '.$cat['state_code'].' '.$cat['zipcode']; ?></p>
							<h5 class="fw-medium title-xs"><?php echo ($cat['price'] != NULL) ? 'USD $'.$cat['price'] : 'Call for Price'; ?></h5>
						</div>
					</div>
				</a>
			</div>
		<?php } ?>
		</div>
		<?php } ?>
		<div class="container py-5 text-center">
			<img src="<?= base_url('assets/frontend/images/ads-hoz.jpg') ?>">
		</div>
		<div class="advSearch mb-5">
			<h5 class="mb-0">Quick Search</h5>
			<form class="form-input p-3 search-form" method='post' id="searchForm2" action='<?php echo base_url(); ?>/providers'>

					<div class="form-section align-items-center d-flex flex-column flex-sm-row gap-2 gap-sm-3">

						<div class="form-group w-100">

							<select name='category' multiple class='form-control mb-0'>

								<option value=''>All Categories</option>

								<?php if(!empty($categories_list)){

									foreach($categories_list as $row){ ?>

									<option value=<?php echo $row->id; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						
						<div class="form-group w-100">

							<select name='category_id' class='form-control mb-0'>

								<option value=''>All Manufacturers</option>

								<?php if(!empty($categories_list)){

									foreach($categories_list as $row){ ?>

									<option value=<?php echo $row->id; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						<div class="form-group w-100">

							<input type="text" class="mb-0" id="keyword" placeholder="Search by Keyword"	/>

						</div>

						

						<input type='submit' value='Search' class='btn mb-0'>

					</div>

				</form>
		</div>
	</div>
</div>
  
<div class="loader"></div>	
<?php
$query = '';
$query1 = '';
if(!empty($_GET)){
	$query1 = http_build_query($_GET);
}
if(!empty($query1)){
	$query .= '?'.$query1;
}
?>
<input name="urlget" type="hidden" id="urlget" value="<?php echo $query; ?>" />	
<input name="urlload" type="hidden" id="urlload" value="<?php echo substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "?")); ?>" />	
<input name="urlfinal" type="hidden" id="urlfinal" value="<?php echo substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "?")).''.$query; ?>" />	
<script>
document.querySelectorAll('.search-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const url = new URL(form.action, window.location.origin);
        const params = new URLSearchParams();

        ['category[]'].forEach(name => {
            const selected = [...form.querySelectorAll('[name="${name}"] option:checked')]
                .map(opt => opt.value)
                .filter(val => val);

            if (selected.length > 0) {
                const newName = name.replace('[]', '');
                params.set(newName, selected.join('|'));
            }
        });

        const manufacturer = form.querySelector('[name="manufacturer"]');
        if (manufacturer && manufacturer.value) {
            params.set('manufacturer', manufacturer.value);
        }

        window.location.href = url.pathname + '?' + params.toString();
    });
});
</script>

</script>


<?= $this->endSection() ?>
