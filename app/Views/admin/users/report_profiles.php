<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ('Reports' === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item active">Reports</li>
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
            
						<div class="row filter_Sec table-filter-container align-items-end py-3">
							<div class="col-sm-12 d-flex align-items-end flex-column flex-sm-row">
								<?php $request = \Config\Services::request(); ?>
								<?php echo form_open(admin_url() . "locations/county", ['method' => 'GET']); ?>
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
									<input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($request->getVar('q')); ?>">
								</div>


								<?php echo form_close(); ?>
							</div>
						</div>
                        <div class="card-body p-0">
                            <div class="tab-content filter_list" id="custom-tabs-locations">
                                <div class="tab-pane fade show active" id="custom-tabs-county" role="tabpanel" aria-labelledby="custom-tabs-county-tab">
                                    <div class="table-responsive">
										
                                        <table id="county_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            
                                            <thead>
                                                <tr>
													<th width="20"><input id="check_all" type="checkbox"></th>
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('business name'); ?></th>
                                                    <th><?php echo trans('report type'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($report_profiles as $item) : ?>
                                                    <tr>
														<td><input type="checkbox" name="row-check" value="<?php echo $item->id;?>"></td>
                                                        <td><?php echo html_escape($item->id); ?></td>
                                                        <td><?php echo html_escape($item->business_name); ?></td>
														<td><?php echo html_escape($item->report_type); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
										<button class="btn bg-danger mb-3" id="delete_selected">Delete</button>
                                        <?php if (empty($report_profiles)) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>



                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row clearfix">
							<?php /*<div class="col-sm-6">
								<button type="button" class="btn btn-danger" onclick="activate_inactivate_counties('inactivate');"><?php echo trans("inactivate_all"); ?></button>
								<button type="button" class="btn btn-success" onclick="activate_inactivate_counties('activate');"><?php echo trans("activate_all"); ?></button>
							</div>*/ ?>
							<div class="col-sm-12 float-right">

								<?php echo $paginations ?>
							</div>
						</div>
 
                        <!-- /.card --> <!-- end col -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- Modal -->
<div id="modal-county" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="<?php echo admin_url() .'locations/county/saved-county-post';?>" method="post">
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">
                <?php echo csrf_field() ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo trans("name"); ?></label>
                        <input type="text" id="modal_name" name="name" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                    </div>                  

                    <div class="form-group" style="display: none">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="1" id="status_1" class="square-purple" checked="checked">
                                <label for="status_1" class="option-label"><?php echo trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
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
$(function() {
	//If check_all checked then check all table rows
	$("#check_all").on("click", function () {
		if ($("input:checkbox").prop("checked")) {
			$("input:checkbox[name='row-check']").prop("checked", true);
		} else {
			$("input:checkbox[name='row-check']").prop("checked", false);
		}
	});

	// Check each table row checkbox
	$("input:checkbox[name='row-check']").on("change", function () {
		var total_check_boxes = $("input:checkbox[name='row-check']").length;
		var total_checked_boxes = $("input:checkbox[name='row-check']:checked").length;

		// If all checked manually then check check_all checkbox
		if (total_check_boxes === total_checked_boxes) {
			$("#check_all").prop("checked", true);
		}
		else {
			$("#check_all").prop("checked", false);
		}
	});
	
	$("#delete_selected").on("click", function () {
		var ids = '';
		var comma = '';
		$("input:checkbox[name='row-check']:checked").each(function() {
			ids = ids + comma + this.value;
			comma = ',';			
		});
		
		if(ids.length > 0) {
			Swal.fire({
				text: "Are you sure you want to delete?",
				icon: "warning",
				showCancelButton: 1,
				confirmButtonColor: "#34c38f",
				cancelButtonColor: "#f46a6a",
				confirmButtonText: sweetalert_ok,
				cancelButtonText: sweetalert_cancel,

			}).then(function (response) {
				if (response.value) {
					$.ajax({
						type: "POST",
						url: "<?php echo admin_url(); ?>"+"report-profiles/bulk-delete-post",
						data: {csrf_token:$.cookie(csrfCookie),'ids': ids},
						dataType: "html",
						success: function(msg) {
							location.reload();				
						},
						error: function(jqXHR, textStatus, errorThrown) {
							$("#msg").html("<span style='color:red;'>" + textStatus + " " + errorThrown + "</span>");
						}
					});
				}
			})
			
			
		} else {
			Swal.fire({
				text: "You must select at least one row for deletion",
				icon: "warning",
				confirmButtonColor: "#34c38f",
				confirmButtonText: sweetalert_ok,

			});
		}
	});
});
</script>
<?php echo $this->endSection() ?>