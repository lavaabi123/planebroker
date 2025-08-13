<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<style>
td:hover {
    cursor: move;
}
</style>
<div class="content-wrapper bg-grey">
    <!-- Content Header (Page header) -->
    <div class="content-header ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h1 class="m-0"><?php echo $title ?></h1>
					<a href="javascript:void(0)" class="btn small bg-primary ms-3" onclick="$('#modal-modalLabel').text('<?php echo trans('add'); ?>');manage_fields('');"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
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
                                    <div class="table-responsive overflow-hidden">
                                        <table id="fields_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            
                                            <thead>
                                                <tr>
                                                    <th><?php echo trans('Name'); ?></th>
                                                    <th><?php echo trans('Type'); ?></th>
                                                    <th><?php echo trans('Category'); ?></th>
                                                    <th width="40%"><?php echo trans('Sub Category'); ?></th>
                                                    <th><?php echo trans('Field Group'); ?></th>
                                                    <th><?php echo trans('Order'); ?></th>
                                                    <th><?php echo trans('Condition'); ?></th>
                                                    <th class="text-center"><?php echo trans('status'); ?></th>
                                                    <th class="text-center"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($fields as $i => $item) : ?>
													<tr data-id="<?= $item->id; ?>">
                                                        <td><?php echo html_escape($item->name); ?></td>
                                                        <td><?php echo html_escape($item->field_type); ?></td>
                                                        <td><?php echo html_escape($item->category_names); ?></td>
                                                        <td><?php echo html_escape($item->subcategory_names); ?></td>
                                                        <td><?php echo html_escape($item->group_names); ?></td>
                                                        <td><?php echo html_escape($item->field_order); ?></td>
                                                        <td><?php echo !empty($item->field_condition) ? 'Required' : 'Optional'; ?></td>
														<td class="text-center">
                                                            <?php if ($item->status == 1) : ?>
                                                                <button class="btn btn-sm bg-success"><?php echo trans("active"); ?></button>
                                                            <?php else : ?>
                                                                <button class="btn btn-sm bg-danger"><?php echo trans("inactive"); ?></button>
                                                            <?php endif; ?>
                                                        </td>	
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
                                                                    <div class=" dropdown-divider">
                                                                    </div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/fields/delete_fields_post','<?php echo $item->id; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
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
                </div>
            </div> <!-- end col -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- Modal -->
<div id="modal-fields" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center p-2 pb-0">
                <h4 class="modal-title mb-0 fw-bolder" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close fs-5 position-absolute top-0 end-0 m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            

                <div class="modal-body pb-0">
					<form id="form_safe" action="<?php echo admin_url() .'fields/saved_fields_post';?>" method="post">
						<input type="hidden" id="modal_id" name="id" class="form-control form-input">
						<?php //echo csrf_field() ?>
						<input type="hidden" id="crsf">
				<div class="row">
				<div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo trans("Field Name"); ?></label>
                        <input type="text" id="modal_name" name="name" maxlength="100" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                    </div>                                
		
				
                    <div class="form-group">
                        <label><?php echo trans("category"); ?></label>
						<select name="category_id[]" id="category_id" class="form-control" data-field-id="" multiple required>
							<?php
							if(!empty($categories_list)){
								foreach($categories_list as $category_row){ ?>
									<option value="<?php echo $category_row->id; ?>"><?php echo $category_row->name; ?></option>
							<?php }
							}
							?>
						</select>
                    </div>
                    <div class="form-group">
                        <label class="ms-0"><?php echo trans("Sub Category"); ?></label>
						 <select name="sub_category_id[]" id="sub_category_id" class="form-control" multiple required>
							<option value=""><?php echo trans('Select Category First') ?></option>							
						</select>
                    </div> 
							
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label><?php echo trans('status'); ?></label>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <input type="radio" name="status" value="1" id="status_1" class="square-purple" checked="checked">
                                <label for="status_1" class="option-label ms-0"><?php echo trans('enable'); ?></label>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <input type="radio" name="status" value="0" id="status_2" class="square-purple">
                                <label for="status_2" class="option-label ms-0"><?php echo trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>  
                    <div class="form-group">
						<div class="row align-items-center">
                            <div class="col-auto">
                                <label class="ms-0"><?php echo trans('Field Condition'); ?></label>
                            </div>					
							<div class="col-auto d-flex align-items-center">
								<input type="radio" name="field_condition" value="1" id="field_condition_1" class="square-purple" checked="checked">
								<label for="field_condition_1" class="option-label ms-0">Required</label>
							</div>
							<div class="col-auto d-flex align-items-center">
								<input type="radio" name="field_condition" value="0" id="field_condition_2" class="square-purple">
								<label for="field_condition_2" class="option-label ms-0">Optional</label>
							</div>
						</div> 
                    </div> 
					
				</div>	
				<div class="col-md-6">	

                    <div class="form-group">
                        <label><?php echo trans("Field Order"); ?></label>
                        <input type="number" id="modal_field_order" name="field_order" maxlength="100" class="form-control form-input" placeholder="<?php echo trans("Field Order"); ?>" required>
                    </div>
							 
                    <div class="form-group">
                        <label><?php echo trans("Group Name (Title where this field comes under)"); ?></label>
						 <select name="fields_group_id[]" id="fields_group_id" class="form-control" multiple required>
							<option value=""><?php echo trans('Select Category') ?></option>							
						</select>
                    </div> 	
                    <div class="form-group">
                        <label><?php echo trans("Field Type"); ?></label>						
						<select id="modal_field_type" name="field_type" class="form-control" onchange="change_field_type(this)">
							<option value="Text">Text</option>
							<option value="Textarea">Textarea</option>
							<option value="Checkbox">Checkbox</option>
							<option value="Radio">Radio</option>
							<option value="Dropdown">Dropdown</option>
							<option value="File">File</option>
							<option value="Number">Number</option>
						</select>						
                    </div> 
					<div class="form-group fieldoptiondiv" style="display:none;">
						<div class="row">
							<div class="col-12">
								<div class='panel rates'>                  
									<a href="javascript:void(0)" class='addOption btn btn-sm yellowbtn mb-3'>Add Options</a>
									<div class='text-sm'>Options will automatically be ordered by name, ascending</div>
								</div>
							</div>                                    
						</div>
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

$(document).ready(function() {

    // On change, load subcategories
    $('#category_id').on('change', function() {
        let selected = $(this).val();
		var field_id = $(this).attr('data-field-id');
        if (selected && selected.length > 0) {
            $.ajax({
                url: baseUrl + "/common/get_sub_category_by_ids",
                method: 'POST',
				dataType:'json',
                data: { category_ids: selected, field_id:field_id },
                success: function(response) {
                    $('#sub_category_id').html(response.text);
                }
            });
			// On change, load group
			$.ajax({
                url: baseUrl + "/common/get_field_group_by_ids",
                method: 'POST',
				dataType:'json',
                data: { category_ids: selected, field_id:field_id },
                success: function(response) {
                    $('#fields_group_id').html(response.text);
                }
            });			
        } else {
            $('#sub_category_id').html('');
            $('#fields_group_id').html('');
        }
    });
});
     
function change_field_type(_this){
	var f_type = $(_this).val();
	if(f_type == 'Checkbox' || f_type == 'Radio' || f_type == 'Dropdown'){
		$('.fieldoptiondiv').show();
	}else{
		$('.fieldoptiondiv').hide();
	}
}        


var addOption = $('.addOption');
addOption.on('click', function(e){
	e.preventDefault();
	$(this).before('<div class="d-flex fieldoption gap-2"><div class="col px-0"><input type="text" class="form-control" placerholder="Option Name" value="" name="field_options[]"></div><a href="javascript:void(0)" class="button tiny alert removeOption p-2"><i class="fas fa-trash"></i></a></div>');
});
	
$('body').on('click', '.removeOption', function(e){
	e.preventDefault();
	$(this).parents('.fieldoption').remove();
});

// Function to fetch content via AJAX
function manage_fields(fieldId) {
    $('#modal_id').val('');
    $('#modal_name').val('');
    $('#modal_field_order').val('');
	$('.fieldoption').remove();

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
                $('#modal_name').val(obj.name);
                $('#modal_field_condition').val(obj.field_condition);
                $('#modal_field_order').val(obj.field_order);
				$("#modal_field_type").val(obj.field_type).change();
				if(obj.field_type == 'Checkbox' || obj.field_type == 'Radio' || obj.field_type == 'Dropdown'){
					$('.addOption').before(obj.option_html);
					$('.fieldoptiondiv').show();
				}else{
					$('.fieldoptiondiv').hide();
				}
				$("input[name=field_condition][value="+obj.field_condition+"]").prop("checked",true);
				$("input[name=status][value="+obj.status+"]").prop("checked",true);
				
				$('#category_id').attr('data-field-id',obj.id);
				
				// Categories
				$('#category_id').empty();
				$.each(obj.allCategories, function (i, cat) {
					$('#category_id').append(
						$('<option>', {
							value: cat.id,
							text: cat.name,
							selected: obj.selectedCategories.includes(cat.id)
						})
					);
				});

				// Subcategories
				$('#sub_category_id').empty();
				$.each(obj.allSubcategories, function (i, sub) {
					$('#sub_category_id').append(
						$('<option>', {
							value: sub.id,
							text: sub.name + ' (' + sub.category_name + ')',
							selected: obj.selectedSubcategories.includes(sub.id)
						})
					);
				});
				
				// Groups
				$('#fields_group_id').empty();
				$.each(obj.allGroups, function (i, grp) {
					$('#fields_group_id').append(
						$('<option>', {
							value: grp.id,
							text: grp.name + ' (' + grp.category_name + ')',
							selected: obj.selectedGroups.includes(grp.id)
						})
					);
				});
				
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
            sort_order: index + 1
          });
        });
		var data = {
            "order": order
        };
        data[csrfName] = $.cookie(csrfCookie);
		$.ajax({
            type: "POST",
            url: baseUrl + "/admin/fields/update_order_post",
            data: data,
            success: function (response) {
				$("#fields_table tbody tr").each(function(index) {
				  //$(this).find("td").eq(0).text(index + 1);
				  $(this).find("td").eq(5).text(index + 1);
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
  let startDate = null;
  let endDate = null;

  $.fn.dataTable.ext.search.push(function (settings, data) {
    if (!startDate || !endDate) return true;
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
    order: [[2, 'asc']],
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],
    dom: '<"d-flex align-items-center gap-2 mb-3"l<"dropdown-filter"><"user-filter"><"reset-filter">>t<"d-flex justify-content-center align-items-center my-3"ip>',
	language: {
      paginate: {
        previous: "<i class='fas fa-caret-left'></i>",
        next: "<i class='fas fa-caret-right'></i>"
      }
    },
    initComplete: function () {
      const api = this.api();
$('.reset-filter').html(
    '<label class="d-block">&nbsp;</label>' +
    '<button type="button" id="resetFilters" class="btn small bg-primary">RESET</button>'
  );
      // Build dropdowns
      $('.dropdown-filter').html(`
        <label>Category</label>
        <select id="filterDropdown" class="form-control form-select-sm">
          <?php foreach($categories_list as $cat){ ?>
            <option value="<?= $cat->id ?>" data-name="<?= esc($cat->name) ?>">
              <?= esc($cat->name) ?>
            </option>
          <?php } ?>
        </select>
      `);
      $('.user-filter').html(`
        <label>Field Group</label>
        <select id="userDropdown" class="form-control form-select-sm" disabled>
          <option value="">Loading...</option>
        </select>
      `);

     // helper: load FG for a category, with optional auto-select+filter
  // Build FG options (no "All"); optionally auto-select first & filter
function loadFieldGroupsByCategory(catId, { autoSelect = false, applyFilter = false } = {}) {
  const $fg = $('#userDropdown');
  $fg.prop('disabled', true).html('<option>Loading...</option>');

  $.getJSON('<?= base_url('admin/fields/field-groups'); ?>/' + catId, function (res) {
    const rows = (res && res.data) ? res.data : [];
    if (!rows.length) {
      $fg.html('<option value="">No field groups</option>').prop('disabled', true);
      // clear FG filter if nothing available
      api.column(4).search('').draw();
      return;
    }

    // No "All" — build options
    let html = '';
    rows.forEach(r => { html += `<option value="${r.name}">${r.name}</option>`; });
    $fg.html(html).prop('disabled', false);

    if (autoSelect) {
      const firstFG = $fg.find('option:first').val();
      if (firstFG) {
        $fg.val(firstFG);
        if (applyFilter) {
          api.column(4).search('^' + $.fn.dataTable.util.escapeRegex(firstFG) + '$', true, false).draw();
        }
      }
    }
  }).fail(function(){
    $fg.html('<option value="">Error loading</option>').prop('disabled', true);
    api.column(4).search('').draw();
  });
}


      // 1) Auto-select & filter by FIRST CATEGORY
  const $cat = $('#filterDropdown');
const firstCatId = $cat.find('option:first').val();
const firstCatName = $cat.find('option:first').data('name');

if (typeof firstCatId !== 'undefined') {
  $cat.val(firstCatId);
  api.column(2).search('^' + $.fn.dataTable.util.escapeRegex(firstCatName) + '$', true, false).draw();
  // → also select & filter by FIRST FG of that category
  loadFieldGroupsByCategory(firstCatId, { autoSelect: true, applyFilter: true });
}

  // Category change => refilter category, clear FG, reload FGs (no auto-select here)
  $('#filterDropdown').on('change', function () {
  const catId = $(this).val();
  const catName = $(this).find(':selected').data('name') || '';

  // Filter by category (col 2)
  api.column(2).search(catName ? '^' + $.fn.dataTable.util.escapeRegex(catName) + '$' : '', true, false).draw();

  // Load FGs for this category, auto-select FIRST FG, and filter by it (col 4)
  if (catId) {
    loadFieldGroupsByCategory(catId, { autoSelect: true, applyFilter: true });
  } else {
    // unlikely since you removed "All" from Category, but safe:
    $('#userDropdown').prop('disabled', true).html('');
    api.column(4).search('').draw();
  }
});

  // Field Group change => filter FG column
  $('#userDropdown').on('change', function () {
    const v = $(this).val();
    api.column(4).search(v ? '^' + $.fn.dataTable.util.escapeRegex(v) + '$' : '', true, false).draw();
  });

  // Reset => back to first category AND first FG of that category
  $(document).on('click', '#resetFilters', function () {
  // ...clear global/per-column, date, etc...

  const $cat = $('#filterDropdown');
  const firstCatId = $cat.find('option:first').val();
  const firstCatName = $cat.find('option:first').data('name');

  if (typeof firstCatId !== 'undefined') {
    $cat.val(firstCatId);
    api.column(2).search('^' + $.fn.dataTable.util.escapeRegex(firstCatName) + '$', true, false);
    // auto-select FIRST FG for that category and filter by it
    loadFieldGroupsByCategory(firstCatId, { autoSelect: true, applyFilter: true });
  } else {
    api.column(2).search('');
    api.column(4).search('');
  }

  api.order([[2, 'asc']]).page('first').draw();
});


  $('.dataTables_length select').removeClass('custom-select-sm');
  $('.dataTables_length label').contents().filter(function () {
        return this.nodeType === 3; // Node.TEXT_NODE
    }).remove();
	$('.dataTables_length label').each(function() {
		$(this).contents().unwrap(); // This removes the <label> but keeps the input
	});
	$('.dataTables_length').prepend('<label>Show</label>');
    }
  });
});

</script>


<?php echo $this->endSection() ?>