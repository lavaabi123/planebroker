<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
        <?php $request = \Config\Services::request(); ?>
        <?php $url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
        <?php echo form_open(admin_url() . $url, ['method' => 'GET','class' => 'provider-form']); ?>


        <div class="item-table-filter">
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
            <label><?php echo trans("Listing Status"); ?></label>
            <select name="status" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="1" <?php echo ($request->getVar('status') == 1) ? 'selected' : ''; ?>><?php echo trans("active"); ?></option>
                <option value="0" <?php echo $request->getVar('status') != null && $request->getVar('status') != 1 ? 'selected' : ''; ?>><?php echo trans("Inactive"); ?></option>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("Subscription Status"); ?></label>
            <select name="is_cancel" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="0" <?php echo $request->getVar('is_cancel') != null && $request->getVar('is_cancel') != 1 ? 'selected' : ''; ?>><?php echo trans("Active"); ?></option>
                <option value="1" <?php echo ($request->getVar('is_cancel') == 1) ? 'selected' : ''; ?>><?php echo trans("Canceled"); ?></option>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("Packages"); ?></label>
            <select name="plan_id" class="form-control">
                <option value=""><?php echo trans('All') ?></option>
				<?php
				if(!empty($packages)){
					foreach($packages as $packages_row){ ?>
						<option value="<?php echo $packages_row->id; ?>" <?php echo ($request->getVar('plan_id') == $packages_row->id) ? 'selected' : ''; ?>><?php echo $packages_row->name; ?></option>
				<?php }
				}
				?>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("Users"); ?></label>
            <select name="user_id" class="form-control">
                <option value=""><?php echo trans('All') ?></option>
				<?php
				if(!empty($users)){
					foreach($users as $user_row){ ?>
						<option value="<?php echo $user_row->id; ?>" <?php echo ($request->getVar('user_id') == $user_row->id) ? 'selected' : ''; ?>><?php echo $user_row->fullname; ?></option>
				<?php }
				}
				?>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="search" class="form-control mb-0" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo $request->getVar('search'); ?>">
        </div>
        <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">

        <div class="item-table-filter">
			<label class="d-block">&nbsp;</label>
            <button type="submit" class="btn small btn-primary"><?php echo trans("filter"); ?></button>
             <a class="btn small btn-primary" href="<?php echo admin_url() . 'listings/'; ?>"><?php echo trans('Reset'); ?></a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>