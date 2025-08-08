<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h1 class="m-0"><?php echo $title ?></h1><a href="<?php echo admin_url() . 'testimonial/add-testimonial/'; ?>"><button type="button" class="btn small btn-primary ms-3"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></button></a>
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
                        <div class="filter_list pt-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th><?php echo trans('Name'); ?></th>
                                                    <th><?php echo trans('Created at'); ?></th>
                                                    <th><?php echo trans('Status'); ?></th>
                                                    <th class="text-center max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($testimonial_list as $h => $testimonial) : ?>
                                                    <tr>
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
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php //echo $pager->Links('default', 'custom_pager') ?>
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

<script>

$(function(){
  const dt = $('.table').DataTable({
    searching: true,  // enable so search box appears
    info: false,
    lengthChange: true,
    paging: true,
    ordering: true,
    order: [[0, 'asc']],   // first column asc
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    dom: '<"d-flex align-items-center gap-2 mb-3"lf<"reset-filter">>t<"d-flex justify-content-center align-items-center my-3"ip>',
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

      // Insert reset button in the placeholder div
      $('.reset-filter').html(`<label class="d-block">&nbsp;</label>
        <button type="button" id="resetFilters" class="btn small bg-primary">Reset</button>
      `);


      // Set initial active arrow
      updateSortIcons(api);
    }
  });

  // Handle table ordering
  $('.table').on('order.dt', function(){
    updateSortIcons(dt);
  });

  // Handle reset button click
  $(document).on('click', '#resetFilters', function () {
    const dt = $('.table').DataTable();
    const $wrapper = $(dt.table().container());

    // 1) Clear the built-in search box UI
    $wrapper.find('.dataTables_filter input[type="search"]').val('');

    // 2) Clear global & per-column searches
    dt.search('');
    dt.columns().every(function () { this.search(''); });

    // 3) Reset any custom dropdown/text filters you added
    // (add selectors you use for filters here)
    $('.dt-filter, .date-filter select, .date-filter input').val('');

    // 4) Reset ordering & page
    dt.order([[0, 'asc']]);     // back to first column ASC
    dt.page('first');

    // 5) Redraw once
    dt.draw();
  });


  // Function to highlight active sort icon
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
  $('.dataTables_filter input').removeClass('form-control-sm');
  $('.dataTables_length select').removeClass('form-control-sm');
  $('.dataTables_length select').removeClass('custom-select-sm');
	
	$('.dataTables_filter label').contents().filter(function () {
        return this.nodeType === 3; // Node.TEXT_NODE
    }).remove();
	$('.dataTables_filter label').each(function() {
		$(this).contents().unwrap(); // This removes the <label> but keeps the input
	});
	$('.dataTables_filter').prepend('<label>Search</label>');
    $('.dataTables_filter input').attr('placeholder', 'Search');
    $('.dataTables_filter input').addClass('m-0');
	
	
	
	$('.dataTables_length label').contents().filter(function () {
        return this.nodeType === 3; // Node.TEXT_NODE
    }).remove();
	$('.dataTables_length label').each(function() {
		$(this).contents().unwrap(); // This removes the <label> but keeps the input
	});
	$('.dataTables_length').prepend('<label>Show</label>');
	
});
</script>
<?php echo $this->endSection() ?>