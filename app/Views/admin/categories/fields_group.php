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
                    <div class="card card-primary card-outline card-outline-tabs p-0">
                        <div class="card-body filter_list">
                            <div class="tab-content" id="custom-tabs-fields_group">
                                <div class="tab-pane fade show active" id="custom-tabs-fields_group" role="tabpanel" aria-labelledby="custom-tabs-fields_group-tab">
                                    <div class="table-responsive">
                                        <table id="fields_group_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            <div class="row table-filter-container m-0">
                                                <div class="col-sm-6">
                                                    <?php $request = \Config\Services::request(); ?>
                                                    <?php echo form_open(admin_url() . "groups/index/".$categoryId, ['method' => 'GET']); ?>
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
                                                        <label><?php echo trans("search"); ?></label>
                                                        <input name="q" class="form-control" style="margin-bottom:0 !important;"  placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($request->getVar('q')); ?>">
                                                    </div>

                                                    <div class="item-table-filter md-top-10 align-self-end">
                                                        <label style="display: block">&nbsp;</label>
                                                        <button type="submit" class="btn small bg-primary"><?php echo trans("filter"); ?></button>

                                                    </div>

                                                    <?php echo form_close(); ?>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <a href="javascript:void(0)" class="btn small bg-primary" onclick="manage_fields_group('<?php echo html_escape($categoryId); ?>','','');"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr class="text-center">
                                                    <th><?php echo trans('name'); ?></th>
                                                    <th class="text-center"><?php echo trans('Sort Order'); ?></th>
                                                    <th class="text-center"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($fields_group as $i => $item) : ?>
                                                    <tr data-id="<?= $item->id; ?>">
                                                        <td><?php echo html_escape($item->name); ?></td>
                                                        <td><?php echo html_escape($item->sort_order); ?></td>
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
                                        <?php if (empty($fields_group)) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>



                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="card-footer clearfix">
                            <div class="row">
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
<div id="modal-fields_group" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
<?php echo $this->endSection() ?>