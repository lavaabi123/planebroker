<?= $this->extend('admin/includes/_layout_view') ?>

<?= $this->section('content') ?>
<div class="content-wrapper bg-grey">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 d-flex">
          <h1 class="m-0">Notifications</h1>
          <a href="<?= admin_url() . 'blog/add-blog/'; ?>">
          </a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= admin_url() ?>"><?= trans('dashboard') ?></a></li>
            <li class="breadcrumb-item active">Notifications</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
  <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
                                <div class="filter_list">
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th>Created</th>
													<th>Title</th>
													<th>Message</th>
                                                    <th class="text-center max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($items as $h => $it) : ?>
                                                    <tr>
                                                        <td><?php echo date('m-d-Y h:i a', strtotime($it['created_at'])); ?> </td>
                                                        <td><?php echo $it['title']; ?> </td>
                                                        <td><?php echo $it['message']; ?> </td>
                                                        <td>
                                                            <div class="mt-2 d-flex gap-2">
                
                    <?php if (!empty($it['link'])): ?>
                      <a class="btn btn-sm btn-primary" href="<?= $it['link'] ?>">Open</a>
                    <?php endif; ?>
                    <?php if (!$it['is_read']): ?>
                      <form method="post" action="<?= site_url('admin/notifications/mark-read/'.$it['pivot_id']) ?>">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-secondary">Mark read</button>
                      </form>
                    <?php endif; ?>
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
        </div>
    
  </section>
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

      // Insert dropdown filter in the placeholder div
      $('.dropdown-filter').html(`
	  <label>Type</label>
        <select id="filterDropdown" class="form-control form-select-sm">
          <option value="">All</option>
		  <option value="Articles">Articles</option>
          <option value="News">News</option>
        </select>
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
    $('#filterDropdown').val('');  // Reset dropdown filter

    // 4) Reset ordering & page
    dt.order([[0, 'asc']]);     // back to first column ASC
    dt.page('first');

    // 5) Redraw once
    dt.draw();
  });

  // Handle dropdown filter change
  $('#filterDropdown').on('change', function () {
    const selectedValue = $(this).val();
    const dt = $('.table').DataTable();

    // Apply filter to column 2 (index 1)
    if (selectedValue) {
      dt.column(2).search(selectedValue).draw();  // Apply filter to second column
    } else {
      dt.column(2).search('').draw();  // Clear filter
    }
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
<?= $this->endSection() ?>
