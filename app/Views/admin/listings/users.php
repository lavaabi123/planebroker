<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
    <div class="content-wrapper">
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

		<div class="titleSec text-center mb-4">
			<h5>Select User for the Listing</h5>
		</div>
		<div class="container-fluid">
		<form action="<?php echo admin_url().'listings/add'; ?>" method="GET">
			<div class="row justify-content-around" style="flex-direction: column;align-content: center;">
				<?php if(!empty($users)){ ?>
				<select name="user_id" class="form-control col-sm-7 col-lg-5 mx-auto" required>
				<option value="">Select</option>
				<?php foreach($users as $user){ ?>	
					<option value="<?php echo $user->id; ?>"><?php echo $user->fullname; ?></option>
				<?php } ?>
				</select>
				<?php } ?>
				<div class="mt-4 text-center"><input type="submit" class="btn" value="Next" /></div>
			</div>
		</form>
		</div>
		</div>
<?= $this->endSection() ?>