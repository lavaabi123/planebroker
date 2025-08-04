<h6 class="border-bottom pb-2 mb-3">INVOICE HISTORY</h6>
<div class="row table-filter-container fb-filter">
    <div class="col-sm-12 form-input">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('RolesPermissionsModel'); ?>
        <?php $request = \Config\Services::request(); ?>
        <?php $url = !empty($uri->getSegment(2)) ? $uri->getSegment(1) . '/' . $uri->getSegment(2) : $uri->getSegment(1) ?>
        <?php echo form_open(base_url(). '/billing/', ['method' => 'GET']); ?>  
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
                <i class="fa fa-calendar fs-6 me-1"></i>
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
             <a class="btn w-100 btn-primary" href="<?php echo base_url() . '/subscriptions/'; ?>"><?php echo trans('Reset'); ?></a>
        </div>
		</div>
        <?php echo form_close(); ?>
    </div>
</div>
			<div class="table-responsive proMsg pb-pay">

				<table class="table table-bordered table-striped">
					<thead>
						<tr role="row">
							<th><?php echo trans('Date / Time'); ?></th>
							<th><?php echo trans('Amount'); ?></th>
							<th><?php echo trans('Status'); ?></th>
							<th><?php echo trans('Plan'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$pp = 0;
						if(!empty($payments)){
							foreach ($payments as $p => $payment) : ?>
							<?php /* ?><!--<tr>
								<td><?php echo ($pp = $pp+1); ?> </td>
								<td><?php echo ($payment->amount/100 == 29.99) ? 'Premium' : 'Standard'; ?></td>
								<td><?php echo '$'.$payment->amount/100; ?></td>
								<td><?php echo date("m/d/Y",$payment->charges->data[0]->created); ?></td>
								<td><?php echo ucfirst($payment->status); ?></td>     
							</tr>--> <?php */ ?>
							<tr>
								<td><?php echo ($payment->stripe_subscription_start_date != NULL) ? date("m/d/Y",strtotime($payment->stripe_subscription_start_date)) : '-'; ?></td>
								<td><?php echo !empty($payment->stripe_subscription_amount_paid) ? '$'.$payment->stripe_subscription_amount_paid : '$0.00'; ?></td>
								<td><?php echo (!empty($payment->stripe_subscription_amount_paid) && $payment->stripe_subscription_amount_paid > 0) ? ucfirst($payment->stripe_invoice_status) : ( ($payment->admin_plan_update==1) ? 'Added by Admin' :'Trial') ; ?></td>    
								<td><?php echo $payment->plan_name; ?></td> 
							</tr>
						<?php endforeach;
						}
						if(!empty($paypal_payments)){						
							foreach ($paypal_payments as $p => $payment) : ?>
							<tr>
								<td><?php echo $payment->plan_name; ?></td>
								<td><?php echo '$'.$payment->transaction_amount; ?></td>
								<td><?php echo date("m/d/Y",strtotime($payment->transaction_initiation_date)); ?></td>
								<td><?php 
								if($payment->transaction_amount > 0){
								echo (strtolower($payment->transaction_status) == 'success' || strtolower($payment->transaction_status) == 'active') ? 'Paid' : '-';
								}else{
									echo '-';
								}?></td>     
							</tr>
							<?php endforeach;
						}?>
					</tbody>
				</table>
				<?php if (count($payments)+count($paypal_payments) == 0) : ?>
					<p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-sm-12 mt-4">
                                    <?php echo ($total_count > 5 || (!empty($_GET['page']) && $_GET['page'] > 1)) ? $paginations : ''; ?>
                                </div>
            
<?php echo $this->include('Providerauth/_modal_provider_messages') ?>
