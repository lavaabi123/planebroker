<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/selectize/css/selectize.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/pickadate/themes/pickadate.min.css" /> 
<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/selectize/js/standalone/selectize.min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>/assets/pickadate/picker.time.js'></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/provider.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?>
                        <a class="btn btn-primary" href="<?php echo admin_url() . 'users/'; ?>"><?php echo trans('Back'); ?></a>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>users"><?php echo trans('users') ?></a></li>
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
            <?php echo form_open_multipart('admin/add_user_post', ['id' => 'provider-form',  'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <input type="hidden" id="crsf">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("First Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="first_name" id="first_name" class="form-control auth-form-input required" placeholder="<?php echo trans("First Name"); ?>" value="<?php echo old('first_name'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Last Name"); ?><span class="required"> *</span></label>
                                                <input type="text" name="last_name" id="last_name" class="form-control auth-form-input required" placeholder="<?php echo trans("Last Name"); ?>" value="<?php echo old('last_name'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("email"); ?><span class="required"> *</span></label>
                                                <input type="email" name="email" id="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo old('email'); ?>" parsley-type="email" readonly onfocus="this.removeAttribute('readonly');">
                                            </div>
                                        </div>

                                         <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("Phone Number"); ?><span class="required"> *</span></label>
                                                <input type="text" name="mobile_no" id="mobile_no" class="form-control auth-form-input" placeholder="<?php echo trans("Phone Number"); ?>" value="<?php echo old('mobile_no'); ?>">
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_password"); ?><span class="required"> *</span></label>
                                                <input type="password" name="password" id="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" value="<?php echo old("password"); ?>"  readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_confirm_password"); ?></label>
                                                <input type="password" name="password_confirm" id="password_confirm" class="form-control form-input" value="" placeholder="<?php echo trans("form_confirm_password"); ?>" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white; color: black;">
                                            </div>
                                        </div>
                                         <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("User Level"); ?><span class="required"> *</span></label>
												<select name="user_level" class="form-control">
													<option value="0">Standard User</option>
													<option value="1">Captain User</option>
												</select>
                                            </div>
                                        </div>									
                                    </div>

                                    <div class="form-group mb-3 float-right">
                                        <button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                                    </div>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
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
        } else {
            $('#sub_category_id').html('');
        }
    });
	
	$('#category_id, #sub_category_id').on('change', function () {
		const selectedCategory = $('#category_id').val();
		const selectedSubcategory = $('#sub_category_id').val();

		$('.d_fields').each(function () {
			const catList = $(this).data('category').toString().split(',');
			const subcatList = $(this).data('subcategory').toString().split(',');

			const matchCategory = selectedCategory === '' || catList.includes(selectedCategory);
			const matchSubcategory = selectedSubcategory === '' || subcatList.includes(selectedSubcategory);

			if (matchCategory && matchSubcategory) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	});
});

    $(document).ready(function() {
        $('select[name="category_id"]').trigger('change');
    });
	$(function() {
		$('input[name="admin_plan_end_date"]').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minDate:new Date(),
			minYear: parseInt(moment().subtract(1, 'years').format('YYYY'),10),
			maxYear: parseInt(moment().add(10, 'years').format('YYYY'), 10),
			autoUpdateInput: false,
		}).on("apply.daterangepicker", function (e, picker) {
			picker.element.val(picker.startDate.format(picker.locale.format));
		});
	});
</script>
<?php echo $this->endSection() ?>