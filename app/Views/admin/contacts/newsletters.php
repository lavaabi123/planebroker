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
                    <div class="filter_list pt-0">
                        <!-- Export Buttons -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">Total Subscribers: <span class="badge badge-primary"><?php echo count($contacts); ?></span></h5>
                                    </div>
                                    <div class="export-buttons">
                                        <a href="<?php echo base_url('admin/newsletter/export/csv'); ?>" class="btn btn-success">
                                            <i class="fas fa-file-csv"></i> Export CSV
                                        </a>
                                        <!--<a href="<?php echo base_url('admin/newsletter/export/excel'); ?>" class="btn btn-info">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </a>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="permission_show1 table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th><?php echo trans('First Name'); ?></th>
                                                <th><?php echo trans('Last Name'); ?></th>
                                                <th><?php echo trans('Email'); ?></th>
                                                <th><?php echo trans('date'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($contacts as $h => $provider_message) : ?>
                                                <tr>
                                                    <td><?php echo esc($provider_message->first_name); ?></td>
                                                    <td><?php echo esc($provider_message->last_name); ?></td>
                                                    <td><?php echo esc($provider_message->email); ?></td>
                                                    <td><?php echo date('m-d-Y H:i:s', strtotime($provider_message->subscribed_at)); ?></td>
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
                    </div> <!-- end card-body -->
                </div> <!-- end col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php echo $this->include('admin/contacts/_modal_contact_messages') ?>
<div class="loader"></div>

<style>
.export-buttons .btn {
    margin-left: 10px;
}
.export-buttons .btn i {
    margin-right: 5px;
}
</style>

<script>
$(function(){
  const dt = $('.table').DataTable({
    searching: true,
    info: false,
    lengthChange: true,
    paging: true,
    ordering: true,
    order: [[3, 'desc']],   // Most recent first (subscribed_at column)
    pageLength: 50,
    lengthMenu: [50, 100, 150, 200],
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

      // Insert reset button
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

    $wrapper.find('.dataTables_filter input[type="search"]').val('');
    dt.search('');
    dt.columns().every(function () { this.search(''); });
    $('.dt-filter, .date-filter select, .date-filter input').val('');
    dt.order([[3, 'desc']]);
    dt.page('first');
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
    return this.nodeType === 3;
  }).remove();
  $('.dataTables_filter label').each(function() {
    $(this).contents().unwrap();
  });
  $('.dataTables_filter').prepend('<label>Search</label>');
  $('.dataTables_filter input').attr('placeholder', 'Search');
  $('.dataTables_filter input').addClass('m-0');
    
  $('.dataTables_length label').contents().filter(function () {
    return this.nodeType === 3;
  }).remove();
  $('.dataTables_length label').each(function() {
    $(this).contents().unwrap();
  });
  $('.dataTables_length').prepend('<label>Show</label>');
});
</script>
<?php echo $this->endSection() ?>