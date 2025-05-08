<?php echo $this->extend('admin/includes/_layout_view') ?> 
<?php echo $this->section('content') ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/js/selectize/css/selectize.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/css/send-mail.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/frontend/js/selectize/js/standalone/selectize.min.js"></script>
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
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>emails/list-emails"><?php echo trans('emails') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <form id="messageForm" action="<?php echo admin_url() ."email/send_email_post";?>" method="post">
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <?php echo form_open_multipart('admin/emails/send_email_post', ['id' => 'form',  'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
           <!-- <input type="hidden" id="crsf">-->
           
            <div class="row" style="">
                 <div class="small-12 medium-4 columns" style="width: 30%;float: left;border: 1px solid rgba(0,0,0,.1);padding: 10px;">
                                    
                <div class="panel">
                
                    <span class="label success numRows" style='cursor: pointer'>0</span> recipients.<br> 
                    <h5>Send To Customers Who:</h5><hr>
                    <input type="radio" class="clickUpdate" name="email_verified" value="" checked> Verified and non-verified.<br>
                    <input type="radio" class="clickUpdate" name="email_verified" value="y"> Verified their email.<br>
                    <input type="radio" class="clickUpdate" name="email_verified" value="n"> Have NOT verified their email.
                    <hr>                    
                    <input type="checkbox" class="clickUpdate" name="plan[]" value="1"> are on the Standard Plan<br>
                    <input type="checkbox" class="clickUpdate" name="plan[]" value="2"> are on the Premium Plan<br>
                    <hr>
                    <div class="item-table-filter" style="width: 100%;">
                        <h5><?php echo trans("Types"); ?></h5>
                        <select name="category_id" id="category_id" class="form-control" onchange="updateTotal()">
                            <option value=""><?php echo trans("all"); ?></option>
                           <?php
                            if(!empty($categories)){
                                foreach($categories as $category){ ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                            <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <hr style="clear: both;">
                    <div class="item-table-filter" style="width: 100%;">
                        <h5><?php echo trans("Location"); ?></h5>
                        <select name="location_id[]" id="location_id" class="location required" multiple="" style="visibility: hidden;"></select>
                    </div>
                    <hr style="clear: both;">
                    <h5>Variables:</h5>
                    
                    <span class="label success">[NAME]</span> = <em>"Provider full name"</em><br>
                    <?php //strtok($loggeduser['name'], ' ') ?>
                    <span class="label success">[F_NAME]</span> = <em>"First Name"</em><br>
                    <span class="label success">[EMAIL]</span> = <em>"Provider email"</em><br>
                    <span class="label success">[SITE_URL]</span> = <em>"<?php echo base_url(); ?>"</em><br>
                    
                    <div class="alert-box warning">If you enter one of the above [including the brackets] in the message or subject, it will be automatically converted when you send the message</div>
                    
                </div>
                
            </div>

                <div class="col-lg-12 col-xl-12" style="float: left;max-width: 70%;">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3 to-email-div" style="min-height: 85px;">
                                <label>To Email Addresses - Format: <span class='label small secondary'>FIRST LAST &lt;EMAIL&gt;</span> <small><b>(these are in addition to the rules set on the left)</b></small></label>
                                    <div style="clear: both">
                                            <select name='to[]' style="display: none;" multiple>
                                                <option value=''></option>
                                                <?php
                                                    foreach ($users as $user) {
                                                        echo "<option value='".$user->email."'>".$user->name."</option>"; 
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                 </div>
                                </div>
                            </div>            
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label><?php echo trans("from_name"); ?><span class="required"> *</span></label>
                                        <input type="text" name="from_name" id="from_name" class="form-control auth-form-input" placeholder="<?php echo trans("from_name"); ?>" value="<?php echo $loggeduser->fullname.' | Plane Broker'; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label><?php echo trans("from_email"); ?><span class="required"> *</span></label>
                                        <input type="text" name="from_email" id="from_email" class="form-control auth-form-input" placeholder="<?php echo trans("from_email"); ?>" value="no-reply@bodycarepros.com" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                            <div class="form-group mb-3">
                                <label><?php echo trans('select_email_template'); ?>&nbsp;&nbsp;<em style="font-size: 13px">(To prefill subject and mail content from email template)</em></label>
                                <select id="emailtemplate_id" name="emailtemplate_id" class="form-control" onchange="get_emailtemplate($(this));">
                                    <option value=""><?php echo trans("select"); ?></option>
                                    <?php
                                    foreach ($emailtemplates as $item) : ?>
                                        <option value="<?php echo $item->id; ?>" data-subject="<?php echo html_escape($item->name); ?>">
                                            <?php echo html_escape($item->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label><?php echo trans("subject"); ?><span class="required"> *</span></label>
                                        <input type="text" name="name" id="subject" class="form-control auth-form-input" placeholder="<?php echo trans("subject"); ?>" value="<?php echo old("subject"); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="control-label"><?php echo trans('content'); ?><span class="required"> *</span></label>                               
                                <script src="<?php echo base_url('assets/ckeditor/build/ckeditor.js'); ?>"></script>
                                <textarea class="form-control text-area" name="content" id="editor" placeholder="<?php echo trans('content'); ?>"></textarea>

                                <script>                                           
                                    var yourEditor;
                                    $(document).ready(function(){
                                    ClassicEditor
                                        .create(document.querySelector('#editor'), {
                                            // CKEditor 5 configuration options
                                            removePlugins: [ 'MediaEmbed' ],
                                            simpleUpload: {
                                                uploadUrl: "<?php echo base_url('fileupload.php?CKEditorFuncNum=') ?>"
                                            },
                                        })
                                        .then(editor => {
                                            console.log('CKEditor 5 initialized:', editor);
                                            window.editor = editor;
                                            yourEditor = editor;
                                        })
                                        .catch(error => {
                                            console.error('Error initializing CKEditor 5:', error);
                                        });                                    
                                  });
                                    // Function to fetch content via AJAX
                                    function get_emailtemplate(ths) {
                                        let val = $(ths).val();
                                        if(val == '') { 
                                            //$('#subject').val('')
                                            $('#emailtemplate_id option[value=""]').prop('selected', true);
                                            //yourEditor.setData('');
                                            return; }
                                        let valSubject = $(ths).find('option:selected').data('subject');
                                        Swal.fire({
                                            text: "Are your sure to load template ("+valSubject+")?",
                                            icon: "warning",
                                            showCancelButton: 1,
                                            confirmButtonColor: "#34c38f",
                                            cancelButtonColor: "#f46a6a",
                                            confirmButtonText: sweetalert_ok,
                                            cancelButtonText: sweetalert_cancel,

                                        }).then(function (response) {
                                            if (response.value) {
                                                var data = {
                                                    "emailtemplate_id": val
                                                };
                                                data[csrfName] = $.cookie(csrfCookie);
                                                $.ajax({
                                                    type: "POST",
                                                    url: baseUrl + "/common/get_emailtemplate",
                                                    data: data,
                                                    success: function (response) {
                                                        var obj = JSON.parse(response);
                                                        $('#subject').val(obj.subject)
                                                        yourEditor.setData(obj.content);
                                                    }
                                                });
                                            }else{
                                                $('#emailtemplate_id option[value=""]').prop('selected', true);
                                            }
                                        });
                                    }
                                </script>                           
                        </div>
                        <div class="form-group mb-3 float-right">
                            <input type="hidden" id="toEmails" name="toEmails">
                            <input type="hidden" id="toNames" name="toNames">
                            <button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('Send Mail'); ?></button>
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
</form>
<!-- /.content -->
</div>
<!-- Modal -->
<div id="modal-emails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('recipients'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group scroll-container" id="emails-recipients"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="loader"></div>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/admin/js/message-users.js"></script>
<?php echo $this->endSection() ?>