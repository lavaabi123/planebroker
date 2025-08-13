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
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?></h1>
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
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                        <div class="filter_list">
                            <div class="tab-content" id="custom-tabs-fields">
                                <div class="tab-pane fade show active" id="custom-tabs-fields" role="tabpanel" aria-labelledby="custom-tabs-fields-tab">
                                    <div class="table-responsive">
                                        <table id="fields_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                                
                                            <thead>
                                                <tr>
                                                    <th><?php echo trans('Field Name'); ?></th>
                                                    <th><?php echo trans('Category'); ?></th>
                                                    <th><?php echo trans('Show under Filter?'); ?></th>
                                                    <th><?php echo trans('Filter Order'); ?></th>
                                                    <th><?php echo trans('Filter Type'); ?></th>
                                                    <th class="max-width-120 text-center"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($fields as $i => $item) : ?>
													<tr  data-category_id="<?= $item->category_id; ?>" data-id="<?= $item->id; ?>">
                                                        <td><?php echo html_escape($item->name); ?></td>
                                                        <td><?php echo html_escape($item->category_names); ?></td>
														<td class="text-center">
                                                            <?php if ($item->is_filter == 1) : ?>
                                                                <button class="btn btn-sm bg-success"><?php echo trans("Yes"); ?></button>
                                                            <?php else : ?>
                                                                <button class="btn btn-sm bg-danger"><?php echo trans("No"); ?></button>
                                                            <?php endif; ?>
                                                        </td>	
                                                        <td><?php echo html_escape($item->filter_order); ?></td>
                                                        <td><?php echo html_escape($item->filter_type); ?></td>
                                                        <td class="text-center">
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <?php if ($item->status == 1) : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="$('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); manage_fields('<?php echo html_escape($item->id); ?>'); $('#status_1').prop('checked', true);"><?php echo trans('edit'); ?></a>
                                                                    <?php else : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="$('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); manage_fields('<?php echo html_escape($item->id); ?>'); $('#status_2').prop('checked', true);"><?php echo trans('edit'); ?></a>
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
                            </div>
                        </div>
                       <div class="card-footer clearfix">
                            <div class="row">
                                <?php /*<div class="col-sm-6">
                                    <button type="button" class="btn btn-danger" onclick="activate_inactivate_counties('inactivate');"><?php echo trans("inactivate_all"); ?></button>
                                    <button type="button" class="btn btn-success" onclick="activate_inactivate_counties('activate');"><?php echo trans("activate_all"); ?></button>
                                </div>*/ ?>
                                <div class="col-sm-6 float-right">

                                    <?php //echo $paginations ?>
                                </div>
                            </div>

                        </div> 
            </div> <!-- end col -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- Modal -->
<div id="modal-fields" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center p-2 pb-0">
                <h4 class="modal-title mb-0 fw-bolder" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close fs-5 position-absolute top-0 end-0 m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            

                <div class="modal-body pb-0">	
					<form id="form_safe" action="<?php echo admin_url() .'fields/saved_filter_fields_post';?>" method="post">
						<input type="hidden" id="modal_id" name="id" class="form-control form-input">
						<?php //echo csrf_field() ?>
						<input type="hidden" id="crsf">
					
						<div class="form-group">
							<label><?php echo trans("Filter Type"); ?></label>						
							<select id="modal_filter_type" name="filter_type" class="form-control">
								<option value="checkbox">Checkbox</option>
								<option value="text">Text</option>
								<option value="radio">Radio</option>
								<option value="number">Number Range</option>
							</select>						
						</div> 
						
						<div class="form-group">
							<div class="row align-items-center">
								<div class="col-auto">
									<label><?php echo trans('Show Under Filter'); ?></label>
								</div>
								<div class="col-auto d-flex align-items-center">
									<input type="radio" name="is_filter" value="1" id="is_filter_1" class="square-purple" checked="checked">
									<label for="is_filter_1" class="option-label ms-0"><?php echo trans('enable'); ?></label>
								</div>
								<div class="col-auto d-flex align-items-center">
									<input type="radio" name="is_filter" value="0" id="is_filter_2" class="square-purple">
									<label for="is_filter_2" class="option-label ms-0"><?php echo trans('disable'); ?></label>
								</div>
							</div>
						</div>
						<div class="modal-footer bg-white px-0 justify-content-between position-sticky bottom-0 rounded-0 z-3">
							<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
						</div>
					</form>
                </div>
                
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>   

// Function to fetch content via AJAX
function manage_fields(fieldId) {
    $('#modal_id').val('');

    if(fieldId != ''){
        $('.loader').show();
        $('#modal_id').val(fieldId);
        var data = {
            "fieldId": fieldId
        };
        data[csrfName] = $.cookie(csrfCookie);
        $.ajax({
            type: "POST",
            url: baseUrl + "/common/get_field",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);   
				$("input[name=is_filter][value="+obj.is_filter+"]").prop("checked",true);
				$("#modal_filter_type").val(obj.filter_type).change();
                $('.loader').hide();
                $('#modal-fields').modal('show');
            }
        });
    }else{
        $('#modal-fields').modal('show');
    }
}


$(function() {
    $("#fields_table tbody").sortable({
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
        $("#fields_table tbody tr").each(function(index) {
          order.push({
            id: $(this).data("id"),
			category_id:$(this).data("category_id"),
            sort_order: index + 1
          });
        });
		var data = {
            "order": order
        };
        data[csrfName] = $.cookie(csrfCookie);
		$.ajax({
            type: "POST",
            url: baseUrl + "/admin/fields/update_filter_order_post",
            data: data,
            success: function (response) {
				$("#fields_table tbody tr").each(function(index) {
				  //$(this).find("td").eq(0).text(index + 1);
				  $(this).find("td").eq(3).text(index + 1);
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
<div class="loader"></div>


<script>

$(function(){
  const dt = $('.table').DataTable({
    searching: true,  // enable so search box appears
    info: false,
    lengthChange: true,
    paging: true,
    ordering: true,
    order: [[3, 'asc']],   // first column asc
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    dom: '<"d-flex align-items-center gap-2 mb-3"lf<"dropdown-filter"><"reset-filter">>t<"d-flex justify-content-center align-items-center my-3"ip>',
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
	  <label>Category</label>
        <select id="filterDropdown" class="form-control form-select-sm">
          <option value="">All</option> <?php
															if(!empty($categories_list)){
																foreach($categories_list as $category){ ?>
																	<option value="<?php echo $category->name; ?>" ><?php echo $category->name; ?></option>
															<?php }
															}
															?>
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
    dt.order([[3, 'asc']]);     // back to first column ASC
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
      dt.column(1).search(selectedValue).draw();  // Apply filter to second column
    } else {
      dt.column(1).search('').draw();  // Clear filter
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
<?php echo $this->endSection() ?>