<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
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
				<?php echo $this->include('admin/users/_filter_provider_messages') ?>
			</div>
            <div class="row filter_list">
                <?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
                    <div class="card p-0">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('Name'); ?></th>
                                                    <th><?php echo trans('Email'); ?></th>
                                                    <th><?php echo trans('Phone'); ?></th>
                                                    <th><?php echo trans('Provider'); ?></th>
                                                    <th><?php echo trans('Date / Time'); ?></th>
                                                    <th class="max-width-120"><?php echo trans('Actions'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($provider_messages as $provider_message) : ?>
                                                    <tr id="pm<?php echo html_escape($provider_message['id']); ?>">
                                                        <td><?php echo clean_number($provider_message['id']); ?></td>
                                                        <td><?php echo $provider_message['from_name']; ?> </td>
                                                        <td><?php echo $provider_message['from_email']; ?></td>
                                                        <td><?php echo $provider_message['from_phone']; ?></td>
                                                        <td><?php echo $provider_message['to_provider']; ?></td>
                                                        <td><?php echo formatted_date($provider_message['created_at'],'m/d/Y h:i a'); ?></td>
                                                        <td> <a href="javascript:void(0)" onclick="get_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="fas fa-eye ml-3 mr-1"></i><?php echo trans('View'); ?></a><a href="javascript:void(0)" onclick="delete_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="fas fa-trash ml-3 mr-1"></i><?php echo trans('Delete'); ?></a></td>      
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($provider_messages)) : ?>
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

<?php echo $this->include('admin/users/_modal_provider_messages') ?>
<div class="loader"></div>
<?php echo $this->endSection() ?>