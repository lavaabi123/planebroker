<div class="row table-filter-container fb-filter">
    <div class="col-sm-12 form-input">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
        <?php $request = \Config\Services::request(); ?>
        <?php $url = !empty($uri->getSegment(2)) ? $uri->getSegment(1) . '/' . $uri->getSegment(2) : $uri->getSegment(1) ?>
        <?php echo form_open(base_url(). '/messages/', ['method' => 'GET']); ?>  
        <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">    
		<div class="bg-grey form-section d-flex align-items-center justify-content-between gap-2 rounded-pill p-3 mb-4">
        <div class="col form-group">
            <!--<span><?php echo trans("search"); ?></span>-->
            <input name="search" class="form-control mb-0" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo $request->getVar('search'); ?>">
        </div>

        <div class="col form-group">
             <!--<span><?php echo trans("Date Created"); ?></span>-->
            <input type="hidden" name="created_at_start" id="created_at_start" value="<?php echo $request->getVar('created_at_start'); ?>">
            <input type="hidden" name="created_at_end" id="created_at_end" value="<?php echo $request->getVar('created_at_end'); ?>">
            <div id="reportrange" class="form-control mb-0">
                <i class="fa fa-calendar fs-5"></i>&nbsp;
                <span class="fs-6 TwCenMT">Start Date - End Date</span> <i class="fa fa-caret-down fs-4 pull-right"></i>
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
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);                                           
            });
            </script>
        </div>
        <div class="col form-group d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn w-100 btn-primary"><?php echo trans("filter"); ?></button>
             <a class="btn w-100 btn-primary" href="<?php echo base_url() . '/messages/'; ?>"><?php echo trans('Reset'); ?></a>
        </div>
		</div>
        <?php echo form_close(); ?>
    </div>
</div>