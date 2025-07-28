<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/js/selectize/css/selectize.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/frontend/js/selectize/js/standalone/selectize.min.js"></script>
<style type="text/css">
#enlargePic{
    display: none;
    position: absolute;
    z-index: 99;
    width: 500px;
    max-width: 90%;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0"><?php echo $title ?> 
                    <a class="btn btn-primary" href="<?php echo admin_url() . 'add-user/'; ?>"><?php echo trans('Add User'); ?></a>
                  </h1>                     
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
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
				<?php echo $this->include('admin/users/_filter') ?>
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
                                                    <th><?php echo trans('fullname'); ?></th>
                                                    <th><?php echo trans('email'); ?></th>
                                                    <th><?php echo trans('status'); ?></th>
                                                    <th><?php echo trans('Email Verified'); ?></th>
                                                    <th><?php echo trans('Phone'); ?></th>
                                                    <th><?php echo trans('User Level'); ?></th>
                                                    <th><?php echo trans('Registered at'); ?></th>
                                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
												$page = !empty($_GET['page']) ? $_GET['page'] : 1;
												$slno_start = $paginate['total'] - (($page-1) * $paginate['per_page_no']);
												foreach ($paginate['users'] as $u => $user) :
												?>
                                                    <tr>
                                                        <td><?php echo $u+1; ?></td>
                                                        <td>
                                                            <?php echo $user['fullname']; ?>
                                                        </td>         
                                                        <td><?php echo $user['email']; ?></td>
                                                        <td style="text-align: center;">                                                            
                                                            <?php if ($user['status'] == 1) : ?>
                                                                <span class="text-success" title="<?php echo trans('active'); ?>"><i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 18px"></i></span>
                                                            <?php else : ?>
                                                                <span class="text-danger" title="<?php echo trans('banned'); ?>"><i class="fa fa-times" aria-hidden="true" style="color: red; font-size: 18px"></i></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?php
                                                            if ($user['email_status'] == 1) : ?>
                                                                <span class="text-success" style="font-size: 14px" title="<?php echo trans("Email Verified"); ?>"><i class="fa fa-check" aria-hidden="true" style="color: green; font-size: 18px"></i></span>
                                                            <?php else : ?>
                                                                <span class="text-danger" style="font-size: 14px" title="<?php echo trans("Email Not Verified"); ?>"><i class="fa fa-times" aria-hidden="true" style="color: red; font-size: 18px"></i></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo $user['mobile_no']; ?></td>
                                                        <td><?php echo !empty($user['user_level']) ? 'Captain User' : 'Standard User'; ?></td>
                                                        <td><?php echo formatted_date($user['created_at'],'m/d/Y h:i a'); ?></td>
                                                        <td>
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <?php if ($user['email_status'] != 1) : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="confirm_user_email(<?php echo $user['id']; ?>);"><?php echo trans('confirm_user_email'); ?></a>
                                                                    <?php endif; ?>
                                                                    <?php if (is_admin()) : ?>
                                                                        <?php if ($user['status'] == "1") : ?>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="ban_user('<?php echo $user['id']; ?>','<?php echo trans('confirm_ban'); ?>', 'ban');"><?php echo trans('ban_user'); ?></a>
                                                                        <?php else : ?>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="ban_user('<?php echo $user['id']; ?>', '<?php echo trans('confirm_remove_ban'); ?>', 'remove_ban');"><?php echo trans('remove_ban'); ?></a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>

                                                                    <?php 
																		if (is_admin()) : ?>
                                                                        <a class="dropdown-item" href="<?php echo admin_url() . 'edit-user/'; ?><?php echo html_escape($user['id']); ?>/<?php echo (!empty($_GET) && !empty($_GET['page'])) ? $_GET['page'] : '1' ?>"><?php echo trans('edit'); ?></a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/delete_user_post','<?php echo $user['id']; ?>','<?php echo trans('confirm_user'); ?>')"><?php echo trans('delete'); ?></a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" target="_blank" href="<?php echo admin_url().'listings?user_id='.$user['id']; ?>"><?php echo trans('View Listings'); ?></a>
                                                                    <?php endif;  ?>
																	
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($paginate['users'])) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php echo $pager->Links('default', 'custom_pager') ?>
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
<!-- Modal -->
<div id="p-history" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="change-role-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="change-role-modalLabel"><?php echo trans('Payment History'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3 load-history">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<?php echo $this->include('admin/users/_modal') ?>
<script>
function attachLocationHome(){
    $('select.locationhome').selectize({
        valueField: 'homesearch',
        labelField: 'locationhome',
        searchField: 'locationhome',
        create: false,
        preload: true,
        render: {
            option: function(item, escape) {
                return '<div>'+escape(item.locationhome)+'</div>';
            }
        },
        load: function(query, callback) {
            $('.selectize-control').removeClass('loading');
            $.ajax({
                url: baseUrl +'/providerauth/get-locations?from=home&q=' + encodeURIComponent(query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    res = $.parseJSON(res);
                    callback(res.locations);
                }
            });
        }
    });
}

/* Enlarge pics */
function attachHoverPic(){
    /* Enlarge pics on hover */
    $('footer').before("<div id='enlargePic'></div>");
    var enlargeDiv = $('#enlargePic');
    $('body').on('mousemove', '.enlargePic', function(e) {
        var picHeight = enlargeDiv.height();
        if(e.clientY + picHeight > window.innerHeight){
            var x_offset = 10;
            var y_offset = -picHeight;
        }else{
            var x_offset = 10;
            var y_offset = 10;
        }
        enlargeDiv.css('left', e.pageX + x_offset).css('top', e.pageY + y_offset);
    }).on('mouseenter', '.enlargePic', function(){
        enlargeDiv.html("<img src='"+$(this).attr('src').replace('-thumb', '')+"' width='100%'>").show();
    }).on('mouseleave', '.enlargePic', function(){
        enlargeDiv.hide();
    });
}

$(document).ready(function(){       
    attachLocationHome();
});

$(function(){
    attachHoverPic();
});

function payment_history_get(user_id,stripe_subscription_customer_id){
	$('.load-history').html('');
	$.ajax({
		url: baseUrl +'/providerauth/get-payment-history',
		type: 'POST',
		data: {user_id:user_id,stripe_subscription_customer_id:stripe_subscription_customer_id},
		error: function() {
			callback();
		},
		success: function(res) {
			$('.load-history').html(res);
			$('#p-history').modal('show');
		}
	});
}
</script>

<?php echo $this->endSection() ?>