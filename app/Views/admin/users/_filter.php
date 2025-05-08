<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
        <?php $request = \Config\Services::request(); ?>
        <?php $url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
        <?php echo form_open(admin_url() . $url, ['method' => 'GET','class' => 'provider-form']); ?>


        <div class="item-table-filter" style="width: 70px; min-width: 70px;">
            <label><?php echo trans("show"); ?></label>
            <select name="show" class="form-control">
                <option value="15" <?php echo ($request->getVar('show') == '25') ? 'selected' : ''; ?>>25</option>
                <option value="30" <?php echo ($request->getVar('show') == '50') ? 'selected' : ''; ?>>50</option>
                <option value="100" <?php echo ($request->getVar('show') == '100') ? 'selected' : ''; ?>>100</option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("Date Added"); ?></label>
            <input type="hidden" name="created_at_start" id="created_at_start" value="<?php echo $request->getVar('created_at_start'); ?>">
            <input type="hidden" name="created_at_end" id="created_at_end" value="<?php echo $request->getVar('created_at_end'); ?>">
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span>Start Date - End Date</span> <i class="fa fa-caret-down"></i>
            </div>

            <script type="text/javascript">
            $(function() {

                //var start = moment().subtract(29, 'days');
                //var end = moment();

                var start = '';
                var end   = '';
                <?php if($request->getVar('created_at_start') !== null && $request->getVar('created_at_end') !== null
                        && $request->getVar('created_at_start') != '' && $request->getVar('created_at_end') != '') { ?>
                            start = moment('<?php echo $request->getVar('created_at_start'); ?>');
                            end = moment('<?php echo $request->getVar('created_at_end'); ?>');
                <?php } ?>

                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#created_at_start').val(start.format('YYYY-MM-DD'));
                    $('#created_at_end').val(end.format('YYYY-MM-DD'));
                }

                //console.log(start);
                //console.log(end);
                if(start != '' && end != ''){
                    cb(start, end);
                }    

                var start = moment().subtract(29, 'days');
                var end = moment();

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                       'Today': [moment(), moment()],
                       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);                                           
            });
            </script>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("status"); ?></label>
            <select name="status" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="1" <?php echo ($request->getVar('status') == 1) ? 'selected' : ''; ?>><?php echo trans("active"); ?></option>
                <option value="0" <?php echo $request->getVar('status') != null && $request->getVar('status') != 1 ? 'selected' : ''; ?>><?php echo trans("banned"); ?></option>
            </select>
        </div>
         <div class="item-table-filter">
            <label><?php echo trans("Plans"); ?></label>
            <select name="plan_id" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="11" <?php echo ($request->getVar('plan_id') == 11) ? 'selected' : ''; ?>><?php echo trans("Free Trial"); ?></option>
                <option value="2" <?php echo ($request->getVar('plan_id') == 2) ? 'selected' : ''; ?>><?php echo trans("Standard"); ?></option>
                <option value="3" <?php echo ($request->getVar('plan_id')  == 3) ? 'selected' : ''; ?>><?php echo trans("Premium"); ?></option>
                <option value="44" <?php echo ($request->getVar('plan_id') == 44) ? 'selected' : ''; ?>><?php echo trans("Canceled"); ?></option>
                <option value="1" <?php echo ($request->getVar('plan_id') == 1) ? 'selected' : ''; ?>><?php echo trans("Without any Plan"); ?></option>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("email_status"); ?></label>
            <select name="email_status" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="1" <?php echo ($request->getVar('email_status') == 1) ? 'selected' : ''; ?>><?php echo trans("confirmed"); ?></option>
                <option value="0" <?php echo $request->getVar('email_status') != null && $request->getVar('email_status') != 1 ? 'selected' : ''; ?>><?php echo trans("unconfirmed"); ?></option>
            </select>
        </div>
         <div class="item-table-filter">
            <label><?php echo trans("Types"); ?></label>
            <select name="category_id" id="category_id" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
               <?php
                if(!empty($categories)){
                    foreach($categories as $category){ ?>
                        <option value="<?php echo $category->id; ?>" <?php echo ($request->getVar('category_id') !== null && $request->getVar('category_id') == $category->id) ? 'selected':''; ?>><?php echo $category->name; ?></option>
                <?php }
                }
                ?>
            </select>
        </div>
        <?php /* <?php if ($uri->getSegment(3) != 'administrators') : ?>
            <div class="item-table-filter">
                <label><?php echo trans("role"); ?></label>
                <select name="role" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php foreach (model('RolesPermissionsModel')->getRoles() as $role) : ?>
                        <option value="<?php echo $role->id ?>" <?php echo ($request->getVar('role') == $role->id) ? 'selected' : ''; ?>><?php echo $role->role_name; ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
        <?php endif; ?>
        <?php */ ?>

        <div class="item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="search" class="form-control" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo $request->getVar('search'); ?>">
        </div>
        <div class="form-group item-table-filter location-filter">
             <label><?php echo trans("Location"); ?></label>
            <select name='location_id' class='locationhome'>
                <option value='<?php echo $search_location_id ?>'><?php echo !empty($search_location_name) ? $search_location_name : '' ?></option>
            </select>
        </div>
        <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">

        <div class="item-table-filter">
            <button type="submit" class="btn small btn-primary"><?php echo trans("filter"); ?></button>
             <a class="btn small btn-primary" href="<?php echo admin_url() . 'providers/list-providers/'; ?>"><?php echo trans('Reset'); ?></a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>