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
<style>
#filterSidebar{
    max-height:100vh;
    overflow-y:auto;
}
.z-999{
	z-index:999 !important;
}
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/owlcarousel/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/owlcarousel/owl.carousel.js"></script>   
<div class="d-flex flex-column flex-sm-row justify-content-end">
	<div class="filter left-section offcanvas-body" id="filterSidebar">	
		<div class="d-flex align-items-center justify-content-between py-3 px-4 bg-white z-2 border-bottom position-sticky top-0">
			<h6 class="text-start TwCenMT fw-normal">Filter & Sort</h6>
			<a class="clearSelected" role="button" style="display:<?= !empty($is_get) ? '' : 'none' ; ?>;">Clear All</a>
			<button class="btn-close w-auto h-auto p-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar" aria-controls="filterSidebar" aria-expanded="false" aria-label="Close">
				<i class="fa-solid fa-xmark fs-3"></i>
			 </button>
		</div>
		<div class="pb-3 bg-white w-100 h-100 m-auto overflow-auto">
		<div id="appliedFilters">
			<?= view('Providers/applied_filters', [
            'is_get'       => $is_get,        // 👈 first variable
            'filter_texts' => $filter_texts,  // 👈 second variable
            'category'     => $category       // used for “Clear All” link
        ]) ?>
		</div>
		<div class="">
		<!--h6 class="mt-2 px-4">Search Filter</h6-->
		<form class="form-input pb-3 search-form needs-ajax" method='get' id="searchFilter" action='<?php echo base_url(); ?>/listings/<?php echo $category; ?>'>
		<div id="filterSidebarContent">
			<?= view('Providers/filter_sidebar', [
				'filters'         => $filters,
				'categories_list' => $categories_list,
				'filter_ids'      => $filter_ids,
				'price_range_array' => $price_range_array,
				'category'        => $category,
				'is_get'          => $is_get,
				'manufacturers'   => $manufacturers,
				'models'          => $models,
				'filter_texts'    => $filter_texts,
				'result_count'    => $result_count,
			]) ?>
		</div>
	</form>
	</div>
		
		</div>
		<div class="d-flex align-items-center justify-content-between py-3 px-4 bg-white z-999 border-top position-sticky bottom-0">
			<button class="btn w-100" data-bs-toggle="collapse" data-bs-target="#filterSidebar" aria-controls="filterSidebar" aria-expanded="false" aria-label="Close">Apply (<span id="applyCount" class="badge p-1"><?= $result_count ?></span>)</button> 
		</div>
	</div>
	
	<div class="carftList right-section">
		<div class="container-xl">
		<h3 class="text-center d-blue fw-bolder mt-5 mb-3 my-md-5"><?php echo !empty($category_detail->skill_name) ? $category_detail->skill_name : 'Aircraft for Sale'; ?></h3>
		
		<div class="row mb-5">
			<div class="col-sm-3 align-self-end">
			<div class="filterSort p-3">
				<button class="btn filterBtn min-w-auto" type="button" data-bs-toggle="collapse" data-bs-target="#filterSidebar" aria-controls="filterSidebar" aria-expanded="false" aria-label="Toggle navigation">
					Filter & Sort <img src="<?php echo base_url('assets/frontend/images/edit.png'); ?>" />				
				</button>
			</div>
			</div>
			<div class="col-sm-9">
				<div class="advSearch">
					<h5 class="mb-1">Quick Search</h5>
					<form class="form-input p-3 search-form" method='get' id="mySearchForm" action='<?php echo base_url(); ?>/listings/<?php echo $category; ?>'>
						<div class="form-section align-items-center d-flex flex-column flex-sm-row gap-2 gap-sm-3">

							<div class="form-group w-100">
								<select name='category[]' type="select" class='form-control mb-0'>

									<option value=''>All Categories</option>

									<?php if(!empty($categories_list)){

										foreach($categories_list as $row){ ?>

										<option value="<?php echo $row->id; ?>" <?php echo in_array($row->id,$filter_ids['category_ids']) ? 'selected' : ''; ?>><?php echo $row->name; ?></option>

									<?php } } ?>

								</select>	

							</div>
							
							<div class="form-group w-100">
								<select name='manufacturer[]' type="select" class='form-control mb-0'>

									<option value=''>All Manufacturers</option>

									<?php if(!empty($manufacturers)){
										foreach($manufacturers as $i => $row){ ?>
										<option value="<?php echo $row->name; ?>" <?php echo in_array($row->name,$filter_ids['manufacturer']) ? 'selected' : ''; ?>><?php echo $row->name; ?></option>

									<?php } } ?>

								</select>	

							</div>
							<div class="form-group w-100">

								<input type="text" class="mb-0" id="keyword" name="keywords" placeholder="Search by Keyword" value="<?php echo !empty($_GET['keywords']) ? $_GET['keywords'] :''; ?>"	/>

							</div>

							

							<input type='submit' value='Search' class='btn mb-0'>
							
							

						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="productGrid">
			<?= view('Providers/product_cards', ['categories' => $categories]) ?>
		</div>
		
		<div class="container py-5 text-center">
			<a href="https://parkrapidsavionics.com/" target="_blank"><img src="<?= base_url('assets/frontend/images/ad/Park-Rapids-Web-Banner.jpg') ?>"></a>
		</div>
		<div class="advSearch mb-5">
			<h5 class="mb-1">Quick Search</h5>
			<form class="form-input p-3 search-form" method='get' id="mySearchForm2" action='<?php echo base_url(); ?>/listings/<?php echo $category; ?>'>

					<div class="form-section align-items-center d-flex flex-column flex-sm-row gap-2 gap-sm-3">

						<div class="form-group w-100">
							<select name='category[]' type="select" class='form-control mb-0'>

								<option value=''>All Categories</option>

								<?php if(!empty($categories_list)){

									foreach($categories_list as $row){ ?>

									<option value="<?php echo $row->id; ?>" <?php echo in_array($row->id,$filter_ids['category_ids']) ? 'selected' : ''; ?>><?php echo $row->name; ?></option>

								<?php } } ?>

							</select>	

						</div>
						
						<div class="form-group w-100">

							<select name='manufacturer[]' type="select" class='form-control mb-0'>

								<option value=''>All Manufacturers</option>

								<?php if(!empty($manufacturers)){

									foreach($manufacturers as $row){ ?>
									<option value="<?php echo $row->name; ?>"  <?php echo in_array($row->name,$filter_ids['manufacturer']) ? 'selected' : ''; ?>><?php echo $row->name; ?></option>
								<?php } } ?>

							</select>	

						</div>
						<div class="form-group w-100">

							<input type="text" class="mb-0" id="keyword" name="keywords" placeholder="Search by Keyword"  value="<?php echo !empty($_GET['keywords']) ? $_GET['keywords'] :''; ?>" />

						</div>

						

						<input type='submit' value='Search' class='btn mb-0'>

					</div>

				</form>
		</div>
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
    function fetchProducts() {
		const query = buildQuery($('#searchFilter'));
		const url   = '<?php echo base_url(); ?>/listings/<?php echo $category; ?>' + (query ? '?' + query : '');
		
		let hasRealFilters = false;
		if (query) {
			const p = new URLSearchParams(query);
			p.delete('sort_by');                 // throw away the sort param
			hasRealFilters = [...p.keys()].length > 0;
		}
		$('.clearSelected').toggle(hasRealFilters);

		
		$.getJSON(url, function (payload) {
			$('#productGrid').html(payload.grid);
			$('#appliedFilters').html(payload.filters);
			$('#filterSidebarContent').html(payload.sidebar);
			$('#applyCount').text(payload.count);

			/* recompute after DOM update (for safety) */
			const pills = $('#appliedFilters .applied-filter')
							.not('[data-name="sort_by"]')
							.length > 0;
			$('.clearSelected').toggle(pills);

			history.replaceState(null, '', url);
		});
	}
    function buildQuery($form) {
        const params = new URLSearchParams();

        /* 📦 1) check‑boxes & radios (may be array‑style names) */
        $form.find('input[type="checkbox"],input[type="radio"]').each(function () {
            if(this.name == 'price_static[]') return;
            if (!this.checked) return;

            const key   = this.name.replace(/\[\]$/, '');
            const value = this.value;
            const prev  = params.get(key);

            params.set(key, prev ? `${prev}|${value}` : value);
        });

        /* 📋 2) <select multiple> and single selects              */
        $form.find('select').each(function () {
            const name = this.name;
            if (!name) return;

            const key    = name.replace(/\[\]$/, '');
            const values = $(this).val();                // array or string

            if (values && values.length) {
                params.set(key, Array.isArray(values) ? values.join('|') : values);
            }
        });

        const groupedValues = {};

		$form.find('input[type="number"],input[type="date"],input[type="text"]').each(function () {
			const name = this.name.replace(/\[\]$/, '');      // remove []
			const val  = this.value.trim();
			if (val === '') return;

			if (!groupedValues[name]) groupedValues[name] = [];
			groupedValues[name].push(val);
		});

		// Join all grouped values using pipe (`|`)
		for (const [key, values] of Object.entries(groupedValues)) {
			params.set(key, values.join('|'));
		}

        return params.toString();                        // "cat=A|B&price=..."
    }
$(function () {

    fetchProducts();                                     // first load

    // run on *any* change inside the filter panel
    $('#searchFilter').on('input change', 'input,select', debounce(fetchProducts, 350));
	$('#searchFilter').on('change', 'input[type="radio"][name="sort_by"]', function () {
		fetchProducts();                      // run immediately on click
	});


    // keep any “Search” buttons from doing a full‑page submit
    $('#searchFilter').on('click', '.btn', function (e) {
        e.preventDefault();
        fetchProducts();
    });

    /* -------------------------------------------------- */

    /* -------------------------------------------------- */
    /* Turn the form into a ?foo=bar|baz&min=10&max=99…   */

    /* 🔹 simple debounce helper so we don’t flood requests */
    function debounce(fn, delay) {
        let id;
        return function () {
            clearTimeout(id);
            id = setTimeout(fn, delay);
        };
    }
});



$('#appliedFilters').on('click', '.remove-filter', function () {
	const $tag   = $(this).closest('.applied-filter');
	const name   = $tag.data('name');            // e.g. "total_time"
	const value  = $tag.data('value');           // e.g. "23"
console.log(name);
	/* Un‑check / clear the corresponding input(s) */
	// 1) checkboxes / radios
	if(name === 'price'){
	    $(`#searchFilter input[name="price_static[]"]`).prop('checked', false);
        $(`#searchFilter input[name="price_static"]`).prop('checked', false);
    }else{
        $(`#searchFilter input[name="${name}[]"][value="${value}"]`).prop('checked', false);
        $(`#searchFilter input[name="${name}"][value="${value}"]`).prop('checked', false);
    }

	// 2) range boxes
	if (name === 'total_time' || name === 'price') {
	    $(`#searchFilter input[name="${name}[]"]`).val('');
		$(`#searchFilter input[name="${name}[]"]`).each(function () {
			if ($(this).val() === String(value)) $(this).val('');
		});
	}

	// 3) single text field
	$(`#searchFilter input[name="${name}"]`).filter(function () {
		return $(this).val() === String(value);
	}).val('');

	fetchProducts();                             // run the filter again
});
$('.clearSelected').on('click', function (e) {
	e.preventDefault();

    const $form = $('#searchFilter');         // or $('#mySearchForm1')
    if ($form.length && $form[0].reset) {
        $form[0].reset();                     // native HTML reset
    }
	$form.find(':input').each(function () {
		const $el = $(this);

		if ($el.is(':checkbox,:radio')) {
			$el.prop('checked', false);
		} else {
			$el.val('');
		}
	});
	fetchProducts();
});

$(document).ready(function () {
	$('body').addClass('listing-page');
	
	$('input[name="price_static[]"]').on('change', function (e) {
        e.preventDefault(); // Prevent normal form submission
		$('#range-input-min-price').val($(this).attr('data-p-min'));
		$('#range-input-max-price').val($(this).attr('data-p-max'));
    });
	
	
    $('#mySearchForm').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission
		console.log('1');
		urlchange1($(this));
    });
    $('#mySearchForm1').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission
		console.log('2');
		urlchange($(this));
    });
    $('#mySearchForm2').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission
		console.log('3');
		urlchange1($(this));
    });
	
	function urlchange1(form1){
		
        const form = form1;
        const action = form.attr('action');
console.log(action);
        const url = new URL(action, window.location.origin);
        const params = new URLSearchParams();

        // Handle category[] and model[]
        form.find('[name="category[]"], [name="manufacturer[]"]').each(function () {
            const selectedValues = [];
			var name = $(this).attr('name');
            // Checkboxes
console.log(name);
            form.find(`input[name="${name}"]:checked`).each(function () {
                selectedValues.push($(this).val());
            });

            // <select multiple>
            form.find(`select[name="${name}"]`).each(function () {
				console.log($(this).find('option:selected'));
                $(this).find('option:selected').each(function () {
					if($(this).val() != ''){
						selectedValues.push($(this).val());
					}
                });
            });

console.log(selectedValues);
            if (selectedValues.length > 0) {
                const paramName = name.replace('[]', '');
                params.set(paramName, selectedValues.join('|'));
            }
        });

		// Handle single-select: manufacturer
        const keywords = form.find('[name="keywords"]').val();
        if (keywords) {
            params.set('keywords', keywords);
        }
		
				console.log(params.toString());
        // Redirect to constructed URL
		window.location.href = url.pathname + (params.toString() ? '?' + params.toString() : '');
	}
	
	function urlchange(form1){
		
        const form = form1;
        const action = form.attr('action');
console.log(action);
        const url = new URL(action, window.location.origin);
        const params = new URLSearchParams();

        // Handle category[] and model[]
        form.find('input').each(function () {
            const selectedValues = [];
			var name = $(this).attr('name');
			var f_type = $(this).attr('type');
            // Checkboxes
console.log(f_type);
if(f_type == 'checkbox'){
            form.find(`input[name="${name}"]:checked`).each(function () {
                selectedValues.push($(this).val());
            });
}

            // <select multiple>
if(f_type == 'select'){
            form.find(`select[name="${name}"]`).each(function () {
				console.log($(this).find('option:selected'));
                $(this).find('option:selected').each(function () {
					if($(this).val() != ''){
						selectedValues.push($(this).val());
					}
                });
            });
}
			//input
if(f_type == 'number' || f_type == 'date'){
            form.find(`input[name="${name}"]`).each(function () {
				console.log('hjk');
	console.log($(this).val());
				if($(this).val() != ''){
					selectedValues.push($(this).val());
				}
            });
}

if(f_type == 'text'){
            form.find(`input[name="${name}"]`).each(function () {
				if($(this).val() != ''){
					selectedValues.push($(this).val());
				}
            });
}
/*if(f_type == 'radio'){
            form.find(`input[name="${name}"]:checked`).each(function () {
                selectedValues.push($(this).val());
            });
}*/
console.log(selectedValues);
            if (selectedValues.length > 0) {
                const paramName = name.replace('[]', '');
                params.set(paramName, selectedValues.join('|'));
            }
        });

		// Handle single-select
        const keywords = form.find('[name="keywords"]').val();
        if (keywords) {
            params.set('keywords', keywords);
        }
		
				console.log(params.toString());
        // Redirect to constructed URL
		if(params.toString() == ''){
			//window.location.href = url.pathname;
		}else{
			//window.location.href = url.pathname + '?' + params.toString();
		}
	}
});
$('#mySearchForm1').on('input change', ':input', function () {
    console.log('input change');
});
$('.accordion-collapse').on('shown.bs.collapse', function () {
    this.scrollIntoView({
        behavior: 'smooth',
        block: 'end'
    });
});
$(document).on('click', '.remove-filter', function () {
    const filterValue = $(this).closest('.applied-filter').data('value');
    const filterName = $(this).closest('.applied-filter').data('name');
	const fType = $(`#mySearchForm1 input[name="${filterName}[]"]`).attr('type');
	const fType1 = $(`#mySearchForm1 input[name="${filterName}"]`).attr('type');
console.log(filterName);
	if(fType == 'checkbox'){
		// Uncheck the checkbox with the matching name and value
		$(`#mySearchForm1 input[name="${filterName}[]"][value="${filterValue}"]`).prop('checked', false);
	}
	if(fType == 'radio'){
		// Uncheck the checkbox with the matching name and value
		$(`#mySearchForm1 input[name="${filterName}[]"][value="${filterValue}"]`).prop('selected', false);
	}
	if(fType == 'select'){
		// Uncheck the checkbox with the matching name and value
		$(`#mySearchForm1 input[name="${filterName}[]"][value="${filterValue}"]`).prop('selected', false);
	}
	if(fType == 'number' || fType == 'date' || fType == 'created_at'){    
		$(`#mySearchForm1 input[name="${filterName}[]"]`).val('');
	}
	if(filterName == 'featured'){    
		$(`#mySearchForm1 input[name="${filterName}"]`).prop('checked', false);
	}
	if(fType1 == 'text'){    
		$(`#mySearchForm1 input[name="${filterName}"]`).val('');
	}

    // Submit the form
    $('#mySearchForm1').submit();
});
$(document).ready(function(){
    $('.viewSelected').on('click', function(){
        $('.hidden-filter').slideToggle();  // toggle hidden filters with animation
        // Change button text on toggle
        if($(this).text() === 'View All Selected Filters'){
            $(this).text('Hide Selected Filters');
        } else {
            $(this).text('View All Selected Filters');
            // Optional: scroll back to top of filters when hiding
            // $('html, body').animate({ scrollTop: $('.selected-filter').offset().top }, 300);
        }
    });
});
$(document).ready(function () {
  $('#filterSidebar').on('shown.bs.collapse hidden.bs.collapse', function (e) {
    if (e.target.id === 'filterSidebar') {
      $('.filter').toggleClass('search-opened');
    }
  });
});

	$(function () {

    const $box          = $('#filterSidebar');   // scroll container
    const APPLY_HEIGHT  = 72;                    // <-- adjust to your footer

    $('#searchFilter').on('shown.bs.collapse', '.accordion-collapse', function () {

        const $panel      = $(this);                     // opened item
        const boxHeight   = $box.innerHeight() - APPLY_HEIGHT;
        const scrollTop   = $box.scrollTop();

        /* coords **inside** the scroll box (not the whole page) */
        const panelTop    = $panel.position().top;                 // px from top of box
        const panelBottom = panelTop + $panel.outerHeight();        // bottom edge

        /* ------------------------------------------------------ */
        /* 1 · Panel bottom hidden under footer   → scroll down    */
        /*    Amount = the hidden part plus a 12 px cushion       */
        /* ------------------------------------------------------ */
        if (panelBottom > boxHeight) {

            let delta = panelBottom - boxHeight + 12;

            /* If panel itself is taller than visible area,       */
            /* scroll so its TOP is flush with the top of view    */
            if ($panel.outerHeight() > boxHeight) {
                delta = panelTop - 12;        // bring top into view
            }

            $box.stop().animate({ scrollTop: scrollTop + delta }, 300);
        }

        /* ------------------------------------------------------ */
        /* 2 · Panel top hidden above view   → scroll up           */
        /* ------------------------------------------------------ */
        else if (panelTop < 0) {
            $box.stop().animate({ scrollTop: scrollTop + panelTop - 12 }, 300);
        }
    });
});
</script>
<style>
.hidden-filter {
    display: none;
}
.selected-filter button.clearSelected {
    border: none;
    background: transparent;
    font-size: 14px;
    text-decoration: underline;
	line-height: normal;
	font-family: 'TwCenMT';
	text-underline-offset: 2px;
	margin-top: 10px;
}
</style>

<?= $this->endSection() ?>
