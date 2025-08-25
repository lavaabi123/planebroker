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
				<?php //echo $this->include('admin/listings/_filter_sales') ?>
			</div>
            <div class="row filter_list">
                <?php echo $this->include('admin/includes/_messages') ?>
					<div class="col-sm-12">
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
										<th class="max-width-120 text-center"><?php echo trans('Options'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($sales as $s => $sale) :
if($sale['provider'] != ''){									?>
										<tr>
											<td><?php echo !empty($sale['display_name']) ? $sale['display_name'] : '<a href="'.admin_url().'listings/add?user_id='.$sale['user_id'].'&sale_id='.$sale['id'].'&plan_id='.$sale['plan_id'].'&payment_type=stripe&proceed=listing" class="btn btn-sm">Add Listing</a>'; ?></td>
											<td><?php echo $sale['plan_name']; ?></td>
											<td><?php echo $sale['provider']; ?></td>
											<td><?php echo ($sale['stripe_subscription_start_date'] != NULL) ? formatted_date($sale['stripe_subscription_start_date'],'m/d/Y') : '-'; ?></td>
											<td><?php echo ($sale['stripe_subscription_end_date'] != NULL) ? formatted_date($sale['stripe_subscription_end_date'],'m/d/Y'): '-'; ?></td>
											<td><?php echo !empty($sale['stripe_subscription_amount_paid']) ? $sale['stripe_subscription_amount_paid'] : '0.00'; ?></td>
											<td><?php echo formatted_date($sale['created_at'],'m/d/Y'); ?></td>
											<td><?php echo !empty($sale['admin_plan_update']) ? 'Admin' : 'User'; ?></td>
											<td><?php echo !empty($sale['is_cancel']) ? '<div class="text-danger">Cancelled</div>' : 'Active'; ?></td>
											
											<td class="text-center">
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
<?php } endforeach; ?>
								</tbody>
							</table>
							<?php if (empty($sales)) : ?>
								<p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-sm-12 float-right">
						<?php //echo $paginations ?>
					</div>
				
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

</script>

<script>
$(function(){
  let startDate = null;
  let endDate = null;

  // Custom date range filter
  $.fn.dataTable.ext.search.push(function (settings, data) {
    if (!startDate || !endDate) return true;

    // "Registered at" column index (0-based index)
    let dateStr = data[3];
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
	'<"d-flex align-items-center gap-2 mb-3"lf<"dropdown-filter"><"user-filter"><"status-filter"><"date-filter"><"reset-filter">>t<"d-flex justify-content-center align-items-center my-3"ip>',
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
        <label>Package</label>
        <select id="filterDropdown" class="form-control form-select-sm">
          <option value=""><?php echo trans('All') ?></option>
				<?php
                if(!empty($plans)){
                    foreach($plans as $plan){ ?>
                        <option value="<?php echo $plan->name; ?>"><?php echo $plan->name; ?></option>
                <?php }
                }
                ?>
				<option value="Captain\'s Club"><?php echo 'Captain\'s Club'; ?></option>
        </select>
      `);
	  
	  $('.user-filter').html(`
        <label>User</label>
        <select id="userDropdown" class="form-control form-select-sm">
          <option value=""><?php echo trans('All') ?></option>
				<?php
                if(!empty($providers)){
                    foreach($providers as $provider){ ?>
                        <option value="<?php echo $provider->fullname; ?>"><?php echo $provider->fullname; ?></option>
                <?php }
                }
                ?>
        </select>
      `);
	  
	  $('.status-filter').html(`
        <label>Status</label>
        <select id="statusDropdown" class="form-control form-select-sm">
          <option value=""><?php echo trans('All') ?></option>
		  <option value="Active">Active</option>
		  <option value="Inactive">Inactive</option>
		  <option value="Cancelled">Cancelled</option>
				
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
    $('#userDropdown').val('');
    $('#statusDropdown').val('');

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
      dt.column(1).search(selectedValue).draw();
    } else {
      dt.column(1).search('').draw();
    }
  });
  $('#userDropdown').on('change', function () {
    const selectedValue = $(this).val();
    if (selectedValue) {
      dt.column(2).search(selectedValue).draw();
    } else {
      dt.column(2).search('').draw();
    }
  });
  $('#statusDropdown').on('change', function () {
    const selectedValue = $(this).val();
    if (selectedValue) {
      dt.column(8).search(selectedValue).draw();
    } else {
      dt.column(8).search('').draw();
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