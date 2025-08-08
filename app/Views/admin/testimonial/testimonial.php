<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bg-grey">
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
                        <?php echo $this->include('admin/testimonial/_filter') ?>
                        <div class="filter_list pt-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th width="40" class="text-right"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('Name'); ?></th>
                                                    <th><?php echo trans('Created at'); ?></th>
                                                    <th><?php echo trans('Status'); ?></th>
                                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($paginate['testimonial'] as $testimonial) : ?>
                                                    <tr>
                                                        <td width="40" class="text-right"><?php echo clean_number($testimonial['id']); ?></td>
                                                        <td><?php echo $testimonial['name']; ?> </td>
                                                        <td><?php echo date("m-d-Y", strtotime($testimonial['created_at'])); ?>
                                                        <td><?php echo ($testimonial['status'] == 1) ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'; ?> </td></td>
                                                        <td>
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <?php if (is_admin()) : ?>
                                                                        <a class="dropdown-item" href="<?php echo admin_url() . 'testimonial/edit-testimonial/'; ?><?php echo html_escape($testimonial['id']); ?>"><?php echo trans('edit'); ?></a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/testimonial/delete_testimonial_post','<?php echo $testimonial['id']; ?>','<?php echo trans('Are you sure you want to delete this testimonial?'); ?>')"><?php echo trans('delete'); ?></a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($paginate['testimonial'])) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php echo $pager->Links('default', 'custom_pager') ?>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                </div> <!-- end col -->

            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php echo $this->endSection() ?>