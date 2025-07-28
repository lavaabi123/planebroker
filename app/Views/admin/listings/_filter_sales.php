<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
        <?php $request = \Config\Services::request(); ?>
        <?php $url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
        <?php echo form_open(admin_url() . $url, ['method' => 'GET']); ?>


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
            <label><?php echo trans("User"); ?></label>
            <select name="user_id" id="user_id" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
               <?php
                if(!empty($providers)){
                    foreach($providers as $provider){ ?>
                        <option value="<?php echo $provider->id; ?>" <?php echo ($request->getVar('user_id') !== null && $request->getVar('user_id') == $provider->id) ? 'selected':''; ?>><?php echo $provider->fullname; ?></option>
                <?php }
                }
                ?>
            </select>
        </div>

         <div class="item-table-filter">
            <label><?php echo trans("Plans"); ?></label>
            <select name="plan_id" id="plan_id" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
               <?php
                if(!empty($plans)){
                    foreach($plans as $plan){ ?>
                        <option value="<?php echo $plan->id; ?>" <?php echo ($request->getVar('plan_id') !== null && $request->getVar('plan_id') == $plan->id) ? 'selected':''; ?>><?php echo $plan->name; ?></option>
                <?php }
                }
                ?>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("Date Paid on"); ?></label>
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
        <div class="item-table-filter item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="search" class="form-control" style="margin-bottom:0 !important;" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo $request->getVar('search'); ?>">
        </div>
        <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">

        <div class="item-table-filter md-top-10 align-self-end">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn small btn-primary"><?php echo trans("filter"); ?></button>
             <a class="btn small btn-primary" href="<?php echo admin_url() . 'listings/sales/'; ?>"><?php echo trans('Reset'); ?></a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>