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
                   <!-- <h1 class="m-0"><?php echo $title ?> : Total Amount : $<?php echo number_format($tot,2); ?></h1>-->
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
				<?php echo $this->include('admin/listings/_filter_sales') ?>
			</div>
            <div class="row filter_list">
                <?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
                    <div class="card p-0">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
								<h6><b>Stripe</b></h6>
								<!--<h6 class="text-right"><b>Total Amount : <?php echo !empty($total_amount['total_amount']) ? $total_amount['total_amount'] : '0.00'; ?></b></h6>-->
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th><?php echo trans('Listing Name'); ?></th>
                                                    <th><?php echo trans('Package Name'); ?></th>
                                                    <th><?php echo trans('User'); ?></th>
                                                    <th><?php echo trans('Subscription Start Date'); ?></th>
                                                    <th><?php echo trans('Subscription End Date'); ?></th>
                                                    <th><?php echo trans('Amount Paid'); ?></th>
                                                    <th><?php echo trans('Paid On'); ?></th>
                                                    <th><?php echo trans('Created by'); ?></th>
                                                    <th><?php echo trans('Subscription Status'); ?></th>
                                                    <th><?php echo trans('Payment Type'); ?></th>
                                                    <th><?php echo trans('Options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($sales as $s => $sale) : ?>
                                                    <tr>
                                                        <td><?php echo !empty($sale['display_name']) ? $sale['display_name'] : '<a href="'.admin_url().'listings/add?user_id='.$sale['user_id'].'&sale_id='.$sale['id'].'&plan_id='.$sale['plan_id'].'&payment_type=stripe&proceed=listing" class="btn btn-sm">Add Listing</a>'; ?></td>
                                                        <td><?php echo $sale['plan_name']; ?></td>
                                                        <td><?php echo $sale['provider']; ?></td>
                                                        <td><?php echo ($sale['stripe_subscription_start_date'] != NULL) ? formatted_date($sale['stripe_subscription_start_date'],'m/d/Y') : '-'; ?></td>
                                                        <td><?php echo ($sale['stripe_subscription_end_date'] != NULL) ? formatted_date($sale['stripe_subscription_end_date'],'m/d/Y'): '-'; ?></td>
                                                        <td><?php echo !empty($sale['stripe_subscription_amount_paid']) ? $sale['stripe_subscription_amount_paid'] : '0.00'; ?></td>
                                                        <td><?php echo formatted_date($sale['created_at'],'m/d/Y'); ?></td>
                                                        <td><?php echo !empty($sale['admin_plan_update']) ? 'Admin' : 'User'; ?></td>
                                                        <td><?php echo !empty($sale['is_cancel']) ? '<div class="text-danger">Canceled</div>' : 'Active'; ?></td>
														<td><?php echo ($sale['plan_id'] != 999) ? $sale['payment_type'] : '-'; ?></td>
                                                        <td>
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
														
														<?php if(!empty($sale['user_level'])){
															if(!empty($sale['is_cancel'])){ ?>
																<a class="dropdown-item" href="javascript:void(0);" onclick="change_subs_status('<?php echo $sale['id']; ?>','<?php echo $sale['product_id']; ?>')" ><?php echo trans('Activate'); ?></a>
															<?php }
														}else{ ?>
														<a class="dropdown-item" href="<?php echo admin_url() . 'listings/change_plan?sale_id='.$sale['id'].'&user_id='.$sale['user_id'].'&plan_id='.$sale['plan_id']; ?>"><?php echo trans('Upgrade'); ?></a>
														<?php } ?>
														<?php if(empty($sale['is_cancel'])){ ?>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" onclick="confirm_cancel('<?php echo $sale['id'];?>','<?php echo $sale['payment_type'];?>')" href="javascript:void(0)" ><?php echo trans('Cancel'); ?></a>
														<?php if(!empty($sale['stripe_subscription_id']) && $sale['stripe_subscription_amount_paid'] > 0){ ?>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" onclick="confirm_cancel_refund('<?php echo $sale['id'];?>','<?php echo $sale['payment_type'];?>')" href="javascript:void(0)" ><?php echo trans('Cancel and Refund'); ?></a>
														<?php } } ?>
														<div class="dropdown-divider"></div>
														<?php if(!empty($sale['display_name'])){ ?>
														<a class="dropdown-item" target="_blank" href="<?php echo base_url().'/listings/'.$sale['permalink'].'/'.$sale['id'].'/'.(!empty($sale['display_name'])?str_replace(' ','-',strtolower($sale['display_name'])):''); ?>"><?php echo trans('View Listing'); ?></a>
														<?php } ?>
														 </div>
                                                            </div>
														</td>
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
				
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<div class="loader"></div>
<script>

function change_subs_status(sale_id,product_id){
	$.confirm({
		title: 'Confirm Activating Plan',
		content: 'Are you sure you want to change to this plan status?',
		buttons: {
			confirm: function () {
				$.ajax({
					url: '<?php echo base_url(); ?>/change_plan_status',
					data: {sale_id:sale_id,product_id:product_id},
					type: 'POST',
					dataType: 'HTML',
					success: function(response){
						window.location = '<?php echo admin_url(); ?>listings/sales';
					}
				})
			},
			cancel: function(){
				
			}
		}
	});
}
function confirm_cancel(subscription_id,payment_type) {
    Swal.fire({
        text: "Are you sure to cancel the subscription by end of billing period?",
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "<?php echo trans("ok"); ?>",
        cancelButtonText: "<?php echo trans("cancel"); ?>",

    }).then(function (response) {
        if (response.value) {
        	window.location = '<?php echo base_url(); ?>/providerauth/billing-cancel/'+subscription_id+'/'+payment_type+'/admin'; 
        }
    });
}

function confirm_cancel_refund(subscription_id,payment_type) {
    Swal.fire({
        text: "Are you sure to cancel the subscription immediately and refund?",
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "<?php echo trans("ok"); ?>",
        cancelButtonText: "<?php echo trans("cancel"); ?>",

    }).then(function (response) {
        if (response.value) {
        	window.location = '<?php echo base_url(); ?>/providerauth/billing-cancel-refund/'+subscription_id+'/'+payment_type+'/admin'; 
        }
    });
}
billing_cancel_refund
</script>
<?php echo $this->endSection() ?>