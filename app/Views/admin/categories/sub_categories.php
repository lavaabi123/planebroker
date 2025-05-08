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
                            <div class="tab-content" id="custom-tabs-categories">
                                <div class="tab-pane fade show active" id="custom-tabs-categories" role="tabpanel" aria-labelledby="custom-tabs-categories-tab">
                                    <div class="table-responsive">
                                        <table id="categories_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            <div class="row table-filter-container">
                                                <div class="col-sm-6">
                                                    <?php $request = \Config\Services::request(); ?>
                                                    <?php echo form_open(admin_url() . "categories", ['method' => 'GET']); ?>
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
                                                    <a href="javascript:void(0)" class="btn bg-primary" onclick="manage_categories('');"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('name'); ?></th>
                                                    <th><?php echo trans('Parent Category'); ?></th>
                                                    <?php /*<th><?php echo trans('status'); ?></th> */ ?>
                                                    <th class="text-center"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($categories as $item) : ?>
                                                    <tr>
                                                        <td><?php echo html_escape($item->id); ?></td>
                                                        <td><?php echo html_escape($item->name); ?></td>
                                                        <td><?php echo html_escape($item->category_name); ?></td>
                                                       <?php /* <td class="text-center">
                                                            <?php if ($item->status == 1) : ?>
                                                                <button class="btn btn-sm btn-success"><?php echo trans("active"); ?></button>
                                                            <?php else : ?>
                                                                <button class="btn btn-sm btn-danger"><?php echo trans("inactive"); ?></button>
                                                            <?php endif; ?>
                                                        </td> */ ?>
                                                        <td class="text-center">
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <?php if ($item->status == 1) : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="$('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); manage_categories('<?php echo html_escape($item->id); ?>'); $('#status_1').prop('checked', true);"><?php echo trans('edit'); ?></a>
                                                                    <?php else : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="$('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); manage_categories('<?php echo html_escape($item->id); ?>'); $('#status_2').prop('checked', true);"><?php echo trans('edit'); ?></a>
                                                                    <?php endif; ?>
                                                                    <div class=" dropdown-divider">
                                                                    </div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/sub-categories/delete_categories_post','<?php echo $item->id; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($categories)) : ?>
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
<div id="modal-categories" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="<?php echo admin_url() .'sub-categories/saved_sub_categories_post';?>" method="post">
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">
                <?php //echo csrf_field() ?>
                <input type="hidden" id="crsf">

                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo trans("name"); ?></label>
                        <input type="text" id="modal_name" name="name" maxlength="100" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                    </div>                                

                    <div class="form-group">
                        <label><?php echo trans("category"); ?></label>
						 <select name="category_id" id="category_id" class="form-control" required>
							<option value=""><?php echo trans('Select Category') ?></option>
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
                        <label><?php echo trans("seo_title"); ?></label>
                        <input type="text" id="modal_seo_title" name="seo_title" maxlength="255" class="form-control form-input" placeholder="<?php echo trans("seo_title"); ?>" required>
                    </div>             

                    <div class="form-group">
                        <label><?php echo trans("seo_keywords"); ?></label>
                        <textarea id="modal_seo_keywords" name="seo_keywords" class="form-control form-input" placeholder="<?php echo trans("seo_keywords"); ?>" required></textarea>
                    </div>     

                    <div class="form-group">
                        <label><?php echo trans("seo_description"); ?></label>
                        <textarea id="modal_seo_description" name="seo_description" class="form-control form-input" placeholder="<?php echo trans("seo_description"); ?>" required></textarea>
                    </div>        

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="1" id="status_1" class="status_modal square-purple" checked="checked">
                                <label for="status_1" class="option-label"><?php echo trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="0" id="status_2" class="status_modal square-purple">
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
// Function to fetch content via AJAX
function manage_categories(categoryId) {
    $('#modal_id').val('');
    $('#modal_name').val('');
	$('#category_id [value=""]').attr('selected', 'true');
	$('.status_modal [value=""]').attr('selected', 'true');
    $('#modal_seo_title').val('');
    $('#modal_seo_keywords').val('');
    $('#modal_seo_description').val('');

    if(categoryId != ''){
        $('.loader').show();
        $('#modal_id').val(categoryId);
        var data = {
            "categoryId": categoryId
        };
        data[csrfName] = $.cookie(csrfCookie);
        $.ajax({
            type: "POST",
            url: baseUrl + "/common/get_sub_category",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);                
                $('#modal_name').val(obj.name);
				$('#category_id [value='+obj.category_id+']').attr('selected', 'true');
				$('.status_modal [value='+obj.status+']').attr('selected', 'true');
                $('#modal_seo_title').val(obj.seo_title);
                $('#modal_seo_keywords').val(obj.seo_keywords);
                $('#modal_seo_description').val(obj.seo_description);
                $('.loader').hide();
                $('#modal-categories').modal('show');
            }
        });
    }else{
        $('#modal-categories').modal('show');
    }
}
</script>   
<div class="loader"></div>
<?php echo $this->endSection() ?>