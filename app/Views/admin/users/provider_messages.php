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
			<div class="filter_Sec">
				<?php //echo $this->include('admin/users/_filter_provider_messages') ?>
			</div>
            <div class="row filter_list">
                <?php echo $this->include('admin/includes/_messages') ?>
					<div class="col-sm-12">
						<div class="table-responsive">

							<table class="table table-bordered table-striped">
								<thead>
									<tr role="row">
										<th><?php echo trans('Name'); ?></th>
										<th><?php echo trans('Email'); ?></th>
										<th><?php echo trans('Phone'); ?></th>
										<th><?php echo trans('Date / Time'); ?></th>
										<th class="text-center"><?php echo trans('Actions'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($provider_messages as $h => $provider_message) : ?>
									<tr id="pm<?php echo ($h+1); ?>">
											<td><?php echo $provider_message['from_name']; ?> </td>
											<td><?php echo $provider_message['from_email']; ?></td>
											<td><?php echo $provider_message['from_phone']; ?></td>
											<td><?php echo formatted_date($provider_message['created_at'],'m/d/Y h:i a'); ?></td>
											<td class="text-center"> <a href="javascript:void(0)" onclick="get_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="fas fa-eye ml-3 mr-1"></i><?php echo trans('View'); ?></a><a href="javascript:void(0)" onclick="delete_provider_messages('<?php echo html_escape($provider_message['id']); ?>');"><i class="fas fa-trash ml-3 mr-1"></i><?php echo trans('Delete'); ?></a></td>      
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
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

<?php echo $this->include('admin/users/_modal_provider_messages') ?>
<div class="loader"></div>
<script>
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
	'<"d-flex align-items-center gap-2 mb-3"lf<"date-filter"><"reset-filter">>t<"d-flex justify-content-center align-items-center my-3"ip>',
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