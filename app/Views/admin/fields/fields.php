<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<style>
td:hover {
    cursor: move;
}
</style>
<div class="content-wrapper">
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
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-fields">
                                <div class="tab-pane fade show active" id="custom-tabs-fields" role="tabpanel" aria-labelledby="custom-tabs-fields-tab">
                                    <div class="table-responsive">
                                        <table id="fields_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            <div class="row table-filter-container">
                                                <div class="col-sm-6">
                                                    <?php $request = \Config\Services::request(); ?>
                                                    <?php echo form_open(admin_url() . "fields", ['method' => 'GET']); ?>
                                                    <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">
                                                    <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                                        <label><?php echo trans("show"); ?></label>
                                                        <select name="show" class="form-control">
                                                            <option value="15" <?php echo ($request->getVar('show') == '15') ? 'selected' : ''; ?>>15</option>
                                                            <option value="30" <?php echo ($request->getVar('show') == '30') ? 'selected' : ''; ?>>30</option>
                                                            <option value="60" <?php echo ($request->getVar('show') == '60') ? 'selected' : ''; ?>>60</option>
                                                            <option value="100" <?php echo ($request->getVar('show') == '100') ? 'selected' : ''; ?>>100</option>
                                                        </select>
                                                    </div>

                                                    <div class="item-table-filter">
                                                        <label><?php echo trans("search"); ?></label>
                                                        <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($request->getVar('q')); ?>">
                                                    </div>

                                                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                                        <label style="display: block">&nbsp;</label>
                                                        <button type="submit" class="btn bg-primary"><?php echo trans("filter"); ?></button>

                                                    </div>

                                                    <?php echo form_close(); ?>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <a href="javascript:void(0)" class="btn bg-primary" onclick="manage_fields('');"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="20"><?php echo trans('S.no'); ?></th>
                                                    <th><?php echo trans('Field Name'); ?></th>
                                                    <th><?php echo trans('Field Type'); ?></th>
                                                    <th><?php echo trans('Category'); ?></th>
                                                    <th><?php echo trans('Sub Category'); ?></th>
                                                    <th><?php echo trans('Field Group(Title)'); ?></th>
                                                    <th><?php echo trans('Order'); ?></th>
                                                    <th><?php echo trans('Position'); ?></th>
                                                    <th><?php echo trans('status'); ?></th>
                                                    <th class="text-center"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($fields as $i => $item) : ?>
													<tr data-id="<?= $item->id; ?>">
                                                        <td><?php echo html_escape($i+1); ?></td>
                                                        <td><?php echo html_escape($item->name); ?></td>
                                                        <td><?php echo html_escape($item->field_type); ?></td>
                                                        <td><?php echo html_escape($item->category_names); ?></td>
                                                        <td><?php echo html_escape($item->subcategory_names); ?></td>
                                                        <td><?php echo html_escape($item->group_names); ?></td>
                                                        <td><?php echo html_escape($item->field_order); ?></td>
                                                        <td><?php echo html_escape($item->field_position); ?></td>
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
                                        <?php if (empty($fields)) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>



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

                                    <?php echo $paginations ?>
                                </div>
                            </div>

                        </div> 
                        <!-- /.card -->
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="<?php echo admin_url() .'fields/saved_fields_post';?>" method="post">
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">
                <?php //echo csrf_field() ?>
                <input type="hidden" id="crsf">

                <div class="modal-body">
				
                    <div class="form-group">
                        <label><?php echo trans("Field Name"); ?></label>
                        <input type="text" id="modal_name" name="name" maxlength="100" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                    </div>                                

                    <div class="form-group">
                        <label><?php echo trans("Field Type"); ?></label>						
						<select id="modal_field_type" name="field_type" class="form-control" onchange="change_field_type(this)">
							<option value="Text">Text</option>
							<option value="Textarea">Textarea</option>
							<option value="Checkbox">Checkbox</option>
							<option value="Radio">Radio</option>
							<option value="Dropdown">Dropdown</option>
						</select>						
                    </div>   
					
					<div class="form-group fieldoptiondiv" style="display:none;">
						<div class="row">
							<div class="col-12">
								<div class="form-group mb-3"> 
									<div class="form-group mb-3 mb-lg-5">
										<div class='panel rates text-center'>                  
											<a href="javascript:void(0)" class='addOption btn btn-sm yellowbtn mb-3'>Add Options</a>
											<div class='text-sm'>Options will automatically be ordered by name, ascending</div>
										</div>
									</div>
								</div>
							</div>                                    
						</div>
					</div>	

                    <div class="form-group">
						<div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('Field Position'); ?></label>
                            </div>					
							<div class="col-sm-4 col-xs-12 col-option d-flex align-items-center">
								<input type="radio" name="field_position" value="Right" id="field_position_1" class="square-purple" checked="checked">
								<label for="field_position_1" class="option-label">Right</label>
							</div>
							<div class="col-sm-4 col-xs-12 col-option d-flex align-items-center">
								<input type="radio" name="field_position" value="Left" id="field_position_2" class="square-purple">
								<label for="field_position_2" class="option-label">Left</label>
							</div>
						</div> 
                    </div>        

                    <div class="form-group">
                        <label><?php echo trans("Field Order"); ?></label>
                        <input type="number" id="modal_field_order" name="field_order" maxlength="100" class="form-control form-input" placeholder="<?php echo trans("Field Order"); ?>" required>
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
                        <label><?php echo trans("Sub Category"); ?></label>
						 <select name="sub_category_id[]" id="sub_category_id" class="form-control" multiple required>
							<option value=""><?php echo trans('Select Category First') ?></option>							
						</select>
                    </div>  
                    <div class="form-group">
                        <label><?php echo trans("Group Name (Title where this field comes under)"); ?></label>
						 <select name="fields_group_id[]" id="fields_group_id" class="form-control" multiple required>
							<option value=""><?php echo trans('Select Category') ?></option>							
						</select>
                    </div> 										
					
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option d-flex align-items-center">
                                <input type="radio" name="status" value="1" id="status_1" class="square-purple" checked="checked">
                                <label for="status_1" class="option-label"><?php echo trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option d-flex align-items-center">
                                <input type="radio" name="status" value="0" id="status_2" class="square-purple">
                                <label for="status_2" class="option-label"><?php echo trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
                </div>
            </form>
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
	$(this).before('<div class="d-flex fieldoption gap-2 gap-sm-4"><div class="col"><input type="text" class="form-control" placerholder="Option Name" value="" name="field_options[]"></div><a href="javascript:void(0)" class="button tiny alert removeOption p-2"><i class="fas fa-trash"></i></a></div>');
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
                $('#modal_field_position').val(obj.field_position);
                $('#modal_field_order').val(obj.field_order);
				$("#modal_field_type").val(obj.field_type).change();
				if(obj.field_type == 'Checkbox' || obj.field_type == 'Radio' || obj.field_type == 'Dropdown'){
					$('.addOption').before(obj.option_html);
					$('.fieldoptiondiv').show();
				}else{
					$('.fieldoptiondiv').hide();
				}
				$("input[name=field_position][value="+obj.field_position+"]").prop("checked",true);
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
				  $(this).find("td").eq(0).text(index + 1);
				  $(this).find("td").eq(6).text(index + 1);
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
<?php echo $this->endSection() ?>