<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
					<?php $tot1 = !empty($total_amount['total_amount']) ? $total_amount['total_amount'] : '0.00';
						$tot2 = !empty($total_amount1['total_amount']) ? $total_amount1['total_amount'] : '0.00';	$tot = $tot1 + $tot2;				?>
                    <h1 class="m-0"><?php echo $title ?> : Total Amount : $<?php echo number_format($tot,2); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
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
			<div class="filter_Sec">
				<?php echo $this->include('admin/users/_filter_sales') ?>
			</div>
            <div class="row filter_list">
                <?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
                    <div class="card p-0">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
								<h6><b>Stripe</b></h6>
								<h6 class="text-right"><b>Total Amount : <?php echo !empty($total_amount['total_amount']) ? $total_amount['total_amount'] : '0.00'; ?></b></h6>
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <!--<th width="20"><?php echo trans('id'); ?></th>-->
                                                    <th><?php echo trans('Provider'); ?></th>
                                                    <th><?php echo trans('Subscription Start Date'); ?></th>
                                                    <th><?php echo trans('Subscription End Date'); ?></th>
                                                    <th><?php echo trans('Amount Paid'); ?></th>
                                                    <th><?php echo trans('Paid On'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($sales as $s => $sale) : ?>
                                                    <tr>
                                                        <!--<td><?php echo clean_number($sale['id']); ?></td>-->
                                                        <td><?php echo $sale['provider']; ?> </td>
                                                        <td><?php echo formatted_date($sale['stripe_subscription_start_date'],'m/d/Y'); ?></td>
                                                        <td><?php echo formatted_date($sale['stripe_subscription_end_date'],'m/d/Y'); ?></td>
                                                        <td><?php echo $sale['stripe_subscription_amount_paid']; ?></td>
                                                        <td><?php echo formatted_date($sale['created_at'],'m/d/Y'); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($sales)) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php echo $paginations ?>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
				<div class="col-lg-12 col-xl-12">
                    <div class="card p-0">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
								<h6><b>Paypal</b></h6>
								<h6 class="text-right"><b>Total Amount : <?php echo !empty($total_amount1['total_amount']) ? $total_amount1['total_amount'] : '0.00'; ?></b></h6>
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <!--<th width="20"><?php echo trans('id'); ?></th>-->
                                                    <th><?php echo trans('Provider'); ?></th>
                                                    <th><?php echo trans('Subscription Start Date'); ?></th>
                                                    <th><?php echo trans('Subscription End Date'); ?></th>
                                                    <th><?php echo trans('Amount Paid'); ?></th>
                                                    <th><?php echo trans('Paid On'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($sales1 as $s => $sale) : ?>
                                                    <tr>
                                                        <!--<td><?php echo clean_number($sale['id']); ?></td>-->
                                                        <td><?php echo $sale['provider']; ?> </td>
                                                        <td><?php echo !empty($sale['stripe_subscription_start_date']) ? formatted_date($sale['stripe_subscription_start_date'],'m/d/Y') : ''; ?></td>
                                                        <td><?php echo !empty($sale['stripe_subscription_end_date']) ? formatted_date($sale['stripe_subscription_end_date'],'m/d/Y') : ''; ?></td>
                                                        <td><?php echo $sale['transaction_amount']; ?></td>
                                                        <td><?php echo formatted_date($sale['created_at'],'m/d/Y'); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($sales1)) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php echo $paginations1 ?>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<div class="loader"></div>
<?php echo $this->endSection() ?>