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
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>blog"><?php echo trans('Blog') ?></a></li>
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
            <?php echo form_open_multipart('admin/blog/add_blog_post', ['id' => 'form',  'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
            <input type="hidden" id="crsf">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class=" ml-0"><?php echo trans("Blog Title"); ?><span class="required"> *</span></label>
                                        <input type="text" name="name" class="form-control auth-form-input" placeholder="<?php echo trans("Blog Title"); ?>" value="<?php echo old("subject"); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class=" ml-0"><?php echo trans("Blog Image"); ?><span class="required"> *</span></label>
                                        <input type="file" name="image" class="form-control auth-form-input" value="" >
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="control-label ml-0"><?php echo trans('Blog Content'); ?><span class="required"> *</span></label>                               
                                <script src="<?php echo base_url('assets/ckeditor/build/ckeditor.js'); ?>"></script>
                                <textarea class="form-control text-area" name="content" id="editor" placeholder="<?php echo trans('content'); ?>" required></textarea>

                                <script>                        
                                    ClassicEditor
                                        .create(document.querySelector('#editor'), {
                                            // CKEditor 5 configuration options
                                            removePlugins: [ 'MediaEmbed','Title' ],
                                            simpleUpload: {
                                                uploadUrl: "<?php echo base_url('fileupload.php?CKEditorFuncNum=') ?>"
                                            },
                                        })
                                        .then(editor => {
                                            console.log('CKEditor 5 initialized:', editor);
                                        })
                                        .catch(error => {
                                            console.error('Error initializing CKEditor 5:', error);
                                        });
                                </script>
                        </div>
						<div class="row">
							<div class="col-6">
								<div class="form-group mb-3">
									<label class=" ml-0"><?php echo trans("Status"); ?><span class="required"> *</span></label>
									<select name="status" class="form-control" required>
									<option value="1" <?php echo (old("status") == 1) ? 'selected':''; ?>>Active</option>
									<option value="2" <?php echo (old("status") == 2) ? 'selected':''; ?>>Inactive</option>
									</select>
								</div>
							</div>
						</div>
                        <div class="form-group mb-3 float-right">
                            <button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                        </div>
                        <div class="card-footer clearfix" style="clear: both">
                            <small><strong><span class="required"> *</span> Must be filled</strong></small>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div> <!-- end col -->

        </div>

        <?php echo form_close(); ?>
        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<?php echo $this->endSection() ?>