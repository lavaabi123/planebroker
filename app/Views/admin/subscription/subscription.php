<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h1 class="m-0"><?php echo $title ?></h1><a href="<?php echo admin_url() . 'subscription/add-subscription/'; ?>"><button type="button" class="btn small btn-primary ms-3"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></button></a>
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
            <div class="row">
                <?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
                            <?php //echo $this->include('admin/subscription/_filter') ?>
                                <div class="filter_list">
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th width="200px"><?php echo trans('Package Name'); ?></th>
                                                    <th><?php echo trans('Price'); ?></th>
                                                    <th width="200px"><?php echo trans('Stripe ID'); ?></th>
                                                    <th><?php echo trans('Status'); ?></th>
                                                    <th><?php echo trans('Recommended?'); ?></th>
                                                    <th class="text-center max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($paginate['subscription'] as $h => $subscription) :
if($subscription['id'] != 999){												?>
                                                    <tr>
                                                        <td><?php echo $subscription['name']; ?> </td>
                                                        <td><?php echo '$'.$subscription['price']; ?> </td>
                                                        <td style="word-break: break-all;"><?php echo $subscription['stripe_price_id']; ?> </td>
                                                        <td><?php echo ($subscription['status'] == 1) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?> </td>
                                                        <td><?php echo ($subscription['is_recommended'] == 1) ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>'; ?> </td>
                                                        <td>
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <?php if (is_admin()) : ?>
                                                                        <a class="dropdown-item" href="<?php echo admin_url() . 'subscription/edit-subscription/'; ?><?php echo html_escape($subscription['id']); ?>"><?php echo trans('edit'); ?></a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/subscription/delete_subscription_post','<?php echo $subscription['id']; ?>','<?php echo trans('Are you sure you want to delete this subscription?'); ?>')"><?php echo trans('delete'); ?></a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
<?php } endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php //echo $pager->Links('default', 'custom_pager') ?>
                                </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->

            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php echo $this->endSection() ?>