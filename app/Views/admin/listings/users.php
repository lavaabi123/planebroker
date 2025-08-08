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
					<h4 class="mb-0 fw-bolder">Select User for the Listing</h4>
				</div>
				
				<div class="row">
					<form action="<?php echo admin_url().'listings/add'; ?>" method="GET" class="col-md-6 mx-auto">
					
						<?php if(!empty($users)){ ?>
						<select name="user_id" class="form-control" required>
						<option value="">Select</option>
						<?php foreach($users as $user){ ?>	
							<option value="<?php echo $user->id; ?>"><?php echo $user->fullname; ?></option>
						<?php } ?>
						</select>
						<?php } ?>
						<div class="mt-4 text-center"><input type="submit" class="btn btn-sm" value="Next" /></div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>