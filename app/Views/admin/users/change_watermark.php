<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
    <div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?>
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
		<div class="container-fluid">
			<div class="card card-primary card-outline card-outline-tabs">
				<div class="titleSec text-center mb-4">
				</div>
				<?php
$wmRel  = 'uploads/sample-watermark.png';
$wmPath = FCPATH . $wmRel;
$ver    = file_exists($wmPath) ? filemtime($wmPath) : time();
?>
				<div class="row">
					<form method="post" action="<?= base_url('admin/listings/watermark') ?>" enctype="multipart/form-data">
					  <?= csrf_field() ?>
						<label class="ml-0">Current watermark:</label>
						<img width="25%" style="background:#9d9d9d;" src="<?= base_url($wmRel) . '?v=' . $ver ?>" />
						<br />
					  <label class="mt-5 ml-0">Upload new watermark (PNG with transparency):</label>
					  <input type="file" name="watermark" class="ml-0 mt-2 w-auto" style="width: auto !important;" accept="image/png" required>
					  <br />
					  <button type="submit" name="save" class="btn btn-primary mt-5">Save only</button>
					  <button type="submit" name="apply" class="btn btn-primary mt-5">Save and Apply to ALL old images</button>
					</form>
					<div>
					</div>

				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>