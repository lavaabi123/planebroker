<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>ad"><?php echo trans('Ad') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <?php echo form_open_multipart('admin/ad/edit_ad_post', ['id' => 'form', 'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                        </div>
                        <div class="card-body p-0">
							<input type="hidden" name="id" value="<?php echo html_escape($ad->id); ?>">
							<input type="hidden" id="crsf">

							<div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class=" ml-0"><?php echo trans("Ad Link"); ?><span class="required"> *</span></label>
                                        <input type="text" name="ad_link" class="form-control auth-form-input" placeholder="<?php echo trans("Ad Link"); ?>" value="<?php echo $ad->ad_link; ?>" required>
                                    </div>
									<div class="form-group mb-3">
										<label class=" ml-0"><?php echo trans("Ad Image"); ?><span class="required"> *</span> (1200x300 for banners, 300x600 for sidebar)</label>
										<input type="file" name="image" class="form-control auth-form-input" value="" >
									</div>
									<input type="hidden" name="image_name" value="<?php echo !empty($ad->image) ? $ad->image : ''; ?>" />
									<div class="form-group mb-3">
									  <label class="ml-0"><?php echo trans("Page"); ?><span class="required"> *</span></label>
									  <select name="page_name" id="page_name" class="form-control" required>
										<option value="" <?php echo ($ad->page_name == '') ? 'selected':''; ?>>Select</option>
										<option value="Home" <?php echo ($ad->page_name == 'Home') ? 'selected':''; ?>>Home</option>
										<?php
										if(!empty($categories_list)){
											foreach($categories_list as $category_row){ ?>
												<option <?php echo ($ad->page_name == $category_row->id) ? 'selected':''; ?> value="<?php echo $category_row->id; ?>"><?php echo $category_row->name; ?></option>
										<?php }
										}
										?>
										<!-- add more pages here as needed -->
									  </select>
									</div>
									<div class="form-group mb-3">
									  <label class="ml-0"><?php echo trans("Position"); ?><span class="required"> *</span></label>
									  <select name="page_position" id="page_position" class="form-control" required>
										<option value="" <?php echo ($ad->page_position == '') ? 'selected':''; ?>>Select</option>

										<!-- Link each position to one or more pages via data-pages -->
										<option value="Top"  <?php echo ($ad->page_position == 'Top') ? 'selected':''; ?>  data-pages="Home">Header Banner (Top of Page)</option>
										<option value="Left"  <?php echo ($ad->page_position == 'Left') ? 'selected':''; ?> data-pages="Home">Side Banner (Left of Page)</option>
										<option value="Right" <?php echo ($ad->page_position == 'Right') ? 'selected':''; ?> data-pages="Home">Side Banner (Right of Page)</option>
										<option value="Bottom" <?php echo ($ad->page_position == 'Bottom') ? 'selected':''; ?> data-pages="Home">Footer Banner (Bottom of Page)</option>

										<?php
										if(!empty($categories_list)){
											foreach($categories_list as $category_row){ ?>
												<option value="Top" <?php echo ($ad->page_name == $category_row->id && $ad->page_position == $category_row->id) ? 'selected':''; ?> data-pages="<?php echo $category_row->id; ?>">Top Banner (Top of Page)</option>
												<option value="Left" <?php echo ($ad->page_name == $category_row->id && $ad->page_position == $category_row->id) ? 'selected':''; ?> data-pages="<?php echo $category_row->id; ?>">Side Banner (Left of Page)</option>
												<option value="Right" <?php echo ($ad->page_name == $category_row->id && $ad->page_position == $category_row->id) ? 'selected':''; ?> data-pages="<?php echo $category_row->id; ?>">Side Banner (Right of Page)</option>
												<option value="Bottom" <?php echo ($ad->page_name == $category_row->id && $ad->page_position == $category_row->id) ? 'selected':''; ?> data-pages="<?php echo $category_row->id; ?>">Footer Banner (Bottom of Page)</option>
										<?php }
										}
										?>

										<!-- Example: make an option available to multiple pages
										<option value="Middle" data-pages="Home,About Us,Contact">Middle Banner</option> -->
									  </select>
									</div>
									<?php
									$startDate = !empty($ad->start_date) ? $ad->start_date : '';
									$endDate   = !empty($ad->end_date) ? $ad->end_date : '';
									?>
									<div class="form-group mb-3">
										<label class="ml-0" for="ad_date_range">
											Ad Show - Date Range <span class="required">*</span>
										</label>
										<input type="text"
											   id="ad_date_range"
											   name="ad_date_range"
											   class="form-control"
											   placeholder="Select start and end date"
											   autocomplete="off"
											   value="<?php echo ($startDate && $endDate) ? $startDate . ' → ' . $endDate : ''; ?>"
											   required>

										<!-- Hidden fields for backend -->
										<input type="hidden" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
										<input type="hidden" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
									</div>
									<div class="form-group mb-3">
										<label class=" ml-0"><?php echo trans("Status"); ?><span class="required"> *</span></label>
										<select name="status" class="form-control" required>
										<option value="1" <?php echo ($ad->status == 1) ? 'selected':''; ?>>Active</option>
										<option value="2" <?php echo ($ad->status == 2) ? 'selected':''; ?>>Inactive</option>
										</select>
									</div>
									<div class="form-group mb-3">
										<button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
									</div>
									<div class="card-footer p-0 pt-3 clearfix" style="clear: both;">
										<small><strong><span class="required"> *</span> Must be filled</strong></small>
									</div>
                                </div>
								<div class="col-6">
								<?php if(!empty($ad->image)){ ?>
									<img style="max-width:100%;" src="<?php echo !empty($ad->image) ? base_url().'/uploads/ad/'.$ad->image : ''; ?>" />
								<?php } ?>
								</div>
							</div>

                        <!-- /.card -->
                    </div>
                </div>
            </div> <!-- end col -->

        </div>
        <?php echo form_close(); ?>
        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<script>
$(function () {
  const $range = $('#ad_date_range');
  const $start = $('#start_date');
  const $end   = $('#end_date');

  $range.daterangepicker({
    autoUpdateInput: false,          // we’ll format the text ourselves
    alwaysShowCalendars: true,
    showDropdowns: true,
    locale: {
      format: 'YYYY-MM-DD',
      applyLabel: 'Apply',
      cancelLabel: 'Clear'
    }
    // Optional: limit dates
    // minDate: moment().startOf('day'),
    // maxDate: moment().add(1, 'year')
  });

  $range.on('apply.daterangepicker', function (ev, picker) {
    const s = picker.startDate.format('YYYY-MM-DD');
    const e = picker.endDate.format('YYYY-MM-DD');
    $(this).val(s + ' → ' + e);  // visible text
    $start.val(s);               // hidden fields for backend
    $end.val(e);
  });

  $range.on('cancel.daterangepicker', function () {
    $(this).val('');
    $start.val('');
    $end.val('');
  });

  // Optional safety check on submit (in case of manual edits)
  $('form').on('submit', function (e) {
    const s = moment($start.val(), 'YYYY-MM-DD', true);
    const eD = moment($end.val(), 'YYYY-MM-DD', true);
    if (!s.isValid() || !eD.isValid() || eD.isBefore(s)) {
      e.preventDefault();
      alert('Please choose a valid date range (End must be on/after Start).');
    }
  });
});
</script>
<script>
(function () {
  const $page = document.getElementById('page_name');
  const $pos  = document.getElementById('page_position');

  // Keep an original copy of all options
  const allOptions = Array.from($pos.options).map(o => o.cloneNode(true));

  function filterPositions() {
    const page = $page.value.trim();

    // rebuild the select each time from the master list
    $pos.innerHTML = '';
    allOptions.forEach(opt => {
      const pagesAttr = opt.getAttribute('data-pages');

      // Always keep the placeholder "Select" option (no data-pages)
      if (!pagesAttr) {
        $pos.appendChild(opt.cloneNode(true));
        return;
      }

      // Check if this option is allowed for the chosen page
      const pages = pagesAttr.split(',').map(s => s.trim());
      if (page && pages.includes(page)) {
        $pos.appendChild(opt.cloneNode(true));
      }
    });

    // If nothing selected after filtering, set to placeholder
    if (!$pos.value) $pos.value = '';
  }

  $page.addEventListener('change', filterPositions);
  filterPositions(); // run once on load (respects preselected "old" values server-side)
})();
</script>
<?php echo $this->endSection() ?>