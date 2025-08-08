<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<style>
td:hover {
    cursor: move;
}
</style>
<div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h1 class="m-0"><?php echo $title ?></h1><a href="javascript:void(0)" class="btn small bg-primary ms-3" onclick="manage_fields_group('<?php echo html_escape($categoryId); ?>','','');"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>       
                             <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>/categories"><?php echo trans('categories') ?></a></li>                       
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
                <div class="col-lg-12 col-xl-12">
                        <div class="filter_list">
                            <div class="tab-content" id="custom-tabs-fields_group">
                                <div class="tab-pane fade show active" id="custom-tabs-fields_group" role="tabpanel" aria-labelledby="custom-tabs-fields_group-tab">
                                    <div class="table-responsive">
                                        <table id="fields_group_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            
                                            <thead>
                                                <tr class="">
                                                    <th><?php echo trans('name'); ?></th>
                                                    <th class="text-center"><?php echo trans('Sort Order'); ?></th>
                                                    <th class="text-center max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($fields_group as $i => $item) : ?>
                                                    <tr data-id="<?= $item->id; ?>">
                                                        <td><?php echo html_escape($item->name); ?></td>
                                                        <td class="text-center"><?php echo html_escape($item->sort_order); ?></td>
                                                        <td class="text-center">
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="$('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); manage_fields_group('<?php echo html_escape($categoryId); ?>','<?php echo html_escape($item->id); ?>','<?php echo html_escape($item->name); ?>');"><?php echo trans('edit'); ?></a>
                                                                    <div class=" dropdown-divider">
                                                                    </div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/fields_group/delete_fields_group_post','<?php echo $item->id; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="card-footer clearfix">
                            <div class="row">
                                <div class="col-sm-6 float-right">

                                    <?php //echo $paginations ?>
                                </div>
                            </div>

                        </div> 
                        <!-- /.card -->
                    
                </div>
            </div> <!-- end col -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- Modal -->
<div id="modal-fields_group" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center p-2 pb-0">
                <h4 class="modal-title mb-0 fw-bolder" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close fs-5 position-absolute top-0 end-0 m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="<?php echo admin_url() .'fields_group/saved_fields_group_post';?>" method="post">
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">
                <?php //echo csrf_field() ?>
                <input type="hidden" id="crsf">

                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo trans("name"); ?></label>
                        <input type="text" id="modal_name" name="name" maxlength="100" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                        <input type="hidden" id="modal_categoryId" name="category_id">
                    </div>                                
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>                                           
// Function to fetch content via AJAX
function manage_fields_group(categoryId,id,name) {
    $('#modal_categoryId').val(categoryId);
    $('#modal_id').val('');
    $('#modal_name').val('');

    if(id != ''){
        $('#modal_id').val(id);
        $('#modal_name').val(name);       
    }
    $('#modal-fields_group').modal('show');
}
$(function() {
    $("#fields_group_table tbody").sortable({
      placeholder: "ui-state-highlight",
	  helper: function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index) {
		  // Set helper cell width to match original
		  $(this).width($originals.eq(index).width());
		});
		return $helper;
	  },
      update: function(event, ui) {
        let order = [];
        $("#fields_group_table tbody tr").each(function(index) {
          order.push({
            id: $(this).data("id"),
            sort_order: index + 1
          });
        });
		var data = {
            "order": order
        };
        data[csrfName] = $.cookie(csrfCookie);
		$.ajax({
            type: "POST",
            url: baseUrl + "/admin/fields_group/update_order_post",
            data: data,
            success: function (response) {
				$("#fields_group_table tbody tr").each(function(index) {
				  $(this).find("td").eq(1).text(index + 1);
				});
				Swal.fire({
				  icon: 'success',
				  text: 'Sort order updated successfully.',
				  toast: true,
				  position: 'top-end',
				  showConfirmButton: false,
				  timer: 2000,
				  timerProgressBar: true
				});
            },
			error: function() {
				Swal.fire({
				  icon: 'error',
				  title: 'Oops...',
				  text: 'Something went wrong while updating!',
				});
			}
        });
      }
    }).disableSelection();
  });
</script>   

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