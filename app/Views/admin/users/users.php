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
<div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0"><?php echo $title ?> 
                    <a class="btn btn-primary" href="<?php echo admin_url() . 'add-user/'; ?>"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
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
				<?php //echo $this->include('admin/users/_filter') ?>
			</div>
            <div class="row">
				<?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
					<div class="filter_list">
						<div class="table-responsive">

							<table class="table table-bordered table-striped">
								<thead>
									<tr role="row">
										<th><?php echo trans('fullname'); ?></th>
										<th><?php echo trans('email'); ?></th>
										<th><?php echo trans('Phone'); ?></th>
										<th><?php echo trans('User Level'); ?></th>
										<th><?php echo trans('Registered at'); ?></th>
										<th class="text-center max-width-120"><?php echo trans('options'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach ($users as $u => $user) :
									?>
										<tr>
											<td>
												<?php echo $user['fullname']; ?>
											</td>         
											<td><?php echo $user['email']; ?></td>
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
						</div>
					</div>
					<div class="col-sm-12 float-right">
						<?php //echo $pager->Links('default', 'custom_pager') ?>
					</div>
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
</script><script>
$(function(){
  let startDate = null;
  let endDate = null;

  // Custom date range filter
  $.fn.dataTable.ext.search.push(function (settings, data) {
    if (!startDate || !endDate) return true;

    // "Registered at" column index (0-based index)
    let dateStr = data[4];
    let date = moment(dateStr, 'MM/DD/YYYY hh:mm a');

    if (!date.isValid()) return true;

    return date.isSameOrAfter(startDate, 'day') && date.isSameOrBefore(endDate, 'day');
  });

  const dt = $('.table').DataTable({
    searching: true,
    info: false,
    lengthChange: true,
    paging: true,
    ordering: true,
    order: [[0, 'asc']],
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    dom: 
	'<"d-flex align-items-center gap-2 mb-3"lf<"dropdown-filter"><"date-filter"><"reset-filter">>t<"d-flex justify-content-center align-items-center my-3"ip>',
    language: {
      paginate: {
        previous: "<i class='fas fa-caret-left'></i>",
        next: "<i class='fas fa-caret-right'></i>"
      }
    },
    columnDefs: [
      { orderable: false, targets: -1 }
    ],
    drawCallback: function () {
      const info = this.api().page.info();
      const wrapper = $(this).closest('.dataTables_wrapper');
      wrapper.find('.dataTables_paginate').toggle(info.pages > 1);
    },
    initComplete: function () {
      const api = this.api();
      const $thead = $(api.table().header());

      // Add sort icons
      $thead.find('th').each(function(i){
        const isSortable = api.settings()[0].aoColumns[i].bSortable;
        if (isSortable && !$(this).find('.sort-icons').length) {
          $(this).append(
            '<span class="sort-icons">' +
              '<i class="fas fa-sort-up sort-icon-up"></i>' +
              '<i class="fas fa-sort-down sort-icon-down"></i>' +
            '</span>'
          );
        }
      });

      // Reset button
      $('.reset-filter').html(`<label class="d-block">&nbsp;</label>
        <button type="button" id="resetFilters" class="btn small bg-primary">Reset</button>
      `);

      // Dropdown filter
      $('.dropdown-filter').html(`
        <label>User Level</label>
        <select id="filterDropdown" class="form-control form-select-sm">
          <option value="">All</option> 
          <option value="Captain User" >Captain User</option>
          <option value="Standard User" >Standard User</option>
        </select>
      `);

      // Date range filter
      $('.date-filter').html(`
        <label for="dateRangeFilter">Date Range</label>
        <input type="text" id="dateRangeFilter" class="form-control form-select-sm" />
      `);

      $('#dateRangeFilter').daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: 'Clear' }
      });

      $('#dateRangeFilter').on('apply.daterangepicker', function(ev, picker) {
        startDate = picker.startDate;
        endDate = picker.endDate;
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        dt.draw();
      });

      $('#dateRangeFilter').on('cancel.daterangepicker', function() {
        startDate = null;
        endDate = null;
        $(this).val('');
        dt.draw();
      });

      updateSortIcons(api);
    }
  });

  // Ordering icons
  $('.table').on('order.dt', function(){
    updateSortIcons(dt);
  });

  // Reset button click
  $(document).on('click', '#resetFilters', function () {
    const $wrapper = $(dt.table().container());

    // Clear search box
    $wrapper.find('.dataTables_filter input[type="search"]').val('');
    dt.search('');

    // Clear per-column searches
    dt.columns().every(function () { this.search(''); });

    // Reset dropdown
    $('#filterDropdown').val('');

    // Reset date filter
    startDate = null;
    endDate = null;
    $('#dateRangeFilter').val('');

    // Reset ordering & page
    dt.order([[0, 'asc']]);
    dt.page('first');

    dt.draw();
  });

  // Dropdown filter change
  $('#filterDropdown').on('change', function () {
    const selectedValue = $(this).val();
    if (selectedValue) {
      dt.column(3).search(selectedValue).draw();
    } else {
      dt.column(3).search('').draw();
    }
  });

  function updateSortIcons(api){
    const $thead = $(api.table().header());
    $thead.find('.sort-icon-up, .sort-icon-down').removeClass('active');

    const ord = api.order();
    if (ord.length){
      const colIdx = ord[0][0];
      const dir = ord[0][1];
      const $th = $thead.find('th').eq(colIdx);
      if (dir === 'asc') $th.find('.sort-icon-up').addClass('active');
      else $th.find('.sort-icon-down').addClass('active');
    }
  }

  // UI tweaks
  	$('.dataTables_filter label').contents().filter(function () {
        return this.nodeType === 3; // Node.TEXT_NODE
    }).remove();
	$('.dataTables_filter label').each(function() {
		$(this).contents().unwrap(); // This removes the <label> but keeps the input
	});
	$('.dataTables_length label').contents().filter(function () {
        return this.nodeType === 3; // Node.TEXT_NODE
    }).remove();
	$('.dataTables_length label').each(function() {
		$(this).contents().unwrap(); // This removes the <label> but keeps the input
	});
  $('.dataTables_filter input').removeClass('form-control-sm').attr('placeholder', 'Search').addClass('m-0');
  $('.date-filter input').removeClass('form-control-sm').attr('placeholder', 'Start Date - End Date').addClass('m-0');
  $('.dataTables_length select').removeClass('form-control-sm custom-select-sm');
  $('.dataTables_filter label, .dataTables_length label').contents().unwrap();
  $('.dataTables_filter').prepend('<label>Search</label>');
  $('.dataTables_length').prepend('<label>Show</label>');
});
</script>

<?php echo $this->endSection() ?>