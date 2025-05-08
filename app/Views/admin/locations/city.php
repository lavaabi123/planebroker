<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo trans('locations') ?></a></li>
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
                        <div class="card-header p-0 border-bottom-0">
                            <?php echo view('admin/locations/_tabs') ?>
                        </div>
						<div class="row filter_Sec table-filter-container align-items-end py-3">
							<div class="col-sm-12 d-flex align-items-end flex-column flex-sm-row">
								<?php $request = \Config\Services::request(); ?>

								<?php echo form_open(admin_url() . "locations/city", ['method' => 'GET']); ?>
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
									<label><?php echo trans('county'); ?></label>
									<select name="county" class="form-control">
										<option value=""><?php echo trans("all"); ?></option>
										<?php
										foreach ($counties as $item) : ?>
											<option value="<?php echo $item->id; ?>" <?php echo ($request->getVar('county') == $item->id) ? 'selected' : ''; ?>>
												<?php echo html_escape($item->name); ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="item-table-filter">
									<label><?php echo trans('state'); ?></label>
									<select name="state" id="select_states" class="form-control">
										<option value=""><?php echo trans("all"); ?></option>
										<?php
										/*$county_id = $request->getVar('county');
										if (!empty($county_id)) {
											$states = $this->location_model->get_states_by_county($county_id);
										}*/
										foreach ($states as $item) : ?>
											<option value="<?php echo $item->id; ?>" <?php echo ($request->getVar('state') == $item->id) ? 'selected' : ''; ?>>
												<?php echo html_escape($item->name); ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="item-table-filter">
									<label><?php echo trans("search"); ?></label>
									<input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($request->getVar('q')); ?>">
								</div>

								<div class="item-table-filter">
									<button type="submit" class="btn small bg-primary"><?php echo trans("filter"); ?></button>
									<a href="javascript:void(0)" class="btn small bg-primary" data-toggle="modal" data-target="#modal-city"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
								</div>
								
								<?php echo form_close(); ?>
							</div>
						</div>
                        <div class="card-body p-0">
                            <div class="tab-content filter_list" id="custom-tabs-locations">
                                <div class="tab-pane fade show active" id="custom-tabs-state" role="tabpanel" aria-labelledby="custom-tabs-state-tab">
                                    <div class="table-responsive">
                                        <table id="city_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            
                                            <thead>
                                                <tr>
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('city'); ?></th>
                                                    <th><?php echo trans('Zipcode'); ?></th>
                                                    <th><?php echo trans('county'); ?></th>
                                                    <th><?php echo trans('state'); ?></th>
                                                    <th width="100"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($city as $item) : ?>
                                                    <tr>
                                                        <td><?php echo html_escape($item->id); ?></td>
                                                        <td><?php echo html_escape($item->city); ?></td>
                                                        <td><?php echo html_escape($item->zipcode); ?></td>
                                                        <td><?php echo html_escape($item->county_name); ?></td>
                                                        <td><?php echo html_escape($item->state_name); ?></td>
                                                        <td class="text-center">
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-city" onclick="$('form').attr('action', '<?php echo admin_url() ."locations/city/saved_city_post";?>'); $('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); $('#modal_id').val('<?php echo html_escape($item->id); ?>'); $('#modal_city').val('<?php echo html_escape($item->city); ?>');$('#modal_zipcode').val('<?php echo html_escape($item->zipcode); ?>');$('#modal_lat').val('<?php echo html_escape($item->lat); ?>');$('#modal_long').val('<?php echo html_escape($item->long); ?>'); $('#modal_county').val('<?php echo html_escape($item->county_id); ?>'); $('#selected_states').val('<?php echo html_escape($item->state_id); ?>').change();"><?php echo trans('edit'); ?></a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/locations/city/delete_city_post','<?php echo $item->id; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($city)) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12 float-right">
                                <?php echo $paginations ?>
                            </div>
                        </div>
                        <!-- /.card -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div id="modal-city" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="<?php echo admin_url() ."locations/city/saved_city_post";?>" method="post">
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">
                <?php echo csrf_field() ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo trans('county'); ?></label>
                        <select id="modal_county" name="county_id" class="form-control" nchange="get_states_by_county($(this).val());" required>
                            <option value=""><?php echo trans("select"); ?></option>
                            <?php
                            foreach ($counties as $item) : ?>
                                <option value="<?php echo $item->id; ?>">
                                    <?php echo html_escape($item->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans('state'); ?></label>
                        <select name="state_id" id="selected_states" class="form-control selected_states" required>
                            <option value=""><?php echo trans("select"); ?></option>
                            <?php foreach ($states as $item) : ?>
                                <option value="<?php echo $item->id; ?>">
                                    <?php echo html_escape($item->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans("name"); ?></label>
                        <input type="text" id="modal_city" name="city" class="form-control form-input" placeholder="<?php echo trans("city"); ?>" required>
                    </div>
                     <div class="form-group">
                        <label><?php echo trans("Zipcode"); ?></label>
                        <input type="text" id="modal_zipcode" name="zipcode" class="form-control form-input" placeholder="<?php echo trans("Zipcode"); ?>" required>
                    </div>
                     <div class="form-group">
                        <label><?php echo trans("Latitude"); ?></label>
                        <input type="text" id="modal_lat" name="lat" class="form-control form-input" placeholder="<?php echo trans("Latitude"); ?>">
                    </div>
                     <div class="form-group">
                        <label><?php echo trans("Longitude"); ?></label>
                        <input type="text" id="modal_long" name="long" class="form-control form-input" placeholder="<?php echo trans("longitude"); ?>">
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
<?php echo $this->endSection() ?>