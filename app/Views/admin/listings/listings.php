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
                    <a class="btn btn-primary" href="<?php echo admin_url() . 'listings/add/'; ?>"><?php echo trans('Add Listing'); ?></a>
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
				<?php echo $this->include('admin/listings/_filter') ?>
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
                                                    <th><?php echo trans('Listing Name'); ?></th>
                                                    <th><?php echo trans('Package Name'); ?></th>
                                                    <th><?php echo trans('Category Name'); ?></th>
                                                    <th><?php echo trans('User'); ?></th>
                                                    <th><?php echo trans('Listing Status'); ?></th>
                                                    <th><?php echo trans('Subscription Status'); ?></th>
                                                    <th><?php echo trans('Created at'); ?></th>
                                                    <th><?php echo trans('Added By'); ?></th>
                                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
												$page = !empty($_GET['page']) ? $_GET['page'] : 1;
												$slno_start = $paginate['total'] - (($page-1) * $paginate['per_page_no']);
												foreach ($paginate['users'] as $u => $user) :
												?>
                                                    <tr id="p_id_<?php echo $user['id']; ?>">
                                                        <td><?php echo $u+1; ?></td>
                                                        <td>
                                                            <a href="<?php echo base_url('listings/'.$user['permalink'].'/'.$user['id'].'/'.(!empty($user['display_name'])?str_replace(' ','-',strtolower($user['display_name'])):'')); ?>" target="_blank"><?php echo $user['display_name']; ?></a>
                                                        </td>         
                                                        <td><?php echo $user['package_names']; ?></td>
                                                        <td><?php echo $user['category_name']; ?></td>
                                                        <td><?php echo $user['fullname']; ?></td>  
                                                        <td class="statustext" style="text-align: center;">     
															<?php if ($user['status'] == 1){ ?>
																<span class="text-success" title="<?php echo trans('ACTIVE'); ?>">ACTIVE</span>
															<?php }else if ($user['status'] == 0){ ?>
																<span class="text-danger" title="<?php echo trans('INACTIVE'); ?>">INACTIVE</span>
															<?php } ?>
														</td>  
														<td style="text-align: center;"> 
															<?php if ($user['is_cancel'] == 0){ ?>
																<span class="text-success" title="<?php echo trans('active'); ?>">ACTIVE</span>
															<?php }else{ ?>
																<span class="text-danger" title="<?php echo trans('banned'); ?>">CANCELED</span>
															<?php } ?>   
                                                        </td>														
                                                        <td><?php echo date("m-d-Y",strtotime($user['created_at'])); ?></td>
                                                        <td><?php echo ( empty($user['added_by']) ) ? 'User' : 'Admin'; ?></td>  
                                                        <td>
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <?php 
																		if (is_admin()) : ?>
                                                                        <a class="dropdown-item" href="<?php echo admin_url() . 'listings/add?id='.$user['id'].'&category='.$user['category_id'].'&plan_id='.$user['plan_id'].'&user_id='.$user['user_id'].'&sale_id='.$user['sale_id']; ?>"><?php echo trans('edit'); ?></a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item openDeleteModal" data-id="<?php echo $user['id']; ?>" href="javascript:void(0)" ><?php echo trans('delete'); ?></a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" target="_blank" href="<?php echo base_url('/listings/'.$user['permalink'].'/'.$user['id'].'/'.(!empty($user['display_name'])?str_replace(' ','-',strtolower($user['display_name'])):'')); ?>"><?php echo trans('View Listing'); ?></a>
                                                                        <div class="dropdown-divider"></div>
																		<?php if ($user['status'] == 1){ ?>
																			 <a class="dropdown-item toggle-status" data-id="<?php echo $user['id']; ?>" data-val="0" href="javascript:void(0)" >Disable</a>
																		<?php }else if ($user['status'] == 0){ ?>
																			 <a class="dropdown-item toggle-status" data-id="<?php echo $user['id']; ?>" data-val="1" href="javascript:void(0)" >Enable</a>
																		<?php } ?>
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
                                    <?php echo $pager->links('default', 'custom_pager') ?>
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


<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-5 p-3 px-md-5 text-center position-relative align-items-center">
      
      <!-- Close Icon -->
      <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close">
		<img src="<?php echo base_url('assets/frontend/images/close.png'); ?>" />
	  </button>

      <!-- Warning Icon -->
      <div class="fs-1 text-danger my-3"><img src="<?php echo base_url('assets/frontend/images/alert.png'); ?>" /></div>

      <h5 class="fw-bolder text-dark mb-3">Are you sure you want to<br/> delete your listing?</h5>
      <p class="text-black fw-medium pb-2 mb-1">
        You are about to delete an existing listing.<br>
        This change is not reversible.
      </p>

      <!-- Delete Button -->
      <button class="btn btn-danger rounded-pill py-3 my-4 confirmDelete min-w-auto" data-id="">
        YES, DELETE THIS LISTING
      </button>

      <!-- Close Text -->
      <div>
        <a href="#" class="text-decoration-underline text-black fs-6" data-bs-dismiss="modal">
          Close this window
        </a>
      </div>
    </div>
  </div>
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
	
	$('.openDeleteModal').click(function() {
		$('.confirmDelete').attr('data-id',$(this).attr('data-id'));
		$('#deleteModal').modal('show');
	});
	
	// Handle delete confirmation
	  $('.confirmDelete').click(function() {
		$.ajax({
			url: '<?php echo base_url(); ?>/product_delete',
			data: {csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db',p_id:$('.confirmDelete').attr('data-id')},
			type: 'POST',
			dataType: 'HTML',
			success: function(response){
				// Hide modal after action
				$('#deleteModal').modal('hide');
				$('#p_id_'+$('.confirmDelete').attr('data-id')).hide();
				Swal.fire({
					icon: 'success',
					text: 'Deleted successfully.',
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 2000,
					timerProgressBar: true
				});			
			}
		})
	  });
	 
	$('.toggle-status').click(function() {
		let checkbox = $(this);
		let listingId = $(this).data('id');
		let status = $(this).data('val');

		// Show confirmation dialog
		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you want to change the status of this listing?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, change it',
			cancelButtonText: 'Cancel',
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {			
				$.ajax({
				  url: '<?php echo base_url(); ?>/product_status_change',
				  method: 'POST',
				  data: {
					listing_id: listingId,
					status: status,
					csrf_token:'1e78598ff0fc7c5d22b2b579edcdc3db'
				  },
				  success: function(response) {
					var status_text = (status == 1) ? '<span class="text-success" title="active">ACTIVE</span>' : '<span class="text-danger" title="banned">INACTIVE</span>';
					$('#p_id_'+listingId+' .statustext').html(status_text);
					Swal.fire({
						icon: 'success',
						text: 'Status updated successfully',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true
					});
				  },
				  error: function(xhr) {
					alert('Error: ' + xhr.responseText);
				  }
				}); 
			} else {
				// Revert checkbox state if cancelled
				checkbox.prop('checked', !status);
			}
		});
	}); 
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