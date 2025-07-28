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
                    <div class="card card-primary card-outline card-outline-tabs p-0">
                        <div class="card-body filter_list">
                            <div class="tab-content" id="custom-tabs-fields">
                                <div class="tab-pane fade show active" id="custom-tabs-fields" role="tabpanel" aria-labelledby="custom-tabs-fields-tab">
                                    <div class="table-responsive">
                                        <table id="fields_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            <div class="row table-filter-container align-items-center">
                                                <div class="col-sm-10 d-flex">
                                                    <?php $request = \Config\Services::request(); ?>
                                                    <?php echo form_open(admin_url() . "listings/filter-fields", ['method' => 'GET']); ?>
                                                    <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">
                                                    <div class="item-table-filter">
                                                        <label><?php echo trans("show"); ?></label>
                                                        <select name="show" class="form-control">
                                                            <option value="15" <?php echo ($request->getVar('show') == '15') ? 'selected' : ''; ?>>15</option>
                                                            <option value="30" <?php echo ($request->getVar('show') == '30') ? 'selected' : ''; ?>>30</option>
                                                            <option value="60" <?php echo ($request->getVar('show') == '60') ? 'selected' : ''; ?>>60</option>
                                                            <option value="100" <?php echo ($request->getVar('show') == '100') ? 'selected' : ''; ?>>100</option>
                                                        </select>
                                                    </div>
													
													
													 <div class="item-table-filter">
														<label><?php echo trans("Category"); ?></label>
														<select name="category_id" id="category_id" class="form-control">
															<option value=""><?php echo trans("all"); ?></option>
														   <?php
															if(!empty($categories_list)){
																foreach($categories_list as $category){ ?>
																	<option value="<?php echo $category->id; ?>" <?php echo ($request->getVar('category_id') !== null && $request->getVar('category_id') == $category->id) ? 'selected':''; ?>><?php echo $category->name; ?></option>
															<?php }
															}
															?>
														</select>
													</div>

                                                    <div class="item-table-filter">
                                                        <label><?php echo trans("search"); ?></label>
                                                        <input name="q" class="form-control" style="margin-bottom:0 !important;" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($request->getVar('q')); ?>">
                                                    </div>

                                                    <div class="item-table-filter align-self-end">
                                                        <label style="display: block">&nbsp;</label>
                                                        <button type="submit" class="btn small btn-primary"><?php echo trans("filter"); ?></button>

                                                    </div>

                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="20"><?php echo trans('S.no'); ?></th>
                                                    <th><?php echo trans('Field Name'); ?></th>
                                                    <th><?php echo trans('Category'); ?></th>
                                                    <th><?php echo trans('Show under Filter?'); ?></th>
                                                    <th><?php echo trans('Filter Order'); ?></th>
                                                    <th><?php echo trans('Filter Type'); ?></th>
                                                    <th class="text-center"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($fields as $i => $item) : ?>
													<tr  data-category_id="<?= $item->category_id; ?>" data-id="<?= $item->id; ?>">
                                                        <td><?php echo html_escape($i+1); ?></td>
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
                                                                    <div class=" dropdown-divider">
                                                                    </div>
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
            <form id="form_safe" action="<?php echo admin_url() .'fields/saved_filter_fields_post';?>" method="post">
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">
                <?php //echo csrf_field() ?>
                <input type="hidden" id="crsf">

                <div class="modal-body">						
					
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
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('Show Under Filter'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option d-flex align-items-center">
                                <input type="radio" name="is_filter" value="1" id="is_filter_1" class="square-purple" checked="checked">
                                <label for="is_filter_1" class="option-label"><?php echo trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option d-flex align-items-center">
                                <input type="radio" name="is_filter" value="0" id="is_filter_2" class="square-purple">
                                <label for="is_filter_2" class="option-label"><?php echo trans('disable'); ?></label>
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
				  $(this).find("td").eq(0).text(index + 1);
				  $(this).find("td").eq(4).text(index + 1);
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